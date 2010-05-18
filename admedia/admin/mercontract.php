<?php 

if(empty($action)){
	$objMerchant = LOAD::loadDB("Merchant");
	$totalnum = $objMerchant->getMerContractTotalCount();
	$totalpage = ceil($totalnum%$perpage);
	$db_mercontractlist = $objMerchant->getMerContractPageList($curpage,$perpage);
}else if($action=="new"){
	$objMerchant = LOAD::loadDB("Merchant");	
	$op_merchantlist = loadMerchantList(1);
	$op_merchancelist = loadMerChanceList();	
}else if($action=="edit"){
	$objMerchant = LOAD::loadDB("Merchant");
	$db_mercontract = $objMerchant->getMerContract($curid);
	$op_merchantlist = loadMerchantList(1,$db_mercontract[mer_id]);	
	$op_merchancelist = loadMerChanceList($db_mercontract[chance_id]);
}else if($action=="save"){
	$objMerchant = LOAD::loadDB("Merchant");	
	if(empty($curid)){
		$objMerchant->insertMerContract($_POST);
	}else{
		$objMerchant->updateMerContract($curid,$_POST);
	}
	unset($objMerchant);
	ObHeader("$basename?job=mercontract$transtr");
	exit;
}

include PrintEot($job);
footer(true);

?>