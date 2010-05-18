<?php 

if($action=="new"){
	$objAdvertise = LOAD::loadDB("Advertise");
	$op_advlist = loadAdvertiseList('1');
	
}else if(empty($action)){
	$objAdvertise = LOAD::loadDB("Advertise");
	$totalnum = $objAdvertise->getAdvPagesTotalCount();
	$totalpage = ceil($totalnum/$perpage);
	$db_advpagelist = $objAdvertise->getAdvPagesPageList($curpage,$perpage);
}

include PrintEot($job);
footer(true);

?>