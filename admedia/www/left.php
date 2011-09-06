<?php
	$objSystem = LOAD::loadDB("System");
	$db_bulletinlist = $objSystem->getSysNewsPageList(1,10,"status=1","is_top");
	$last_date = date('m/d h:i',$timestamp);
	include PrintEot($job,"www");
	footer(false);		
?>