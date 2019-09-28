<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit95e2fa98eab0c7ca3e1c2d956a5a9859
{
    public static $files = array(
        '9b552a3cc426e3287cc811caefa3cf53' => __DIR__ . '/..' . '/topthink/think-helper/src/helper.php',
    );

    public static $prefixLengthsPsr4 = array(
        't' =>
            array(
                'think\\' => 6,
            ),
        'P' =>
            array(
                'Psr\\SimpleCache\\' => 16,
                'Psr\\Log\\' => 8,
            ),
    );

    public static $prefixDirsPsr4 = array(
        'think\\' =>
            array(
                0 => __DIR__ . '/..' . '/topthink/think-helper/src',
                1 => __DIR__ . '/..' . '/topthink/think-orm/src',
            ),
        'Psr\\SimpleCache\\' =>
            array(
                0 => __DIR__ . '/..' . '/psr/simple-cache/src',
            ),
        'Psr\\Log\\' =>
            array(
                0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
            ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit95e2fa98eab0c7ca3e1c2d956a5a9859::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit95e2fa98eab0c7ca3e1c2d956a5a9859::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
