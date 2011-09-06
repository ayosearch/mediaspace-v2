<?php
include_once('rolecontrol.php');	

$stwhere = " a.is_del=1 and ";
(!empty($status) || $status=="0") && $stwhere .= " a.status=$status and ";
(!empty($itype) || $itype=="0") && $stwhere .= " a.client_type=$itype and ";	
if(!empty($searchtype) && !empty($searchkey)) {
	$querykey = "%".$searchkey."%";
	$stwhere .= " $searchtype like ".sqlEscape($querykey)." and ";			
}
(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);		

$objMerchant = LOAD::loadDB("Merchant");
$totalnum = $objMerchant->getMerchantTotalCount($stwhere);
$totalpage = ceil($totalnum%$perpage);
$db_merlist = $objMerchant->getMerchantPageList($curpage,$perpage,$stwhere,"a.create_time");

include PrintEot($job);
footer(true); 
?>