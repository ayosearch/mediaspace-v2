<?php 

if(empty($action)){
	$objSysUser = LOAD::loadDB("AdminUser");
	$totalnum = $objSysUser->getSysOpLogTotalCount();
	$totalpage = ceil($totalnum/$perpage);
	$db_sysoploglist = $objSysUser->getSysOpLogPageList($curpage,$perpage);
	include PrintEot($job);
	footer(true);
}


?>