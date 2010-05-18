<?php 

if(isset($action)){
	$objSysUser = LOAD::loadDB("AdminUser");	
	if(empty($action)){
		$totalnum = $objSysUser->getSysModuleTotalCount();
		$totalpage = ceil($totalnum%$perpage);
		$db_syscolumnlist = $objSysUser->getSysModulePageList($curpage,$perpage);
	}
	if($action=="new" || $action=="edit"){
		if(empty($curid)){
			$db_column = $objSysUser->getSysModule($curid);			
		}
	}
	if($action=="save"){
		if(empty($curid)){
			$_POST[create_time] = $timestamp;
			$objSysUser->insertSysModule($_POST);
		}else{
			$objSysUser->updateSysModule($curid,$_POST);
		}
	}
	if($action=="del"){
		$objSysUser->deleteSysModule($curid);
	}
	unset($objSysUser);
}

include PrintEot($job);
footer(true);

?>