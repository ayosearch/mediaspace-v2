<?php
$objDataLog = LOAD::loadClass("DataLog");
$totalnum = $objDataLog->getEffectLogTotalCount();
$totalpage = ceil($totalnum/$perpage);
$db_repeffectloglist = $objDataLog->getEffectLogPageList($curpage,$perpage,null,"create_time");
include PrintEot($job);
footer(true);
?>