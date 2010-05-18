<?php

error_reporting(E_ERROR | E_PARSE);
set_magic_quotes_runtime(0);

define('S_P',getdirname(__FILE__));
define('P_M','global');
define('P_C','global');

$t_array = explode(' ',microtime());
$P_S_T	 = $t_array[0] + $t_array[1];
require_once(S_P.'require/common.php');
pmInitGlobals();

require_once(S_P.'require/config.php');
$timestamp = time();

$imgpath = $cfg_http != 'N' ? $cfg_http:"$cfg_url/$cfg_imgpath/".P_M;

$onlineip = pmGetIp();

if ($cfg_dir && $cfg_ext) {
	$_ARRGET = array();
	$self_array = explode('-',substr($pmServer['QUERY_STRING'],0,strpos($pmServer['QUERY_STRING'],$cfg_ext)));
	$s_count = count($self_array);
	for ($i=0;$i<$s_count-1;$i++) {
		$_key	= $self_array[$i];
		$_value	= rawurldecode($self_array[++$i]);
		$_ARRGET[$_key] = addslashes($_value);
	}
	if(!empty($$_ARRGET)) $_GET = $_ARRGET;
	unset($_ARRGET);
}

foreach ($_GET as $_key => $_value) {
	checkVar($_GET[$_key]);
}

if($cfg_debug)
	error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);

$dirstrpos = strpos($pmServer['PHP_SELF'],$cfg_dir);

if ($dirstrpos !== false) {
	$tmp = substr($pmServer['PHP_SELF'],0,$dirstrpos);
	$pmServer['PHP_SELF'] = "$tmp.php";
} else {
	$tmp = $pmServer['PHP_SELF'];
}
$REQUEST_URI = $pmServer['PHP_SELF'].($pmServer['QUERY_STRING'] ? '?'.$pmServer['QUERY_STRING'] : '');

$R_url = $v_siteurl = Char_cv("http://".$pmServer['HTTP_HOST'].substr($tmp,0,strrpos($tmp,'/')));

if (GetCookie('lastvisit')) {
	list($c_oltime,$lastvisit,$lastpath) = explode("\t",GetCookie('lastvisit'));
	$onbbstime=$timestamp-$lastvisit;
	if($onbbstime<$cfg_onlinetime){
		$c_oltime+=$onbbstime;
	}
} else {
	$lastvisit = $lastpath = '';
	$c_oltime = $onbbstime = 0;
	Cookie('lastvisit',$c_oltime."\t".$timestamp."\t".$REQUEST_URI);
}
$db = $ftp = $credit = null;

require_once(S_P.'require/dbconfig.php');

$loginhash = getVerify($onlineip,$cfg_key);

if ($cfg_ifopen && $cfg_type == 'client') {
	if (strpos($cfg_loginurl,'?') === false) {
		$cfg_loginurl .= '?';
	} elseif (substr($cfg_loginurl,-1) != '&') {
		$cfg_loginurl .= '&';
	}
	if (strpos($v_pptregurl,'?') === false) {
		$cfg_regurl .= '?';
	} elseif (substr($v_pptregurl,-1) != '&') {
		$cfg_regurl .= '&';
	}
	$urlencode	= rawurlencode($cfg_url);
	$loginurl	= "$cfg_serverurl/{$cfg_loginurl}forward=$urlencode";
	$loginouturl= "$cfg_serverurl/$cfg_loginouturl&forward=$urlencode&verify=$loginhash";
	$regurl		= "$cfg_serverurl/{$cfg_regurl}forward=$urlencode";
} else {
	$loginurl	= 'login.php';
	$loginouturl= "login.php?action=quit&verify=$loginhash";
	$regurl		= $cfg_regfile;
}

ipSafe();

unset($cfg_ipmap,$db_host,$db_user,$db_pass,$db_name,$pconnect);

function refreshTo($URL,$content,$statime=1,$forcejump=false){
	if (defined('AJAX')) showMsg($content);
	global $cfg_ifjump;

	if ($forcejump || ($cfg_ifjump && $statime>0)) {
		ob_end_clean();
		global $expires,$cfg_charset,$tplpath,$fid,$imgpath,$cfg_obstart,$cfg_name,$B_url,$forumname,$tpctitle,$cfg_url;
		$index_name =& $cfg_name;
		$index_url =& $B_url;
		ObStart();//noizy
		extract(L::style());

		$content = getLangInfo('refreshTo',$content);
		@require PrintEot('refreshTo');
		$output = str_replace(array('<!--<!---->','<!---->',"\r\n\r\n"),'',ob_get_contents());
		echo ObContents($output);exit;
	} else {
		ObHeader($URL);
	}
}



function adminCheck($forumadmin,$fupadmin,$username){
	if (!$username) {
		return false;
	}
	if ($forumadmin && strpos($forumadmin,",$username,")!==false) {
		return true;
	}
	if ($fupadmin && strpos($fupadmin,",$username,")!==false) {
		return true;
	}
	return false;
}

function allowcheck($allowgroup,$groupid,$groups,$fid='',$allowmodule=''){
	if ($allowgroup && strpos($allowgroup,",$groupid,")!==false) {
		return true;
	}
	if ($allowgroup && $groups) {
		$groupids = explode(',',substr($groups,1,-1));
		foreach ($groupids as $value) {
			if (strpos($allowgroup,",$value,")!==false) {
				return true;
			}
		}
	}
	if ($fid && $allowmodule && strpos(",$allowmodule,",",$fid,")!==false) {
		return true;
	}
	return false;
}

function getVerify($str) {
	global $cfg_siteid;
	if(!$cfg_siteid) $cfg_siteid=$GLOBALS['cfg_siteid'];
	return substr(md5($str.$cfg_siteid.$GLOBALS['pwServer']['HTTP_USER_AGENT']),8,8);
}

function checkPost($verify = 1,$gdcheck = 0,$qcheck = 0,$refer = 1) {
	global $pmServer;
	if($verify) checkVerify();
	if ($refer && $pmServer['REQUEST_METHOD'] == 'POST') {
		$referer_a = @parse_url($pmServer['HTTP_REFERER']);
		if ($referer_a['host']) {
			list($http_host) = explode(':',$pmServer['HTTP_HOST']);
			if ($referer_a['host'] != $http_host) {
				Showmsg('undefined_action');
			}
		}
	}
	if($gdcheck) gdConfirm($_POST['gdcode']);
	if($qcheck) qCheck($_POST['qanswer'],$_POST['qkey']);
}

function checkVerify($hash = 'verifyhash') {
	if(getGP('verify') <> $GLOBALS[$hash])
		showMsg('illegal_request');
}
function gdConfirm($code) {
	cookie('cknum','',0);
	if (!$code || !safeCheck(explode("\t",StrCode(GetCookie('cknum'),'DECODE')),strtoupper($code),'cknum',1800)) {
		showMsg('check_error');
	}
}
function qCheck($answer,$qkey) {
	global $db_question,$db_answer;
	if ($db_question && (!isset($db_answer[$qkey]) || $answer!=$db_answer[$qkey])) {
		Showmsg('qcheck_error');
	}
}

function setstatus(&$status,$b,$setv = '1') {
	--$b;
	for ($i = strlen($setv)-1; $i >= 0 ; $i--) {
		if ($setv[$i]) {
			$status |= 1 << $b;
		} else {
			$status &= ~(1 << $b);
		}
		++$b;
	}
	//return $status;
}
function sendHeader($num,$rtarr=null){
	static $sapi = null;
	if ($sapi===null) {
		$sapi = php_sapi_name();
	}
	$header_a = array(
		'200' => 'OK',
		'206' => 'Partial Content',
		'304' => 'Not Modified',
		'404' => '404 Not Found',
		'416' => 'Requested Range Not Satisfiable',
	);
	if ($header_a[$num]) {
		if ($sapi=='cgi' || $sapi=='cgi-fcgi') {
			$headermsg = "Status: $num ".$header_a[$num];
		} else {
			$headermsg = "HTTP/1.1: $num ".$header_a[$num];
		}
		if (empty($rtarr)) {
			header($headermsg);
		} else {
			return $headermsg;
		}
	}
	return '';
}
?>