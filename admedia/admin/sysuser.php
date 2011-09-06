<?php

include_once('rolecontrol.php');	

InitGetPost(array('ownIds','userName','delflag'));

if($action=="new"){
	$objSysUser = LOAD::loadDB("AdminUser");
	$db_sysrolelist = $objSysUser->getSysRoleAll();
	$selrolelist = "";
	foreach($db_sysrolelist as $sysrole){
		$selrolelist .= "<input type='checkbox' name='role_id' value='".$sysrole[id]."'>".$sysrole[name]."</option>";
	}
}else if($action=="edit"){
	$objSysUser = LOAD::loadDB("AdminUser");
	$db_sysuser = $objSysUser->getSysUser($curid);
	$db_sysrolelist = $objSysUser->getSysRoleAll();
	foreach($db_sysrolelist as $sysrole){
		if($db_sysuser[role_id]==$sysrole[id]){
			$selrolelist .= "<input type='checkbox' name='role_id' value='".$sysrole[id]."' checked>".$sysrole[name]."</option>";
		}else{
			$selrolelist .= "<input type='checkbox' name='role_id' value='".$sysrole[id]."'>".$sysrole[name]."</option>";
		}
	}
}else if($action=="save"){
	$objSysUser = LOAD::loadDB("AdminUser");
	if(empty($curid)){//add save
		if($objSysUser->checkSysUser($_POST["login_name"])){
			$_POST["create_time"] = $timestamp;
			$_POST["login_pwd"] = pwdCode($_POST["login_srcpwd"]);
			$objSysUser->insertSysUser($_POST);
			writeSysLog(1, "增加用户", $AdminUser[login_name]."新增用户:".$_POST);	
		}else{
			$basename = $GLOBALS['pmServer']['HTTP_REFERER'];
			adminMsg('username_exists');
		}
	}else{
		$_POST["login_pwd"] = pwdCode($_POST["login_srcpwd"]);
		$objSysUser->updateSysUser($curid,$_POST);
		writeSysLog(2, "修改用户", $AdminUser[login_name]."修改用户信息:".$_POST);			
	}
	ObHeader($admin_file.$transtr);
}else if($action=="dis"){
	$objSysUser = LOAD::loadDB("AdminUser");
	$db_sysuser = $objSysUser->getSysUser($curid);
	$ownIds = "";
	if (!empty($db_sysuser[own_users])) 
		$ownIds = $db_sysuser[own_users];
	$owncount = 0;
	$nowoncount = 0;
	$db_sysuserall = $objSysUser->getSysUserNormalAll();
	foreach($db_sysuserall as $sysuser){
		if($sysuser[id]==$curid) continue;
		if(strpos(",,".$ownIds,",".$sysuser[id].",")>0){
			$ownUserList .= "<input type=checkbox id='".$sysuser[id]."' value=".$sysuser[id]." onclick='RemoveUser()'><label for='".$sysuser[id]."'>".$sysuser[login_name]."</label>&nbsp;&nbsp;&nbsp;";
			$owncount++;
			if ($owncount % 5 == 0){
				$ownUserList .= "<br/>";
			}
		}else{
		   $notOwnUserList .= "<input type=checkbox id='".$sysuser[id]."' value=".$sysuser[id]." onclick='SelectUser()'><label for='".$sysuser[id]."'>".$sysuser[login_name]. "</label>&nbsp;&nbsp;&nbsp;";
			$nowoncount++;
			if ($nowoncount % 5 == 0){
				$notOwnUserList .= "<br/>";
			}
		}
	}
}else if($action=="disave"){
	$objSysUser = LOAD::loadDB("AdminUser");
	$objSysUser->distributeSysUser($curid,$ownIds);
	writeSysLog(5,"分配用户下属", $AdminUser[login_name]." 分配用户".userName."的下属用户:".$ownIds);
	ObHeader($admin_file.$transtr);
}else if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
		$objSysUser = LOAD::loadDB("AdminUser");
		$objSysUser->deleteSysUserBatch($ids);		
		writeSysLog(3, "删除用户", $AdminUser[login_name]."删除用户:".$ids);
	}else{
		$objSysUser = LOAD::loadDB("AdminUser");
		$objSysUser->deleteSysUser($ids);
		writeSysLog(3, "删除用户", $AdminUser[login_name]."删除用户:".$ids);		
	}
	ObHeader($admin_file.$transtr);
}else if(empty($action)){
	$objSysUser = LOAD::loadDB("AdminUser");
	$totalnum = $objSysUser->getSysUserTotalCount();
	$totalpage = ceil($totalnum/$perpage);
	$db_sysuserlist = $objSysUser->getSysUserPageList($curpage,$perpage);
}
include PrintEot($job);
footer(true);


?>