<?php 
require_once('global.php');
$objMerchant = LOAD::loadDB("Merchant");
$db_merlist = $objMerchant->getMerchantAll(1);
$cut_ids = "";
$unuse_ids = "";
foreach($db_merlist as $db_mer){
	if($db_mer[deposit]>$db_mer[over_draft]){
		if(intval($db_mer[credit])>0){
			$cut_ids .= $db_mer[id].",";
			$arrDeposit = array("mer_id"=>$db_mer[id],"curr_fee"=>$db_mer[over_draft],"itype"=>0,"create_time"=>$timestamp);
			$objMerchant->insertMerDeposit($arrDeposit);
		}else{
			$unuse_ids .= $db_mer[id].",";
			$arrDeposit = array("mer_id"=>$db_mer[id],"curr_fee"=>$db_mer[over_draft],"itype"=>1,"create_time"=>$timestamp);
			$objMerchant->insertMerDeposit($arrDeposit);			
		}
	}
}
if(strlen($cut_ids)>0 && strpos($cut_ids,',')){
	$cut_ids = substr($cut_ids,0,strlen($cut_ids)-1);
	$objMerchant->updateMerchantCredit($cut_ids,-5);
}
if(strlen($unuse_ids)>0 && strpos(",",$unuse_ids)){
	$unuse_ids = substr($unuse_ids,0,strlen($unuse_ids)-1);
	$objMerchant->updateMerchantClientType($unuse_ids,2);
}
echo "1";
?>