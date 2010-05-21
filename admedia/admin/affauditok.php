<?php 

InitGetPost(array('status','source','all','auditstatus','start_date','end_date'));

strlen($source)>0 && $transtr .= "&source=$source";
strlen($start_date)>0 && $transtr .= "&start_date=$start_time";
strlen($end_date)>0&& $transtr .= "&end_date=$end_date";
(strlen($searchtype)>0 && strlen($searchkey)>0) && $transtr .= "&searchtype=".$searchtype."&searchkey=$searchkey";

if(empty($action) || $action=="select"){
	$objAffUser = LOAD::loadDB("Affiliate");
	
	$stwhere = " status=1 and ";	
	(strlen($source)>0 || $source=="0") && $stwhere .= " source=$source and ";
	(strlen($start_date)>0) && $stwhere .= " create_time>=".__strtotime($start_date)." and ";	
	(strlen($end_date)>0) && $stwhere .= " create_time<=".__strtotime($end_date)." and ";		
	if(strlen($searchtype)>0 && strlen($searchkey)>0) {
		$querykey = "%".$searchkey."%";
		$stwhere .= " $searchtype like ".sqlEscape($querykey)." and ";			
	}
	(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);
	
	$totalnum = $objAffUser->getAffiliateTotalCount($stwhere);	
	$totalpage = ceil($totalnum/$perpage);

	$db_afflist = $objAffUser->getAffiliatePageList($curpage,$perpage,$stwhere,"update_time");
	include PrintEot($job);
	footer(true);
	unset($objAffUser,$totalnum,$db_afflist);
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
		unset($objAffUser,$ids);
		ObHeader("admincp.php?job=affauditok".$transtr);
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
		}else{
			$basename = $GLOBALS['pmServer']['HTTP_REFERER'];			
			adminMsg("username_exists");
		}
	}else{
		$objAffUser->updateAffiliate($curid,$_POST);
	}
	ObHeader("admincp.php?job=affauditok".$transtr);	
}else if($action=="black"){
	include PrintEot($job);
	footer(true);
}else if($action=="blacksave"){
    $objSystem = LOAD::loadDB("System");	
	$objAffUser = LOAD::loadDB("Affiliate");
	$ids = substr($ids,0,strlen($ids)-1);	
	if(strpos($ids,',')>0){
		$arrids = split(',',$ids);
		foreach($arrids as $affid){
			$db_affiliate = getAffiliate($affid);
			$blacklist = array("platform"=>"aff","user_id"=>$affid,"user_name"=>$db_affiliate[login_name],"lock_time"=>$timestamp,"status"=>0,
										  "lock_id"=>$AdminUser[id],"lock_user"=>$AdminUser[login_name],"memo"=>$_POST[memo]);
			$objSystem->insertSysBlackList($blacklist);
		}
	}else{
		$db_affiliate = getAffiliate($ids);
		$blacklist = array("platform"=>"aff","user_id"=>$ids,"user_name"=>$db_affiliate[login_name],"lock_time"=>$timestamp,"status"=>0,
										  "lock_id"=>$AdminUser[id],"lock_user"=>$AdminUser[login_name],"memo"=>$_POST[memo]);
		$objSystem->insertSysBlackList($blacklist);
	}
	$objAffUser->updateAffiliateStatus($ids,0,4);
	//echo "<script>window.returnValue='1';window.close();</script>";
	//unset($objSystem,$objAffUser,$ids);
	//exit;
	//ObHeader("admincp.php?job=affauditok".$transtr);	
}

unset($job,$action);

?>