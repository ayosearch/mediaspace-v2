<?php
define('CM',"1");
define('CO',"1");
define('DB',"1");

require_once('global.php');

$imgpath = $cfg_http != 'N' ? $cfg_http:"$cfg_url/$cfg_imgpath";

$jspath = "$cfg_vdir/$cfg_jspath";
$csspath = "$cfg_vdir/$cfg_csspath";
$onlineip = ClientIp();

InitGetPost(array('job','action','curpage','perpage','curid','ids','all','searchkey','transtr'));

$index_file = $pmServer['PHP_SELF'];
$basename = $index_file;
if($pmServer['QUERY_STRING'])
	$REQUEST_URI  = $pmServer['PHP_SELF'].'?'.$pmServer['QUERY_STRING'];
else
	$REQUEST_URI  = $pmServer['PHP_SELF'].'?job=enter';

if ($job == 'exit') {
	Cookie('AffUser','',0);
	ObHeader($index_file);
}

if ($job == 'regedit') {
	Cookie('AffUser','',0);
	require_once (C_P.$job.$cfg_pext);
	footer(false);
}

$CK = array();
$aff_name = '';

if ($_POST['aff_pass'] && $_POST['aff_name']) {
	$aff_name = stripcslashes($_POST['aff_name']);
	$CK = array($timestamp,$_POST['aff_name'],pwdCode($_POST['aff_pass']),strtoupper($_POST['aff_code']).$_POST['ts']);
	Cookie('AffUser',encodeDecode(implode("\t",$CK)));	
} else {
	$AffUser = GetCookie('AffUser');
	if ($AffUser) {
		$CK = explode("\t",encodeDecode($AffUser,'DECODE'));
		$aff_name = stripcslashes($CK[1]);
	}
}

$ckLogin = -2;

if (!empty($CK)) {
	require_once R_P."lib/db_mysql.php";
	$db = new DB($db_host,$db_user,$db_pass,$db_name,$PM,$charset,$pconnect);
	$memcache = LOAD::loadClass("Memcache",null);
	require_once R_P."require/service.php";	
	$ckLogin = checkPass($CK);
} else {
	$db = null;
}

if ($ckLogin!=1) {
	if ($_POST['aff_name'] && $_POST['aff_pass']) {		
		$db_affrecord	= 0;
		$REQUEST_URI	= $index_file;
		if($ckLogin===0){
			showMsg('aff_login_vcerror');
		}
		if($ckLogin===-1){
			showMsg('aff_login_error');
		}
		if($ckLogin===-2){
			showMsg('aff_login_exception');
		}			
	}else{
		if(!isset($job) || empty($job)){
			Cookie('AffUser','',0);
			include PrintEot('login','www');
		}else{
			if($AffUser)  require_once(C_P.$job.$cfg_pext);
			else{
				Cookie('AffUser','',0);
				showMsg('aff_login_expire');
			}
		}
	}
} else {
	if($job=="enter"){
		include PrintEot("enter","www");
		footer(false);
	}else if($job=="head" || $job=="switch"){
		include PrintEot($job,"www");
		footer(false);
	}else{
		$curidx = 0;		
		empty($perpage) && $perpage = 10;
		empty($curpage) && $curpage = 1;		
		$backurl = urlencode($basename."?".$pmServer[QUERY_STRING]);
		$index_file = "$index_file?job=".$job;
		//echo C_P.$job.$cfg_pext;
		require_once(C_P.$job.$cfg_pext);
	}
}

function checkPass($CK){
	global $job,$AffUser;
	if(empty($job)){
		return -3;
	}
	$imgcode = GetCookie('aff_imgcode');
	if($imgcode==md5($CK[3])){
		if($GLOBALS['db']){
			$objaffuser = LOAD::loadDB("Affiliate");
			$AffUser = $objaffuser->getAffiliateByLogin($CK[1],$CK[2]);
			if($AffUser){
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

function loadBaseSortList($key,$selval=null){
	$db_basesortlist = getBaseSortListByKey($key);
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

function loadBaseAdvSize($adsize=null){
	$db_advsizelist = getBaseAdvSizeAll();
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

function getAffAdvApplyStatus($affid,$advid){
	global $objAffiliate;
	if(!$objAffiliate) $objAffiliate=LOAD::loadDB("Affiliate");
	$db_affadvapply = $objAffiliate->getAffAdvApplyByAffId($affid,$advid);
	if($db_affadvapply) return $db_affadvapply[status];
	else return -1;
}

function showPageLink($strparam,$strval,$strtext){
	global $index_file;
	if($_GET[$strparam] == $strval){
		echo "<a href='$index_file&$strparam=$strval'><b><font color=red>".$strtext."</font></b></a> ";
	}else{
		echo "<a href='$index_file&$strparam=$strval'>".$strtext."</a> ";
	}
}

function showPageBreakInfo($currpagecount,$js=null){
	global $index_file,$action,$curpage,$perpage,$totalpage,$totalnum,$transtr;

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
			$pagebreak .= "&nbsp;<img src='/www/img/backhome.gif' width='15' height='16' border='0' align='absmiddle'>&nbsp;<a href='$index_file&action=$action&curpage=1$transtr'>首页</a>";
		}else{
			$pagebreak .= "&nbsp;<img src='/www/img/backhome.gif' width='15' height='16' border='0' align='absmiddle'>&nbsp;<a href=javascript:$js('$index_file&action=$action&curpage=1$transtr');>首页</a>";
		}
	}
	if ($curpage > 1){
		$beforepage = $curpage-1;
		if($js==null){
			$pagebreak .= "&nbsp;<img src='/www/img/pre.gif' width='13' height='14' border='0' align='absmiddle'>&nbsp;<a href='$index_file&action=$action&curpage=$beforepage$transtr'>上一页</a>";
		}else{
			$pagebreak .= "&nbsp;<img src='/www/img/pre.gif' width='13' height='14' border='0' align='absmiddle'>&nbsp;<a href=javascript:$js('$index_file&action=$action&curpage=$beforepage$transtr');>上一页</a>";
		}
	}

	if ($curpage < $totalpage){
		$nextpage = $curpage + 1;
		if($js==null){
			$pagebreak .= "&nbsp;<img src='/www/img/next.gif' width='13' height='14' border='0' align='absmiddle'>&nbsp;<a href='$index_file&action=$action&curpage=$nextpage$transtr'>下一页</a>";
		}else{
			$pagebreak .= "&nbsp;<img src='/www/img/next.gif' width='13' height='14' border='0' align='absmiddle'>&nbsp;<a href=javascript:$js('$index_file&action=$action&curpage=$nextpage$transtr');>下一页</a>";
		}
	}
	if ($curpage < $totalpage){
		if($js==null){
			$pagebreak .= "&nbsp;<img src='/www/img/end.gif' width='15' height='16' border='0' align='absmiddle'>&nbsp;<a href='$index_file&action=$action&curpage=$totalpage$transtr'>尾页</a>";
		}else{
			$pagebreak .= "&nbsp;<img src='/www/img/end.gif' width='15' height='16' border='0' align='absmiddle'>&nbsp;<a href=javascript:$js('$index_file&action=$action&curpage=$totalpage$transtr');>尾页</a>";
		}
	}

	echo $pagebreak;
}
?>