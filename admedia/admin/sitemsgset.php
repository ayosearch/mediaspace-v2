<?php 
include_once('rolecontrol.php');	

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
		$insertid = $objmsg->insertSysMsgset($_POST);
		writeSysLog(1, "新增消息设置", $AdminUser[login_name]."消息设置ID:".$insertid.",消息内容:".implode(",",$_POST));
	}else{
		$objmsg->updateSysMsgset($curid,$_POST);
		writeSysLog(2, "修改消息设置", $AdminUser[login_name]."消息设置ID:".$curid.",消息内容:".implode(",",$_POST));
	}
	ObHeader($admin_file);	
}

if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
		$objmsg = LOAD::loadDB("Message");
		$objmsg->deleteSysMsgsetBatch($ids);		
		writeSysLog(3, "删除消息设置", $AdminUser[login_name]."消息设置ID:".$ids);
	}else{
		$objmsg = LOAD::loadDB("Message");
		$objmsg->deleteSysMsgset($ids);
		writeSysLog(3, "删除消息设置", $AdminUser[login_name]."消息设置ID:".$ids);
	}
	ObHeader($admin_file.$transtr);
}

include PrintEot($job);
footer(true);
?>