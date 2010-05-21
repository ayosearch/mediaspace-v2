<?php 
InitGetPost(array('audit','all','auditstatus','start_date','end_date'));

!empty($audit) && $transtr .= "&audit=$audit";
!empty($start_date) && $transtr .= "&start_date=$start_time";
!empty($end_date) && $transtr .= "&end_date=$end_date";
(!empty($searchtype) && !empty($searchkey)) && $transtr .= "&searchtype=".$searchtype."&searchkey=$searchkey";

if($action=="new"){
	$objMerchant = LOAD::loadDB("Merchant");
	$op_merchantlist = loadMerchantList(1);
	$objCommData = LOAD::loadDB("CommonData");
	$op_advtypelist = loadBaseSortList("advtype");
	$op_unitlist = loadBaseSortList("unit");
	$op_mercontractlist = loadMerContractList(1);	
	$op_affunitlist = $op_unitlist;
}else if($action=="edit"){
	if(isset($curid) && !empty($curid)){
		$objAdvertise = LOAD::loadDB("Advertise");	
		$db_adv = $objAdvertise->getAdvertise($curid);
		$objMerchant = LOAD::loadDB("Merchant");
		$op_merchantlist = loadMerchantList(1,$db_adv[mer_id]);	
		$op_mercontractlist = loadMerContractList(1,$db_adv[contract_id]);
		$objCommData = LOAD::loadDB("CommonData");
		$op_advtypelist = loadBaseSortList("advtype",$db_adv[advtype]);
		$op_unitlist = loadBaseSortList("unit",$db_adv[unit]);
		$op_affunitlist = loadBaseSortList("unit",$db_adv[aff_unit]);
	}
}else if($action=="save"){
	$objAdvertise = LOAD::loadDB("Advertise");
	if(!isset($_POST[is_view])) $_POST[is_view]=0;
	if(!isset($_POST[is_click])) $_POST[is_click]=0;
	if(!isset($_POST[is_rolling])) $_POST[is_rolling]=0;
	if(!isset($_POST[mer_onlyfee])) $_POST[mer_onlyfee]=0;	
	if(!isset($_POST[filter_likeip])) $_POST[filter_likeip]=0;
	if(!isset($_POST[filter_agentip])) $_POST[filter_agentip]=0;
	if(!isset($_POST[filter_foreignip])) $_POST[filter_foreignip]=0;		
	if(empty($curid)){
		if(uploadFile($_FILES['file_logo']['tmp_name'],$cfg_upfilepath.$_FILES['file_logo']['name'])){
			$_POST[logo] = $cfg_upfilepath.$_FILES['file_logo']['name'];
		}
		$_POST[create_time]=$timestamp;
		$_POST[update_time]=$timestamp;		
		$_POST[start_time]=__strtotime($_POST[start_time]." ".$_POST[start_hour].":00:00");
		$_POST[end_time]=__strtotime($_POST[end_time]." ".$_POST[end_hour].":00:00");
		$objAdvertise->insertAdvertise($_POST);		
	}else{
		if(uploadFile($_FILES['file_logo']['tmp_name'],$cfg_upfilepath.$_FILES['file_logo']['name'])){
			$_POST[logo] = $cfg_upfilepath.$_FILES['file_logo']['name'];			
		}
		$_POST[update_time]=$timestamp;
		$_POST[start_time]=__strtotime($_POST[start_time]." ".$_POST[start_hour].":00:00");
		$_POST[end_time]=__strtotime($_POST[end_time]." ".$_POST[end_hour].":00:00");
		$objAdvertise->updateAdvertise($curid,$_POST);		
	}
	ObHeader("$basename?job=advmanage");	
	exit;
}else if($action=="auditsave"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}
	$arrfield = array("audit_id"=>$AdminUser[id],"audit_name"=>$AdminUser[login_name],"create_time"=>$timestamp,"target_ids"=>$ids,
								"parent_id"=>0,"level"=>0,"action"=>$aduitstatus,"content"=>$_POST[content],"itype"=>4);
	$objSystem = LOAD::loadDB("System");	
	$sysaudit_id = $objSystem->insertSysAudit($arrfield);
	$objAdvertise = LOAD::loadDB("Advertise");	
	$objAdvertise->updateAdvertiseAudit($ids,$sysaudit_id,$auditstatus);
	echo "<script>window.returnValue='1';window.close();</script>";
	unset($objSystem,$objAdvertise,$arrfield);
	exit;
	//ObHeader("admincp.php?job=affmanage".$transtr);		
}else if(empty($action)){
	$stwhere = "";
	(!empty($audit)) && $stwhere .= " audit=".sqlEscape($audit)." and ";		
	(!empty($start_date)) && $stwhere .= " create_time>=".__strtotime($start_date)." and ";	
	(!empty($end_date)) && $stwhere .= " create_time<=".__strtotime($end_date)." and ";		
	if(!empty($searchtype) && !empty($searchkey)) {
		$querykey = "%".$searchkey."%";
		$stwhere .= " $searchtype like ".sqlEscape($querykey)." and ";			
	}
	(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);	
	
	$objAdvertise = LOAD::loadDB("Advertise");
	$totalnum = $objAdvertise->getAdvertiseTotalCount($stwhere);
	$totalpage = ceil($totalnum/$perpage);
	$db_advlist = $objAdvertise->getAdvertisePageList($curpage,$perpage,$stwhere,"level");
}

include PrintEot($job);
footer(true);


?>