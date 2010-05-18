<?php 

if(empty($action)){
	$objAdvertise = LOAD::loadDB("Advertise");
	$totalnum = $objAdvertise->getAdvBuyAffPlacesTotalCount();
	$totalpage = ceil($totalnum/$perpage);
	$db_advbuyplacelist = $objAdvertise->getAdvBuyAffPlacesPageList($curpage,$perpage);
}

if($action=="new"){
	$objAdvertise = LOAD::loadDB("Advertise");
	$op_advlist = loadAdvertiseList(1);
}

if($action=="edit"){

}

if($action=="save"){
	$objAdvertise = LOAD::loadDB("Advertise");	
	if(isset($curid) && empty($curid)){
		$objAdvertise->insertAdvBuyAffPlaces($_POST);
	}else if(isset($curid)){
		$objAdvertise->updateAdvBuyAffPlaces($curid,$_POST);
	}
	ObHeader("$basename?job=advbuyplace$transtr");
}

include PrintEot($job);
footer(true);


?>