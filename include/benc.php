<?php
function benc($obj)
{
    if (!is_array($obj) || !isset($obj["type"]) || !isset($obj["value"]))
        return;
    $c = $obj["value"];
    switch ($obj["type"]) {
        case "string":
            return benc_str($c);
        case "integer":
            return benc_int($c);
        case "list":
            return benc_list($c);
        case "dictionary":
            return benc_dict($c);
        default:
            return;
    }
}

function benc_str($s)
{
    return strlen($s) . ":$s";
}

function benc_int($i)
{
    return "i" . $i . "e";
}

function benc_list($a)
{
    $s = "l";
    foreach ($a as $e) {
        $s .= benc($e);
    }
    $s .= "e";
    return $s;
}

function benc_dict($d)
{
    $s = "d";
    $keys = array_keys($d);
    sort($keys);
    foreach ($keys as $k) {
        $v = $d[$k];
        $s .= benc_str($k);
        $s .= benc($v);
    }
    $s .= "e";
    return $s;
}

function bdec_file($path)
{
    try {
        return bdec_decode_new(file_get_contents($path, FILE_BINARY));
    } catch (Exception $e) {
        return;
    }

}

function bdec($s)
{
    if (preg_match('/^(\d+):/', $s, $m)) {
        $l = $m[1];
        $pl = strlen($l) + 1;
        $v = substr($s, $pl, $l);
        $ss = substr($s, 0, $pl + $l);
        if (strlen($v) != $l)
            return;
        return array('type' => "string", 'value' => $v, 'strlen' => strlen($ss), 'string' => $ss);
    }
    if (preg_match('/^i(-?\d+)e/', $s, $m)) {
        $v = $m[1];
        $ss = "i" . $v . "e";
        if ($v === "-0")
            return;
        if ($v[0] == "0" && strlen($v) != 1)
            return;
        return array('type' => "integer", 'value' => $v, 'strlen' => strlen($ss), 'string' => $ss);
    }
    switch ($s[0]) {
        case "l":
            return bdec_list($s);
        case "d":
            return bdec_dict($s);
        default:
            return;
    }
}

function bdec_list($s)
{
    if ($s[0] != "l")
        return;
    $sl = strlen($s);
    $i = 1;
    $v = array();
    $ss = "l";
    for (; ;) {
        if ($i >= $sl)
            return;
        if ($s[$i] == "e")
            break;
        $ret = bdec(substr($s, $i));
        if (!isset($ret) || !is_array($ret))
            return;
        $v[] = $ret;
        $i += $ret["strlen"];
        $ss .= $ret["string"];
    }
    $ss .= "e";
    return array('type' => "list", 'value' => $v, 'strlen' => strlen($ss), 'string' => $ss);
}

function bdec_dict($s)
{
    if ($s[0] != "d")
        return;
    $sl = strlen($s);
    $i = 1;
    $v = array();
    $ss = "d";
    for (; ;) {
        if ($i >= $sl)
            return;
        if ($s[$i] == "e")
            break;
        $ret = bdec(substr($s, $i));
        if (!isset($ret) || !is_array($ret) || $ret["type"] != "string")
            return;
        $k = $ret["value"];
        $i += $ret["strlen"];
        $ss .= $ret["string"];
        if ($i >= $sl)
            return;
        $ret = bdec(substr($s, $i));
        if (!isset($ret) || !is_array($ret))
            return;
        $v[$k] = $ret;
        $i += $ret["strlen"];
        $ss .= $ret["string"];
    }
    $ss .= "e";
    return array('type' => "dictionary", 'value' => $v, 'strlen' => strlen($ss), 'string' => $ss);
}

function bdec_simple($dict)
{
//'url-list'
    foreach ($dict['value'] as $key => $value)
        if (!in_array($key, array('created by', 'creation date', 'info', 'encoding'))) unset($dict['value'][$key]);
    return $dict;
}

function bdec_decode_new($data, &$pos = 0)
{
    $start_decode = ($pos === 0);
    if ($data[$pos] === 'd') {
        $pos++;
        $return = [];
        while ($data[$pos] !== 'e') {
            $type = $data[$pos - 1];
            $key = bdec_decode_new($data, $pos)['value'];
            $value = bdec_decode_new($data, $pos);
            if ($key === null || $value === null) {
                break;
            }
            if (!is_string($key)) {


                throw new Exception('Invalid key type, must be string: ' . gettype($key));
            }
            $return[$key] = $value;

            //$return[]=$value;
        }
        $return = array('type' => "dictionary", 'value' => $return, 'strlen' => 0, 'string' => 0);
        ksort($return);
        $pos++;
    } elseif ($data[$pos] === 'l') {
        $pos++;
        $return = [];
        while ($data[$pos] !== 'e') {
            $value = bdec_decode_new($data, $pos);

            $return[] = $value;
        }
        $return = array('type' => "list", 'value' => $return, 'strlen' => 0, 'string' => 0);
        $pos++;
    } elseif ($data[$pos] === 'i') {
        $pos++;
        $digits = strpos($data, 'e', $pos) - $pos;
        $return = substr($data, $pos, $digits);
        if ($return === '-0') {


            throw new Exception('Cannot have integer value -0');
        }
        $multiplier = 1;
        if ($return[0] === '-') {
            $multiplier = -1;
            $return = substr($return, 1);
        }
        if (!ctype_digit($return)) {


            throw new Exception('Cannot have non-digit values in integer number: ' . $return);
        }
        $return = $multiplier * ((int)$return);
        $pos += $digits + 1;
        $return = array('type' => "integer", 'value' => $return, 'strlen' => 0, 'string' => 0);
    } else {
        $digits = strpos($data, ':', $pos) - $pos;
        $len = (int)substr($data, $pos, $digits);
        $pos += ($digits + 1);
        $return = substr($data, $pos, $len);
        $pos += $len;
        $return = array('type' => "string", 'value' => $return, 'strlen' => 0, 'string' => 0);
    }
    if ($start_decode) {
        if ($pos !== strlen($data)) {
            throw new Exception('Could not fully decode bencode string');
        }
    }
    return $return;
}

?>