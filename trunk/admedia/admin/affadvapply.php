<?php 

InitGetPost(array('status','all','auditstatus','start_date','end_date'));

strlen($status)>0 && $transtr .= "&status=$status";
strlen($start_date)>0 && $transtr .= "&start_date=$start_time";
strlen($end_date)>0&& $transtr .= "&end_date=$end_date";
(strlen($searchtype)>0 && strlen($searchkey)>0) && $transtr .= "&searchtype=".$searchtype."&searchkey=$searchkey";

if($action=="new"){
	$objAdvertise = LOAD::loadDB("Advertise");
	$op_advlist = loadAdvertiseList(1);
	unset($objAdvertise);		
}else if($action=="edit"){
	$objAdvertise = LOAD::loadDB("Advertise");	
	$objAffiliate = LOAD::loadDB("Affiliate");		
	$db_advapply = $objAffiliate->getAffAdvApply($curid);
	$op_advlist = loadAdvertiseList(1,$db_advapply[adv_id]);
	$op_sitelist = loadAffSiteList(1,$db_advapply[aff_id],$db_advapply[site_id]);
	unset($objAffiliate,$objAdvertise);
}else if($action=="save"){
	$objAffiliate = LOAD::loadDB("Affiliate");		
	if(empty($curid)){
		$_POST[create_time] = $timestamp;
		$objAffiliate->insertAffAdvApply($_POST);
	}else{
		$objAffiliate->updateAffAdvApply($curid,$_POST);
	}
	unset($objAffiliate);
	ObHeader("$basename?job=affadvapply");	
}else if($action=="audit"){
	$objAffiliate = LOAD::loadDB("Affiliate");
	$objAffiliate->updateAffAdvApplyStatus($curid,$status);
}else if($action=="auditsave"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}
	$arrfield = array("audit_id"=>$AdminUser[id],"audit_name"=>$AdminUser[login_name],"create_time"=>$timestamp,"target_ids"=>$ids,
								"parent_id"=>0,"level"=>0,"auditstatus"=>$aduitstatus,"content"=>$_POST[content],"itype"=>2);
	$objSystem = LOAD::loadDB("System");	
	$sysaudit_id = $objSystem->insertSysAudit($arrfield);
	$objAffUser = LOAD::loadDB("Affiliate");	
	$objAffUser->updateAffWebSiteStatus($ids,$sysaudit_id,$auditstatus);
	echo "<script>window.returnValue='1';window.close();</script>";
	unset($objSystem,$objAffUser,$arrfield);
	exit;
}else if($action=="del"){
	$objAffiliate = LOAD::loadDB("Affiliate");
	$objAffiliate->deleteAffAdvApply($curid);
	unset($objAffiliate);	
	ObHeader("$basename?job=affadvplace");	
}else if(empty($action) || $action=="select"){
	$stwhere = "status in (0,2) and ";	
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