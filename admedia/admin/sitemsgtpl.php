<?php 
include_once('rolecontrol.php');	

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
		$insertid = $objmsg->insertSysMsgtpl($_POST);
		writeSysLog(1, "新增消息模板", $AdminUser[login_name]."消息模板ID:".$insertid.",消息模板内容:".implode(",",$_POST));		
	}else{
		$objmsg->updateSysMsgtpl($curid,$_POST);
		writeSysLog(2, "修改消息模板", $AdminUser[login_name]."消息模板ID:".$curid.",消息模板内容:".implode(",",$_POST));		
	}
	ObHeader($admin_file);	
}

if($action=="del"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
		$objmsg = LOAD::loadDB("Message");
		$objmsg->deleteSysMsgtplBatch($ids);		
		writeSysLog(3, "删除消息模板", $AdminUser[login_name]."消息模板ID:".$ids);
	}else{		
		$objmsg = LOAD::loadDB("Message");
		$objmsg->deleteSysMsgtpl($ids);
		writeSysLog(3, "删除消息设置", $AdminUser[login_name]."消息模板ID:".$ids);
	}
	ObHeader($admin_file.$transtr);
}

include PrintEot($job);
footer(true);
?>