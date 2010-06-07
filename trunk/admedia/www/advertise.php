<?php
	InitGetPost(array('fee_type','status','start_date','end_date'));

	$affpaycycle = $cfg_syspaycycle[getSysConfigByKey("pay_cycle")];

	!empty($status) && $transtr .= "&status=$status";
	!empty($fee_type) && $transtr .= "&fee_type=$fee_type";
	!empty($start_date) && $transtr .= "&start_date=$start_time";
	!empty($end_date) && $transtr .= "&end_date=$end_date";
	(!empty($searchtype) && !empty($searchkey)) && $transtr .= "&searchtype=".$searchtype."&searchkey=$searchkey";

	$stwhere = "a.is_del=0 and a.status=1 and ";
	(strlen($fee_type)>0) && $stwhere .= " a.fee_type=".sqlEscape($fee_type)." and ";		
	(strlen($status)>0) && $stwhere .= " apply_status=".sqlEscape($status)." and ";		
	(strlen($start_date)>0) && $stwhere .= " a.start_time>=".__strtotime($start_date)." and ";	
	(strlen($end_date)>0) && $stwhere .= " a.end_time<=".__strtotime($end_date)." and ";		
	if(strlen($searchkey)>0) {
		$querykey = "%".$searchkey."%";
		$stwhere .= " a.name like ".sqlEscape($querykey)." and ";			
	}
	(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);	

	$objAdvertise = LOAD::loadDB("Advertise");
	$totalnum = $objAdvertise->getAdvertiseTotalCount($stwhere);
	$totalpage = ceil($totalnum/$perpage);
	$db_advlist = $objAdvertise->getAdvertisePageList($curpage,$perpage,$stwhere,"level");

	include PrintEot($job,'www');
	footer(false);
?>