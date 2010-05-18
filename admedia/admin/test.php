<?php
define('CM',"1");
define('CO',"1");
define('DB',"1");

require_once('global.php');

require_once R_P."lib/db_mysql.php";

$db = new DB($db_host,$db_user,$db_pass,$db_name,$PM,$charset,$pconnect);
$objSysUser = LOAD::loadDB("AdminUser");


//'login_name','login_pwd','real_name','nick_name','create_time','role_id','own_users','is_active','qq','mobile','msn','is_del'
$arruser = array(login_name=>'admin',login_pwd=>pwdCode('admin'));

echo $objSysUser->updateSysUser(7,$arruser)."<br/>";

//Cookie('AdminUser','',0);
echo "test";
?>