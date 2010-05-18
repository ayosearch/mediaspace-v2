<?php 

if($action=="new" || $action=="edit"){
	if(!empty($curid)){
		$objAffiliate = LOAD::loadDB("Affiliate");
		$db_affblack = $objAffiliate->getAffBlack($curid);
	}
	unset($objAffiliate);
}else if($acton=="save"){
	$objAffiliate = LOAD::loadDB("Affiliate");		
	if(empty($curid)){
		$_POST[create_time] = $timestamp;
		$objAffiliate->insertAffBlack(_POST);
	}else{
		$objAffiliate->updateAffBlack($curid,_POST);
	}
	unset($objAffiliate);
	ObHeader("$basename?job=affblack");	
}else if($action=="del"){
	$objAffiliate = LOAD::loadDB("Affiliate");
	$objAffiliate->deleteAffBlack($curid);
	unset($objAffiliate);	
	ObHeader("$basename?job=affblack");	
}else if($action=="status"){
	$objAffiliate = LOAD::loadDB("Affiliate");
	$objAffiliate->updateAffBlackStatus($curids,$status);
}else{
	$objAffiliate = LOAD::loadDB("Affiliate");
	$totalnum = $objAffiliate->getAffBlackTotalCount();
	$totalpage = ceil($totalnum/$perpage);
	$db_affblacklist = $objAffiliate->getAffBlackPageList($curpage,$perpage,null,"lock_time");
	unset($objAffiliate);
}
include PrintEot($job);
footer(true);
?>