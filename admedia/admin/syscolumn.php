<?php 

	$objSysUser = LOAD::loadDB("AdminUser");	
	if(empty($action)){
		$totalnum = $objSysUser->getSysModuleTotalCount();
		$totalpage = ceil($totalnum/$perpage);
		$db_syscolumnlist = $objSysUser->getSysModulePageList($curpage,$perpage,null,"a.col_index");
	}else if($action=="new" || $action=="edit"){
		$selmodulelist = "";
		$db_columnlist =$objSysUser->getSysModuleAll();
		if(!empty($curid)){
			$db_column = $objSysUser->getSysModule($curid);	
			editCol(0, 0, $db_column[parent_id]);
		}else{
			editCol(0, 0, 0);
		}
	}else if($action=="save"){
		if(empty($curid)){
			$_POST[create_time] = $timestamp;
			$curid = $objSysUser->insertSysModule($_POST);
		}else{
			$objSysUser->updateSysModule($curid,$_POST);
		}
		$db_sysoperatelist = $objSysUser->getSysOperateAll();
		foreach($db_sysoperatelist as $db_sysoperate){
			$count = $objSysUser->checkSysCellOperate($curid,$db_sysoperate[id]);
			if($count==0){
				$arrfield = array("col_id"=>"$curid","op_id"=>"$db_sysoperate[id]","is_del"=>"0");
				$objSysUser->insertSysCellOperate($arrfield);
			}
		}
		ObHeader($admin_file."&curpage=$curpage".$transtr);
		exit;
	}else if($action=="del"){
		if(strpos($ids,',')>0){
			$ids = substr($ids,0,strlen($ids)-1);		
			$objSysUser->deleteSysModule($ids);
			$objSysUser->deleteSysCellOperateByColId($ids);
		}
	}
	unset($objSysUser);
	include PrintEot($job);
	footer(true);

function editCol($id, $spacenum, $selid){
	global $db_columnlist,$selmodulelist;
	$num = $spacenum;
	foreach($db_columnlist as $column ){
		if ($column[parent_id] == $id) {
			if ($column[parent_id]  ==  0) $spacenum = 0;
			$num = $spacenum + 1;
            $strsel = ($column[id] == $selid) ? "selected" : "";
            $tmpstr =  colIndent("-", $spacenum);
			$selmodulelist = $selmodulelist."<option ".$strsel." value='".$column[id]."'>".$tmpstr.$column[name]."</option>";
			editCol($column[id], $num, $selid);
		}
	}
}

function colIndent($symb,$symbnum) {
	$strR = "";
	if ($symbnum != 0){
		$strR = "├";
		for ($i = 0; $i < $symbnum; $i++){
                $strR .= $symb;
		}
	} else  $strR = "";
	return $strR;
}
?>