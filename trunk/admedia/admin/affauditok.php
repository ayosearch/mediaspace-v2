<?php 
include_once('rolecontrol.php');	

InitGetPost(array('status','source','all','auditstatus','start_date','end_date'));

strlen($source)>0 && $transtr .= "&source=$source";
strlen($start_date)>0 && $transtr .= "&start_date=$start_time";
strlen($end_date)>0&& $transtr .= "&end_date=$end_date";
(strlen($searchtype)>0 && strlen($searchkey)>0) && $transtr .= "&searchtype=".$searchtype."&searchkey=$searchkey";

if($action=="hassite"){
	$objAffUser = LOAD::loadDB("Affiliate");
	$stwhere = " a.is_del=0 and a.status=1 and b.status=1 ";	
	
	$totalnum = $objAffUser->getAffiliateHaveSiteTotalCount($stwhere);	
	$totalpage = ceil($totalnum/$perpage);

	$db_afflist = $objAffUser->getAffiliateHaveSitePageList($curpage,$perpage,$stwhere,"a.id");
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
}else if($action=="black"){
	include PrintEot($job);
	footer(true);
}else if($action=="blacksave"){
    $objSystem = LOAD::loadDB("System");	
	$objAffUser = LOAD::loadDB("Affiliate");
	$ids = substr($ids,0,strlen($ids)-1);	
	$insertId = 0;
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
		$arrids = split(',',$ids);
		foreach($arrids as $affid){
			$db_affiliate = getAffiliate($affid);
			$blacklist = array("platform"=>"aff","user_id"=>$affid,"user_name"=>$db_affiliate[login_name],"lock_time"=>$timestamp,"status"=>0,
										  "lock_id"=>$AdminUser[id],"lock_user"=>$AdminUser[login_name],"memo"=>$_POST[memo]);
			$insertId = $objSystem->insertSysBlackList($blacklist);
			$objAffUser->updateAffiliateStatus($affid,$insertId,4);
			writeSysLog(4, "设置站长黑名单", $AdminUser[login_name]."站长ID:".$ids);
		}
	}else{
		$db_affiliate = getAffiliate($ids);
		$blacklist = array("platform"=>"aff","user_id"=>$ids,"user_name"=>$db_affiliate[login_name],"lock_time"=>$timestamp,"status"=>0,
										  "lock_id"=>$AdminUser[id],"lock_user"=>$AdminUser[login_name],"memo"=>$_POST[memo]);
		$insertId = $objSystem->insertSysBlackList($blacklist);
		$objAffUser->updateAffiliateStatus($ids,$insertId,4);
		writeSysLog(4, "设置站长黑名单", $AdminUser[login_name]."站长ID:".$ids);
	}
	
	echo "<script>window.returnValue='1';window.close();</script>";
	unset($objSystem,$objAffUser,$ids);
	//exit;
	ObHeader($admin_file.$transtr);
}else if($action=="select" || empty($action)){
	$objAffUser = LOAD::loadDB("Affiliate");
	
	$stwhere = " is_del=0 and status in (1,4) and ";	
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

	$db_afflist = $objAffUser->getAffiliatePageList($curpage,$perpage,$stwhere,"audit_time");
	include PrintEot($job);
	footer(true);
	unset($objAffUser,$totalnum,$db_afflist);
}

unset($job,$action);

?>