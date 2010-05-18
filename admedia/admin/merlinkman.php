<?php 

if($action=="new"){
	$objMerchant = LOAD::loadDB("Merchant");
	$op_merchantlist = loadMerchantList(1);
}else if($action=="edit"){
	$objMerchant = LOAD::loadDB("Merchant");
	$db_merlinkman = $objMerchant->getMerLinkMan($curid);
	$op_merchantlist = loadMerchantList(1,$db_merlinkman[mer_id]);
}else if($action=="save"){
	$objMerchant = LOAD::loadDB("Merchant");
	if(isset($curid) && empty($curid)){
		$_POST[create_time] = $timestamp;
		$objMerchant->insetMerLinkman($_POST);
	}else{
		$objMerchant->updateMerLinkman($_POST);
	}
}
if(empty($action)){
	$objMerchant = LOAD::loadDB("Merchant");
	$totalnum = $objMerchant->getMerLinkManTotalCount();
	$totalpage = ceil($totalnum%$perpage);
	$db_merlinkmanlist = $objMerchant->getMerLinkManPageList($curpage,$perpage);
}

include PrintEot($job);
footer(true);


?>