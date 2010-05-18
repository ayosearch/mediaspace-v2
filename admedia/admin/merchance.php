<?php 

if($action=="new"){
	$objCommData = LOAD::loadDB("CommonData");
	$op_phaselist = loadBaseSortList("clientphase");
	$op_sourcelist = loadBaseSortList("clientsource"); 
}else if($action=="edit"){
	$objMerchant = LOAD::loadDB("Merchant");
	$db_chance = $objMerchant->getMerChance($curid);
	$objCommData = LOAD::loadDB("CommonData");
	$op_phaselist = loadBaseSortList("clientphase",$db_chance[phase]);
	$op_sourcelist = loadBaseSortList("clientsource",$db_chance[clientsource]); 	
}else if($action=="save"){
	$_POST[creator_id] = $AdminUser[id];
	$_POST[creator_name] = $AdminUser[login_name];
	$objMerchant = LOAD::loadDB("Merchant");
	if(empty($curid)) $objMerchant->insertMerChance($_POST);
	else $objMerchant->updateMerChance($curid,$_POST);
	ObHeader("$basename?job=merchance$transtr");
	exit;
}else if(empty($action)){
	$objMerchant = LOAD::loadDB("Merchant");
	$totalnum = $objMerchant->getMerChanceTotalCount();
	$totalpage = ceil($totalnum%$perpage);
	$db_merchancelist = $objMerchant->getMerChancePageList($curpage,$perpage);
	include PrintEot($job);
	footer(true);
}

include PrintEot($job);
footer(true);
?>