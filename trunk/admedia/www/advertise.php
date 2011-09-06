<?php
	InitGetPost(array('fee_type','status','start_date','end_date'));
	
	!empty($status) && $transtr .= "&status=$status";
	!empty($fee_type) && $transtr .= "&fee_type=$fee_type";
	!empty($start_date) && $transtr .= "&start_date=$start_time";
	!empty($end_date) && $transtr .= "&end_date=$end_date";
	(!empty($searchkey)) && $transtr .= "&searchkey=$searchkey";

	if($action=="apply"){
		$objAdvertise = LOAD::loadDB("Advertise");
		$objAffiliate = LOAD::loadDB("Affiliate");			
		$db_adv = $objAdvertise->getAdvertise($curid);
		$db_sitelist = $objAffiliate->getAffSiteStatusList($AffUser[id],1);
		if($db_adv) $adv_name = $db_adv[name];
		else{
			$basename = "javascript:history.go(-1);";
			showMsg("advertise_notexists");
		}
	}else if($action=="affplace"){
		$objAffiliate = LOAD::loadDB("Affiliate");		
		$db_affplacelist = $objAffiliate->getAffAdvPlaceAll($AffUser[id],$curid,1);
		unset($objAffiliate);
	}else if($action=="advcode"){
		$objAdvertise = LOAD::loadDB("Advertise");	
		$objAffiliate = LOAD::loadDB("Affiliate");			
		$db_advlinklist = $objAdvertise->getAdvCreativeAll(1,$curid,0);
		$db_advimglist = $objAdvertise->getAdvCreativeAll(1,$curid,1);
		$db_advcodelist = $objAdvertise->getAdvCreativeAll(1,$curid,2);				
		$db_adv = $objAdvertise->getAdvertise($curid);
		$db_sitelist = $objAffiliate->getAffSiteStatusList($AffUser[id],1);
		if(count($db_sitelist)>0){
			$db_affplacelist = $objAffiliate->getAffAdvPlaceAll($AffUser[id],$db_sitelist[0][id],1);
		}
		unset($objAdvertise,$objAffiliate);
	}else if($action=="reapply"){
		$objAdvertise = LOAD::loadDB("Advertise");
		$objAffiliate = LOAD::loadDB("Affiliate");			
		$db_adv = $objAdvertise->getAdvertise($curid);
		$db_advapply = $objAffiliate->getAffAdvApplyByAffId($AffUser[id],$curid);
		$db_sitelist = $objAffiliate->getAffSiteStatusList($AffUser[id],1);
		if($db_adv) $adv_name = $db_adv[name];
		else{
			$basename = "javascript:history.go(-1);";
			showMsg("advertise_notexists");
		}
		unset($objAffiliate,$objAdvertise);
	}else if($action=="applysave"){
		$objAffiliate = LOAD::loadDB("Affiliate");	
		$_POST[create_time] = $timestamp;
		$_POST[aff_id] = $AffUser[id];
		$_POST[adv_id] = $curid;
		$db_advapply = $objAffiliate->getAffAdvApplyByAffId($AffUser[id],$curid);
		if($db_advapply){
			$_POST[status] = 3;
			$objAffiliate->updateAffAdvApply($db_advapply[id],$_POST);
		}else{
			$_POST[status] = 0;
			$objAffiliate->insertAffAdvApply($_POST);
		}
		unset($objAffiliate,$objAdvertise);
		ObHeader($index_file.$transtr);
	}else if($action=="innercode"){
		InitGetPost(array('site_id','aff_id','place_id'));
		$objAdvertise = LOAD::loadDB("Advertise");
		$db_advplace = $objAdvertise->getAdvCreative($curid);
		if($db_advplace){
			if($db_advplace[content_type]==0){
				$valicode = pwdCode($AffUser[login_name].$AffUser[login_pwd].$cfg_placehash);
			}
			if($db_advplace[content_type]==1){
				$valicode = pwdCode($AffUser[login_name].$AffUser[login_pwd].$cfg_placehash);
				$arradsize = split('X',$db_advplace[adsize]);
			}
			if($db_advplace[content_type]==2){
				$valicode = pwdCode($AffUser[login_name].$AffUser[login_pwd].$cfg_placehash);
				$content = str_replace("{aff_id}",$aff_id,$db_advplace[res_content]);
				$content = str_replace("{id}",$curid,$content);
				$content = str_replace("{site_id}",$site_id,$content);
				$content = str_replace("{place_id}",$site_id,$content);
				$content = str_replace("{vali_code}",$valicode,$content);
			}
		}
	}else if(empty($action)){
		$affpaycycle = $cfg_syspaycycle[getSysConfigByKey("pay_cycle")];
		
		$stwhere = "a.is_del=0 and a.status=1 and ";
		(strlen($fee_type)>0) && $stwhere .= " a.fee_type=".sqlEscape($fee_type)." and ";		
		(strlen($start_date)>0) && $stwhere .= " a.start_time>=".__strtotime($start_date)." and ";	
		(strlen($end_date)>0) && $stwhere .= " a.end_time<=".__strtotime($end_date)." and ";		
	
		$ids = "";
		if(isset($status) && strlen($status)>0){
			$objAffiliate = LOAD::loadDB("Affiliate");
			$db_applylist = $objAffiliate->getAffAdvApplyAllByAffId($AffUser[id],intval($status));
			if(count($db_applylist)>0){
				foreach($db_applylist as $db_apply){
					$ids .= $db_apply[adv_id].",";
				}
			}
		}
		if(strlen($ids)>0){
			$ids = substr($ids,0,strlen($ids)-1);
			if($status=="-1") $stwhere .= " a.id not in (".$ids.") and ";
			else if(isset($status) && strlen($status)>0) $stwhere .= " a.id in (".$ids.") and ";		
		}else{
			if(isset($status) && strlen($status)>0 && $status!="-1") $stwhere .= " a.id=0 and ";		
		}

		if(strlen($searchkey)>0) {
			$querykey = "%".$searchkey."%";
			$stwhere .= " a.name like ".sqlEscape($querykey)." and ";			
		}
		(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);		
	
		$objAdvertise = LOAD::loadDB("Advertise");
		$totalnum = $objAdvertise->getAdvertiseTotalCount($stwhere);
		$totalpage = ceil($totalnum/$perpage);
		$db_advlist = $objAdvertise->getAdvertisePageList($curpage,$perpage,$stwhere,"a.id");
	}

	include PrintEot($job,'www');
	footer(false);
?>