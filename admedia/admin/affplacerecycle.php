<?php
include_once('rolecontrol.php');	

if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}
	$objAffUser = LOAD::loadDB("Affiliate");
	$objAffUser->deleteAffAdvPlace($ids);
	writeSysLog(6, "清除站长广告位", $AdminUser[login_name]."清除站长广告位:".$ids);
	unset($objAffUser,$ids);
	ObHeader($admin_file.$transtr);
}else{
	$stwhere = " a.is_del=1 and ";
	($action=="select") && $stwhere .= " a.audit=1 and ";
	(strlen($status)>0) && $stwhere .= " a.status=$status and ";
	(strlen($audit)>0) && $stwhere .= " a.audit=$audit and ";	
	(strlen($start_date)>0) && $stwhere .= " a.create_time>=".__strtotime($start_date)." and ";	
	(strlen($end_date)>0) && $stwhere .= " a.create_time<=".__strtotime($end_date)." and ";		
	if(strlen($searchtype)>0 && strlen($searchkey)>0) {
		$querykey = "%".$searchkey."%";
		$stwhere .= " $searchtype like ".sqlEscape($querykey)." and ";			
	}	
	(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);	
	
	$objAffiliate = LOAD::loadDB("Affiliate");
	$totalnum = $objAffiliate->getAffAdvPlaceTotalCount($stwhere);
	$totalpage = ceil($totalnum/$perpage);
	$db_affadplacelist = $objAffiliate->getAffAdvPlacePageList($curpage,$perpage,$stwhere,"a.update_time");
}
	include PrintEot($job);
	footer(true);
?>