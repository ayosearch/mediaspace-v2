<?php
$objDataLog = LOAD::loadClass("DataLog");
$totalnum = $objDataLog->getClickLogTotalCount();
$totalpage = ceil($totalnum/$perpage);
$db_showlist = $objDataLog->getClickLogPageList($curpage,$perpage,null,"create_time");
include PrintEot($job);
footer(true);
?>