<?php 
InitGetPost(array('status','enablecpc','all','start_date','end_date','auditstatus'));

strlen($status)>0 && $transtr .= "&status=$status";
strlen($enablecpc)>0 && $transtr .= "&enablecpc=$enablecpc";
strlen($start_date)>0 && $transtr .= "&start_date=$start_time";
strlen($end_date)>0 && $transtr .= "&end_date=$end_date";
(strlen($searchtype)>0 && strlen($searchkey)>0) && $transtr .= "&searchtype=".$searchtype."&searchkey=$searchkey";

if(isset($action) && $action=="new"){
	$objCommData = LOAD::loadDB("CommonData");
	$op_sortlist = loadBaseSortList("sitetype");
	unset($objCommData,$db_sortlist);
}else if($action=="edit"){
	$objCommData = LOAD::loadDB("CommonData");
	$objAffiliate = LOAD::loadDB("Affiliate");	
	$db_affsite = $objAffiliate->getAffWebSite($curid);
	$op_sortlist = loadBaseSortList("sitetype",$db_affsite[sitetype]);		
}else if($action=="save"){
	$objAffiliate = LOAD::loadDB("Affiliate");
	if(isset($curid) && empty($curid)){
		$_POST[create_time] = $timestamp;
		$objAffiliate->insertAffWebsite($_POST);
	}else{
		$objAffiliate->updateAffWebsite($curid,$_POST);
	}
	unset($objAffiliate,$curid);
	ObHeader("$basename?job=affsiteaudit".$transtr);	
}else if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}
	$objAffiliate = LOAD::loadDB("Affiliate");
	$objAffiliate->deleteAffWebSite($ids);
	unset($objAffiliate);
	ObHeader("$basename?job=affsiteaudit".$transtr);
}else if($action=="auditsave"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}
	$arrfield = array("audit_id"=>$AdminUser[id],"audit_name"=>$AdminUser[login_name],"create_time"=>$timestamp,"target_ids"=>$ids,
								"parent_id"=>0,"level"=>0,"auditstatus"=>$aduitstatus,"content"=>$_POST[content],"itype"=>1);
	$objSystem = LOAD::loadDB("System");	
	$sysaudit_id = $objSystem->insertSysAudit($arrfield);
	$objAffUser = LOAD::loadDB("Affiliate");	
	$objAffUser->updateAffWebSiteStatus($ids,$sysaudit_id,$auditstatus);
	echo "<script>window.returnValue='1';window.close();</script>";
	unset($objSystem,$objAffUser,$arrfield);
	exit;
}else if($action=="selsite"){
	$objAffiliate = LOAD::loadDB("Affiliate");	
	$db_sitelist = $objAffiliate->getAffWebSiteByAffId($curid);
	unset($objAffiliate);
	include PrintEot($job);
	exit;
}else if($action=="lock"){
	$objAffiliate = LOAD::loadDB("Affiliate");
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}	
	$objAffUser->updateAffWebSiteStatus($ids,0,3);
	ObHeader("$basename?job=affsiteaudit".$transtr);	
}else if(empty($action)){
	$stwhere = " a.is_del=0 and ";
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