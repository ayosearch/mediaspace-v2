<?php
	$affpaycycle = $cfg_syspaycycle[getSysConfigByKey("pay_cycle")];
	
	$ids = "";
	$objAffiliate = LOAD::loadDB("Affiliate");
	$db_applylist = $objAffiliate->getAffAdvApplyAllByAffId($AffUser[id],1);
	
	$objAdvertise = LOAD::loadDB("Advertise");
	$db_advtimelist = $objAdvertise->getAdvertisePageList(1,3,"a.status=1","a.create_time");
	$db_advlevellist = $objAdvertise->getAdvertisePageList(1,5,"a.status=1","a.level");	
	
	if($AffUser[last_paytime]>0){
		$last_paytime = date('Y/m/d H:i:s',$affuser[last_paytime]);
	}
	
	include PrintEot($job,"www");
	footer(false);		
?>