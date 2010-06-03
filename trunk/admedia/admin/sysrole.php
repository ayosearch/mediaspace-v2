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
if($action=="dis"){
	$objSysUser = LOAD::loadDB("AdminUser");	
	$db_sysrole = $objSysUser->getSysRole($curid);
	$db_sysmodulelist = $objSysUser->getSysModuleAll();
	$db_limitlist = $objSysUser->getSysCellOperateAll();
	$txtlimit = ",".$db_sysrole[operate_ids].",";
	$showhtml = EditModule(0);
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
				$streturn .= "<tr height='25'><td align='left'><b>".$db_sysmodule[name].":</b></td><td>&nbsp;</td></tr>";
			}else{
				$streturn .= "<tr height='25'><td width='180px' align='left'>&nbsp;&nbsp;<input type='checkbox' id='col_"
               						.$db_sysmodule[id]."' onclick='SelectOneColumn(".$db_sysmodule[id].")'><label for='col_"
                    				.$db_sysmodule[id]."' class='hei12b'>".$db_sysmodule[name]. "：</label></td><td align=left>";
                 for($i=4;$i<11;$i++){
                 	$ischeck = "";
                 	$sellimit = $objSysUser->getSysCellOperateById($db_sysmodule[id],$i);
                 	if(strpos($txtlimit,",".$sellimit.",")>0)
                 		$ischeck = "checked";
                 	$streturn .= "<input onclick='SelectLimt()' type='checkbox' id='".$db_sysmodule[id]."_".$i.
                 						 "' value='".$sellimit[id]."' ".$ischeck."><label for='".$db_sysmodule[id]."_".$i."'>".$sellimit[op_name]."</label>&nbsp;&nbsp;";
                 }
			}
            $streturn .= EditModule($db_sysmodule[id]);			
		}
	}
	return $streturn;
}

?>