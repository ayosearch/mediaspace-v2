<?php
include_once('rolecontrol.php');	
InitGetPost(array('all','status',',start_date','end_date','fee_type','adv_ids','type','hascpc','hascpa','hascpm','hascpd','is_cpc','is_cpa','is_cpm','is_cpd'));

strlen($hascpc)>0 && $transtr .= "&hascpc=$hascpc";
strlen($hascpa)>0 && $transtr .= "&hascpa=$hascpa";
strlen($hascpm)>0 && $transtr .= "&hascpm=$hascpm";
strlen($hascpd)>0&& $transtr .= "&hascpd=$hascpd";
strlen($status)>0&& $transtr .= "&status=$status";
(strlen($searchtype)>0 && strlen($searchkey)>0) && $transtr .= "&searchtype=".$searchtype."&searchkey=$searchkey";

if($action=="new"){
	$objAdvertise = LOAD::loadDB("Advertise");
	$db_advlist = $objAdvertise->getAdvertiseFeetypeStatusList(0,1);
	$db_advcreativelist = $objAdvertise->getAdvCreativeAll(1);
	$show_creative = "none";
	$show_adv = "block";
	$show_range="block";
	$show_type="block";
}else if($action=="edit"){
	$show_creative = "none";
	$show_adv = "block";
	$show_range="block";
	$show_type="block";	
	$objAdvertise = LOAD::loadDB("Advertise");
	$db_advrole = $objAdvertise->getAdvRollPlan($curid);
	$db_advlist = $objAdvertise->getAdvertiseByIds($db_advrole[adv_ids]."0");
	if($db_advrole){
		if($db_advrole[is_all]==1){
			$show_adv = "none";
			$show_range="none";
			$show_type="none";	
		}else{
			if($db_advrole[type]==1 || $db_advrole[type]==2){
				$show_creative = "block";
			}
		}
	}
}else if($action=="seladv"){
	if(strlen($fee_type)>0){
		if(strpos($fee_type,',')>0){
			$fee_type = substr($fee_type,0,strlen($fee_type)-1);
		}
		$objAdvertise = LOAD::loadDB("Advertise");
		$db_advlist = $objAdvertise->getAdvertiseFeetypeStatusList($fee_type,1);
	}
	include PrintEot($job);
	footer();
}else if($action=="selcreative"){
	if(!empty($adv_ids)){
		if(strpos($adv_ids,',')>0){
			$adv_ids = substr($adv_ids,0,strlen($adv_ids)-1);
		}		
		$objAdvertise = LOAD::loadDB("Advertise");	
		$db_advcreativelist = $objAdvertise->getAdvCreativeAll(1,$adv_ids,1);
		if($curid)	$db_detailist = $objAdvertise->getAdvRollDetailByPlanId($curid);		
	}
}else if($action=="save"){
		$objAdvertise = LOAD::loadDB("Advertise");			
		if(!empty($curid)){
			$objAdvertise->deleteAdvRollDetailByPlanId($curid);
		}		
		$_POST["create_time"] = $timestamp;
		$_POST["update_time"] = $timestamp;
		if($_POST[is_all]=="1"){
			if($objAdvertise->checkAdvRollPlanIsAll()){
				$basename = $GLOBALS['pmServer']['HTTP_REFERER'];			
				adminMsg("advrollplanisall_exists");	
				exit;
			}
			if(empty($curid)){
				$objAdvertise->insertAdvRollPlan($_POST);
				writeSysLog(1, "新增轮播计划", $AffUser[login_name]."新增计划内容:".implode(',',$_POST));
			}else{
				if(!$is_cpc) $_POST[is_cpc] = 0;
				if(!$is_cpm) $_POST[is_cpm] = 0;
				if(!$is_cpa) $_POST[is_cpa] = 0;
				if(!$is_cpd) $_POST[is_cpd] = 0;
				$objAdvertise->updateAdvRollPlan($curid,$_POST);
				writeSysLog(2, "修改轮播计划", $AdminUser[login_name]."修改计划id:".$curid.",内容:".implode(',',$_POST));
			}			
		}else{
			if(empty($curid)){
				$roll_id = $objAdvertise->insertAdvRollPlan($_POST);
				writeSysLog(1, "新增轮播计划", $AdminUser[login_name]."新增计划内容:".implode(',',$_POST));
			}else{
				$roll_id = $curid;
				if(!$is_cpc) $_POST[is_cpc] = 0;
				if(!$is_cpm) $_POST[is_cpm] = 0;
				if(!$is_cpa) $_POST[is_cpa] = 0;
				if(!$is_cpd) $_POST[is_cpd] = 0;				
				$objAdvertise->updateAdvRollPlan($curid,$_POST);
				writeSysLog(2, "修改轮播计划", $AdminUser[login_name]."修改计划id:".$curid.",内容:".implode(',',$_POST));
			}
			if($_POST[type]=="1"){
				$ctids = $_POST["creative_ids"];
				if(strpos($ctids,',')>0){
					$arrids = explode(",",$ctids);
					foreach($arrids as $selctid){
						if($selctid && strlen($selctid)>0){
							$arrdetail = array("mer_id"=>$_POST["mer_id_".$selctid],"adv_id"=>$_POST["adv_id_".$selctid],"creative_id"=>$selctid,
														 "roll_id"=>$roll_id,"create_time"=>$timestamp,"update_time"=>$timestamp);
							$objAdvertise->insertAdvRollDetail($arrdetail);
						}
					}
				}
			}else if($_POST[type]=="2"){
				$ctids = $_POST["creative_ids"];
				if(strpos($ctids,',')>0){
					$arrids = explode(",",$ctids);
					foreach($arrids as $selctid){
						if($selctid && strlen($selctid)>0){
							$shour = $_POST["start_hour_".$selctid].":".$_POST["start_minute_".$selctid];
							$ehour = $_POST["end_hour_".$selctid].":".$_POST["end_minute_".$selctid];
							$arrdetail = array("mer_id"=>$_POST["mer_id_".$selctid],"adv_id"=>$_POST["adv_id_".$selctid],"creative_id"=>$selctid,"roll_id"=>$roll_id,
															"start_time"=>$shour,"end_time"=>$ehour,"create_time"=>$timestamp,"update_time"=>$timestamp);
							$objAdvertise->insertAdvRollDetail($arrdetail);
						}
					}
				}
			}		
		}
		ObHeader($admin_file.$transtr);
		exit;
}else if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}	
	$objAdvertise = LOAD::loadDB("Advertise");
	$arrids = explode(",",$ids);
	foreach($arrids as $selid){
		$objAdvertise->deleteAdvRollDetailByPlanId($selid);
	}
	$objAdvertise->deleteBatchAdvRollPlan($ids);
	writeSysLog(3, "删除轮播计划", $AdminUser[login_name]."删除计划id:".$ids);
	ObHeader($admin_file.$transtr);
}else if(empty($action)){
	$stwhere = "";
	strlen($status)>0 && $stwhere .= " status=".$status." and ";	
	strlen($hascpc)>0 && $stwhere .= " is_cpc=1 and ";
	strlen($hascpa)>0 && $stwhere .= " is_cpa=1 and ";
	strlen($hascpm)>0 && $stwhere .= " is_cpa=1 and ";
	strlen($hascpd)>0&& $stwhere .= " is_cpa=1 and ";	
	if(!empty($searchtype) && !empty($searchkey)) {
		$querykey = "%".$searchkey."%";
		$stwhere .= " $searchtype like ".sqlEscape($querykey)." and ";			
	}
	(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);	
	
	$objAdvertise = LOAD::loadDB("Advertise");
	$totalnum = $objAdvertise->getAdvRollPlanTotalCount($stwhere);
	$totalpage = ceil($totalnum/$perpage);
	$db_adrolllist = $objAdvertise->getAdvRollPlanPageList($curpage,$perpage,$stwhere);
}
include PrintEot($job);
footer(true);

?>