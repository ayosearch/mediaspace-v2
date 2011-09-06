<?php
include_once('rolecontrol.php');	

if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}
	$objAffUser = LOAD::loadDB("Affiliate");
	$objAffUser->deleteAffiliate($ids);
	writeSysLog(6, "清除站长", $AdminUser[login_name]."清除站长:".$ids);
	unset($objAffUser,$ids);
	ObHeader($admin_file.$transtr);
}else{
	$stwhere = " is_del=1 and ";	
	(!empty($source)) && $stwhere .= " source=".sqlEscape($source)." and ";		
	(!empty($start_date)) && $stwhere .= " create_time>=".__strtotime($start_date)." and ";	
	(!empty($end_date)) && $stwhere .= " create_time<=".__strtotime($end_date)." and ";		
	if(!empty($searchtype) && !empty($searchkey)) {
		$querykey = "%".$searchkey."%";
		$stwhere .= " $searchtype like ".sqlEscape($querykey)." and ";			
	}
	(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);
	
	$objAffUser = LOAD::loadDB("Affiliate");	
	$totalnum = $objAffUser->getAffiliateTotalCount($stwhere);	
	$totalpage = ceil($totalnum/$perpage);
	
	$db_afflist = $objAffUser->getAffiliatePageList($curpage,$perpage,$stwhere,"create_time");
	include PrintEot($job);
	footer(true);
	unset($objAffUser,$totalnum,$db_afflist);
}
include PrintEot($job);
footer(true);
?>