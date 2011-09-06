<?php 
require_once('global.php');
$objMerchant = LOAD::loadDB("Merchant");
$db_mercontractlist = $objMerchant->getMerContractAll(1);
if($db_mercontractlist && count($db_mercontractlist)>0){
	$expireIds = "";
	foreach($db_mercontractlist as $db_mercontract){
		$endtime = __strtotime($db_mercontract[end_date]." 00:00:00");
		if($timestamp>=$endtime){
			$expireIds .= $db_mercontract[id].",";
		}
	}
	if(!empty($expireIds)){
		$expireIds = substr($expireIds,0,strlen($expireIds)-1);
		$objMerchant->updateMerContractStatus($expireIds,2);
		echo "1";
	}
}
echo "0";
?>