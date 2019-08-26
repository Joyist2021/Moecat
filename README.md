# MoeCatPT

## MoeCatPT是一个基于NexusPHP搭建的网站，源代码修改自蚂蚁PT开源代码

## 服务器运行环境：
Nginx 1.16.0

Mysql 5.6.44

PHP 5.6.40

[Memcache](http://php.net/manual/en/book.memcache.php)

[gmp](http://php.net/manual/en/book.gmp.php)

[exec function](http://php.net/manual/en/function.exec.php)

[OPcache](https://www.php.net/manual/zh/book.opcache.php)

## 因为时间太紧，我也有点懒，文件里面还有少许的蚂蚁PT的文字/图标（上线网站已删除）
## 如果你要架设网站，请务必删除（包括但不限于蚂蚁的标识，文字，图标等等），谢谢

1.注意及时修改class_cache.php与class_cache_announce.php中第195行，选择合适的缓存器。

2.并且还要修改allconfig.php中数据库连接部分。

3.验证码的话，如果开启海报验证，要等种子数目足够多才行。

如果要开启IMDB系统，请到include/functions_plus.php文件里，更换你自己的APIKEY。

H&R系统设定在include/cleanup.php。

请自行在数据库torrents表中新建tags字段  `alter table pt.torrents  add tags int`

首页聊天机器人ID设定在include/config.php文件，大约在440行。

关于初始用户ID，种子ID以及各种ID不为1问题我在这里给出解决方案（涉及到数据库操作请务必备份数据，以防数据丢失）
```
truncate语句，是清空表中的内容，包括自增主键的信息。truncate表后，表的主键就会重新从1开始。(执行此操作表内容将会被全部清空)
语法：

TRUNCATE TABLE table1;

TRUNCATE TABLE adclicks;
TRUNCATE TABLE adminpanel;
TRUNCATE TABLE advertisements;
TRUNCATE TABLE agent_allowed_exception;
TRUNCATE TABLE agent_allowed_family;
TRUNCATE TABLE allowedemails;
TRUNCATE TABLE attachments;
TRUNCATE TABLE attendance;
TRUNCATE TABLE audiocodecs;
TRUNCATE TABLE avps;
TRUNCATE TABLE bannedemails;
TRUNCATE TABLE bans;
TRUNCATE TABLE bitbucket;
TRUNCATE TABLE blocks;
TRUNCATE TABLE bookmarks;
TRUNCATE TABLE categories;
TRUNCATE TABLE caticons;
TRUNCATE TABLE cheaters;
TRUNCATE TABLE chronicle;
TRUNCATE TABLE codecs;
TRUNCATE TABLE comments;
TRUNCATE TABLE complains;
TRUNCATE TABLE complain_replies;
TRUNCATE TABLE countries;
TRUNCATE TABLE downloadspeed;
TRUNCATE TABLE faq;
TRUNCATE TABLE files;
TRUNCATE TABLE forummods;
TRUNCATE TABLE forums;
TRUNCATE TABLE friends;
TRUNCATE TABLE fun;
TRUNCATE TABLE funds;
TRUNCATE TABLE funvotes;
TRUNCATE TABLE invites;
TRUNCATE TABLE iplog;
TRUNCATE TABLE iplog_announce;
TRUNCATE TABLE isp;
TRUNCATE TABLE language;
TRUNCATE TABLE links;
TRUNCATE TABLE locations;
TRUNCATE TABLE loginattempts;
TRUNCATE TABLE magic;
TRUNCATE TABLE media;
TRUNCATE TABLE messages;
TRUNCATE TABLE modpanel;
TRUNCATE TABLE news;
TRUNCATE TABLE offers;
TRUNCATE TABLE offervotes;
TRUNCATE TABLE overforums;
TRUNCATE TABLE peers;
TRUNCATE TABLE pmboxes;
TRUNCATE TABLE pollanswers;
TRUNCATE TABLE polls;
TRUNCATE TABLE posts;
TRUNCATE TABLE processings;
TRUNCATE TABLE prolinkclicks;
TRUNCATE TABLE readposts;
TRUNCATE TABLE regimages;
TRUNCATE TABLE reports;
TRUNCATE TABLE rules;
TRUNCATE TABLE schools;
TRUNCATE TABLE searchbox;
TRUNCATE TABLE secondicons;
TRUNCATE TABLE shoutbox;
TRUNCATE TABLE sitelog;
TRUNCATE TABLE snatched;
TRUNCATE TABLE sources;
TRUNCATE TABLE staffmessages;
TRUNCATE TABLE standards;
TRUNCATE TABLE stylesheets;
TRUNCATE TABLE subs;
TRUNCATE TABLE suggest;
TRUNCATE TABLE sysoppanel;
TRUNCATE TABLE teams;
TRUNCATE TABLE thanks;
TRUNCATE TABLE topics;
TRUNCATE TABLE torrents;
TRUNCATE TABLE torrents_myrss;
TRUNCATE TABLE torrents_state;
TRUNCATE TABLE uploadspeed;
TRUNCATE TABLE users;
TRUNCATE TABLE user_invitations;
```

其他的想到再写吧 2333333