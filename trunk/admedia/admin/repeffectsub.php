<?php
include_once('rolecontrol.php');	

$objAdvertise = LOAD::loadDB("Advertise");	
$op_advlist = loadAdvertiseList(1,"0");

$objDataLog = LOAD::loadClass("DataLog");
$totalnum = $objDataLog->getEffectSubTotalCount();
$totalpage = ceil($totalnum/$perpage);
$db_repeffectsublist = $objDataLog->getEffectSubPageList($curpage,$perpage,null,"create_time");
include PrintEot($job);
footer(true);
?>