<?php
	InitGetPost(array('site_id'));

	$objAffiliate = LOAD::loadDB("Affiliate");	
	$demourl = "http://";
	$clickprice = "0.00";
	$weekprice = "0.00";
	
	if($action=="add"){
		$op_sitelist = loadAffSiteList(1,$AffUser[id]);				
		$op_basesizelist = loadBaseAdvSize();
	}else if($action=="edit"){
		$db_advplace = $objAffiliate->getAffAdvPlace($curid);
		$op_sitelist = loadAffSiteList(1,$db_advplace[aff_id],$db_advplace[site_id]);		
		$op_basesizelist = loadBaseAdvSize($db_advplace[adsize]);
		if($db_advplace[demo_url]){
			$demourl = $db_advplace[demo_url];
			$weekprice =  $db_advplace[week_price];
			$clickprice = $db_advplace[click_price];
		}		
	}else if($action=="save"){
		$objAffiliate = LOAD::loadDB("Affiliate");		
		if(isset($curid) && empty($curid)){
			$_POST[aff_id] = $AffUser[id];
			$_POST[create_time] = $timestamp;
			$_POST[update_time] = $timestamp;		
			$objAffiliate->insertAffAdvPlace($_POST);
		}else{
			$_POST[update_time] = $timestamp;
			unset($_POST[status],$_POST[audit]);
			$objAffiliate->updateAffAdvPlace($curid,$_POST);
		}
		ObHeader("$basename?job=advplace&curpage=$curpage");	
	}else if(empty($action)){
		$db_affsitelist = $objAffiliate->getAffSiteStatusList($AffUser[id]);
		
		$stwhere = "a.aff_id=".$AffUser[id]." and ";
		(strlen($site_id)>0) && $stwhere .= " a.site_id=$site_id and ";
		(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);	
		
		$objAffiliate = LOAD::loadDB("Affiliate");
		$totalnum = $objAffiliate->getAffAdvPlaceTotalCount($stwhere);
		$totalpage = ceil($totalnum/$perpage);
		$db_affadplacelist = $objAffiliate->getAffAdvPlacePageList($curpage,$perpage,$stwhere,"a.create_time");
	}
	include PrintEot($job,'www');
	footer(false);
?>