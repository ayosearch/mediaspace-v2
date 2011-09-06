<?php
include_once('rolecontrol.php');	
	
InitGetPost(array('status','all','auditstatus','start_date','end_date'));

if(empty($action) || $action=="select"){
	$stwhere = "status in (1,3) and ";	
	if(strlen($start_date)>0) $stwhere .= " create_time>=".__strtotime($start_date)." and ";	
	if(strlen($end_date)>0) $stwhere .= " create_time<=".__strtotime($end_date)." and ";		

	if(strlen($searchtype)>0 && strlen($searchkey)>0) {
		$querykey = "%".$searchkey."%";
		$stwhere .= " $searchtype like ".sqlEscape($querykey)." and ";			
	}	
	(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);	
	
	$objAffiliate = LOAD::loadDB("Affiliate");
	$totalnum = $objAffiliate->getAffAdvApplyTotalCount($stwhere);
	$totalpage = ceil($totalnum/$perpage);
	$db_affadvapplylist = $objAffiliate->getAffAdvApplyPageList($curpage,$perpage,$stwhere,"create_time");
	unset($objAffiliate,$totalnum,$totalpage);
} 

include PrintEot($job);
footer(true);
?>