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

function deleteSysConfigVal($key){
	global $memcache;
	$memcache->delete("SYS_CONFIG_".$key);
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

function deleteBaseSortListByKey($key){
	global $memcache;
	$memcache->delete("BASESORT_".$key);
}

function getBaseAdvSizeAll(){
	global $memcache;
	$list = $memcache->get("BASEADSIZE_LIST");
	if($list==null || !isset($list) || empty($list)){
		$objCommData = LOAD::loadDB("CommonData");
		$list = $objCommData->getBaseAdvSizeAll();
		if($list) $memcache->set("BASEADSIZE_LIST",$list);
		else return null;
	}
	return $list;
}

function deleteBaseAdvSizeAll(){
	global $memcache;
	$memcache->set("BASEADSIZE_LIST");
}

function getCacheAffliate($id){
	global $memcache;
	$db_affiliate = $memcache->get("AFFILIATE_".$id);
	if($db_affiliate==null){
		return setCacheAffiliate($id);
	}
	return $db_affiliate;
}

function setCacheAffiliate($id){
	global $memcache;
	$objAffiliate = LOAD::loadDB("Affiliate");
	$db_affiliate = $objAffiliate->getAffiliate($id);
	if($db_affiliate) $memcache->set("AFFILIATE_".$id,$db_affiliate);
	else return null;
	unset($objAffiliate);
	return $db_affiliate;
}

function deleteCacheAffiliate($id){
	global $memcache;
	$memcache->delete("AFFILIATE_".$id);
}

function getCacheAdvCreative($id){
	global $memcache;
	$db_advcreative = $memcache->get("ADVCREATIVE_".$id);
	if($db_advcreative==null){
		return setCacheAdvCreative($id);
	}
	return $db_advcreative;
}

function setCacheAdvCreative($id){
	global $memcache;
	$objAdvertise = LOAD::loadDB("Advertise");
	$db_advcreative = $objAdvertise->getAdvCreative($id);
	if($db_advcreative) $memcache->set("ADVCREATIVE_".$id,$db_advcreative);
	else return null;
	unset($objAdvertise);
	return $db_advcreative;
}

function deleteCacheAdvCreative($id){
	global $memcache;
	$memcache->delete("ADVCREATIVE_".$id);
}

function getCacheAdvCreativeListByAdvId($id="-1",$type){
	global $memcache;
	$db_advcreativelist = $memcache->get("ADVCEREATIVE_LIST_".$type."_".$id);
	if($db_advcreativelist==null){
		return setCacheAdvCreativeListByAdvId($id);
	}
	return $db_advcreativelist;
}

function setCacheAdvCreativeListByAdvId($id="-1",$type){
	global $memcache;
	$objAdvertise = LOAD::loadDB("Advertise");
	$db_advcreativelist = $objAdvertise->getAdvCreativeAll(1,$id,$type);
	if($db_advcreativelist) $memcache->set("ADVCEREATIVE_LIST_".$type."_".$id,$db_advcreativelist);
	else return null;
	unset($objAdvertise);
	return $db_advcreativelist;
}

function deleteCacheAdvCreativeListByAdvId($id="-1",$type){
	global $memcache;
	$memcache->delete("ADVCEREATIVE_LIST_".$type."_".$id);
}

function getCacheAdvertise($id){
	global $memcache;
	$db_advertise = $memcache->get("ADVERTISE_".$id);
	if($db_advertise==null){
		return setCacheAdvertise($id);
	}
	return $db_advertise;
}

function setCacheAdvertise($id){
	global $memcache;
	$objAdvertise = LOAD::loadDB("Advertise");
	$db_advertise = $objAdvertise->getAdvertise($id);
	if($db_advertise) $memcache->set("ADVERTISE_".$id,$db_advertise);
	else return null;
	unset($objAdvertise);
	return $db_advertise;
}

function deleteCacheAdvertise($id){
	global $memcache;
	$memcache->delete("ADVERTISE_".$id);
}

function getCacheAdvRoll($id){
	global $memcache;
	$db_advroll = $memcache->get("ADVROLL_".$id);
	if($db_advroll==null){
		return setCacheAdvertise($id);
	}
	return $db_advroll;
}

function setCacheAdvRoll($id){
	global $memcache;
	$objAdvertise = LOAD::loadDB("Advertise");
	$db_advroll = $objAdvertise->getAdvRollPlan($id);
	if($db_advroll) $memcache->set("ADVROLL_".$id,$db_advroll);
	else return null;
	unset($objAdvertise);
	return $db_advroll;
}

function getCacheAdvRollDetailList($rollid){
	global $memcache;
	$db_advrollist = $memcache->get("ADVROLLDETAIL_LIST_".$rollid);
	if($db_advrollist==null){
		return setCacheAdvertise($id);
	}
	return $db_advrollist;
}

function setCacheAdvRollDetailList($rollid){
	global $memcache;
	$objAdvertise = LOAD::loadDB("Advertise");
	$db_advrollist = $objAdvertise->getAdvRollDetailByPlanId($rollid);
	if($db_advrollist) $memcache->set("ADVROLLDETAIL_LIST_".$rollid,$db_advrollist);
	else return null;
	unset($objAdvertise);
	return $db_advrollist;
}

function getCacheAdvPage($id){
	global $memcache;
	$db_advpage = $memcache->get("ADVPAGE_".$id);
	if($db_advpage==null){
		return setCacheAdvPage($id);
	}
	return $db_advpage;
}

function setCacheAdvPage($id){
	global $memcache;
	$objAdvertise = LOAD::loadDB("Advertise");
	$db_advpage = $objAdvertise->getAdvPages($id);
	if($db_advpage) $memcache->set("ADVPAGE_".$id,$db_advpage);
	else return null;
	unset($objAdvertise);
	return $db_advpage;
}


function deleteCacheAdvPage($id){
	global $memcache;
	$memcache->delete("ADVPAGE_".$id);
}

?>