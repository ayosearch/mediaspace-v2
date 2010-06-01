<?php
$stwhere = " a.is_del=1 and ";
(!empty($audit)) && $stwhere .= " a.audit=".sqlEscape($audit)." and ";		
(!empty($start_date)) && $stwhere .= " a.create_time>=".__strtotime($start_date)." and ";	
(!empty($end_date)) && $stwhere .= " a.create_time<=".__strtotime($end_date)." and ";		
if(!empty($searchtype) && !empty($searchkey)) {
	$querykey = "%".$searchkey."%";
	$stwhere .= " $searchtype like ".sqlEscape($querykey)." and ";			
}
(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);	
	
$objAdvertise = LOAD::loadDB("Advertise");
$totalnum = $objAdvertise->getAdvertiseTotalCount($stwhere);
$totalpage = ceil($totalnum/$perpage);
$db_advlist = $objAdvertise->getAdvertisePageList($curpage,$perpage,$stwhere,"level");

include PrintEot($job);
footer(true); 
?>