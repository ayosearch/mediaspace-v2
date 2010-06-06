<?php
if($action=="add"){
	$op_sortlist = loadBaseSortList("sitetype");
}else if($action=="edit"){
	$objAffiliate = LOAD::loadDB("Affiliate");	
	$db_affsite = $objAffiliate->getAffWebSite($curid);
	$op_sortlist = loadBaseSortList("sitetype",$db_affsite[sitetype]);		
}else if($action=="save"){
	$objAffiliate = LOAD::loadDB("Affiliate");
	if(isset($curid) && empty($curid)){
		$_POST[create_time] = $timestamp;
		$objAffiliate->insertAffWebsite($_POST);
	}else{
		$objAffiliate->updateAffWebsite($curid,$_POST);
	}
	unset($objAffiliate,$curid);
	ObHeader($index_file."&curpage=".$curpage);	
}else if(empty($action)){
	$stwhere = " a.is_del=0 and a.aff_id=".intval($AffUser[id]);
	$objAffiliate = LOAD::loadDB("Affiliate");
	$totalnum = $objAffiliate->getAffWebSiteTotalCount($stwhere);
	$totalpage = ceil($totalnum/$perpage);
	$db_affwebsitelist = $objAffiliate->getAffWebSiteAllPageList($curpage,$perpage,$stwhere,"a.id");
}
include PrintEot($job,'www');
footer(false);
?>