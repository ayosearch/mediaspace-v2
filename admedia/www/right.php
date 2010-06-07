<?php
	$affpaycycle = $cfg_syspaycycle[getSysConfigByKey("pay_cycle")];
	
	$objAdvertise = LOAD::loadDB("Advertise");
	$db_advtimelist = $objAdvertise->getAdvertisePageList(1,3,"a.status=1","a.create_time");
	$db_advlevellist = $objAdvertise->getAdvertisePageList(1,5,"a.status=1","a.level");	
	
	include PrintEot($job,"www");
	footer(false);		
?>