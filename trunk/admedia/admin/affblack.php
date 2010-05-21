<?php 
InitGetPost(array('source','all','auditstatus','start_date','end_date'));

!empty($source) && $transtr .= "&source=$source";
!empty($start_date) && $transtr .= "&start_date=$start_time";
!empty($end_date) && $transtr .= "&end_date=$end_date";
(!empty($searchtype) && !empty($searchkey)) && $transtr .= "&searchtype=".$searchtype."&searchkey=$searchkey";

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
}else if($action=="releasesave"){
	$objAffiliate = LOAD::loadDB("Affiliate");
	if(isset($ids) && !empty($ids)){
		$ids = substr($ids,0,strlen($ids)-1);	
		$arrBlack = array("release_time"=>$timestamp,"release_id"=>$AdminUser[id],"release_user"=>$AdminUser[login_name],
		"release_desc"=>$_POST[release_desc],"status"=>1);
		$objAffiliate->updateBatchAffBlacks($ids,$arrBlack);
		$arrAff = $objAffiliate->getAffBlackList($ids);
		$strAffIds = "";
		foreach($arrAff as $aff){
			$strAffIds .= $aff[user_id].",";
		}
		$strAffIds = substr($strAffIds,0,strlen($strAffIds)-1);	
		$arrfield = array("update_time"=>$timestamp,"status"=>1);
		$objAffiliate->updateBatchAffiliates($strAffIds,$arrfield);
		echo "<script>window.returnValue='1';window.close();</script>";
	}
}else{
 	$stwhere = "";
	(!empty($source)) && $stwhere .= " source=".sqlEscape($source)." and ";		
	(!empty($start_date)) && $stwhere .= " create_time>=".__strtotime($start_date)." and ";	
	(!empty($end_date)) && $stwhere .= " create_time<=".__strtotime($end_date)." and ";		
	if(!empty($searchtype) && !empty($searchkey)) {
		$querykey = "%".$searchkey."%";
		$stwhere .= " $searchtype like ".sqlEscape($searchkey)." and ";			
	}
	(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);	 		
	
	$objAffiliate = LOAD::loadDB("Affiliate");
	$totalnum = $objAffiliate->getAffBlackTotalCount($searchkey);
	$totalpage = ceil($totalnum/$perpage);
	$db_affblacklist = $objAffiliate->getAffBlackPageList($curpage,$perpage,$searchkey,"lock_time");
	unset($objAffiliate);
}
include PrintEot($job);
footer(true);
?>