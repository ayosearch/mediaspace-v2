<?php
function getSysConfigByKey($key){
	global $memcache;
	$val = $memcache->get("SYS_CONFIG_".$key);
	if($val==null || !isset($val) || empty($val)){
		$objSystem = LOAD::loadDB("System");
		$val = $objSystem->getSystem($key);
		if($val){
			$memcache->set("SYS_CONFIG_".$key,$val[key_value]);
			$val = $val[key_value];
		}
	}
	return $val;
}

function setSysConfigVal($key,$val){
	global $memcache;
	$memcache->set("SYS_CONFIG_".$key,$val);
}

function getBaseSortListByKey($key){
	global $memcache;
	$list = $memcache->get("BASESORT_".$key);
	if($list==null || !isset($list) || empty($list)){
		$objCommData = LOAD::loadDB("CommonData");
		$list = $objCommData->getBaseSortKeyList($key);
		if($list) $memcache->set("BASESORT_".$key,$list);
		else return null;
	}
	return $list;
}

function setBaseSortListByKey($key,$val){
	global $memcache;
	$memcache->set("BASESORT_".$key,$val);
}

?>