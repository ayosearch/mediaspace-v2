<?php 

if(empty($action)){
	$objSysUser = LOAD::loadDB("AdminUser");
	$totalnum = $objSysUser->getSysRoleTotalCount();
	$totalpage = ceil($totalnum/$perpage);
	$db_sysrolelist = $objSysUser->getSysRolePageList($curpage,$perpage);
}
if($action=='save'){
	$objSysUser = LOAD::loadDB("AdminUser");	
	if(empty($curid)){
		$objSysUser->insertSysRole($_POST);
	}else{
		$objSysUser->updateSysRole($curid,$_POST);
	}
	ObHeader($admin_file);
}
if($action=="edit"){
	$objSysUser = LOAD::loadDB("AdminUser");
	$db_sysrole = $objSysUser->getSysRole($curid);
}
if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
		$objSysUser = LOAD::loadDB("AdminUser");
		$objSysUser->deleteSysRoleBatch($ids);
		ObHeader("admincp.php?job=sysrole");		
	}
}
include PrintEot($job);
footer(true);
?>