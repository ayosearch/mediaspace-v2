<?php 
include_once('rolecontrol.php');	

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
	$db_sitelist = $objAffiliate->getAffSiteStatusList($db_advapply[aff_id],1);
	unset($objAffiliate,$objAdvertise);
}else if($action=="save"){
	$objAffiliate = LOAD::loadDB("Affiliate");		
	if(empty($curid)){
		$_POST[create_time] = $timestamp;
		$objAffiliate->insertAffAdvApply($_POST);
		writeSysLog(1, "新增站长投放申请", $AdminUser[login_name]."新增投放申请内容".implode(',',$_POST));
	}else{
		$objAffiliate->updateAffAdvApply($curid,$_POST);
		writeSysLog(2, "修改站长投放申请", $AdminUser[login_name]."修改投放id:".$curid.",内容:".implode(',',$_POST));
	}
	unset($objAffiliate);
	ObHeader($admin_file.$transtr);
}else if($action=="audit"){
	//$objAffiliate = LOAD::loadDB("Affiliate");
}else if($action=="auditsave"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}
	$arrfield = array("audit_id"=>$AdminUser[id],"audit_name"=>$AdminUser[login_name],"create_time"=>$timestamp,"target_ids"=>$ids,
								"parent_id"=>0,"level"=>0,"auditstatus"=>$auditstatus,"content"=>$_POST[content],"itype"=>2);
	$objSystem = LOAD::loadDB("System");	
	$sysaudit_id = $objSystem->insertSysAudit($arrfield);
	$objAffUser = LOAD::loadDB("Affiliate");	
	//$objAffUser->updateAffWebSiteStatus($ids,$sysaudit_id,$auditstatus);
	$objAffUser->updateAffAdvApplyStatus($ids,$sysaudit_id,$auditstatus);
	writeSysLog(4, "审核站长投放申请", $AdminUser[login_name]."相关广告:,".$ids.",状态:".$auditstatus);
	echo "<script>window.returnValue='1';window.close();</script>";
	unset($objSystem,$objAffUser,$arrfield);
	exit;
}else if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}		
	$objAffiliate = LOAD::loadDB("Affiliate");
	$objAffiliate->deleteAffAdvApply($ids);
	writeSysLog(3, "删除站长投放申请", $AdminUser[login_name]."删除投放id:".$ids);
	unset($objAffiliate);	
	ObHeader($admin_file.$transtr);
}else if(empty($action) || $action=="select"){
	$stwhere = "";	
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