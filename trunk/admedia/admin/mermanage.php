<?php 
include_once('rolecontrol.php');	

InitGetPost(array('status','itype','all','auditstatus'));

!empty($status) && $transtr .= "&status=$status";
!empty($itype) && $transtr .= "&itype=$itype";

if($action=="new" || $action=="edit"){
	$objCommData = LOAD::loadDB("CommonData");
	$db_tradelist = $objCommData->getBaseSortKeyList("trade");
	$db_sourcelist = $objCommData->getBaseSortKeyList("clientsource");
	$db_phaselist = $objCommData->getBaseSortKeyList("clientphase");
	$db_scalelist = $objCommData->getBaseSortKeyList("companyscale");
	$op_tradelist='';$op_sourcelist='';$op_phaselist='';$op_scalelist="";	
	if(empty($curid)){
		$op_tradelist = loadBaseSortList("trade");
		$op_sourcelist = loadBaseSortList("clientsource");
		$op_phaselist = loadBaseSortList("clientphase");
		$op_scalelist =  loadBaseSortList("companyscale");
		$op_provincelist = loadProvinceList($sel_province);
		$op_citylist = loadCityList($sel_province[id]);
		$op_sellerlist = loadUserList(3,$AffUser[id]);			
	}else{
		$objMerchant = LOAD::loadDB("Merchant");
		$db_merchant = $objMerchant->getMerchant($curid);
		$op_tradelist = loadBaseSortList("trade",$db_merchant[trade]);
		$op_sourcelist = loadBaseSortList("clientsource",$db_merchant[client_source]);
		$op_phaselist = loadBaseSortList("clientphase",$db_merchant[phase]);
		$op_scalelist =  loadBaseSortList("companyscale",$db_merchant[scale]);
		$op_provincelist = loadProvinceList($sel_province,$db_merchant[province_id]);
		$op_citylist = loadCityList($sel_province[id],$db_merchant[city_id]);
		$op_sellerlist = loadUserList(3,$db_merchant[seller_id]);	
	}
}else if($action=="audit"){
	include PrintEot($job);
	footer(true);	
}else if($action=="auditsave"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}
	$arrfield = array("audit_id"=>$AdminUser[id],"audit_name"=>$AdminUser[login_name],"create_time"=>$timestamp,"target_ids"=>$ids,
								"parent_id"=>0,"level"=>0,"auditstatus"=>$_POST[auditstatus],"content"=>$_POST[content],"itype"=>4);
	$objSystem = LOAD::loadDB("System");	
	$sysaudit_id = $objSystem->insertSysAudit($arrfield);
	$objMerchant = LOAD::loadDB("Merchant");	
	$objMerchant->updateMerchantStatus($ids,$sysaudit_id,$auditstatus);
	echo "<script>window.returnValue='1';window.close();</script>";
	unset($objSystem,$objMerchant,$arrfield,$sysaudit_id);
	exit;
}else if($action=="save"){
	$objMerchant = LOAD::loadDB("Merchant");	
	$objSysUser = LOAD::loadDB("AdminUser");
	$db_sysuser = $objSysUser->getSysUser($_POST[seller_id]);
	if($db_sysuser) $_POST[seller_name] = $db_sysuser[login_name];	
	if(empty($curid)){
		$_POST[create_time] = $timestamp;
		$filename = $timestamp.$sec.str_replace(".","",$millsec).substr($_FILES['logo_file']['name'],strripos($_FILES['logo_file']['name'],'.'));	
		if(uploadFile($_FILES['logo_file']['tmp_name'],$cfg_basepath.$cfg_upfilepath.'merlogo/'.$filename)){
			$_POST[logo] = $cfg_upfilepath.'merlogo/'.$filename;			
		}
		$insertid = $objMerchant->insertMerchant($_POST);
		writeSysLog(1,"新增广告主", $AdminUser[login_name]."新增广告主ID:".$insertid.",广告主内容:".implode(",",$_POST));			
	}else{
		$filename = $timestamp.$sec.str_replace(".","",$millsec).substr($_FILES['logo_file']['name'],strripos($_FILES['logo_file']['name'],'.'));	
		if(uploadFile($_FILES['logo_file']['tmp_name'],$cfg_basepath.$cfg_upfilepath.'merlogo/'.$filename)){
			$_POST[logo] = $cfg_upfilepath.'merlogo/'.$filename;	
		}
		$objMerchant->updateMerchant($curid,$_POST);
		writeSysLog(2,"修改广告主", $AdminUser[login_name]."修改广告主ID:".$curid.",广告主内容:".implode(",",$_POST));					
	}
	ObHeader($admin_file.$transtr);
}else if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
		$objMerchant = LOAD::loadDB("Merchant");
		$objMerchant->deleteMerchantBatch($ids);
		writeSysLog(3, "删除广告主", $AdminUser[login_name]."删除广告主ID:".$ids);		
		unset($objMerchant,$ids);
		ObHeader($admin_file.$transtr);
	}
}else if(empty($action)){
	$objMerchant = LOAD::loadDB("Merchant");
	$stwhere = "";
	(!empty($status) || $status=="0") && $stwhere .= " a.status=$status";
	(!empty($itype) || $itype=="0") && $stwhere .= " a.client_type=$itype";	
	
	$totalnum = $objMerchant->getMerchantTotalCount();
	$totalpage = ceil($totalnum/$perpage);	
	$db_merlist = $objMerchant->getMerchantPageList($curpage,$perpage,$stwhere,"a.create_time");
}

include PrintEot($job);
footer(true);


?>