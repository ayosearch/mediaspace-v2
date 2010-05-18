<?php 

InitGetPost(array('status','itype','is_top','is_red','all','auditstatus'));

!empty($status) && $transtr .= "&status=$status";
!empty($itype) && $transtr .= "&itype=$itype";
!empty($is_top) && $transtr .= "&is_top=$is_top";
!empty($is_red) && $transtr .= "&is_red=$is_red";

if(empty($action)){
	$objSystem = LOAD::loadDB("System");
	$totalnum = $objSystem->getSysNewsTotalCount();
	$totalpage = ceil($totalnum/$perpage);
	$stwhere = "";
	(!empty($status) || $status=="0") && $stwhere .= " status=$status";
	(!empty($itype) || $itype=="0") && $stwhere .= " itype=$itype";
	(!empty($is_top) || $is_top=="0") && $stwhere .= " is_top=$is_top";
	(!empty($is_red) || $is_red=="0") && $stwhere .= " is_red=$is_red";

	$db_sysnewslist = $objSystem->getSysNewsPageList($curpage,$perpage,$stwhere,"create_time");
	include PrintEot($job);
	footer(true);
}
if($action=='save'){
	$objSystem = LOAD::loadDB("System");	
	if(empty($curid)){
		$_POST["create_time"] = $timestamp;
		$objSystem->insertSysNews($_POST);
	}else{
		$objSystem->updateSysNews($curid,$_POST);
	}
	ObHeader($admin_file);
}
if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
		$objSysUser = LOAD::loadDB("System");
		$objSysUser->deleteSysNewsBatch($ids);
		ObHeader("admincp.php?job=sitebulletin$transtr");		
	}
}
if($action=="edit"){
	$objSystem = LOAD::loadDB("System");
	$db_sysnews = $objSystem->getSysNews($curid);
}

if($action=="audit"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}
	$curid=$ids;	
	$objSystem = LOAD::loadDB("System");
	$_POST["status"] = $auditstatus;
	$objSystem->updateSysNews($curid,$_POST);
	ObHeader("admincp.php?job=sitebulletin&curpage=$curpage$transtr");		
}
include PrintEot($job);
footer(true);
?>