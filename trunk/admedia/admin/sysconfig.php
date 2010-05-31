<?php
	
	$memcache = LOAD::loadClass("Memcache",null);
	$objSystem = LOAD::loadDB("System");
	require_once R_P."require/service.php";	
	
	if($action=="save"){
		foreach($cfg_sysconfig as $key_name=>$key_val){
			$arrfield = array("key_name"=>"$key_name","key_value"=>$_POST["$key_name"]);
			if($objSystem->checkSystem($key_name)==0){
				$objSystem->insertSystem($arrfield);
				setSysConfigVal($key_name,$_POST["$key_name"]);
			}else{
				$objSystem->updateSystem("$key_name",$_POST["$key_name"]);
				setSysConfigVal($key_name,$_POST[$key_name]);
			}
		}
		ObHeader($admin_file);	
	}

	$db_sc = $objSystem->getSystemAll();
	$db_sysconfig = $cfg_sysconfig;
	if($db_sc){
		foreach($db_sc as $dbconfig){
			$keyname = $dbconfig[key_name];
			$db_sysconfig[$keyname] = $dbconfig[key_value];
		}
	}

	include PrintEot($job);
	footer(true);
?>