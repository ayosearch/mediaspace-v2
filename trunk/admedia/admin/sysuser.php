<?php

if(empty($action)){
	$objSysUser = LOAD::loadDB("AdminUser");
	$totalnum = $objSysUser->getSysUserTotalCount();
	$totalpage = ceil($totalnum/$perpage);
	$db_sysuserlist = $objSysUser->getSysUserPageList($curpage,$perpage);
	include PrintEot($job);
	footer(true);
}

if($action=="new"){
	$objSysUser = LOAD::loadDB("AdminUser");
	$db_sysrolelist = $objSysUser->getSysRoleAll();
	$selrolelist = "";
	foreach($db_sysrolelist as $sysrole){
		$selrolelist .= "<input type='checkbox' name='role_id' value='".$sysrole[id]."'>".$sysrole[name]."</option>";
	}
}

if($action=="edit"){
	$objSysUser = LOAD::loadDB("AdminUser");
	$db_sysuser = $objSysUser->getSysUser($curid);
	$db_sysrolelist = $objSysUser->getSysRoleAll();
	$selrolelist = "";
	foreach($db_sysrolelist as $sysrole){
		if($db_sysuser[role_id]==$sysrole[id]){
			$selrolelist .= "<input type='checkbox' name='role_id' value='".$sysrole[id]."' checked>".$sysrole[name]."</option>";
		}else{
			$selrolelist .= "<input type='checkbox' name='role_id' value='".$sysrole[id]."'>".$sysrole[name]."</option>";
		}
	}
}

if($action=="save"){
	$objSysUser = LOAD::loadDB("AdminUser");
	if(empty($curid)){//add save
		if($objSysUser->checkSysUser($_POST["login_name"])==false){
			$_POST["create_time"] = $timestamp;
			$_POST["login_pwd"] = pwdCode($_POST["login_srcpwd"]);
			$objSysUser->insertSysUser($_POST);
		}else{
			$basename = $GLOBALS['pmServer']['HTTP_REFERER'];
			adminMsg('username_exists');
		}
	}else{
		$_POST["login_pwd"] = pwdCode($_POST["login_srcpwd"]);
		$objSysUser->updateSysUser($curid,$_POST);
	}
	ObHeader($admin_file);	
}

if($action=="audit"){
	$objSysUser = LOAD::loadDB("AdminUser");
}

if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
		$objSysUser = LOAD::loadDB("AdminUser");
		$objSysUser->deleteSysUserBatch($ids);		
	}else{
		$objSysUser = LOAD::loadDB("AdminUser");
		$objSysUser->deleteSysUser($curid);
	}
	ObHeader("admincp.php?job=sysuser");	
}

include PrintEot($job);
footer(true);


?>