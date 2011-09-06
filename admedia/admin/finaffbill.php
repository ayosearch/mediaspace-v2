<?php
include_once('rolecontrol.php');	

InitGetPost(array('adv_id','aff_id','start_time','end_time'));

!empty($adv_id) && $transtr .= "&adv_id=$adv_id";
!empty($aff_id) && $transtr .= "&aff_id=$aff_id";
!empty($start_time) && $transtr .= "&start_time=$start_time";
!empty($end_time) && $transtr .= "&end_time=$end_time";

$objAdvertise = LOAD::loadClass("Advertise");
$op_advlist = loadAdvertiseList(1,$adv_id);

$objFinance = LOAD::loadClass("Finance");

$stwhere = "";	
(!empty($adv_id)) && $stwhere .= " adv_id=$adv_id";
(!empty($aff_id)) && $stwhere .= " aff_id=$aff_id";
(!empty($start_time)) && $stwhere .= " create_time>=".__strtotime($start_time);
(!empty($end_time)) && $stwhere .= " create_time<=".__strtotime($end_time);

$objFinance = LOAD::loadClass("Finance");
$totalnum = $objFinance->getAffBillCycleTotalCount();
$totalpage = ceil($totalnum/$perpage);
$db_affbillcyclelist = $objFinance->getAffBillCyclePageList($curpage,$perpage,null,"create_time");
include PrintEot($job);
footer(true);
?>