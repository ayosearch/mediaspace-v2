<?php
$objDataLog = LOAD::loadClass("DataLog");
$totalnum = $objDataLog->getShowLogTotalCount();
$totalpage = ceil($totalnum/$perpage);
$db_showlist = $objDataLog->getShowLogPageList($curpage,$perpage,null,"create_time");
include PrintEot($job);
footer(true);
?>