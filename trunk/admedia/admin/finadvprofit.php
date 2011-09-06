<?php
include_once('rolecontrol.php');	

InitGetPost(array('mer_id','start_time','end_time'));

!empty($mer_id) && $transtr .= "&mer_id=$mer_id";
!empty($start_time) && $transtr .= "&start_time=$start_time";
!empty($end_time) && $transtr .= "&end_time=$end_time";

$objMerchant = LOAD::loadClass("Merchant");
$op_merlist = loadMerchantList(1,$mer_id);

$objFinance = LOAD::loadClass("Finance");

$stwhere = "";	
(!empty($mer_id)) && $stwhere .= " a.mer_id=$mer_id and ";
(!empty($start_time)) && $stwhere .= " a.create_time>=".__strtotime($start_time." 00:00:00")." and ";
(!empty($end_time)) && $stwhere .= " a.create_time<=".__strtotime($end_time." 00:00:00")." and ";
(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);
	
$totalnum = $objFinance->getAdvProfitDayTotalCount($stwhere);
$totalpage = ceil($totalnum/$perpage);
$db_advprofitlist = $objFinance->getAdvProfitDayPageList($curpage,$perpage,$stwhere,"a.create_time");
include PrintEot($job);
footer(true);
?>