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
(!empty($mer_id)) && $stwhere .= " mer_id=$mer_id";
(!empty($start_time)) && $stwhere .= " start_time=".__strtotime($start_time);
(!empty($end_time)) && $stwhere .= " end_time=".__strtotime($end_time);
	
$totalnum = $objFinance->getMerBillDayTotalCount($stwhere);
$totalpage = ceil($totalnum/$perpage);
$db_affbillcyclelist = $objFinance->getMerBillDayPageList($curpage,$perpage,$stwhere,"create_time");
include PrintEot($job);
footer(true);
?>