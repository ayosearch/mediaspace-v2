<?php 

if($action=="new" || $action=="edit"){
	$objCommData = LOAD::loadDB("CommonData");
	if(!empty($curid)){
		$objAffiliate = LOAD::loadDB("Affiliate");
		$objAdvertise = LOAD::loadDB("Advertise");		
		$db_advapply = $objAffiliate->getAffAdvApply($curid);
		$db_advlist = $objAdvertise->getAdvertiseAll();
		$op_advlist = "";
		foreach ($db_advlist as $db_adv){
			if($db_adv[id]==$db_advapply[adv_id]){
				$op_advlist .= "<option value='$db_adv[id]' selected>$db_adv[name]</option>";
			}else{
				$op_advlist .= "<option value='$db_adv[id]'>$db_adv[name]</option>";
			}
		}
	}
	unset($objAffiliate,$objAdvertise,$db_affadvplace);
}else if($acton=="save"){
	$objAffiliate = LOAD::loadDB("Affiliate");		
	if(empty($curid)){
		$_POST[create_time] = $timestamp;
		$objAffiliate->insertAffAdvApply(_POST);
	}else{
		$objAffiliate->updateAffAdvApply($curid,_POST);
	}
	unset($objAffiliate);
	ObHeader("$basename?job=affadvapply");	
}else if($action=="audit"){
	$objAffiliate = LOAD::loadDB("Affiliate");
	$objAffiliate->updateAffAdvApplyStatus($curid,$status);
}else if($action=="del"){
	$objAffiliate = LOAD::loadDB("Affiliate");
	$objAffiliate->deleteAffAdvApply($curid);
	unset($objAffiliate);	
	ObHeader("$basename?job=affadvplace");	
}else if(empty($action) || $action=="select"){
	$objAffiliate = LOAD::loadDB("Affiliate");
	$totalnum = $objAffiliate->getAffAdvApplyTotalCount();
	$totalpage = ceil($totalnum/$perpage);
	$db_affadvapplylist = $objAffiliate->getAffAdvApplyPageList($curpage,$perpage);
	unset($objAffiliate,$totalnum,$totalpage);
}
include PrintEot($job);
footer(true);
?>