<?php
InitGetPost(array('all','status',',start_date','end_date'));

!empty($status) && $transtr .= "&status=$status";
!empty($start_date) && $transtr .= "&start_date=$start_time";
!empty($end_date) && $transtr .= "&end_date=$end_date";
(!empty($searchtype) && !empty($searchkey)) && $transtr .= "&searchtype=".$searchtype."&searchkey=$searchkey";

 if(empty($action)){
 	$stwhere = "audit=1 and ";
	(!empty($status)) && $stwhere .= " status=".sqlEscape($status)." and ";		
	(!empty($start_date)) && $stwhere .= " create_time>=".__strtotime($start_date)." and ";	
	(!empty($end_date)) && $stwhere .= " create_time<=".__strtotime($end_date)." and ";		
	if(!empty($searchtype) && !empty($searchkey)) {
		$querykey = "%".$searchkey."%";
		$stwhere .= " $searchtype like ".sqlEscape($querykey)." and ";			
	}
	(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);	 	
 	
	$objAdvertise = LOAD::loadDB("Advertise");
	$totalnum = $objAdvertise->getAdvertiseTotalCount($stwhere);
	$totalpage = ceil($totalnum/$perpage);
	$db_advlist = $objAdvertise->getAdvertisePageList($curpage,$perpage,$stwhere,"id");
}else if($action=="createview"){
	$objDataLog = LOAD::loadDB("DataLog");
	if($objDataLog->createShowLog($curid)){
		$objAdvertise = LOAD::loadDB("Advertise");
		$objAdvertise->updateAdvertiseShow($curid);
		ObHeader("$basename?job=advcontrol$transtr");
	}else{
		adminMsg("error_create_view");	
	}
}else if($action=="createclick"){
	$objDataLog = LOAD::loadDB("DataLog");
	if($objDataLog->createClickLog($curid)){
		$objAdvertise = LOAD::loadDB("Advertise");
		$objAdvertise->updateAdvertiseClick($curid);		
		ObHeader("$basename?job=advcontrol$transtr");	
	}else{
		adminMsg("error_create_click");	
	}
	exit;	
}

include PrintEot($job);
footer(true);
?>