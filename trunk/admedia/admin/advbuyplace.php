<?php 
include_once('rolecontrol.php');	
InitGetPost(array('status','all','start_date','end_date','adv_id','aff_id','site_id'));

if(empty($action)){
	$stwhere = "";
	(strlen($status)>0) && $stwhere .= " a.status=$status and ";
	(strlen($start_date)>0) && $stwhere .= " a.create_time>=".__strtotime($start_date)." and ";	
	(strlen($end_date)>0) && $stwhere .= " a.create_time<=".__strtotime($end_date)." and ";		
	if(strlen($searchtype)>0 && strlen($searchkey)>0) {
		$querykey = "%".$searchkey."%";
		$stwhere .= " $searchtype like ".sqlEscape($querykey)." and ";			
	}	
	(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);		
	
	$objAdvertise = LOAD::loadDB("Advertise");
	$totalnum = $objAdvertise->getAdvBuyAffPlacesTotalCount($stwhere);
	$totalpage = ceil($totalnum/$perpage);
	$db_advbuyplacelist = $objAdvertise->getAdvBuyAffPlacesPageList($curpage,$perpage,$stwhere,"a.create_time");
}else if($action=="new"){
	$objAdvertise = LOAD::loadDB("Advertise");
	$op_advlist = loadAdvertiseList(1);
}else if($action=="edit"){
	$objAdvertise = LOAD::loadDB("Advertise");
	$db_advbuyaffplace = $objAdvertise->getAdvBuyAffPlaces($curid);
	$op_advlist = loadAdvertiseList(1,$db_advbuyaffplace[adv_id]);
}else if($action=="save"){
	$objAdvertise = LOAD::loadDB("Advertise");	
	if(isset($curid) && empty($curid)){
		$db_adv = $objAdvertise->getAdvertise($adv_id);
		if($db_adv){
			$_POST[mer_id] = $db_adv[mer_id];
			$_POST[create_time] = $timestamp;
			$_POST[audit_id] = $AdminUser[id];
			$_POST[audit_user] = $AdminUser[login_name];
			$_POST[start_time] = strtotime($_POST[start_date]." ".$_POST[start_hour].":".$_POST[start_minute]);
			$_POST[end_time] = strtotime($_POST[end_date]." ".$_POST[end_hour].":".$_POST[end_minute]);			
			$objAdvertise->insertAdvBuyAffPlaces($_POST);
			writeSysLog(5, "新增广告定投", $AdminUser[login_name]."新增定投信息:".implode(",",$_POST));		
		}
	}else if(isset($curid)){
		$db_adv = $objAdvertise->getAdvertise($adv_id);		
		if($db_adv){
			$_POST[mer_id] = $db_adv[mer_id];
			$_POST[start_time] = strtotime($_POST[start_date]." ".$_POST[start_hour].":".$_POST[start_minute]);
			$_POST[end_time] = strtotime($_POST[end_date]." ".$_POST[end_hour].":".$_POST[end_minute]);	
			$objAdvertise->updateAdvBuyAffPlaces($curid,$_POST);
			writeSysLog(6, "修改广告定投", $AdminUser[login_name]."修改定投信息:".implode(",",$_POST));		
		}
	}
	ObHeader($admin_file.$transtr);
}else if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}
	if(strlen($ids)>0){
		$objAdvertise = LOAD::loadDB("Advertise");	
		$objAdvertise->deleteAdvBatchBuyAffPlaces($ids);
		writeSysLog(7, "删除广告定投", $AdminUser[login_name]."删除定投信息:".$ids);
	}
}

include PrintEot($job);
footer(true);


?>