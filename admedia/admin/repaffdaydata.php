<?php
$objDataLog = LOAD::loadClass("DataLog");
$totalnum = $objDataLog->getRepAffDayDataTotalCount();
$totalpage = ceil($totalnum/$perpage);
$db_affdaydatalist = $objDataLog->getRepAffDayDataPageList($curpage,$perpage,null,"create_time");
include PrintEot($job);
footer(true);
?>