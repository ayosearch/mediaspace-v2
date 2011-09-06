<?php
set_magic_quotes_runtime(0);

if(function_exists('date_default_timezone_set'))
	date_default_timezone_set(PRC);

define('C_P',getDirName(__FILE__));
define('R_P',C_P."../");
include_once(R_P.'require/common.php');	
include_once(R_P.'require/dbconfig.php');
include_once(R_P.'require/config.php');
include_once(R_P.'require/service.php');

$timestamp = time();
list($millsec, $sec) = explode(" ",microtime());

require_once R_P."lib/db_mysql.php";
$db = new DB($db_host,$db_user,$db_pass,$db_name,$PM,$charset,$pconnect);

function getDirName($path=null){
	if (!empty($path)) {
		if (strpos($path,'\\')!==false) {
			return substr($path,0,strrpos($path,'\\')).'/';
		} elseif (strpos($path,'/')!==false) {
			return substr($path,0,strrpos($path,'/')).'/';
		}
	}
	return './';
}
?>