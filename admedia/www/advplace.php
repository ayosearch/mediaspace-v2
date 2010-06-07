<?php
	InitGetPost(array('fee_type','status','start_date','end_date'));

	$objAffiliate = LOAD::loadDB("Affiliate");	
	
	$db_affsitelist = $objAffiliate->getAffSiteStatusList($AffUser[id]);
	
	$stwhere = "a.aff_id=".$AffUser[id]." and ";
	(strlen($site_id)>0) && $stwhere .= " a.site_id=$site_id and ";
	(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);	
	
	$objAffiliate = LOAD::loadDB("Affiliate");
	$totalnum = $objAffiliate->getAffAdvPlaceTotalCount($stwhere);
	$totalpage = ceil($totalnum/$perpage);
	$db_affadplacelist = $objAffiliate->getAffAdvPlacePageList($curpage,$perpage,$stwhere,"a.create_time");
	
	include PrintEot($job,'www');
	footer(false);
?>