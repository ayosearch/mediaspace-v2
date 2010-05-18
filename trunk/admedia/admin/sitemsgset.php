<?php 

if(empty($action)){
	$objmsg = LOAD::loadDB("Message");
	$totalnum = $objmsg->getSysMsgsetTotalCount();
	$totalpage = ceil($totalnum/$perpage);
	$db_sysmsgsetlist = $objmsg->getSysMsgsetPageList($curpage,$perpage,null,"id");
}

if($action=="edit"){
	$objmsg = LOAD::loadDB("Message");
	$db_sysmsgset = $objmsg->getSysMsgset($curid);
}

if($action=="save"){
	$objmsg = LOAD::loadDB("Message");
	if(empty($curid)){//add save
		$_POST["create_time"] = $timestamp;
		$_POST["send_time"] = strtotime($_POST["send_date"]." ".$_POST["send_hour"].":".$_POST["send_minute"].":0");
		$objuser = LOAD::loadDB("AdminUser");
		$db_sysuser = $objuser->getSysUserByUserName($admin_name);
		$_POST["sys_id"] = $db_sysuser[id];
		$_POST["sys_name"] = "$admin_name";
		$objmsg->insertSysMsgset($_POST);
	}else{
		$objmsg->updateSysMsgset($curid,$_POST);
	}
	ObHeader($admin_file);	
}

if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
		$objmsg = LOAD::loadDB("Message");
		$objmsg->deleteSysMsgsetBatch($ids);		
	}else{
		$objmsg = LOAD::loadDB("Message");
		$objmsg->deleteSysMsgset($ids);
	}
	ObHeader("admincp.php?job=sitemsgset&curpage=$curpage");	
}

include PrintEot($job);
footer(true);
?>