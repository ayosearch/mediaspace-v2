<?php
set_magic_quotes_runtime(0);

if(function_exists('date_default_timezone_set'))
	date_default_timezone_set(PRC);

define('C_P',getDirName(__FILE__));
define('R_P',C_P."../");
define('P_M','affiliate');

if(CM=="1"){
	include_once(R_P.'require/common.php');	
	InitGlobals();		
	ObStart();
}

if(CO=="1"){
	include_once(R_P.'require/cookie.php');
}

if(DB=="1"){
	include_once(R_P.'require/dbconfig.php');
}

include_once(R_P.'require/config.php');

$timestamp = time();
list($millsec, $sec) = explode(" ",microtime());

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