<?php

define('DB_A_HOST','127.0.0.1');
define('DB_A_USER',"root");
define('DB_A_PASS',"root");
define('DB_A_NAME','adspace');
define('DB_A_CHARSET','utf8');
define('DB_A_PCONNECT',0);

define('DB_P_HOST','127.0.0.1');
define('DB_P_USER',"root");
define('DB_P_PASS',"root");
define('DB_P_NAME','prices');
define('DB_P_CHARSET','utf8');
define('DB_P_PCONNECT',0);

/**
* 镜像站点设置，默认为1，代表是主站点
*/
$db_hostweb = '1';

/**
* 附件url地址，以http:// 开头的绝对地址，为空使用默认
*/
$attach_url = array();
?>