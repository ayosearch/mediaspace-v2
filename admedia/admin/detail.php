<?php
InitGetPost(array("adv_id","mer_id","backurl"));
if($action=="affiliate"){
	$aff_id = $curid;
	$objAffUser = LOAD::loadDB("Affiliate");
	$db_affiliate = $objAffUser->getAffiliate($curid);
	if($db_affiliate){
		$db_affpayinfolist = $objAffUser->getAffPayInfoByAffId($curid);
		$objSystem = LOAD::loadDB("System");
		$db_auditlist = $objSystem->getSysAuditAll($curid,0);
	}
}else if($action=="newpayinfo"){
	$objCommData = LOAD::loadDB("CommonData");
	$op_paymethodlist = loadBaseSortList("bank");
}else if($action=="editpayinfo"){
	$objAffUser = LOAD::loadDB("Affiliate");
	$db_payinfo = $objAffUser->getAffPayInfo($curid);
	$objCommData = LOAD::loadDB("CommonData");
	$op_paymethodlist = loadBaseSortList("bank",$db_payinfo[pay_method]);
}else if($action=="delpayinfo"){
	$objAffUser = LOAD::loadDB("Affiliate");
	$objAffUser->deleteAffPayInfo($curid);
	writeSysLog(3,"删除站长支付信息", $AdminUser[login_name]."删除支付ID:".$curid);
	ObHeader("$basename?job=detail&action=affiliate&curid=$aff_id");
}else if($action=="savepayinfo"){
	$objAffUser = LOAD::loadDB("Affiliate");
	if(isset($curid) && empty($curid)){
		$objAffUser->insertAffPayInfo($_POST);
		writeSysLog(1,"新增站长支付信息", $AdminUser[login_name]."新增支付内容:".implode(",",$_POST));
	}else{
		$objAffUser->updateAffPayInfo($curid,$_POST);
		writeSysLog(2,"修改站长支付信息", $AdminUser[login_name]."修改支付ID:".$curid.",修改支付内容:".implode(",",$_POST));
	}
	echo "<script>window.returnValue='1';window.close();</script>";
	exit;
}else if($action=="editpayinfo"){
	$objAffUser = LOAD::loadDB("Affiliate");
	$objAffUser->updateAffPayInfo($curid,$_POST);
}else if($action=="merchant"){
	$objMerchant = LOAD::loadDB("Merchant");
	$db_merchant = $objMerchant->getMerchant($curid);
	if($db_merchant){
		$db_defaultman  = $objMerchant->getDefaultMerLinkMan($curid);
		$db_advlist = $objMerchant->getMerAdvList($curid);
		$objSystem = LOAD::loadDB("System");
		$db_auditlist = $objSystem->getSysAuditAll($curid,4);
	}
}else if($action=="affsite"){
	$objAffiliate = LOAD::loadDB("Affiliate");
	$db_affsite = $objAffiliate->getAffWebSite($curid);
	if($db_affsite){
		$objSystem = LOAD::loadDB("System");
		$db_auditlist = $objSystem->getSysAuditAll($curid,1);
	}
}else if($action=="advertise"){
	$objAdvertise = LOAD::loadDB("Advertise");
	$db_adv = $objAdvertise->getAdvertise($curid);
	$db_advselectorlist = $objAdvertise->getAdvSelectorByAdvId($curid);
	if($db_adv){
		$objSystem = LOAD::loadDB("System");
		$db_auditlist = $objSystem->getSysAuditAll($curid,5);	
	}
}else if($action=="newadvselector" || $action=="editadvselector"){
	$objCommData = LOAD::loadDB("CommonData");
	$db_provincelist = $objCommData->getBaseProvinceAll();
	//$db_citylist = $objCommData->getBaseCityAll();	
	$db_sitetypelist = $objCommData->getBaseSortKeyList("sitetype");
}else if($action=="saveadvselector"){
	if(isset($adv_id) && !empty($adv_id)){
		$objAdvertise = LOAD::loadDB("Advertise");	
		$bcheck = $objAdvertise->checkAdvSelector($adv_id,$_POST[is_filter],$_POST[itype]);
		if($bcheck==false){
			if($_POST[itype]=='site_type'){
				$_POST[content] = $_POST[sel_sitetype];
			}else if($_POST[itype]=='province'){
				$_POST[content] = $_POST[sel_province];
			}else if($_POST[itype]=='domain'){
				$_POST[content] = $_POST[sel_domain];
			}
			$db_advertise = $objAdvertise->getAdvertise($adv_id);
			if($db_advertise){
				$_POST[mer_id] =$db_advertise[mer_id];
				$_POST[create_time]=$timestamp;
				if(strpos($_POST[content],',')>0){
					$_POST[content] = substr($_POST[content],0,strlen($_POST[content])-1);
				}			
				$insertid = $objAdvertise->insertAdvSelector($_POST);
				writeSysLog(2,"新增广告定向", $AdminUser[login_name]."新增广告定向ID:".$insertid.",内容:".implode(",",$_POST));
				echo "<script>window.returnValue='1';window.close();</script>";
			}else{
				$basename = "$basename?job=detail&action=newadvselector&adv_id=$adv_id";							
				adminMsg("save_error");
			}
		}else{
			$basename = "$basename?job=detail&action=newadvselector&adv_id=$adv_id";			
			adminMsg("advselector_exists");
		}
	}else{
		$basename = "$basename?job=detail&action=newadvselector&adv_id=$adv_id";			
		adminMsg("save_error");
	}		
	exit;
}else if($action=="deladvselector"){
	if(isset($curid) && !empty($curid)){
		$objAdvertise = LOAD::loadDB("Advertise");	
		$objAdvertise->deleteAdvSelector($curid);
		writeSysLog(3,"删除广告定向", $AdminUser[login_name]."删除广告定向ID:".$curid);		
		$reurl = "$basename?job=detail&action=advertise&curid=$adv_id&backurl=".urlencode($backurl);
		//echo $reurl;
		ObHeader($reurl);
		exit;
	}
}else if($action=="advapply"){
	$showsite = "";
	$objAdvertise = LOAD::loadDB("Advertise");	
	$objAffiliate = LOAD::loadDB("Affiliate");		
	$db_advapply = $objAffiliate->getAffAdvApply($curid);
	if($db_advapply){
		$db_aff = $objAffiliate->getAffiliate($db_advapply[aff_id]);
		$db_adv = $objAdvertise->getAdvertise($db_advapply[adv_id]);
		$db_sitelist = $objAffiliate->getAffSiteStatusList($db_advapply[aff_id],1);
		if(strpos($db_advapply[site_ids],',')>0){
			$arrsiteids = explode(",",$db_advapply[site_ids]);
			foreach($arrsiteids as $siteid){
				if(strlen($siteid)>0){
					$db_site = $objAffiliate->getAffWebSite($siteid);
					if($db_site){
						$showsite .=$db_site[name].',';
					}
				}
			}
			$showsite = substr($showsite,0,strlen($showsite)-1);
		}
		$objSystem = LOAD::loadDB("System");
		$db_auditlist = $objSystem->getSysAuditAll($curid,2);	
	}
	unset($objAffiliate,$objAdvertise);
}

include PrintEot($job);
footer(true);	
?>