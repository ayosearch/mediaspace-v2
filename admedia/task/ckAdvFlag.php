<?php
require_once('global.php');
$memcache = LOAD::loadClass("Memcache",null);
$objAdvertise = LOAD::loadDB("Advertise");
$db_advlist = $objAdvertise->getAdvertiseStatusList(1);
if($db_advlist){
	$arrIds_X = "";
	$arrIds_Y = "";
	foreach($db_advlist as $db_adv){
		if($db_adv[log_flag]=="X"){
			$arrIds_X .= $db_adv[id].",";
			deleteCacheAdvertise($db_adv[id]);
		}
		if($db_adv[log_flag]=="Y"){
			$arrIds_Y .= $db_adv[id].",";
			deleteCacheAdvertise($db_adv[id]);
		}		
	}
	if(!empty($arrIds_X)){
		$arrIds_X = substr($arrIds_X,0,strlen($arrIds_X)-1);
		$objAdvertise->updateAdvertiseFlag($arrId_X,"Y",$timestamp);
	}
	if(!empty($arrIds_Y)){
		$arrIds_Y = substr($arrIds_Y,0,strlen($arrIds_Y)-1);
		$objAdvertise->updateAdvertiseFlag($arrIds_Y,"X",$timestamp);

	}
}
echo "1";
?>