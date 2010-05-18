<?php 

if(empty($action) || $action=="showdlg"){
	$objmsg = LOAD::loadDB("Message");
	$totalnum = $objmsg->getSysMsgtplTotalCount();
	$totalpage = ceil($totalnum/$perpage);
	$db_sysmsgtpllist = $objmsg->getSysMsgtplPageList($curpage,$perpage,null,"id");
}

if($action=="edit"){
	$objmsg = LOAD::loadDB("Message");
	$db_sysmsgtpl = $objmsg->getSysMsgtpl($curid);
}

if($action=="save"){
	$objmsg = LOAD::loadDB("Message");
	if(empty($curid)){//add save
		$_POST["create_time"] = $timestamp;
		$objmsg->insertSysMsgtpl($_POST);
	}else{
		$objmsg->updateSysMsgtpl($curid,$_POST);
	}
	ObHeader($admin_file);	
}

if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
		$objmsg = LOAD::loadDB("Message");
		$objmsg->deleteSysMsgtplBatch($ids);		
	}else{		
		$objmsg = LOAD::loadDB("Message");
		$objmsg->deleteSysMsgtpl($ids);
	}
	ObHeader("admincp.php?job=sitemsgtpl&curpage=$curpage");	
}

include PrintEot($job);
footer(true);
?>