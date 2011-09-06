<?php 
include_once('rolecontrol.php');	

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
		writeSysLog(1, "新增站长广告位", $AdminUser[login_name]."新增广告位:".implode(',',$_POST));
	}else{
		$_POST[update_time] = $timestamp;
		unset($_POST[status],$_POST[audit],$_POST[aff_id]);
		$objAffiliate->updateAffAdvPlace($curid,$_POST);
		writeSysLog(2, "修改站长广告位", $AdminUser[login_name]."广告位ID:,".$curid.",内容:".implode(',',$_POST));
	}
	ObHeader($admin_file.$transtr);
}else if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}	
	$objAffiliate = LOAD::loadDB("Affiliate");
	$objAffiliate->deleteBatchAffAdvPlace($ids);
	writeSysLog(3, "删除站长广告位", $AdminUser[login_name]."删除广告位:,".$ids);
	ObHeader($admin_file.$transtr);
}else if($action=="auditsave"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}
	$arrfield = array("audit_id"=>$AdminUser[id],"audit_name"=>$AdminUser[login_name],"create_time"=>$timestamp,"target_ids"=>$ids,
								"parent_id"=>0,"level"=>0,"auditstatus"=>$auditstatus,"content"=>$_POST[content],"itype"=>3);
	$objSystem = LOAD::loadDB("System");	
	$sysaudit_id = $objSystem->insertSysAudit($arrfield);
	$objAffUser = LOAD::loadDB("Affiliate");	
	$_POST[create_time] = $timestamp;
	$objAffUser->updateAffAdvPlaceAudit($ids,$sysaudit_id,$auditstatus);
	writeSysLog(4, "审核站长广告位", $AdminUser[login_name]."审核广告位:,".$ids.",状态:".$auditstatus);
	echo "<script>window.returnValue='1';window.close();</script>";
	unset($objSystem,$objAffUser,$arrfield);
	exit;	
}else if(empty($action) || $action=="select"){
	$stwhere = " a.is_del=0 and ";
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
	$db_affadplacelist = $objAffiliate->getAffAdvPlacePageList($curpage,$perpage,$stwhere,"a.create_time");
}
include PrintEot($job);
footer(true);
?>