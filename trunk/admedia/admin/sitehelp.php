<?php 

if(empty($action)){
	$objSystem = LOAD::loadDB("System");
	$totalnum = $objSystem->getSysHelpTotalCount();
	$totalpage = ceil($totalnum/$perpage);
	$db_syshelplist = $objSystem->getSysHelpPageList($curpage,$perpage,null,"id");
}

if($action=="new"){
	$objCommData = LOAD::loadDB("CommonData");
	$db_helpmodulelist = $objCommData->getBaseSortKeyList("helpmodule");
	$op_helpmodule = "";
	foreach($db_helpmodulelist as $db_helpmodule){
		$op_helpmodule .= "<option value='$db_helpmodule[val]'>".$db_helpmodule[val]."</option>";
	}
}

if($action=="edit"){
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
}

if($action=="save"){
	$objSystem = LOAD::loadDB("System");
	if(empty($curid)){//add save
		$_POST["create_time"] = $timestamp;
		$objSystem->insertSysHelp($_POST);
	}else{
		$objSystem->updateSysHelp($curid,$_POST);
	}
	ObHeader($admin_file);	
}

if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
		$objSystem = LOAD::loadDB("System");
		$objSystem->deleteSysHelpBatch($ids);		
	}else{
		$objSystem = LOAD::loadDB("System");
		$objSystem->deleteSysHelp($curid);
	}
	ObHeader("admincp.php?job=sitehelp&curpage=$curpage");	
}

include PrintEot($job);
footer(true);
?>