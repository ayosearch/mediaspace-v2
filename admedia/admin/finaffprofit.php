<?php
include_once('rolecontrol.php');	

InitGetPost(array('aff_id','start_time','end_time'));

!empty($mer_id) && $transtr .= "&mer_id=$mer_id";
!empty($start_time) && $transtr .= "&start_time=$start_time";
!empty($end_time) && $transtr .= "&end_time=$end_time";

$objFinance = LOAD::loadClass("Finance");

$stwhere = "";	
(!empty($aff_id)) && $stwhere .= " a.aff_id=$aff_id and ";
(!empty($start_time)) && $stwhere .= " a.create_time>=".__strtotime($start_time." 00:00:00")." and ";
(!empty($end_time)) && $stwhere .= " a.create_time<=".__strtotime($end_time." 00:00:00")." and ";
(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);
	
$totalnum = $objFinance->getAffProfitDayTotalCount($stwhere);
$totalpage = ceil($totalnum/$perpage);
$db_affprofitlist = $objFinance->getAffProfitDayPageList($curpage,$perpage,$stwhere,"a.create_time");
include PrintEot($job);
footer(true);
?>