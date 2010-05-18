<?php

/**
 * 获取客户端IP
 *
 * @return string
 */
function ClientIp() {
	global $pmServer,$cfg_xforwardip;
	if ($cfg_xforwardip) {
		if ($pmServer['HTTP_X_FORWARDED_FOR'] && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/',$pmServer['HTTP_X_FORWARDED_FOR'])) {
			return $pmServer['HTTP_X_FORWARDED_FOR'];
		} elseif ($pmServer['HTTP_CLIENT_IP'] && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/',$pmServer['HTTP_CLIENT_IP'])) {
			return $pmServer['HTTP_CLIENT_IP'];
		} else {
			$cfg_xforwardip = 0;
		}
	}
	if (preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/',$pmServer['REMOTE_ADDR'])) {
		return $pmServer['REMOTE_ADDR'];
	}
	return 'Unknown';
}

/**
 * 分析服务器负载
 *
 * 只针对*unix服务器有效
 *
 * @param int $loadavg 负载最大值
 * @return boolean 是否超过最大负载
 */
function LoadAvg($loadavg) {
	$avgstats = 0;
	if (file_exists('/proc/loadavg')) {
		$fp = @fopen('/proc/loadavg','r');
		if ($fp) {
			$avgdata = @fread($fp,6);
			@fclose($fp);
			list($avgstats) = explode(' ',$avgdata);
		}
	}
	if ($avgstats > $loadavg) {
		return true;
	} else {
		return false;
	}
}

/**
 * CC攻击处理
 *
 * CC攻击会导致服务器负载过大,对相关客户端请求进行处理并日志
 *
 * @param int $cc 服务器负载参数
 * @return void
 */
function DefendCc($cc) {
	global $timestamp,$onlineip,$pmServer,$cfg_xforwardip;
	if ($cc==2 && !empty($pmServer['HTTP_USER_AGENT'])) {
		$useragent = strtolower($pmServer['HTTP_USER_AGENT']);
		if (str_replace(array('spider','google','msn','yodao','yahoo','http:'),'',$useragent)!=$useragent) {
			$cc = 1;
		}
	}
	Cookie('c_stamp',$timestamp,0);
	$c_stamp = getCookie('c_stamp');
	$c_crc32 = substr(md5($c_stamp.$pmServer['HTTP_REFERER']),0,10);
	$c_banedip = readover(D_P.'data/ccbanip.txt');
	if ($c_banedip && $c_ipoffset = strpos("$c_banedip\n","\t$onlineip\n")) {
		$c_ltt = substr($c_banedip,$c_ipoffset-10,10);
		if($c_crc32==$c_ltt)
			exit('Forbidden, Please turn off CC');
		writeover(D_P.'data/ccbanip.txt',str_replace("\n$c_ltt\t$onlineip",'',$c_banedip));
	}
	if (($cfg_xforwardip || $cc==2) && ($timestamp-$c_stamp>3 || $timestamp<$c_stamp)) {
		$c_on = false;
		$c_fp = @fopen(D_P.'data/ccip.txt','rb');
		if ($c_fp) {
			flock($c_fp,LOCK_SH);
			$c_size = 27*800;
			fseek($c_fp,-$c_size,SEEK_END);
			while (!feof($c_fp)) {
				$c_value = explode("\t",fgets($c_fp,29));
				if (trim($c_value[1])==$onlineip && $c_crc32==$c_value[0]) {
					$c_on = true; break;
				}
			}
			fclose($c_fp);
		}
		if ($c_on) {
			echo 'Forbidden, Please Refresh';
			$ccbanip = '';
			if($c_banedip)
				$ccbanip .= implode("\n",array_slice(explode("\n",$c_banedip),-999));
			$ccbanip .= "\n".$c_crc32."\t".$onlineip;
			writeover(D_P.'data/ccbanip.txt',$ccbanip); exit;
		}
		if(@filesize(D_P.'data/ccip.txt')>27*1000)
			P_unlink(D_P.'data/ccip.txt');
			
		writeover(D_P.'data/ccip.txt',"$c_crc32\t$onlineip\n",'ab');
	}
}


function safeCheck($CK,$PwdCode,$var='AdminUser',$expire=1800){
	global $timestamp;
	if ($timestamp-$CK[0]>$expire || $CK[2]!=md5($PwdCode.$CK[0])) {
		Cookie($var,'',0);
		return false;
	}
	$CK[0] = $timestamp;
	$CK[2] = md5($PwdCode.$CK[0]);
	Cookie($var,StrCode(implode("\t",$CK)));
	return true;
}

function pathCheck($filename,$ifcheck=0){
	$tmpname = strtolower($filename);
	$tmparray = array('http://',"\0");
	if($ifcheck) $tmparray[] = '..';
	if (str_replace($tmparray,'',$tmpname)!=$tmpname) {
		exit('Forbidden');
	}
	return $filename;
}

function htmlCheck($url,$tag){
	global $cfg_dir,$cfg_ext;
	$tmppos = strpos($url,'#');
	$add = $tmppos!==false ? substr($url,$tmppos) : '';
	$url = str_replace(
		array('.php?','=','&amp;','&',$add),
		array($cfg_dir,'-','-','-',''),
		$url
	).$cfg_ext.$add;
	return stripslashes($tag).$url.'"';
}

function ipSafe(){
	global $cfg_ipsafemap;
	if ($cfg_ipsafemap) {
		global $onlineip;
		$baniparray = explode(',',$cfg_ipsafemap);
		foreach ($baniparray as $banip) {
			if ($banip && strpos(",$onlineip.",','.trim($banip).'.')!==false) {
				showMsg('ip_safe');
			}
		}
	}
}

function checkOnline($time){
	global $db_onlinetime,$timestamp;
	if ($time+$db_onlinetime*1.5>$timestamp) {
		return true;
	}
	return false;
}


function checkVar(&$var) {
	if (is_array($var)) {
		foreach($var as $key => $value) {
			checkVar($var[$key]);
		}
	} elseif (P_W != 'admincp') {
		$var = str_replace(array('..',')','<','='),array('&#46;&#46;','&#41;','&#60;','&#61;'),$var);
	} elseif (str_replace(array('<iframe','<meta','<script'),'',$var)!=$var) {
		global $basename;
		$basename = 'javascript:history.go(-1);';
		adminMsg('word_error');
	}
}


function formCheck($pre,$url,$add){
	$pre = stripslashes($pre);
	$add = stripslashes($add);
	return "<form{$pre} action=\"".EncodeUrl($url)."&\"{$add}>";
}

function postCheck($verify){
	global $cfg_hash,$admin_name,$admin_gid;
	$source = '';
	foreach ($_GET as $key => $val) {
		if (!in_array($key,array('verify','nowtime'))) {
			$source .= $key.$val;
		}
	}
	if ($verify != substr(md5($source.$admin_name.$admin_gid.$cfg_hash),0,8)) {
		adminMsg('illegal_request');
	}
	return true;
}


?>