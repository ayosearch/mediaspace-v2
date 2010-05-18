<?php 

if(empty($action)){
	$objAffiliate = LOAD::loadDB("Affiliate");
	$totalnum = $objAffiliate->getAdvCreativeTotalCount();
	$totalpage = ceil($totalnum/$perpage);
	$db_affadplacelist = $objAffiliate->getAdvCreativePageList($curpage,$perpage);
}

include PrintEot($job);
footer(true);

?>