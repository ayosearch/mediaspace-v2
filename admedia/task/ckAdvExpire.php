<?php 
require_once('global.php');
$memcache = LOAD::loadClass("Memcache",null);
$objAdvertise = LOAD::loadDB("Advertise");
$db_advlist = $objAdvertise->getAdvertiseStatusList(1);
$upIds = "";
foreach($db_advlist as $db_adv){
	if($timestamp>=$db_adv[end_time]){
		$upIds .= $db_adv[id].",";
		deleteCacheAdvertise($db_adv[id]);
	}
}
if(!empty($upIds)){
	$upIds = substr($upids,0,strlen($upids)-1);
	$objAdvertise->updateAdvertiseStatus($upids,2);
	echo "1";
}
echo "0";
?>