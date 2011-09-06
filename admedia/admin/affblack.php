<?php 
include_once('rolecontrol.php');	

InitGetPost(array('status','all','auditstatus','start_date','end_date'));

!empty($status) && $transtr .= "&status=$status";
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
	ObHeader($admin_file.$transtr);
}else if($action=="del"){
	$objAffiliate = LOAD::loadDB("Affiliate");
	$objAffiliate->deleteAffBlack($curid);
	writeSysLog(3,"删除站长黑名单", $AdminUser[login_name]."站长ID:".$curid);	
	unset($objAffiliate);	
	ObHeader($admin_file.$transtr);
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
		writeSysLog(4, "释放站长黑名单", $AdminUser[login_name]."站长ID:".$strAffIds);
		echo "<script>window.returnValue='1';window.close();</script>";
	}
}else{
 	$stwhere = "";
	(strlen($status)>0) && $stwhere .= " status=".sqlEscape($status)." and ";		
	if(strlen($searchtype)>0 && strlen($searchkey)>0) {
		$querykey = "%".$searchkey."%";
		$stwhere .= " $searchtype like ".sqlEscape($querykey)." and ";			
	}
	(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);	 		
	
	$objAffiliate = LOAD::loadDB("Affiliate");
	$totalnum = $objAffiliate->getAffBlackTotalCount($stwhere);
	$totalpage = ceil($totalnum/$perpage);
	$db_affblacklist = $objAffiliate->getAffBlackPageList($curpage,$perpage,$stwhere,"lock_time");
	unset($objAffiliate);
}
include PrintEot($job);
footer(true);
?>