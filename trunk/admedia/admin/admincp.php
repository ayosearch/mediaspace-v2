<?php
define('CM',"1");
define('CO',"1");
define('DB',"1");

require_once('global.php');

$imgpath = $cfg_http != 'N' ? $cfg_http:"$cfg_url/$cfg_imgpath";

$jspath = "$cfg_vdir/$cfg_jspath";
$csspath = "$cfg_vdir/$cfg_csspath";
$onlineip = ClientIp();

InitGetPost(array('job','colid','curid','action','curpage','ajax','searchtype','searchkey','ids','transtr'));

$admin_file = $pmServer['PHP_SELF'];
$basename = $admin_file;
if($pmServer['QUERY_STRING'])
	$REQUEST_URI  = $pmServer['PHP_SELF'].'?'.$pmServer['QUERY_STRING'];
else
	$REQUEST_URI  = $pmServer['PHP_SELF'].'?job=enter';

if ($job == 'quit') {
	Cookie('AdminUser','',0);
	ObHeader($admin_file);
}

$CK = array();
$admin_name = '';

if ($_POST['admin_pass'] && $_POST['admin_name']) {
	$admin_name = stripcslashes($_POST['admin_name']);
	//echo $_POST['admin_pass']."<br/>";
	$CK = array($timestamp,$_POST['admin_name'],pwdCode($_POST['admin_pass']),strtoupper($_POST['admin_code']).$_POST['ts']);
	Cookie('AdminUser',encodeDecode(implode("\t",$CK)));	
} else {
	$AdminUser = GetCookie('AdminUser');
	if ($AdminUser) {
		$CK = explode("\t",encodeDecode($AdminUser,'DECODE'));
		$admin_name = stripcslashes($CK[1]);
	}
}

$ckLogin = -2;

if (!empty($CK)) {
	require_once R_P."lib/db_mysql.php";
	$db = new DB($db_host,$db_user,$db_pass,$db_name,$PM,$charset,$pconnect);
	$ckLogin = checkPass($CK);
} else {
	$db = null;
}

if ($ckLogin!=1) {
	if ($_POST['admin_name'] && $_POST['admin_pass']) {		
		$db_adminrecord	= 0;
		$REQUEST_URI	= $admin_file;
		if($ckLogin===0){
			adminMsg('login_vcerror');
		}
		if($ckLogin===-1){
			adminMsg('login_error');
		}
		if($ckLogin===-2){
			adminMsg('login_exception');
		}			
	}else{
		Cookie('AdminUser','',0);
		include PrintEot('login');
		footer(true);
	}
} else {
	if($job=="enter"){
		include PrintEot("enter");
		footer(true);
	}else if($job=="top" || $job=="main" || $job=="intro" || $job=="treemenu"){
		include PrintEot($job);
		footer(true);
	}else{
		$curidx = 0;		
		empty($perpage) && $perpage = 25;
		empty($curpage) && $curpage = 1;		
		$canaudit = true;
		$canadd = true;
		$canedit = true;
		$candel = true;
		$candis = true;
		$transtr = "";
		$backurl = urlencode($basename."?".$pmServer[QUERY_STRING]);
		$admin_file = "$admin_file?job=".$job;
		require_once(C_P.$job.$cfg_pext);
	}
}


function checkPass($CK){
	global $job,$AdminUser;
	if(empty($job)){
		return -3;
	}
	$imgcode = GetCookie('imgcode');
	//echo $imgcode.":".$CK[2];
	if($imgcode==md5($CK[3])){
		if($GLOBALS['db']){
			$objSysUser = LOAD::loadDB("AdminUser");
			$AdminUser = $objSysUser->getSysUserByLogin($CK[1],$CK[2]);
			if($AdminUser){
				return 1;
			}else{
				return -1;
			}
		}
	}else{
		return 0;
	}
	return -2;
}

function ifcheck($var,$out) {
	$GLOBALS[$out.'_Y'] = $GLOBALS[$out.'_N'] = '';
	$GLOBALS[$out.'_'.($var ? 'Y' : 'N')] = 'checked';
}

function checkSelId($selid) {
	if (is_array($selid)) {
		$ret = array();
		foreach ($selid as $key => $value) {
			if (!is_numeric($value)) {
				return false;
			}
			$ret[] = $value;
		}
		return arrayImplode($ret);
	} else {
		return '';
	}
}

function ObHeader($URL) {
	echo '<meta http-equiv="expires" content="0">';
	echo '<meta http-equiv="Pragma" content="no-cache">';
	echo '<meta http-equiv="Cache-Control" content="no-cache">';
	echo "<meta http-equiv='refresh' content='0;url=$URL'>";exit;
}

function ipLimit() {
	global $db_iplimit;
	if ($db_iplimit) {
		global $onlineip;
		$allowip = false;
		$ip_a = explode(',',$db_iplimit);
		foreach ($ip_a as $value) {
			$value = trim($value);
			if ($value && strpos(",$onlineip.",",$value.") !== false) {
				$allowip = true;
				break;
			}
		}
		if(!$allowip) 
			adminMsg('ip_ban');
	}
}
function PostLog($log) {
	foreach ($log as $key => $val) {
		$key = str_replace(array("\n","\r","|"),array('\n','\r','&#124;'),$key);
		if (is_array($val)) {
			$data .= "$key=array(".PostLog($val).")";
		} else {
			$val = str_replace(array("\n","\r","|"),array('\n','\r','&#124;'),$val);
			if ($key == 'password' || $key == 'check_pwd') {
				$data .= "$key=***, ";
			} else {
				$data .= "$key=$val, ";
			}
		}
	}
	return $data;
}
function safeConfirm($code,$t=1) {
	Cookie('imgcode','',0);
	if (!$code || !safeCheck(explode("\t",encodeDecode(GetCookie('imgcode'),'DECODE')),strtoupper($code),'cknum',300)) {
		global $basename,$admin_file;
		if($t) Cookie('AdminUser','',0);
		$basename = $admin_file;
		adminMsg('check_error');
	}
}

function maxmin($id) {
	global $tlistdb;
	$tidmax = $tidmin = 0;
	foreach ($tlistdb as $key => $val) {
		if ($key == $id) {
			$tidmin = $val;
			break;
		}
		$tidmax = $val;
	}
	return array($tidmin,$tidmax);
}

function questcode($question,$customquest,$answer) {
	$question = $question=='-1' ? $customquest : $question;
	return $question ? substr(md5(md5($question).md5($answer)),8,10) : '';
}

function confirm($msg,$inputmsg=null) {
	@extract($GLOBALS,EXTR_SKIP);
	$adminmsg = 0;
	$msg = getLangInfo('lang_msg',$msg);
	include PrintEot('message');
	footer();
}

function getAffName($id){
	$objAffUser = LOAD::loadDB("Affiliate");
	$affuser = $objAffUser->getAffiliate($id);
	if($affuser){
		return $affuser[login_name];
	}
	return "";
}

function getAffWebSite($id){
	$objAffUser = LOAD::loadDB("Affiliate");
	$affwebsite = $objAffUser->getAffWebSite($id);
	return $affwebsite;
}

function getAffPlace($id){
	$objAffUser = LOAD::loadDB("Affiliate");
	$affplace = $objAffUser->getAffAdvPlace($id);
	return $affplace;
}

function getAdvCreative($id){
	$objAdv = LOAD::loadDB("Advertise");
	$affcreative = $objAdv->getAdvCreative($id);
	return $affcreative;
}

function getAdvertise($id){
	$objAdv = LOAD::loadDB("Advertise");
	$adv = $objAdv->getAdvertise($id);
	return $adv;
}

function getAffiliate($id){
	$objAffiliate = LOAD::loadDB("Affiliate");
	$aff = $objAffiliate->getAffiliate($id);
	return $aff;
}

function getMerchant($id){
	$objMerchant = LOAD::loadDB("Merchant");
	$merchant = $objMerchant->getMerchant($id);
	return $merchant;
}

function showSex($sex){
	if($sex=="0"){
		echo "男";
	}
	echo "女";
}

function showPayType($state){
	$str = "支票";
	switch (State){
		case 0: $str = "支票"; break;
		case 1: $str = "现金"; break;
		case 2: $str = "邮政汇款"; break;
		case 3: $str = "电汇"; break;
		case 4: $str = "网上银行"; break;
		case 5: $str = "线上充值"; break;
		default:$str = "支票"; break;
    }
	echo StrR;
}

function showChancePossible($state){
	$str = "0%";
	switch($state){
		case 0: $str = "0%"; break;
		case 1: $str = "50%"; break;
		case 2: $str = "80%"; break;
		case 3: $str = "100%"; break;
		default: $str = "0%"; break;
	}
	echo $str;
}

function showOPName($state){
	$str = "插入";
	switch (State){
		case 0: $str = "插入"; break;
		case 1: $str = "更新"; break;
		case 2: $str = "删除"; break;
		case 3: $str = "浏览"; break;
		default: $str = "插入"; break;
	}
	echo $str;
}

function showRequireType($state){
	$str= "不明确";
	switch ($state){
		case 0: $str = "不明确"; break;
		case 0: $str = "CPC"; break;		
		case 1: $str = "CPM"; break;
		case 2: $str = "CPA"; break;
		default:
			$str = "不明确"; break;
	}
	echo $str;
}

function showBulletinStatus($state){
	$str = "停止";
	switch (State){
		case "0": $str = "<font color=red>未审核</font>"; break;
		case "1": $str = "<font color=blue>已审核</font>"; break;
		case "2": $str = "<font color=green>已发布</font>"; break;
		case "3": $str = "<font color=red>禁止发布</font>"; break;
		default:$str = "停止"; break;
	}
    echo $str;
}

function showUrl($url,$text=null){
	global $imgpath;
	if ($text==null){
		echo"<a href='$url' target=_blank><img src='$imgpath/admin/url.gif' border=0></a>";
	}else{
		echo "<a href='$url'' target=_blank class=NoLine>$text</a>";
	}
    
}

function showDepositUseType($use_type){
	if(intval($use_type)==0){
		echo "充值";
	}
	if(intval($use_type)==1){
		echo "当期扣费";
	}	
}

function showClientType($state){
	$str = "潜在客户";
	switch ($state){
		case "0": $str = "潜在客户"; break;
		case "1": $str = "正常客户"; break;
		case "2": $str = "失效客户"; break;
		default:
		$str = "潜在客户"; break;
	}
	echo iconv('gbk','utf-8',$str);
}

function showAdvAudit($status){
	$strR = "<font color=red>等待审核</font>";
	switch ($state){
		case 0: $strR = "<font color=red>等待审核</font>"; break;
		case 1: $strR = "<font color=blue>审核通过</font>"; break;
		case 2: $strR = "<font color=red>审核未通过</font>"; break;
		default: $strR = "<font color=red>等待审核</font>"; break;
	}
	echo $strR;
}

function showAdvStatus($status){
	$strR = "<font color=red>暂停</font>";
	switch ($state){
		case 0: $strR = "<font color=red>暂停</font>"; break;
		case 1: $strR = "<font color=blue>运营中</font>"; break;
		default: $strR = "<font color=red>暂停</font>"; break;
	}
	echo $strR;
}

function adminRightCheck($key){
	global $rightset;
	return isset($rightset[$key]) && $rightset[$key] == 1;
}

function loadAreaList(&$selarea){
	global $objCommData;
	$op_arealist = "";	
	if(objCommData){
		$db_arealist = $objCommData->getBaseAreaAll();
		$selarea = $db_arealist[0]; 
		foreach($db_arealist as $db_area){
			$op_arealist .= "<option value='".$db_area[name]."'>".$db_area[name]."</option>";		
		}
		unset($db_arealist);
	}
	return $op_arealist;
}

function loadProvinceList(&$selpro,$proId=0){//$selAreaId,
	global $objCommData;	
	//$db_provincelist = $objCommData->getBaseProvinceAllByArea($selAreaId);
	$db_provincelist = $objCommData->getBaseProvinceAll();
	$selpro = $db_provincelist[0];
	$op_provincelist = "";
	foreach($db_provincelist as $db_province){
		if($proId==$db_province[id]){
			$selpro = $db_province;
			$op_provincelist .= "<option value='".$db_province[id]."' selected>".$db_province[name]."</option>";
		}else{
			$op_provincelist .= "<option value='".$db_province[id]."'>".$db_province[name]."</option>";
		}
	}
	unset($db_provincelist);
	return $op_provincelist;
}

function loadCityList($selProvinceId,$cityId=0){
	global $objCommData;	
	$db_citylist = $objCommData->getBaseCityAllByProvince($selProvinceId);
	$op_citylist = "";
	foreach($db_citylist as $db_city){
		if($cityId==$db_city[id]){
			$op_citylist .= "<option value='".$db_city[id]."' selected>".$db_city[name]."</option>";
		}else{
			$op_citylist .= "<option value='".$db_city[id]."'>".$db_city[name]."</option>";
		}
	}
	unset($db_citylist);	
	return $op_citylist;
}

function loadMerchantList($status,$selid=null){
	global $objMerchant;
	$db_merchantlist = $objMerchant->getMerchantAll($status);
	$op_merchantlist = "";
	foreach($db_merchantlist as $db_merchant){
		if($selid==$db_merchant[id]){
			$op_merchantlist .= "<option value='$db_merchant[id]' selected>$db_merchant[short_name]</option>";
		}else{
			$op_merchantlist .= "<option value='$db_merchant[id]'>$db_merchant[short_name]</option>";
		}
	}
	unset($db_merchantlist);
	return $op_merchantlist;
}

function loadMerContractList($status,$selid=null){
	global $objMerchant;
	$db_mercontractlist = $objMerchant->getMerContractAll($status);
	$op_mercontractlist = "";
	foreach($db_mercontractlist as $db_mercontract){
		if($selid==$db_mercontract[id]){
			$op_mercontractlist .= "<option value='$db_mercontract[id]' selected>$db_mercontract[title]</option>";
		}else{
			$op_mercontractlist .= "<option value='$db_mercontract[id]'>$db_mercontract[title]</option>";
		}
	}
	unset($db_mercontractlist,$db_mercontract);
	return $op_mercontractlist;
}

function loadMerChanceList($selid=null){
	global $objMerchant;
	$db_merchancelist = $objMerchant->getMerChanceAll();
	$op_merchancelist = "";
	foreach($db_merchancelist as $db_merchance){
		if($selid==$db_merchance[id]){
			$op_merchantlist .= "<option value='$db_merchance[id]' selected>$db_merchance[title]</option>";
		}else{
			$op_merchantlist .= "<option value='$db_merchance[id]'>$db_merchance[title]</option>";
		}
	}
	unset($db_merchancelist,$db_merchance);
	return $op_merchantlist;
}

function loadAdvertiseList($status,$selid=0){
	global $objAdvertise;
	$db_advlist = $objAdvertise->getAdvertiseStatusList($status);
	$op_advlist = "";
	foreach($db_advlist as $db_adv){
		if($selid==$db_adv[id]){
			$op_advlist .= "<option value='$db_adv[id]' selected>$db_adv[name]</option>";
		}else{
			$op_advlist .= "<option value='$db_adv[id]'>$db_adv[name]</option>";
		}
	}
	unset($db_advlist,$db_adv);
	return $op_advlist;
}

function loadAffSiteList($status,$affid,$selid=0){
	global $objAffiliate;
	$db_sitelist = $objAffiliate->getAffSiteStatusList($affid,$status);
	$op_sitelist = "";
	foreach($db_sitelist as $db_site){
		if($selid==$db_site[id]){
			$op_sitelist .= "<option value='$db_site[id]' selected>$db_site[name]</option>";
		}else{
			$op_sitelist .= "<option value='$db_site[id]'>$db_site[name]</option>";
		}
	}
	unset($db_sitelist,$db_site);
	return $op_sitelist;
}

function loadAdvPagesList($status,$selid=null){
	global $objAdvertise;
	$db_advpagelist = $objAdvertise->getAdvPagesList($status);
	$op_advpagelist = "";
	foreach($db_advpagelist as $db_advpage){
		if($selid==$db_advpage[id]){
			$op_advpagelist .= "<option value='$db_advpage[id]' selected>$db_advpage[name]</option>";
		}else{
			$op_advpagelist .= "<option value='$db_advpage[id]'>$db_advpage[name]</option>";
		}
	}
	unset($db_advpagelist,$db_advpage);
	return $op_advpagelist;
}

function loadBaseSortList($key,$selval=null){
	global $objCommData;
	$db_basesortlist = $objCommData->getBaseSortKeyList($key);
	$op_basesortlist = "";
	foreach($db_basesortlist as $db_basesort){
		if($selval==$db_basesort[val]){
			$op_basesortlist .= "<option value='$db_basesort[val]' selected>$db_basesort[val]</option>";
		}else{
			$op_basesortlist .= "<option value='$db_basesort[val]'>$db_basesort[val]</option>";
		}
	}
	unset($db_basesortlist,$db_basesort);
	return $op_basesortlist;
}

function loadBaseAdvFormat($format=null){
	global $objCommData;
	$db_advformatlist = $objCommData->getBaseAdvFormatAll();
	$op_advformatlist = "";
	foreach($db_advformatlist as $db_advformat){
		if($format==$db_advformat[format]){
			$op_advformatlist .= "<option value='$db_advformat[format]' selected>$db_advformat[format]</option>";
		}else{
			$op_advformatlist .= "<option value='$db_advformat[format]'>$db_advformat[format]</option>";
		}
	}
	unset($db_advformatlist,$db_advformat);
	return $op_advformatlist;
}

function loadBaseAdvSize($adsize=null){
	global $objCommData;
	$db_advsizelist = $objCommData->getBaseAdvSizeAll();
	$op_advsizelist = "";
	foreach($db_advsizelist as $db_advsize){
		if($adsize==$db_advsize[height].'X'.$db_advsize[width]){
			$op_advsizelist .= "<option value='".$db_advsize[height]."X".$db_advsize[width]."' selected>".$db_advsize[height]."X".$db_advsize[width]."</option>";
		}else{
			$op_advsizelist .= "<option value='".$db_advsize[height]."X".$db_advsize[width]."'>".$db_advsize[height]."X".$db_advsize[width]."</option>";
		}
	}
	unset($objCommData,$db_advsizelist,$db_advsize);
	return $op_advsizelist;
}

function showEditButton($curid){
	global $canedit,$admin_file,$curpage,$transtr,$imgpath;
	if($canedit){
		echo "<a href='$admin_file&action=edit&curid=$curid&curpage=$curpage$transtr'><img align='absMiddle' alt='".iconv("gbk","utf-8","查看/编辑")."' border='0' src='$imgpath/admin/view.gif'/></a>";
	}else{
		echo "";
	}
}

function showDisString($curid){
	global $candis,$admin_file,$curid,$curpage,$transtr,$imgpath;
	if ($candis) {
		echo "<a href='$admin_file&action=dis&curid=$curid&curpage=$curpage$transtr'><img align='absMiddle'alt='".iconv("gbk","utf-8","分配权限")."' border='0' src='$imgpath/admin/loginok.gif'/></a>";
	}else{
		echo "";
    }
}

function showDelButton($curid,$del="del"){
	global $candel,$admin_file,$curpage,$transtr,$imgpath,$aff_id,$mer_id,$backurl,$adv_id;
	$url = $admin_file."&action=".$del."&curpage=".$curpage."&curid=".$curid.$transtr;
	if(isset($aff_id)) $url .= "&aff_id=".$aff_id;
	if(isset($mer_id)) $url .= "&mer_id=".$mer_id;	
	if(isset($adv_id)) $url .= "&adv_id=".$adv_id;		
	if(isset($backurl)) $url .= "&backurl=".urlencode($backurl);		
	if($candel){
		echo "<a href=javascript:ConfirmUrlDel('$url','".iconv("gbk","utf-8","此操作不能恢复，确定删除吗？")."');><img align='absMiddle' alt='".iconv("gbk","utf-8","删除")."' border='0' src='$imgpath/admin/del.gif'/></a>";
	}else{
		echo "";
	}
}

function showFile($url){
	global $imgpath;
	$strR = "";
	if (url != ""){
		$strR = "<a href='$url' target=_blank><img src='$imgpath/admin/fujian.jpg' border=0 /></a>";
	}
	echo $strR;	
}

function showLink($strpage,$curid,$text){
	global $curpage,$transtr;
	echo "<a href='$strpage&curid=$curid&$transtr&curpage=$curpage' class=NoLine>$text</a>";
}

function showPageLink($strparam,$strval,$strtext){
	global $admin_file;
	if($_GET[$strparam] == $strval){
		echo "<a href='$admin_file&$strparam=$strval'><b><font color=red>".$strtext."</font></b></a> ";
	}else{
		echo "<a href='$admin_file&$strparam=$strval'>".$strtext."</a> ";
	}
}

function showButton($imgval,$title,$clickurl){
	global $imgpath;
	$iconimgurl = "$imgpath/admin/view.gif";
	if($imgval==1){
		$iconimgurl = "$imgpath/admin/add.gif";
	}
	if($imgval==2){
		$iconimgurl = "$imgpath/admin/del.gif";
	}
	if($imgval==3){
		$iconimgurl = "$imgpath/admin/view.gif";
	}
	if($imgval==4){
		$iconimgurl = "$imgpath/admin/open.gif";
	}
	if($imgval==5){
		$iconimgurl = "$imgpath/admin/stop.gif";
	}
	if($imgval==6){
		$iconimgurl = "$imgpath/admin/url.gif";
	}			
	echo "<img src='$imgpath/admin/bg_line.gif' align='absmiddle'/>&nbsp;<img src='$iconimgurl'/><a href='$clickurl' title='$title' align='absmiddle'>$title</a>";
}

function showPageBreakInfo($currpagecount,$js=null){
	global $admin_file,$action,$imgpath,$curpage,$perpage,$totalpage,$totalnum,$transtr;

	//根据页面总数及所需显示的页面数显示页面的链接
	if ($currpagecount > 0) {
		$pagebreak = "当前：<font color=red>$curpage</font>,<font color=red>$perpage</font>记录/页 共<font color=red>$totalpage</font>页/<font color=red>$totalnum</font>条";
	}
	$perpage = intval($perpage);
	$totalpage = intval($totalpage);
	$totalnum = intval($totalnum);
	if ($curpage <= 0){
		$curpage = 1;
	}else if ($curpage >= $totalpage){
		$curpage = $totalpage;
	}

	if($curpage>1 && $curpage <= $totalpage){
		$pagebreak .= " | ";
	}

	if ($curpage > 1) {
		if($js==null){
			$pagebreak .= "&nbsp;<img src='$imgpath/admin/backhome.gif' width='15' height='16' border='0' align='absmiddle'>&nbsp;<a href='$admin_file&action=$action&curpage=1$transtr'>首页</a>";
		}else{
			$pagebreak .= "&nbsp;<img src='$imgpath/admin/backhome.gif' width='15' height='16' border='0' align='absmiddle'>&nbsp;<a href=javascript:$js('$admin_file&action=$action&curpage=1$transtr');>首页</a>";
		}
	}
	if ($curpage > 1){
		$beforepage = $curpage-1;
		if($js==null){
			$pagebreak .= "&nbsp;<img src='$imgpath/admin/pre.gif' width='13' height='14' border='0' align='absmiddle'>&nbsp;<a href='$admin_file&action=$action&curpage=$beforepage$transtr'>上一页</a>";
		}else{
			$pagebreak .= "&nbsp;<img src='$imgpath/admin/pre.gif' width='13' height='14' border='0' align='absmiddle'>&nbsp;<a href=javascript:$js('$admin_file&action=$action&curpage=$beforepage$transtr');>上一页</a>";
		}
	}

	if ($curpage < $totalpage){
		$nextpage = $curpage + 1;
		if($js==null){
			$pagebreak .= "&nbsp;<img src='$imgpath/admin/next.gif' width='13' height='14' border='0' align='absmiddle'>&nbsp;<a href='$admin_file&action=$action&curpage=$nextpage$transtr'>下一页</a>";
		}else{
			$pagebreak .= "&nbsp;<img src='$imgpath/admin/next.gif' width='13' height='14' border='0' align='absmiddle'>&nbsp;<a href=javascript:$js('$admin_file&action=$action&curpage=$nextpage$transtr');>下一页</a>";
		}
	}
	if ($curpage < $totalpage){
		if($js==null){
			$pagebreak .= "&nbsp;<img src='$imgpath/admin/end.gif' width='15' height='16' border='0' align='absmiddle'>&nbsp;<a href='$admin_file&action=$action&curpage=$totalpage$transtr'>尾页</a>";
		}else{
			$pagebreak .= "&nbsp;<img src='$imgpath/admin/end.gif' width='15' height='16' border='0' align='absmiddle'>&nbsp;<a href=javascript:$js('$admin_file&action=$action&curpage=$totalpage$transtr');>尾页</a>";
		}
	}

	echo iconv("gbk","utf-8",$pagebreak);
}
?>