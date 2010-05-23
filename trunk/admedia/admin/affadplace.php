<?php 
InitGetPost(array('status','all','audit','auditstatus','start_date','end_date'));

strlen($status)>0 && $transtr .= "&status=$status";
strlen($audit)>0 && $transtr .= "&audit=$audit";
strlen($start_date)>0 && $transtr .= "&start_date=$start_time";
strlen($end_date)>0&& $transtr .= "&end_date=$end_date";
(strlen($searchtype)>0 && strlen($searchkey)>0) && $transtr .= "&searchtype=".$searchtype."&searchkey=$searchkey";

if($action=="new" || $action=="edit"){
	$objCommData = LOAD::loadDB("CommonData");
	if(isset($curid) && empty($curid)){
		$db_basesizelist = $objCommData->getBaseAdvSizeAll();
		$op_basesizelist = loadBaseAdvSize();
	}else{
		$objAffiliate = LOAD::loadDB("Affiliate");			
		$db_advplace = $objAffiliate->getAffAdvPlace($curid);
		$op_sitelist = loadAffSiteList(1,$db_advplace[aff_id],$db_advplace[site_id]);		
		$op_basesizelist = loadBaseAdvSize($db_advplace[adsize]);
	}
	unset($objAffiliate);
}else if($action=="save"){
	$objAffiliate = LOAD::loadDB("Affiliate");		
	if(isset($curid) && empty($curid)){
		$_POST[create_time] = $timestamp;
		$_POST[update_time] = $timestamp;		
		$objAffiliate->insertAffAdvPlace($_POST);
	}else{
		$_POST[update_time] = $timestamp;
		unset($_POST[status],$_POST[audit]);
		$objAffiliate->updateAffAdvPlace($curid,$_POST);
	}
	ObHeader("$basename?job=affadplace$transtr");	
}else if($action=="del"){
	$objAffiliate = LOAD::loadDB("Affiliate");
	$objAffiliate->deleteAffiliate($curid);
	ObHeader("$basename?job=affadplace");	
}else if($action=="auditsave"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}
	$arrfield = array("audit_id"=>$AdminUser[id],"audit_name"=>$AdminUser[login_name],"create_time"=>$timestamp,"target_ids"=>$ids,
								"parent_id"=>0,"level"=>0,"action"=>$aduitstatus,"content"=>$_POST[content],"itype"=>3);
	$objSystem = LOAD::loadDB("System");	
	$sysaudit_id = $objSystem->insertSysAudit($arrfield);
	$objAffUser = LOAD::loadDB("Affiliate");	
	$objAffUser->updateAffAdvPlaceAudit($ids,$sysaudit_id,$auditstatus);
	echo "<script>window.returnValue='1';window.close();</script>";
	unset($objSystem,$objAffUser,$arrfield);
	exit;	
}else if(empty($action)){
	$stwhere = "";
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