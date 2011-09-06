<?php 
include_once('rolecontrol.php');	

if(empty($action)){
	$objMerchant = LOAD::loadDB("Merchant");
	$totalnum = $objMerchant->getMerContractTotalCount();
	$totalpage = ceil($totalnum/$perpage);
	$db_mercontractlist = $objMerchant->getMerContractPageList($curpage,$perpage);
}else if($action=="new"){
	$objMerchant = LOAD::loadDB("Merchant");	
	$op_merchantlist = loadMerchantList(1);
	$op_merchancelist = loadMerChanceList();	
	$op_sellerlist = loadUserList(3,$AffUser[id]);			
}else if($action=="edit"){
	$objMerchant = LOAD::loadDB("Merchant");
	$db_mercontract = $objMerchant->getMerContract($curid);
	$op_merchantlist = loadMerchantList(1,$db_mercontract[mer_id]);	
	$op_merchancelist = loadMerChanceList($db_mercontract[chance_id]);
	$op_sellerlist = loadUserList(3,$db_mercontract[seller_id]);	
}else if($action=="save"){
	$objMerchant = LOAD::loadDB("Merchant");	
	$objSysUser = LOAD::loadDB("AdminUser");
	$db_sysuser = $objSysUser->getSysUser($_POST[seller_id]);
	if($db_sysuser) $_POST[seller_name] = $db_sysuser[login_name];
	if(empty($curid)){
		$filename = $timestamp.$sec.str_replace(".","",$millsec).substr($_FILES['contract_file']['name'],strripos($_FILES['contract_file']['name'],'.'));			
		if(uploadFile($_FILES['contract_file']['tmp_name'],$cfg_basepath.$cfg_upfilepath.'mercontract/'.$filename)){
			$_POST[file_path] = $cfg_upfilepath.'mercontract/'.$filename;			
		}
		$insertid = $objMerchant->insertMerContract($_POST);
		writeSysLog(1, "新增广告合同", $AdminUser[login_name]."新增广告合同:".$insertid.",内容:".implode(",",$_POST));		
	}else{
		$filename = $timestamp.$sec.str_replace(".","",$millsec).substr($_FILES['contract_file']['name'],strripos($_FILES['contract_file']['name'],'.'));			
		if(uploadFile($_FILES['contract_file']['tmp_name'],$cfg_basepath.$cfg_upfilepath.'mercontract/'.$filename)){
			$_POST[file_path] = $cfg_upfilepath.'mercontract/'.$filename;			
		}		
		$objMerchant->updateMerContract($curid,$_POST);
		writeSysLog(2, "修改广告合同", $AdminUser[login_name]."修改广告合同:".$curid.",内容:".implode(",",$_POST));			
	}
	unset($objMerchant);
	ObHeader($admin_file.$transtr);
	exit;
}else if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}
	if(strlen($ids)>0){
		$objAdvertise = LOAD::loadDB("Merchant");
		$objAdvertise->deleteBatchMerContract($ids);
		writeSysLog(3, "删除广告合同", $AdminUser[login_name]."删除广告合同:".$ids);		
	}
	ObHeader($admin_file.$transtr);	
	exit;
}

include PrintEot($job);
footer(true);

?>