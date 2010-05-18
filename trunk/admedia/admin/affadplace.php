<?php 
InitGetPost(array('status','all','audit','auditstatus','start_date','end_date'));

strlen($status)>0 && $transtr .= "&status=$status";
strlen($audit)>0 && $transtr .= "&audit=$audit";
strlen($start_date)>0 && $transtr .= "&start_date=$start_time";
strlen($end_date)>0&& $transtr .= "&end_date=$end_date";
(strlen($searchtype)>0 && strlen($searchkey)>0) && $transtr .= "&searchtype=".$searchtype."&searchkey=$searchkey";

if($action=="new" || $action=="edit"){
	$objCommData = LOAD::loadDB("CommonData");
	if(empty($curid)){
		$db_basesizelist = $objCommData->getBaseAdvSizeAll();
		$op_basesizelist = "";
		foreach ($db_basesizelist as $db_basesize){
			$op_basesizelist .= "<option value='$db_basesize[height]X$db_basesize[width]'>$db_basesize[height]X$db_basesize[width]</option>";
		}
	}else{
		$objAffiliate = LOAD::loadDB("Affiliate");			
		$db_affadvplace = $objAffiliate->getAffAdvPlace($curid);	
		$db_basesizelist = $objCommData->getBaseAdvSizeAll();
		$op_basesizelist = "";
		foreach ($db_basesizelist as $db_basesize){
			if($db_basesize[height]."X".$db_basesize[width]==$db_affadvplace[adsize]){
				$op_basesizelist .= "<option value='$db_basesize[height]X$db_baseadv[width]' selected>$db_basesize[height]X$db_basesize[width]</option>";
			}else{
				$op_basesizelist .= "<option value='$db_basesize[height]X$db_baseadv[width]'>$db_basesize[height]X$db_basesize[width]</option>";
			}
		}
	}
	unset($objAffiliate,$curid);
}else if($acton=="save"){
	$objAffiliate = LOAD::loadDB("Affiliate");		
	if(empty($curid)){
		$_POST[create_time] = $timestamp;
		$objAffiliate->insertAffAdvPlace(_POST);
	}else{
		$_POST[update_time] = $timestamp;		
		$objAffiliate->updateAffAdvPlace($curid,_POST);
	}
	ObHeader("$basename?job=affadvplace");	
}else if($action=="del"){
	$objAffiliate = LOAD::loadDB("Affiliate");
	$objAffiliate->deleteAffiliate($curid);
	ObHeader("$basename?job=affadvplace");	
}else if(empty($action) || $action=="select"){
	$stwhere = "";
	(strlen($status)>0) && $stwhere .= " status=$status and ";
	(strlen($audit)>0) && $stwhere .= " audit=$audit and ";	
	(strlen($start_date)>0) && $stwhere .= " create_time>=".__strtotime($start_date)." and ";	
	(strlen($end_date)>0) && $stwhere .= " create_time<=".__strtotime($end_date)." and ";		
	if(strlen($searchtype)>0 && strlen($searchkey)>0) {
		$querykey = "%".$searchkey."%";
		$stwhere .= " $searchtype like ".sqlEscape($querykey)." and ";			
	}	
	
	$objAffiliate = LOAD::loadDB("Affiliate");
	$totalnum = $objAffiliate->getAffAdvPlaceTotalCount($stwhere);
	$totalpage = ceil($totalnum/$perpage);
	$db_affadplacelist = $objAffiliate->getAffAdvPlacePageList($curpage,$perpage,$stwhere,"id");
}
include PrintEot($job);
footer(true);
?>