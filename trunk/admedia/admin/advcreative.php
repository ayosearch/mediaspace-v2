<?php 

if($action=="new"){
	
}else if($action=="edit"){
	
}else if($action=="save"){
	$objAdvertise = LOAD::loadDB("Advertise");	
	if(empty($curid)){
		$_POST[create_time] = $timestamp;
		$objAdvertise->insertAdvCreatvie($_POST);
	}else{
		$_POST[update_time] = $timestamp;
		$objAdvertise->updateAdvCreative($curid,$_POST);
	}
}else if(empty($action)){
	$objAdvertise = LOAD::loadDB("Advertise");
	$totalnum = $objAdvertise->getAdvCreativeTotalCount();
	$totalpage = ceil($totalnum/$perpage);
	$db_advcreativelist = $objAdvertise->getAdvCreativePageList($curpage,$perpage);
}

include PrintEot($job);
footer(true);

?>