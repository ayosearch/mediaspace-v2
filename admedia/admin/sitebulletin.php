<?php 
include_once('rolecontrol.php');	

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
	(strlen($status)>0) && $stwhere .= " status=".$status." and ";
	(strlen($itype)>0) && $stwhere .= " itype=".$itype." and ";
	(strlen($is_top)>0) && $stwhere .= " is_top=".$is_top." and ";
	(strlen($is_red)>0) && $stwhere .= " is_red=".$is_red." and ";
	
	(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);	

	$db_sysnewslist = $objSystem->getSysNewsPageList($curpage,$perpage,$stwhere,"create_time");
	include PrintEot($job);
	footer(true);
}else if($action=='save'){
	$objSystem = LOAD::loadDB("System");	
	$arrNews = array("platform"=>"aff","title"=>$_POST[title],"create_time"=>$timestamp,"content"=>$_POST[content],
									"user_id"=>$AdminUser[login_id],"user_name"=>$AdminUser[login_name],"is_top"=>$_POST[cktop],
									"is_red"=>$_POST[ckred],"itype"=>$_POST[citype]);	
	if(empty($curid)){
		$_POST["create_time"] = $timestamp;
		$objSystem->insertSysNews($arrNews);
		writeSysLog(1, "新增网站公告", $AdminUser[login_name]."新增网站公告ID:".$insertid.",公告内容:".implode(",",$arrNews));		
	}else{
		$insertid = $objSystem->updateSysNews($curid,$arrNews);
		writeSysLog(2, "修改网站公告", $AdminUser[login_name]."修改网站公告ID:".$curid.",公告内容:".implode(",",$arrNews));			
	}
	ObHeader($admin_file.$transtr);
}else if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
		$objSysUser = LOAD::loadDB("System");
		$objSysUser->deleteSysNewsBatch($ids);
		writeSysLog(3, "删除网站公告", $AdminUser[login_name]."删除网站公告ID:".$ids);				
		ObHeader($admin_file.$transtr);
	}
}else if($action=="edit"){
	$objSystem = LOAD::loadDB("System");
	$db_sysnews = $objSystem->getSysNews($curid);
}else if($action=="audit"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}
	$curid=$ids;	
	$objSystem = LOAD::loadDB("System");
	$_POST["status"] = $auditstatus;
	$objSystem->updateSysNews($curid,$_POST);
	writeSysLog(4, "审核网站公告", $AdminUser[login_name]."审核网站公告ID:".$curid.",审核内容:".implode(",",$_POST));				
	ObHeader($admin_file.$transtr);
}
include PrintEot($job);
footer(true);
?>