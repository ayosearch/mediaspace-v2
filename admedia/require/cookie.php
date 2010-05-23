<?php
function Cookie($ck_Var,$ck_Value,$ck_Time='F',$p=true){
	global $cfg_ckpath,$cfg_ckdomain,$timestamp,$pmServer;

	if (!$pmServer['REQUEST_URI'] || ($https = @parse_url($pmServer['REQUEST_URI']))===false) {
		$https = array();
	}
	if ($https['scheme']=='https' || (empty($https['scheme']) && ($pmServer['HTTP_SCHEME']=='https' || $pmServer['HTTPS'] && strtolower($pmServer['HTTPS'])!='off'))) {
		$ck_Secure = true;
	} else {
		$ck_Secure = false;
	}

	if (P_M!='admin') {
		$ckpath = !$cfg_ckpath ? '/' : $cfg_ckpath;
		$ckdomain = $cfg_ckdomain;
	} else {
		$ckpath = '/';
		$ckdomain = '';
	}
	$ck_Httponly = false;
	if ($ck_Var=='AdminUser') {
		$agent = strtolower($pmServer['HTTP_USER_AGENT']);
		if (!($agent && preg_match('/msie ([0-9]\.[0-9]{1,2})/i', $agent) && strstr($agent, 'mac'))) {
			$ck_Httponly = true;
		}
	}

	if(strlen($ck_Value) > 512) $ck_Value = substr($ck_Value,0,512);
	if($p) $ck_Var = cookiePre().'_'.$ck_Var;
	if ($ck_Time=='F') {
		$ck_Time = $timestamp+31536000;
	} elseif ($ck_Value=='' && $ck_Time==0) {
		return setcookie($ck_Var,'',$timestamp-31536000,$ckpath,$ckdomain,$ck_Secure);
	}
	
	if (PHP_VERSION < 5.2) {
		return setcookie($ck_Var,$ck_Value,$ck_Time,$ckpath.($ck_Httponly ? '; HttpOnly' : ''),$ckdomain,$ck_Secure);
	} else {
		$ret = setcookie($ck_Var,$ck_Value,$ck_Time,$ckpath,$ckdomain,$ck_Secure,$ck_Httponly);
		return $ret;
	}
}
function GetCookie($Var){
	$var_cookie = $_COOKIE[cookiePre().'_'.$Var];
	return $var_cookie;
}
function CookiePre(){
	static $pre = null;
	if(!isset($pre)) $pre = substr(md5($GLOBALS['cfg_sitehash']),0,5);
	return $pre;
}
?>