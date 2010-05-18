<?php
/**
* 数据库相关信息设置
* 具体数值，请联系您的主机商,询问具体的数据库相关信息
*/
// 数据库 主机名 或 IP 地址，如数据库端口不是3306，请在 主机名 或 IP 地址后添加“:具体端口”，如您的主机是localhost，端口是3307，则更改为“localhost:3307”
$db_host = 'localhost';

// 数据库用户名和密码，连接和访问 MySQL 数据库时所需的用户名和密码，不推荐使用空的数据库密码。
$db_user = 'root';
$db_pass = 'root';

// 数据库名，论坛程序所使用的数据库名。
$db_name = 'adspace';

// 数据库类型，有效选项有 mysql 和 mysqli，自pwforums v6.3.2起，引入了mysqli的支持，兼容性更好，效率性能更稳定，与mysql连接更稳定
// 若服务器的配置是 PHP5.1.0或更高版本 和 MySQL4.1.3或更高版本，可以尝试使用 mysqli。
$database = 'mysql';

	// 表区分符，用于区分每一套程序的符号
$PM = 'pm_';

	// 是否持久连接，暂不支持mysqli
$pconnect = '0';

/**
* Mysql编码设置(常用编码：gbk、big5、utf8、latin1)
* 如果您的论坛出现乱码现象，需要设置此项来修复
* 请不要随意更改此项，否则将可能导致论坛出现乱码现象
*/
$charset = 'utf8';

/**
* 镜像站点设置，默认为1，代表是主站点
*/
$db_hostweb = '1';

/**
* 附件url地址，以http:// 开头的绝对地址，为空使用默认
*/
$attach_url = array();
?>