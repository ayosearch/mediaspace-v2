<?php
$objDataLog = LOAD::loadClass("DataLog");
$totalnum = $objDataLog->getEffectSubTotalCount();
$totalpage = ceil($totalnum/$perpage);
$db_repeffectsublist = $objDataLog->getEffectSubPageList($curpage,$perpage,null,"create_time");
include PrintEot($job);
footer(true);
?>