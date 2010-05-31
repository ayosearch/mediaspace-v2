<?php

require_once(R_P.'require/util.php');
require_once(R_P.'require/lang.php');
require_once(R_P.'require/load.php');
require_once(R_P.'require/safe.php');

function ObContents($output){
	ob_end_clean();
	$getHAE = getServer('HTTP_ACCEPT_ENCODING');
	if (!headers_sent() && $GLOBALS['db_obstart'] && $getHAE && N_output_zip()!='ob_gzhandler') {
		$encoding = '';
		if (strpos($getHAE,'x-gzip') !== false) {
			$encoding = 'x-gzip';
		} elseif (strpos($getHAE,'gzip') !== false) {
			$encoding = 'gzip';
		}
		if ($encoding && function_exists('crc32') && function_exists('gzcompress')) {
			header('Content-Encoding: '.$encoding);
			$outputlen  = strlen($output);
			$outputzip  = "\x1f\x8b\x08\x00\x00\x00\x00\x00";
			$outputzip .= substr(gzcompress($output,$GLOBALS['db_obstart']),0,-4);
			$outputzip .= @pack('V',crc32($output));
			$output = $outputzip.@pack('V',$outputlen);
		} else {
			ObStart();
		}
	} else {
		ObStart();
	}
	return $output;
}

function ObStart(){
	ObGetMode() == 1 ? ob_start('ob_gzhandler') : ob_start();
}

function ObGetMode(){
	static $mode = null;
	if ($mode!==null) {
		return $mode;
	}
	$mode = 0;
	if ($GLOBALS['db_obstart'] && function_exists('ob_gzhandler') && outputZip()!='ob_gzhandler' && (!function_exists('ob_get_level') || ob_get_level()<1)) {
		$mode = 1;
	}
	return $mode;
}

/**
 * 删除多余全局变量
 *
 * 多余的全局变量,会对站点安全构成威胁.需要保留的变量在$allowed中说明
 *
 */
function InitGlobals() {
	$allowed = array('GLOBALS'=>1, '_GET'=>1, '_POST'=>1, '_COOKIE'=>1, '_FILES'=>1, '_SERVER'=>1, 'P_S_T'=>1);
	foreach($GLOBALS as $key=>$value) {
		if (!isset($allowed[$key])) {
			$GLOBALS[$key] = null;
			unset($GLOBALS[$key]);
		}
	}
	if (!get_magic_quotes_gpc()) {
		Add_S($_POST);
		Add_S($_GET);
		Add_S($_COOKIE);
	}
	Add_S($_FILES);
	$GLOBALS['pmServer'] = getServer(array('HTTP_REFERER','HTTP_HOST','HTTP_X_FORWARDED_FOR','HTTP_USER_AGENT','HTTP_CLIENT_IP', 'HTTP_SCHEME','HTTPS','PHP_SELF','REQUEST_URI','REQUEST_METHOD','REMOTE_ADDR','QUERY_STRING'));
	if(!$GLOBALS['pmServer']['PHP_SELF'])
		$GLOBALS['pmServer']['PHP_SELF'] = getServer('SCRIPT_NAME');
}

/**
 * 检查错误登录次数
 *
 * @param unknown_type $filename
 * @param unknown_type $offset
 * @return unknown
 */
function ckLogFailurCount($filename,$offset){
	global $onlineip;
	$count=0;
	$fp=@fopen($filename,"rb");
	if($fp){
		flock($fp,LOCK_SH);
		fseek($fp,-$offset,SEEK_END);
		$readb=fread($fp,$offset);
		fclose($fp);
		$readb=trim($readb);
		$readb=explode("\n",$readb);
		$count=count($readb);$count_F=0;
		for($i=$count-1;$i>0;$i--){
			if(strpos($readb[$i],"|Logging Failed|$onlineip|")===false){
				break;
			}
			$count_F++;
		}
	}
	return $count_F;
}

function showMsg($msg,$jumpurl='',$t=2) {
	adminMsg($msg,$jumpurl,$t);
}

function adminMsg($msg,$jumpurl='',$t=2) {
	@extract($GLOBALS,EXTR_SKIP);
	$msg = getLangInfo('msg',$msg);
	if (defined('AJAX')) {
		echo $msg;ajax_footer();
	}
	if ($jumpurl != '') {
		$basename = $jumpurl;
		$ifjump	  = "<meta http-equiv='Refresh' content='$t; url=$jumpurl'>";
	} elseif (!$basename) {
		$basename = $REQUEST_URI;
	}
	if ($cfg_adminrecord == 1 && $basename != 'javascript:history.go(-1);' ) {
		$adminmsg = 2;
	} else {
		$adminmsg = 1;
	}
	include PrintEot('message');
	footer();
}



function pwdCode($pwd){
	return md5($pwd.$GLOBALS['cfg_hash']);
}

function delatt($path,$ifftp) {
	if (strpos($path,'..') !== false) {
		return false;
	}
	if (!file_exists("$GLOBALS[attachdir]/$path")) {
		if (pmFtpNew($GLOBALS['ftp'],$ifftp)) {
			$GLOBALS['ftp']->delete($path);
			$GLOBALS['ftp']->delete('thumb/'.$path);
		}
	} else {
		__unlink("$GLOBALS[attachdir]/$path");
		if (file_exists("$GLOBALS[attachdir]/thumb/$path")) {
			__unlink("$GLOBALS[attachdir]/thumb/$path");
		}
	}
	return true;
}

function getUrl($attachurl,$type = null,$thumb = null) {
	global $attachdir,$attachpath,$cfg_ftpweb,$attach_url;
	if ($thumb) {
		if (file_exists($attachdir.'/thumb/'.$attachurl)) {
			return array($attachpath.'/thumb/'.$attachurl,'Local');
		} elseif (file_exists($attachdir.'/'.$attachurl)) {
			return array($attachpath.'/'.$attachurl,'Local');
		} elseif ($cfg_ftpweb) {
			$attachurl = 'thumb/'.$attachurl;
		}
	}
	if (file_exists($attachdir.'/'.$attachurl)) {
		return array($attachpath.'/'.$attachurl,'Local');
	}
	if ($cfg_ftpweb && !$attach_url || $type == 'lf') {
		return array($cfg_ftpweb.'/'.$attachurl,'Ftp');
	}
	if (!$cfg_ftpweb && !is_array($attach_url)) {
		return array($attach_url.'/'.$attachurl,'att');
	}
	if (!$cfg_ftpweb && count($attach_url) == 1) {
		return array($attach_url[0].'/'.$attachurl,'att');
	}
	if ($type == 'show') {
		return ($cfg_ftpweb || $attach_url) ? 'imgurl' : 'nopic';
	}
	if ($cfg_ftpweb && $fp = @fopen($cfg_ftpweb.'/'.$attachurl,'rb')) {
		@fclose($fp);
		return array($cfg_ftpweb.'/'.$attachurl,'Ftp');
	}
	if (!empty($attach_url)) {
		foreach ($attach_url as $value) {
			if ($value != $cfg_ftpweb && ($fp = @fopen($value.'/'.$attachurl,'rb'))) {
				@fclose($fp);
				return array($value.'/'.$attachurl,'att');
			}
		}
	}
	return false;
}

function __strtotime($time){
	global $cfg_timezone;
	return function_exists('date_default_timezone_set') ? strtotime($time) - $cfg_timezone*3600 : strtotime($time);
}

function dirCheck($dir){
	$dir = str_replace(array("'",'#','=','`','$','%','&',';'),'',$dir);
	return trim(preg_replace('/(\/){2,}|(\\\){1,}/','/',$dir),'/');
}

function varExport($input,$t = null) {
	switch (gettype($input)) {
		case 'string':
			return "'".str_replace(array("\\","'"),array("\\\\","\'"),$input)."'";
		case 'array':
			$output = "array(\r\n";
			foreach ($input as $key => $value) {
				$output .= $t."\t".varExport($key,$t."\t").' => '.varExport($value,$t."\t");
				$output .= ",\r\n";
			}
			$output .= $t.')';
			return $output;
		case 'boolean':
			return $input ? 'true' : 'false';
		case 'NULL':
			return 'NULL';
		case 'integer':
		case 'double':
		case 'float':
			return "'".(string)$input."'";
	 }
	 return 'NULL';
}


/**
 * 针对SQL语句的变量进行反斜线过滤,并两边添加单引号
 *
 * @param mixed $var 过滤前变量
 * @param boolean $strip 数据是否经过stripslashes处理
 * @return mixed 过滤后变量
 */
function sqlEscape($var,$strip = true) {
	if (is_array($var)) {
		foreach ($var as $key => $value) {
			$var[$key] = trim(sqlEscape($value,$strip));
		}
		return $var;
	} elseif (is_numeric($var)) {
		return " '".$var."' ";
	} else {
		return " '".addslashes($strip ? stripslashes($var) : $var)."' ";
	}
}

/**
 * 构造单记录数据更新SQL语句
 *  格式: field='value',field='value'
 *
 * @param array $array 更新的数据,格式: array(field1=>'value1',field2=>'value2',field3=>'value3')
 * @param boolean $strip 数据是否经过stripslashes处理
 * @return string SQL语句
 */
function sqlSingle($array,$strip=true) {
	$array = sqlEscape($array,$strip);
	$str = '';
	foreach ($array as $key => $val) {
		$str .= ($str ? ', ' : ' ').$key.'='.$val;
	}
	return $str;
}
/**
 * 构造批量数据更新SQL语句
 *  格式: ('value1[1]','value1[2]','value1[3]'),('value2[1]','value2[2]','value2[3]')
 *
 * @param array $array 更新的数据,格式: array(array(value1[1],value1[2],value1[3]),array(value2[1],value2[2],value2[3]))
 * @param boolean $strip 数据是否经过stripslashes处理
 * @return string SQL语句
 */
function sqlMulti($array,$strip=true) {
	$str = '';
	foreach ($array as $val) {
		if (!empty($val)) {
			$str .= ($str ? ', ' : ' ') . '(' . arrayImplode($val,$strip) .') ';
		}
	}
	return $str;
}
/**
 * SQL查询中,构造LIMIT语句
 *
 * @param integer $start 开始记录位置
 * @param integer $num 读取记录数目
 * @return string SQL语句
 */
function sqlLimit($start,$num=false) {
	return ' LIMIT '.($start <= 0 ? 0 : (int)$start).($num ? ','.abs($num) : '');
}
function getStatus($status,$b,$getv = 1) {
	return $status >> --$b & $getv;
}

function InitGetPost($keys,$method=null,$cvtype=1){//0=null,1=toChar,2=int
	if(!is_array($keys)) $keys = array($keys);
	foreach ($keys as $key) {
		if ($key == 'GLOBALS') continue;
		$GLOBALS[$key] = NULL;
		if ($method != 'P' && isset($_GET[$key])) {
			$GLOBALS[$key] = $_GET[$key];
		} elseif ($method != 'G' && isset($_POST[$key])) {
			$GLOBALS[$key] = $_POST[$key];
		}
		if (isset($GLOBALS[$key]) && !empty($cvtype) || $cvtype==2) {
			$GLOBALS[$key] = toChar($GLOBALS[$key],$cvtype==2,true);
		}
	}
}
function GetPost($key,$method=null){
	if ($method == 'G' || $method != 'P' && isset($_GET[$key])) {
		return $_GET[$key];
	}
	return $_POST[$key];
}

function __convert($str,$to_encoding,$from_encoding,$ifmb=true) {
	if (strtolower($to_encoding) == strtolower($from_encoding)) {
		return $str;
	}
	if (is_array($str)) {
		foreach ($str as $key=>$value) {
			$str[$key] = pmConvert($value,$to_encoding,$from_encoding,$ifmb);
		}
		return $str;
	} else {
		if (function_exists('mb_convert_encoding') && $ifmb) {
			return mb_convert_encoding($str,$to_encoding,$from_encoding);
		} else {
			static $pmconvert = null;
			if(!$to_encoding) $to_encoding = 'GBK';
			if(!$from_encoding) $from_encoding = 'GBK';
			if (!isset($pmconvert) && !is_object($pmconvert)) {
				require_once(R_P.'wap/chinese.php');
				$pmconvert = new Chinese();
			}
			return $pmconvert->Convert($str,$from_encoding,$to_encoding,!$ifmb);
		}
	}
}

//缓冲区跳转
function ObJumpHeader($URL){
	global $cfg_obstart;

	ob_end_clean();
	if (!$cfg_obstart) {
		ob_start();
		echo "<meta http-equiv='refresh' content='0;url=$URL'>";exit;
	}
	header("Location: $URL");exit;
}

function PrintEot($template,$type='admin',$EXT='html'){
	if(!$template) $template = 'N';
	
	if($type!="admin"){
		//apps template render
		if(!defined('PMERROR')) {
			if (defined('P_M')){
				$temp = modeEot($template,$EXT);
				if ($temp) return $temp;
			}
		}
	}
	if (file_exists(R_P."template/$type/$template.$EXT")) {
		return R_P."template/$type/$template.$EXT";
	} else {
		exit("Can not find $template.$EXT file");
	}
}

function readLog($filename,$offset=1024000) {
	$readb = array();
	$fp = @fopen($filename,"rb");
	if ($fp) {
		flock($fp,LOCK_SH);
		$size = filesize($filename);
		$size > $offset ? fseek($fp,-$offset,SEEK_END): $offset = $size;
		$readb = fread($fp,$offset);
		fclose($fp);
		$readb = str_replace("\n","\n<:wind:>",$readb);
		$readb = explode("<:wind:>",$readb);
		$count = count($readb);
		if ($readb[$count-1] == '' || $readb[$count-1] == "\r") {unset($readb[$count-1]);}
		if (empty($readb)) {$readb[0] = "";}
	}
	return $readb;
}

function footer($unfoot=false){
	static $showafooter;
	global $admin_keyword;
	$showafooter = false;
	if ($unfoot==true) {
		$showafooter = true;
		require PrintEot('footer');
	}

	$output = ob_get_contents();
	$output = str_replace(array('<!--<!--<!---->','<!--<!---->','<!---->','-->','<!--'),'',$output);
	if ($admin_keyword) {
		$output = preg_replace('/('.preg_quote($admin_keyword, '/').')([^">]*<)(?!\/script)/si','<font color="red"><u>\\1</u></font>\\2',$output);
	}
	echo ObContents($output);
	unset($output);
	exit;
}

/**
 * 获取用户的唯一字符串
 */
function userKey($uid,$app=false,$add=false){
	global $cfg_hash;
	return substr(md5($uid.$cfg_hash.($add ? $add : '').($app ? $app : '')),8,18);
}

function getMemberId($nums){
	global $lneed;
	if(!$lneed) $lneed = GAL_LOAD::config('lneed', 'level');
	arsort($lneed); reset($lneed);
	foreach ($lneed as $key => $lowneed) {
		$gid = $key;
		if ($nums >= $lowneed) {
			break;
		}
	}
	return $gid;
}

function isGM($name) {
	global $manager;
	return checkInArray($name,$manager);
}

function getDataCache() {
	global $db_datastore;
	switch (strtolower($db_datastore)) {
		case 'memcache' :
			$_cache = GAL_LOAD::loadClass('Memcache');
			break;
		case 'dbcache' :
			$_cache = GAL_LOAD::loadClass('DBCache');
			break;
		default :
			$_cache = GAL_LOAD::loadClass('DBCache');
			break;
	}
	return $_cache;
}

/**
 * 读取指定的全局环境变量值
 *
 * @param mixed $keys 环境变量名，可数组或单值
 * @return mixed 根据参数个数返回指定环境变量值
 */
function GetServer($keys){
	foreach ((array)$keys as $key) {
		$server[$key] = NULL;
		if (isset($_SERVER[$key])) {
			$server[$key] = str_replace(array('<','>','"',"'",'%3C','%3E','%22','%27','%3c','%3e'),'',$_SERVER[$key]);
		}
	}
	return is_array($keys) ? $server : $server[$keys];
}

function tplGetData($invokename,$title,$loopid=false){
	$tplgetdata = LOAD::loadClass('tplgetdata');
	return $tplgetdata->getData($invokename,$title,$loopid);
}

function encodeUrl($url) {
	global $cfg_hash,$admin_name,$admin_gid;
	$url_a = substr($url,strrpos($url,'?')+1);
	if(substr($url,-1) == '&')
		$url = substr($url,0,-1);
	parse_str($url_a,$url_a);
	$source = '';
	foreach ($url_a as $key => $val) {
		$source .= $key.$val;
	}
	$posthash = substr(md5($source.$admin_name.$admin_gid.$cfg_hash),0,8);
	$url .= "&verify=$posthash";
	return $url;
}

function if_uploaded_file($tmp_name) {
	if (!$tmp_name || $tmp_name == 'none') {
		return false;
	} elseif (function_exists('is_uploaded_file') && !is_uploaded_file($tmp_name) && !is_uploaded_file(str_replace('\\\\', '\\', $tmp_name))) {
		return false;
	} else {
		return true;
	}
}

function showOptionHour($selhour=-1){
	$op_hourlist = "";
	for($i=0;$i<24;$i++){
		if($i<10) $hour = "0".$i;
		else $hour = $i;
		if($selhour==$i)
			$op_hourlist .= "<option value='".$i."' selected>".$hour."</option>";
		else
			$op_hourlist .= "<option value='".$i."'>".$hour."</option>";
	}
	return $op_hourlist;
}

function showOptionSecond($selSecond=-1){
	$op_secondlist = "";
	for($i=0;$i<60;$i++){
		if($i<10) $second = "0".$i;
		else $second = $i;
		if($selSecond==$i)
			$op_secondlist .= "<option value='".$i."' selected>".$second."</option>";
		else
			$op_secondlist .= "<option value='".$i."'>".$second."</option>";
	}
	return $op_secondlist;
}

//上传文件
function uploadFile($tmp_name,$filename) {
	if (strpos($filename,'..') !== false || strpos($filename,'.php.') !== false || eregi("\.php$",$filename)) {
		exit('illegal file type!');
	}
	createFolder(dirname($filename));
	if (function_exists("move_uploaded_file") && @move_uploaded_file($tmp_name,$filename)) {
		@chmod($filename,0777);
		return true;
	} elseif (@copy($tmp_name, $filename)) {
		@chmod($filename,0777);
		return true;
	} elseif (is_readable($tmp_name)) {
		writeOver($filename,readOver($tmp_name));
		if (file_exists($filename)) {
			@chmod($filename,0777);
			return true;
		}
	}
	return false;
}
?>