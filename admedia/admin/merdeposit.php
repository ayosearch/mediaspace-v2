<?php 
include_once('rolecontrol.php');	

	(!empty($searchtype) && !empty($searchkey)) && $transtr .= "&searchtype=".$searchtype."&searchkey=$searchkey";
	$stwhere = "";
	if(!empty($searchtype) && !empty($searchkey)) {
		$querykey = "%".$searchkey."%";
		$stwhere .= " $searchtype like ".sqlEscape($querykey)." and ";			
	}
	(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);

	$objMerchant = LOAD::loadDB("Merchant");
	$totalnum = $objMerchant->getMerDepositTotalCount($stwhere);
	$totalpage = ceil($totalnum/$perpage);
	$db_merdepositlist = $objMerchant->getMerDepositPageList($curpage,$perpage,$stwhere,"a.id");
	
	include PrintEot($job);
	footer(true);
?>