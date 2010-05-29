<?php 

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
	}else{
		$objMerchant = LOAD::loadDB("Merchant");
		$db_merchant = $objMerchant->getMerchant($curid);
		$op_tradelist = loadBaseSortList("trade",$db_merchant[trade]);
		$op_sourcelist = loadBaseSortList("clientsource",$db_merchant[client_source]);
		$op_phaselist = loadBaseSortList("clientphase",$db_merchant[phase]);
		$op_scalelist =  loadBaseSortList("companyscale",$db_merchant[scale]);
		$op_provincelist = loadProvinceList($sel_province,$db_merchant[province_id]);
		$op_citylist = loadCityList($sel_province[id],$db_merchant[city_id]);
	}
}else if($action=="audit"){
	include PrintEot($job);
	footer(true);	
}else if($action=="auditsave"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}
	$arrfield = array("audit_id"=>$AdminUser[id],"audit_name"=>$AdminUser[login_name],"create_time"=>$timestamp,"target_ids"=>$ids,
								"parent_id"=>0,"level"=>0,"action"=>$_POST[auditstatus],"content"=>$_POST[content],"itype"=>4);
	$objSystem = LOAD::loadDB("System");	
	$sysaudit_id = $objSystem->insertSysAudit($arrfield);
	$objMerchant = LOAD::loadDB("Merchant");	
	$objMerchant->updateMerchantStatus($ids,$sysaudit_id,$auditstatus);
	echo "<script>window.returnValue='1';window.close();</script>";
	unset($objSystem,$objMerchant,$arrfield,$sysaudit_id);
	exit;
}else if($action=="save"){
	$objMerchant = LOAD::loadDB("Merchant");	
	if(empty($curid)){
		$_POST[create_time] = $timestamp;
		if(uploadFile($_FILES['logo_file']['tmp_name'],$cfg_upfilepath.'merlogo/'.$_FILES['logo_file']['name'])){
			$_POST[logo] = $cfg_upfilepath.'merlogo/'.$_FILES['logo_file']['name'];			
		}
		$objMerchant->insertMerchant($_POST);
	}else{
		if(uploadFile($_FILES['logo_file']['tmp_name'],$cfg_upfilepath.'merlogo/'.$_FILES['logo_file']['name'])){
			$_POST[logo] = $cfg_upfilepath.'merlogo/'.$_FILES['logo_file']['name'];			
		}		
		$objMerchant->updateMerchant($curid,$_POST);
	}
	ObHeader("$basename?job=mermanage$transtr");
}else if(empty($action)){
	$objMerchant = LOAD::loadDB("Merchant");
	$totalnum = $objMerchant->getMerchantTotalCount();
	$totalpage = ceil($totalnum%$perpage);
	$stwhere = "";
	(!empty($status) || $status=="0") && $stwhere .= " a.status=$status";
	(!empty($itype) || $itype=="0") && $stwhere .= " a.client_type=$itype";	
	$db_merlist = $objMerchant->getMerchantPageList($curpage,$perpage,$stwhere,"a.create_time");
}

include PrintEot($job);
footer(true);


?>