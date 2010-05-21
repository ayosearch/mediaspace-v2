<?php 
InitGetPost(array('audit','all','auditstatus','status',',start_date','end_date'));

!empty($audit) && $transtr .= "&audit=$audit";
!empty($status) && $transtr .= "&status=$status";
!empty($start_date) && $transtr .= "&start_date=$start_time";
!empty($end_date) && $transtr .= "&end_date=$end_date";
(!empty($searchtype) && !empty($searchkey)) && $transtr .= "&searchtype=".$searchtype."&searchkey=$searchkey";
		
if($action=="new"){
	$objAdvertise = LOAD::loadDB("Advertise");	
	$op_advlist = loadAdvertiseList(1,"0");
	$objCommData = LOAD::loadDB("CommonData");	
	$op_advformatlist = loadBaseAdvFormat();
	$op_advsizelist = loadBaseAdvSize();
}else if($action=="edit"){
	$objAdvertise = LOAD::loadDB("Advertise");	
	$db_adv = $objAdvertise->getAdvCreative($curid);
	$objCommData = LOAD::loadDB("CommonData");
	$op_advlist = loadAdvertiseList(1,$db_adv[adv_id]);
	$op_advformatlist = loadBaseAdvFormat($db_adv[format]);
	$op_advsizelist = loadBaseAdvSize($db_adv[adsize]);
}else if($action=="save"){
	$objAdvertise = LOAD::loadDB("Advertise");	
	if(empty($curid)){
		$_POST[create_time] = $timestamp;
		$_POST[update_time] = $timestamp;		
		$objAdvertise->insertAdvCreatvie($_POST);
	}else{
		$_POST[update_time] = $timestamp;
		$objAdvertise->updateAdvCreative($curid,$_POST);
	}
	ObHeader("$basename?job=advcreative$tranastr");
	unset($objAdvertise);
	exit;
}else if(empty($action)){
	(!empty($audit)) && $stwhere .= " audit=".sqlEscape($audit)." and ";	
	(!empty($status)) && $stwhere .= " status=".sqlEscape($status)." and ";		
	(!empty($start_date)) && $stwhere .= " create_time>=".__strtotime($start_date)." and ";	
	(!empty($end_date)) && $stwhere .= " create_time<=".__strtotime($end_date)." and ";		
	if(!empty($searchtype) && !empty($searchkey)) {
		$querykey = "%".$searchkey."%";
		$stwhere .= " $searchtype like ".sqlEscape($querykey)." and ";			
	}
	(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);	
	
	$objAdvertise = LOAD::loadDB("Advertise");
	$totalnum = $objAdvertise->getAdvCreativeTotalCount();
	$totalpage = ceil($totalnum/$perpage);
	$db_advcreativelist = $objAdvertise->getAdvCreativePageList($curpage,$perpage);
}

include PrintEot($job);
footer(true);

?>