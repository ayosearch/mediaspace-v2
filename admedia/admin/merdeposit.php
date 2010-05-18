<?php 
$curidx = 0;

$perpage = 20;
$curpage = 1;

$canaudit = true;
$canadd = true;
$canedit = true;
$candel = true;
$transtr = "";

$admin_file = "$admin_file?job=".$job;

if(empty($action)){
	$objMerchant = LOAD::loadDB("Merchant");
	$totalnum = $objMerchant->getMerDepositTotalCount();
	$totalpage = ceil($totalnum%$perpage);
	$db_merdepositlist = $objMerchant->getMerDepositPageList($curpage,$perpage);
	include PrintEot($job);
	footer(true);
}

if($action=="new"){
	include PrintEot("merdepositedit");
	footer(true);
}


?>