<?php 

if(empty($action)){
	$objMerchant = LOAD::loadDB("Merchant");
	$totalnum = $objMerchant->getMerPayRecTotalCount();
	$totalpage = ceil($totalnum%$perpage);
	$db_merpayreclist = $objMerchant->getMerPayRecPageList($curpage,$perpage);
}

if($action=="new"){
	$objMerchant = LOAD::loadDB("Merchant");
	$op_merchantlist = loadMerchantList(1);
	$op_mercontractlist = loadMerContractList(1);
}

include PrintEot($job);
footer(true);

?>