<?php 
include_once('rolecontrol.php');	
InitGetPost(array('audit','all','auditstatus','status',',start_date','end_date','code'));

!empty($audit) && $transtr .= "&audit=$audit";
!empty($status) && $transtr .= "&status=$status";
!empty($start_date) && $transtr .= "&start_date=$start_time";
!empty($end_date) && $transtr .= "&end_date=$end_date";
(!empty($searchtype) && !empty($searchkey)) && $transtr .= "&searchtype=".$searchtype."&searchkey=$searchkey";
		
if($action=="new"){
	$objAdvertise = LOAD::loadDB("Advertise");	
	$op_advlist = loadAdvertiseList(1,"0");
	$objCommData = LOAD::loadDB("CommonData");	
	$op_advformatlist = loadBaseAdvFormat();
	$op_advsizelist = loadBaseAdvSize();
	$op_advpagelist = loadAdvPagesList(1,1);
}else if($action=="edit"){
	$objAdvertise = LOAD::loadDB("Advertise");	
	$db_advcreative = $objAdvertise->getAdvCreative($curid);
	$objCommData = LOAD::loadDB("CommonData");
	$op_advlist = loadAdvertiseList(1,$db_advcreative[adv_id]);
	$op_advformatlist = loadBaseAdvFormat($db_advcreative[adformat]);
	$op_advsizelist = loadBaseAdvSize($db_advcreative[adsize]);
	$op_advpagelist = loadAdvPagesList(1,$db_advcreative[page_id]);	
}else if($action=="save"){
	($_POST[content_type]==0) && $_POST[res_content] = $_POST[txt_word];
	if($_POST[content_type]==1) {
		$filename = $timestamp.$sec.str_replace(".","",$millsec).substr($_FILES['img_file']['name'],strripos($_FILES['img_file']['name'],'.'));
		if(uploadFile($_FILES['img_file']['tmp_name'],$cfg_basepath.$cfg_upfilepath.'creative/'.$filename)){
			$_POST[res_content] = $cfg_upfilepath.'creative/'.$filename;			
		}
	}
	($_POST[content_type]==2) && $_POST[res_content] = $_POST[txt_code];
	$objAdvertise = LOAD::loadDB("Advertise");	
	if(empty($curid)){
		$_POST[create_time] = $timestamp;
		$_POST[update_time] = $timestamp;
		$db_adv = $objAdvertise->getAdvertise($_POST[adv_id]);
		if($db_adv){
			$_POST[mer_id] = $db_adv[mer_id];
			$_POST[creator_id] = $AdminUser[id];
			$_POST[creator_user] = $AdminUser[login_name];
			$objAdvertise->insertAdvCreative($_POST);
			writeSysLog(1, "新增广告创意", $AdminUser[login_name]."新增广告创意:".implode(",",$_POST));
		}
	}else{
		$_POST[update_time] = $timestamp;
		$objAdvertise->updateAdvCreative($curid,$_POST);
		writeSysLog(2, "修改广告创意", $AdminUser[login_name]."修改广告创意:".implode(",",$_POST));		
	}
	ObHeader($admin_file.$transtr);
	unset($objAdvertise);
	exit;
}else if($action=="changestatus"){
	if(strpos($ids,',')>0){
		$ids = substr($ids,0,strlen($ids)-1);
	}	
	$objAdvertise = LOAD::loadDB("Advertise");	
	$objAdvertise->updateAdvCreativeStatus($ids,$auditstatus);
	writeSysLog(4, "审核广告创意", $AdminUser[login_name]."审核广告创意:".$ids.":设置状态为:".$auditstatus);		
	ObHeader($admin_file.$transtr);
	unset($objAdvertise);	
	exit;	
}else if($action=="innercode"){
	$code = str_replace("&lt;","<",$code);
	$code = str_replace("&gt;",">",$code);
	$code = str_replace("\\&quot;",'"',$code);
	include PrintEot("index","wap");
	footer(false);
}else if($action=="viewcode"){
	header("Content-type: text/wml; charset=utf-8");
	$code = str_replace("&lt;","<",$code);
	$code = str_replace("&gt;",">",$code);
	$code = str_replace("\\&quot;",'"',$code);
	echo $code;
	exit;
}else if(empty($action)){
	$stwhere = "";
	(!empty($audit)) && $stwhere .= " audit=".sqlEscape($audit)." and ";	
	(!empty($status)) && $stwhere .= " status=".sqlEscape($status)." and ";		
	(!empty($start_date)) && $stwhere .= " create_time>=".__strtotime($start_date)." and ";	
	(!empty($end_date)) && $stwhere .= " create_time<=".__strtotime($end_date)." and ";		
	if(!empty($searchtype) && !empty($searchkey)) {
		$querykey = "%".$searchkey."%";
		$stwhere .= " $searchtype like ".sqlEscape($querykey)." and ";			
	}
	(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);	
	
	$objAdvertise = LOAD::loadDB("Advertise");
	$totalnum = $objAdvertise->getAdvCreativeTotalCount($stwhere);
	$totalpage = ceil($totalnum/$perpage);
	$db_advcreativelist = $objAdvertise->getAdvCreativePageList($curpage,$perpage,$stwhere,"id");
}

include PrintEot($job);
footer(true);

?>