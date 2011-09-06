<?php 
include_once('rolecontrol.php');	

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
		writeSysLog(1, "新增网站消息", $AdminUser[login_name]."网站消息ID:".$insertid.",消息内容:".implode(",",$_POST));
	}else{
		$objmsg->updateSysMessage($curid,$_POST);
		writeSysLog(2, "修改网站消息", $AdminUser[login_name]."网站消息ID:".$curid.",消息内容:".implode(",",$_POST));
	}
	ObHeader($admin_file);	
}

if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
		$objmsg = LOAD::loadDB("Message");
		$objmsg->deleteSysMessageBatch($ids);
		writeSysLog(3, "删除网站消息", $AdminUser[login_name]."网站消息ID:".$ids);
	}else{
		$objmsg = LOAD::loadDB("Message");
		$objmsg->deleteSysMessage($curid);
		writeSysLog(3, "删除网站消息", $AdminUser[login_name]."网站消息ID:".$curid);		
	}
	ObHeader($admin_file.$transtr);
}

include PrintEot($job);
footer(true);
?>