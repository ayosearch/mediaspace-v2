<?php
if(empty($action)){


	if(!empty($searchtype) && !empty($searchkey)) {
		$querykey = "%".$searchkey."%";
		$stwhere .= " $searchtype like ".sqlEscape($querykey)." and ";			
	}
	(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);	
	
	$objAdvertise = LOAD::loadDB("Advertise");
	$totalnum = $objAdvertise->getAdvRollPlanTotalCount();
	$totalpage = ceil($totalnum/$perpage);
	$db_adrolllist = $objAdvertise->getAdvRollPlanPageList($curpage,$perpage);
}
include PrintEot($job);
footer(true);
?>