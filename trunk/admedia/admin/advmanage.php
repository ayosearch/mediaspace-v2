<?php 
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
	if(empty($curid)){
		if(uploadFile($_FILES['file_logo']['tmp_name'],$cfg_upfilepath.$_FILES['file_logo']['name'])){
			$_POST[logo] = $cfg_upfilepath.$_FILES['file_logo']['name'];
		}
		$_POST[create_time]=$timestamp;
		$_POST[start_time]=__strtotime($_POST[start_time]." ".$_POST[start_hour].":00:00");
		$_POST[end_time]=__strtotime($_POST[end_time]." ".$_POST[end_hour].":00:00");
		$objAdvertise->insertAdvertise($_POST);		
	}else{
		if(uploadFile($_FILES['file_logo']['tmp_name'],$cfg_upfilepath.$_FILES['file_logo']['name'])){
			$_POST[logo] = $cfg_upfilepath.$_FILES['file_logo']['name'];			
		}
		$_POST[start_time]=__strtotime($_POST[start_time]." ".$_POST[start_hour].":00:00");
		$_POST[end_time]=__strtotime($_POST[end_time]." ".$_POST[end_hour].":00:00");
		$objAdvertise->updateAdvertise($curid,$_POST);		
	}
	ObHeader("$basename?job=advmanage");	
	exit;
}else if(empty($action)){
	$objAdvertise = LOAD::loadDB("Advertise");
	$totalnum = $objAdvertise->getAdvertiseTotalCount();
	$totalpage = ceil($totalnum/$perpage);
	$db_advlist = $objAdvertise->getAdvertisePageList($curpage,$perpage);
}

include PrintEot($job);
footer(true);


?>