<?php 
include_once('rolecontrol.php');	

strlen($status)>0 && $transtr .= "&status=$status";
strlen($enablecpc)>0 && $transtr .= "&enablecpc=$enablecpc";
strlen($start_date)>0 && $transtr .= "&start_date=$start_time";
strlen($end_date)>0 && $transtr .= "&end_date=$end_date";
(strlen($searchtype)>0 && strlen($searchkey)>0) && $transtr .= "&searchtype=".$searchtype."&searchkey=$searchkey";

if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}
	$objAffiliate = LOAD::loadDB("Affiliate");
	$objAffiliate->clearAffWebSite($ids);
	unset($objAffiliate);
	ObHeader($admin_file.$transtr);
}else if(empty($action)){
	$stwhere = " a.is_del=1 and ";
	(strlen($status)>0) && $stwhere .= " a.status=".intval($status)." and ";			
	(strlen($enablecpc)>0) && $stwhere .= " a.enable_cpc=".intval($enablecpc)." and ";		
	(strlen($start_date)>0) && $stwhere .= " a.create_time>=".__strtotime($start_date)." and ";	
	(strlen($end_date)>0) && $stwhere .= " a.create_time<=".__strtotime($end_date)." and ";		
	if(strlen($searchtype)>0 && strlen($searchkey)>0) {
		$querykey = "%".$searchkey."%";
		$stwhere .= " $searchtype like ".sqlEscape($querykey)." and ";			
	}
	(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);
	$objAffiliate = LOAD::loadDB("Affiliate");
	$totalnum = $objAffiliate->getAffWebSiteTotalCount($stwhere);
	$totalpage = ceil($totalnum/$perpage);
	$db_affwebsitelist = $objAffiliate->getAffWebSiteAllPageList($curpage,$perpage,$stwhere,"id");
	unset($objAffiliate);
}
include PrintEot($job);
footer(true);
?>