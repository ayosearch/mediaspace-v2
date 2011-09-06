<?php 
include_once('rolecontrol.php');	

if($action=="new"){
	$objCommData = LOAD::loadDB("CommonData");
	$op_phaselist = loadBaseSortList("clientphase");
	$op_sourcelist = loadBaseSortList("clientsource");
	$op_sellerlist = loadUserList(3,$AffUser[id]);
}else if($action=="edit"){
	$objMerchant = LOAD::loadDB("Merchant");
	$db_chance = $objMerchant->getMerChance($curid);
	$objCommData = LOAD::loadDB("CommonData");
	$op_phaselist = loadBaseSortList("clientphase",$db_chance[phase]);
	$op_sourcelist = loadBaseSortList("clientsource",$db_chance[clientsource]); 	
	$op_sellerlist = loadUserList(3,$db_chance[seller_id]);	
}else if($action=="save"){
	$_POST[creator_id] = $AdminUser[id];
	$_POST[creator_name] = $AdminUser[login_name];
	$objSysUser = LOAD::loadDB("AdminUser");
	$db_sysuser = $objSysUser->getSysUser($_POST[seller_id]);
	if($db_sysuser) $_POST[seller_name] = $db_sysuser[login_name];
	$objMerchant = LOAD::loadDB("Merchant");
	if(empty($curid)){
		$insertid = $objMerchant->insertMerChance($_POST);
		writeSysLog(1,"新增广告机会", $AdminUser[login_name]."新增广告主ID:".$insertid.",内容:".implode(",",$_POST));		
	}else{
		$objMerchant->updateMerChance($curid,$_POST);
		writeSysLog(3,"修改广告机会", $AdminUser[login_name]."修改广告主ID:".$curid.",内容:".implode(",",$_POST));		
	}
	ObHeader($admin_file.$transtr);
	exit;
}else if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}
	if(strlen($ids)>0){
		$objAdvertise = LOAD::loadDB("Merchant");
		$objAdvertise->deleteBatchMerChance($ids);
		writeSysLog(3, "删除广告机会", $AdminUser[login_name]."删除广告机会:".$ids);		
	}
	ObHeader($admin_file.$transtr);	
	exit;
}else if(empty($action)){
	$objMerchant = LOAD::loadDB("Merchant");
	$totalnum = $objMerchant->getMerChanceTotalCount();
	$totalpage = ceil($totalnum/$perpage);
	$db_merchancelist = $objMerchant->getMerChancePageList($curpage,$perpage);
	include PrintEot($job);
	footer(true);
}

include PrintEot($job);
footer(true);
?>