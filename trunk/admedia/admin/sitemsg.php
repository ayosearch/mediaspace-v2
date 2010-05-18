<?php 

if(empty($action)){
	$objmsg = LOAD::loadDB("Message");
	$totalnum = $objmsg->getSysMessageTotalCount();
	$totalpage = ceil($totalnum/$perpage);
	$db_sysmsglist = $objmsg->getSysMessagePageList($curpage,$perpage,null,"id");
}

if($action=="edit"){
	$objmsg = LOAD::loadDB("Message");
	$db_sysmsg = $objmsg->getSysMessage($curid);
}

if($action=="save"){
	$objmsg = LOAD::loadDB("Message");
	if(empty($curid)){//add save
		$_POST["create_time"] = $timestamp;
		$objmsg->insertSysMessage($_POST);
	}else{
		$objmsg->updateSysMessage($curid,$_POST);
	}
	ObHeader($admin_file);	
}

if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
		$objmsg = LOAD::loadDB("Message");
		$objmsg->deleteSysMessageBatch($ids);		
	}else{
		$objmsg = LOAD::loadDB("Message");
		$objmsg->deleteSysMessage($curid);
	}
	ObHeader("admincp.php?job=sitemsg&curpage=$curpage");	
}

include PrintEot($job);
footer(true);
?>