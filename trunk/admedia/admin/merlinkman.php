<?php 
include_once('rolecontrol.php');	

InitGetPost(array('birthday','all','sex'));

$month = date('Y-m',$timestamp);

strlen(birthday)>0 && $transtr .= "&birthday=$birthday";
strlen($sex)>0 && $transtr .= "&sex=$sex";
(strlen($searchtype)>0 && strlen($searchkey)>0) && $transtr .= "&searchtype=".$searchtype."&searchkey=$searchkey";

if($action=="new"){
	$objMerchant = LOAD::loadDB("Merchant");
	$op_merchantlist = loadMerchantList(1);
}else if($action=="edit"){
	$objMerchant = LOAD::loadDB("Merchant");
	$db_merlinkman = $objMerchant->getMerLinkMan($curid);
	$op_merchantlist = loadMerchantList(1,$db_merlinkman[mer_id]);
}else if($action=="save"){
	$objMerchant = LOAD::loadDB("Merchant");
	if(empty($curid)){
		$_POST[create_time] = $timestamp;
		$insertid = $objMerchant->insertMerLinkMan($_POST);
		writeSysLog(1,"新增广告主联系人", $AdminUser[login_name]."新增广告主联系人ID:".$insertid.",联系人内容:".implode(",",$_POST));			
	}else{
		$objMerchant->updateMerLinkman($curid,$_POST);
		writeSysLog(2,"修改广告主联系人", $AdminUser[login_name]."修改广告主联系人ID:".$curid.",联系人内容:".implode(",",$_POST));					
	}
	ObHeader($admin_file.$transtr);
}else if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}
	if(strlen($ids)>0){
		$objAdvertise = LOAD::loadDB("Merchant");
		$objAdvertise->deleteBatchMerLinkMan($ids);
		writeSysLog(3, "删除广告主联系人", $AdminUser[login_name]."删除广告主联系人ID:".$ids);		
	}
	ObHeader($admin_file.$transtr);	
	exit;
}else if(empty($action)){
	(!empty($birthday)) && $stwhere .= " a.birthday like '".$month."%' and ";		
	(!empty($sex)) && $stwhere .= " a.sex=".intval($sex)." and ";	
	if(!empty($searchtype) && !empty($searchkey)) {
		$querykey = "%".$searchkey."%";
		$stwhere .= " $searchtype like ".sqlEscape($querykey)." and ";			
	}
	(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);	
	
	$objMerchant = LOAD::loadDB("Merchant");
	$totalnum = $objMerchant->getMerLinkManTotalCount();
	$totalpage = ceil($totalnum/$perpage);
	$db_merlinkmanlist = $objMerchant->getMerLinkManPageList($curpage,$perpage);
}

include PrintEot($job);
footer(true);


?>