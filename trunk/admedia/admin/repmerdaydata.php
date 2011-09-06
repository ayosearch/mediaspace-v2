<?php
include_once('rolecontrol.php');	

$objDataLog = LOAD::loadClass("DataLog");
$totalnum = $objDataLog->getRepMerDayDataTotalCount();
$totalpage = ceil($totalnum/$perpage);
$db_merdaydatalist = $objDataLog->getRepMerDayDataPageList($curpage,$perpage,null,"create_time");
include PrintEot($job);
footer(true);
?>