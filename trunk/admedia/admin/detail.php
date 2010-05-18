<?php
InitGetPost(array("aff_id","mer_id","backurl"));

if($action=="affiliate"){
	$aff_id = $curid;
	$objAffUser = LOAD::loadDB("Affiliate");
	$db_affiliate = $objAffUser->getAffiliate($curid);
	if($db_affiliate) $db_affpayinfolist = $objAffUser->getAffPayInfoByAffId($curid);
}
if($action=="newpayinfo"){
	$objCommData = LOAD::loadDB("CommonData");
	$op_paymethodlist = loadBaseSortList("bank");
}
if($action=="editpayinfo"){
	$objAffUser = LOAD::loadDB("Affiliate");
	$db_payinfo = $objAffUser->getAffPayInfo($curid);
	$objCommData = LOAD::loadDB("CommonData");
	$op_paymethodlist = loadBaseSortList("bank",$db_payinfo[pay_method]);
} 	
if($action=="delpayinfo"){
	$objAffUser = LOAD::loadDB("Affiliate");
	$objAffUser->deleteAffPayInfo($curid);
	ObHeader("$basename?job=detail&action=affiliate&curid=$aff_id");
}
if($action=="savepayinfo"){
	$objAffUser = LOAD::loadDB("Affiliate");
	if(isset($curid) && empty($curid))
		$objAffUser->insertAffPayInfo($_POST);
	else
		$objAffUser->updateAffPayInfo($curid,$_POST);
	echo "<script>window.returnValue='1';window.close();</script>";
	exit;
}
if($action=="editpayinfo"){
	$objAffUser = LOAD::loadDB("Affiliate");
	$objAffUser->updateAffPayInfo($curid,$_POST);
}
if($action=="merchant"){
	$objMerchant = LOAD::loadDB("Merchant");
	$db_merchant = $objMerchant->getMerchant($mer_id);
	if($db_merchant){
		$db_defaultman  = $objMerchant->getDefaultMerLinkMan($mer_id);
		$db_advlist = $objMerchant->getMerAdvList($mer_id);
	}
}
if($action=="website"){
	
}

include PrintEot($job);
footer(true);	
?>