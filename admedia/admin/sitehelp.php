<?php 
include_once('rolecontrol.php');	

if($action=="new"){
	$objCommData = LOAD::loadDB("CommonData");
	$db_helpmodulelist = $objCommData->getBaseSortKeyList("helpmodule");
	$op_helpmodule = "";
	foreach($db_helpmodulelist as $db_helpmodule){
		$op_helpmodule .= "<option value='$db_helpmodule[val]'>".$db_helpmodule[val]."</option>";
	}
}else if($action=="edit"){
	$objSystem = LOAD::loadDB("System");
	$db_syshelp = $objSystem->getSysHelp($curid);
	
	$objCommData = LOAD::loadDB("CommonData");
	$db_helpmodulelist = $objCommData->getBaseSortKeyList("helpmodule");
	
	$op_helpmodule = "";
	foreach($db_helpmodulelist as $db_helpmodule){
		if($db_syshelp[module]==$db_helpmodule[val]){
			$op_helpmodule .= "<option value='$db_helpmodule[val]' selected>$db_helpmodule[val])</option>";
		}else{
			$op_helpmodule .= "<option value='$db_helpmodule[val]'>$db_helpmodule[val]</option>";
		}
	}
}else if($action=="save"){
	$objSystem = LOAD::loadDB("System");
	if(empty($curid)){//add save
		$_POST["create_time"] = $timestamp;
		$insertid = $objSystem->insertSysHelp($_POST);
		writeSysLog(1, "新增网站帮助", $AdminUser[login_name]."网站帮助ID:".$insertid.",帮助内容:".implode(",",$_POST));
	}else{
		$objSystem->updateSysHelp($curid,$_POST);
		writeSysLog(2, "修改网站帮助", $AdminUser[login_name]."网站帮助ID:".$curid.",帮助内容:".implode(",",$_POST));		
	}
	ObHeader($admin_file.$transtr);
}else if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
		$objSystem = LOAD::loadDB("System");
		$objSystem->deleteSysHelpBatch($ids);		
		writeSysLog(3, "删除网站帮助", $AdminUser[login_name]."删除网站帮助ID:".$ids);			
	}else{
		$objSystem = LOAD::loadDB("System");
		$objSystem->deleteSysHelp($curid);
		writeSysLog(3, "删除网站帮助", $AdminUser[login_name]."删除网站帮助ID:".$curid);	
	}
	ObHeader($admin_file.$transtr);
}else if(empty($action)){
	$objSystem = LOAD::loadDB("System");
	$totalnum = $objSystem->getSysHelpTotalCount();
	$totalpage = ceil($totalnum/$perpage);
	$db_syshelplist = $objSystem->getSysHelpPageList($curpage,$perpage,null,"id");
}
include PrintEot($job);
footer(true);
?>