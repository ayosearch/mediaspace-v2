<?php 
include_once('rolecontrol.php');	

InitGetPost(array('txtlimit'));

if($action=='save'){
	$objSysUser = LOAD::loadDB("AdminUser");	
	if(empty($curid)){
		$objSysUser->insertSysRole($_POST);
		writeSysLog(1, "用户添加系统角色", "增加角色内容：".$curid." Name:".$_POST[name]." Memo:" .$_POST[memo]);	
	}else{
		$objSysUser->updateSysRole($curid,$_POST);
		writeSysLog(2, "用户修改系统角色", "修改角色编号：".$curid." Name:".$_POST[name]." Memo:" .$_POST[memo]);	
	}	
	ObHeader($admin_file);
}else if($action=="edit"){
	$objSysUser = LOAD::loadDB("AdminUser");
	$db_sysrole = $objSysUser->getSysRole($curid);
}else if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
		$objSysUser = LOAD::loadDB("AdminUser");
		$objSysUser->deleteSysRoleBatch($ids);
		writeSysLog(3, "用户删除系统角色", $AdminUser[login_name]."删除角色编号：".$ids);	
		ObHeader($admin_file.$transtr);
	}
}else if($action=="dis"){
	$objSysUser = LOAD::loadDB("AdminUser");	
	$db_sysrole = $objSysUser->getSysRole($curid);
	$db_sysmodulelist = $objSysUser->getSysModuleAll();
	$db_limitlist = $objSysUser->getSysCellOperateAll();
	$txtlimit = $db_sysrole[operate_ids];
	$showhtml = EditModule(0);
}else if($action=="savedispatch"){
	$objSysUser = LOAD::loadDB("AdminUser");
	$objSysUser->updateSysRoleOperateIds($curid,$txtlimit);
	writeSysLog(5, "用户设定角色权限", $AdminUser[login_name]."角色：".$curid." 设定权限单元：".$txtlimit);
	ObHeader($admin_file.$transtr);
}else if(empty($action)){
	$objSysUser = LOAD::loadDB("AdminUser");
	$totalnum = $objSysUser->getSysRoleTotalCount();
	$totalpage = ceil($totalnum/$perpage);
	$db_sysrolelist = $objSysUser->getSysRolePageList($curpage,$perpage);
}

include PrintEot($job);
footer(true);

function EditModule($id){
	global $objSysUser,$db_sysmodulelist,$txtlimit;
	$streturn = "";
	foreach($db_sysmodulelist as $db_sysmodule){
		if($db_sysmodule[parent_id]==$id){
			$re = $objSysUser->getSysModuleTotalCount("parent_id=".$db_sysmodule[id]);
			if($re>0){
				$streturn .= "<tr height='25'><td align='left'><b>&nbsp;&nbsp;".$db_sysmodule[name].":</b></td><td>&nbsp;</td></tr>";
			}else{
				$streturn .= "<tr height='25'><td width='210px' align='left'>&nbsp;&nbsp;<input type='checkbox' id='col_"
               						.$db_sysmodule[id]."' onclick='SelectOneColumn(".$db_sysmodule[id].")'><label for='col_"
                    				.$db_sysmodule[id]."' class='hei12b'>".$db_sysmodule[name]. "：</label></td><td align=left>";
                 for($i=4;$i<11;$i++){
                 	$ischeck = "";
                 	$sellimit = $objSysUser->getSysCellOperateById($db_sysmodule[id],$i);
                 	if(strpos(",,".$txtlimit,",".$sellimit[id].",")>0)
                 		$ischeck = "checked";
                 	$streturn .= "<input onclick='SelectLimt(this)' type='checkbox' id='".$db_sysmodule[id]."_".$i.
                 						 "' value='".$sellimit[id]."' ".$ischeck."><label for='".$db_sysmodule[id]."_".$i."'>".$sellimit[op_name]."</label>&nbsp;&nbsp;";
                 }
			}
            $streturn .= EditModule($db_sysmodule[id]);			
		}
	}
	return $streturn;
}

?>