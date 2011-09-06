<?php 
include_once('rolecontrol.php');	
InitGetPost(array('source','all','auditstatus','start_date','end_date','orderby'));

!empty($source) && $transtr .= "&source=$source";
!empty($start_date) && $transtr .= "&start_date=$start_time";
!empty($end_date) && $transtr .= "&end_date=$end_date";
(!empty($searchtype) && !empty($searchkey)) && $transtr .= "&searchtype=".$searchtype."&searchkey=$searchkey";

if(empty($action) || $action=="select"){
	$objAffUser = LOAD::loadDB("Affiliate");
	
	$stwhere = " is_del=0 and status in (0,2) and ";	
	(!empty($source)) && $stwhere .= " source=".sqlEscape($source)." and ";		
	(!empty($start_date)) && $stwhere .= " create_time>=".__strtotime($start_date)." and ";	
	(!empty($end_date)) && $stwhere .= " create_time<=".__strtotime($end_date)." and ";		
	if(!empty($searchtype) && !empty($searchkey)) {
		$querykey = "%".$searchkey."%";
		$stwhere .= " $searchtype like ".sqlEscape($querykey)." and ";			
	}
	(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);
	
	$totalnum = $objAffUser->getAffiliateTotalCount($stwhere);	
	$totalpage = ceil($totalnum/$perpage);

	$db_afflist = $objAffUser->getAffiliatePageList($curpage,$perpage,$stwhere,"create_time");
	include PrintEot($job);
	footer(true);
	unset($objAffUser,$totalnum,$db_afflist);
}else if($action=="new"){
	$objCommData = LOAD::loadDB("CommonData");
	//$op_arealist = loadAreaList($sel_area);	
	$op_provincelist = loadProvinceList($sel_province);
	$op_citylist = loadCityList($sel_province[id]);	
	include PrintEot($job);
	footer(true);	
	unset($objCommData,$op_arealist,$op_provincelist,$op_citylist);
}else if($action=="edit"){
	$objAffUser = LOAD::loadDB("Affiliate");
	$objCommData = LOAD::loadDB("CommonData");	
	$db_affiliate = $objAffUser->getAffiliate($curid);
	$op_provincelist = loadProvinceList($sel_province,$db_affiliate[province_id]);
	$op_citylist = loadCityList($sel_province[id],$db_affiliate[city_id]);		
	include PrintEot($job);
	footer(true);	
	unset($objAffUser,$db_affiliate);
}else if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
		$objAffUser = LOAD::loadDB("Affiliate");
		$objAffUser->deleteAffiliateBatch($ids);
		writeSysLog(3, "删除站长", $AdminUser[login_name]."删除站长:".$ids);
		unset($objAffUser,$ids);
		ObHeader($admin_file.$transtr);
	}
}else if($action=="selcity"){
	$objCommData = LOAD::loadDB("CommonData");
	$op_provincelist = loadProvinceList($sel_province,intval($curid));	
	$op_citylist = loadCityList($sel_province[id]);
	include PrintEot($job);
	exit;
}else if($action=="save"){
	$objAffUser = LOAD::loadDB("Affiliate");
	$_POST[login_pwd]=pwdCode($_POST[login_srcpwd]);
	$_POST[source] = "1";
	if(empty($curid)){
		if($objAffUser->checkAffiliate($_POST[login_name])){
			$_POST[create_time]=$timestamp;
			$_POST[service_id] = $AdminUser[id];
			$_POST[service_name] = $AdminUser[login_name];
			$objAffUser->insertAffiliate($_POST);
			writeSysLog(1, "新增站长", $AdminUser[login_name]."新增站长:".implode(",",$_POST));
		}else{
			$basename = $GLOBALS['pmServer']['HTTP_REFERER'];			
			adminMsg("username_exists");
		}
	}else{
		$objAffUser->updateAffiliate($curid,$_POST);
		writeSysLog(2, "修改站长", $AdminUser[login_name]."修改站长:".$curid.",内容:".implode(",",$_POST));
	}
	ObHeader($admin_file.$transtr);	
}else if($action=="auditsave"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}
	$arrfield = array("audit_id"=>$AdminUser[id],"audit_name"=>$AdminUser[login_name],"create_time"=>$timestamp,"target_ids"=>$ids,
								"parent_id"=>0,"level"=>0,"auditstatus"=>$auditstatus,"content"=>$_POST[content],"itype"=>0);
	$objSystem = LOAD::loadDB("System");	
	$sysaudit_id = $objSystem->insertSysAudit($arrfield);
	$objAffUser = LOAD::loadDB("Affiliate");	
	$objAffUser->updateAffiliateStatus($ids,$sysaudit_id,$auditstatus);
	writeSysLog(4, "审核站长", $AdminUser[login_name]."审核站长:".$ids.",状态:".$auditstatus);
	echo "<script>window.returnValue='1';window.close();</script>";
	unset($objSystem,$objAffUser,$arrfield);
	exit;
	//ObHeader("admincp.php?job=affmanage".$transtr);		
}else if($action=="audit"){
	include PrintEot($job);
	footer(true);	
}

unset($job,$action);

?>