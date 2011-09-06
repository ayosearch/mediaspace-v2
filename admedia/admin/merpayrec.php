<?php 
include_once('rolecontrol.php');	

InitGetPost(array('status','sure_id','mer_id','real_money'));

!empty($status) && $transtr .= "&status=$status";
(!empty($searchtype) && !empty($searchkey)) && $transtr .= "&searchtype=".$searchtype."&searchkey=$searchkey";

if($action=="new"){
	$objMerchant = LOAD::loadDB("Merchant");
	$op_merchantlist = loadMerchantList(1);
	$op_surelist = loadUserList(3);			
}else if($action=="edit"){
	$objMerchant = LOAD::loadDB("Merchant");
	$db_merpayrec = $objMerchant->getMerPayrec($curid);
	$op_merchantlist = loadMerchantList(1,$db_merpayrec[mer_id]);
	$op_mercontractlist = loadMerContractList(1,$db_merpayrec[contract_id],$db_merpayrec[mer_id]);	
	$op_surelist = loadUserList(3,$db_merpayrec[sure_id]);			
}else if($action=="save"){
	$_POST[creator_id] = $AdminUser[id];
	$_POST[creator_user] = $AdminUser[login_name];
	$objSysUser = LOAD::loadDB("AdminUser");
	if($sure_id && strlen($sure_id)>0){
		$db_sysuser = $objSysUser->getSysUser($sure_id);
		if($db_sysuser) $_POST[sure_user] = $db_sysuser[login_name];
	}
	$objMerchant = LOAD::loadDB("Merchant");
	if(empty($curid)){
		$insertid = $objMerchant->insertMerPayrec($_POST);
		writeSysLog(1,"新增广告主收款", $AdminUser[login_name]."新增广告主收款ID:".$insertid.",广告主收款内容:".implode(",",$_POST));			
	}else{
		$objMerchant->updateMerPayrec($curid,$_POST);
		writeSysLog(2,"修改广告主收款", $AdminUser[login_name]."修改广告主收款ID:".$curid.",广告主收款内容:".implode(",",$_POST));		
	}
	if($_POST[status]==4 && isset($mer_id) && strlen($mer_id)>0){//款已到，增加到广告主的留存/透支金额中
		$objMerchant->updateMerchantOverDraft($mer_id,$real_money);
	}
	ObHeader($admin_file.$transtr);
}else if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
		$objMerchant = LOAD::loadDB("Merchant");
		$objMerchant->deleteMerPayrecBatch($ids);
		writeSysLog(3,"删除广告主收款", $AdminUser[login_name]."删除广告主收款ID:".$ids);				
		unset($objMerchant,$ids);
		ObHeader($admin_file.$transtr);
	}
}else if($action=="showmercontract"){
	$objMerchant = LOAD::loadDB("Merchant");	
	$op_mercontractlist = loadMerContractList(1,-1,$curid);
	unset($objMerchant);
}else if(empty($action)){
	$objAffUser = LOAD::loadDB("Merchant");
	$stwhere = " a.is_del=0 and ";	
	(!empty($source)) && $stwhere .= " a.status=".sqlEscape($status)." and ";		
	if(!empty($searchtype) && !empty($searchkey)) {
		$querykey = "%".$searchkey."%";
		$stwhere .= " $searchtype like ".sqlEscape($querykey)." and ";			
	}
	(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);
	
	$objMerchant = LOAD::loadDB("Merchant");
	$totalnum = $objMerchant->getMerPayRecTotalCount($stwhere);
	$totalpage = ceil($totalnum/$perpage);
	$db_merpayreclist = $objMerchant->getMerPayRecPageList($curpage,$perpage,$stwhere,"a.id");
}

include PrintEot($job);
footer(true);

?>