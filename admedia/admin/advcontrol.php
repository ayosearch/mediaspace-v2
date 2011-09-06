<?php
include_once('rolecontrol.php');	
InitGetPost(array('all','status',',start_date','end_date'));

!empty($status) && $transtr .= "&status=$status";
!empty($start_date) && $transtr .= "&start_date=$start_time";
!empty($end_date) && $transtr .= "&end_date=$end_date";
(!empty($searchtype) && !empty($searchkey)) && $transtr .= "&searchtype=".$searchtype."&searchkey=$searchkey";

 if(empty($action)){
 	$stwhere = "audit=1 and ";
	(!empty($status)) && $stwhere .= " status=".sqlEscape($status)." and ";		
	(!empty($start_date)) && $stwhere .= " create_time>=".__strtotime($start_date)." and ";	
	(!empty($end_date)) && $stwhere .= " create_time<=".__strtotime($end_date)." and ";		
	if(!empty($searchtype) && !empty($searchkey)) {
		$querykey = "%".$searchkey."%";
		$stwhere .= " $searchtype like ".sqlEscape($searchkey)." and ";			
	}
	(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);	 	
 	
	$objAdvertise = LOAD::loadDB("Advertise");
	$totalnum = $objAdvertise->getAdvertiseTotalCount($stwhere);
	$totalpage = ceil($totalnum/$perpage);
	$db_advlist = $objAdvertise->getAdvertisePageList($curpage,$perpage,$stwhere,"id");
}else if($action=="createview"){
	$objDataLog = LOAD::loadDB("DataLog");
	if($objDataLog->createShowLog($curid)){
		$objAdvertise = LOAD::loadDB("Advertise");
		$objAdvertise->updateAdvertiseShow($curid);
		writeSysLog(1, "广告计划控制", $AdminUser[login_name]."将广告计划：".$curid."生成显示日志");			
		ObHeader($admin_file.$transtr);
	}else{
		adminMsg("error_create_view");	
	}
}else if($action=="open"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}
	$objAdvertise = LOAD::loadDB("Advertise");
	$objAdvertise->updateAdvertiseStatus($ids,1);
	writeSysLog(4, "广告计划控制", $AdminUser[login_name]."设置广告计划为运营状态:".$ids);
	ObHeader($admin_file.$transtr);
	exit;	
}else if($action=="stop"){
	$objAdvertise = LOAD::loadDB("Advertise");
	$objAdvertise->updateAdvertiseStatus($ids,0);
	ObHeader($admin_file.$transtr);
	writeSysLog(4, "广告计划控制", $AdminUser[login_name]."设置广告计划为暂停状态:".$ids);	
	exit;	
}else if($action=="createclick"){
	$objDataLog = LOAD::loadDB("DataLog");
	if($objDataLog->createClickLog($curid)){
		$objAdvertise = LOAD::loadDB("Advertise");
		$objAdvertise->updateAdvertiseClick($curid);
		writeSysLog(1, "广告计划控制", $AdminUser[login_name]."将广告计划：".$curid."生成点击日志");	
		ObHeader($admin_file.$transtr);
	}else{
		adminMsg("error_create_click");	
	}
	exit;	
}

include PrintEot($job);
footer(true);
?>