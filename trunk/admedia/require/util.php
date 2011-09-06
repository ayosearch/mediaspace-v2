<?php
function trimSameTags($str){
	$arrStr = explode(',',$str);
	$tags = "";
	$flag = true;
	for ($i = 0; $i < count($arrStr); $i++){
		$flag = true;
		$tempArr = explode(',',$tags);
		if (count($tempArr) > 0){
			for($j = 0; $j < count($tempArr); $j++){
               if (empty($tempArr[$j])>0 && $arrStr[$i] == $tempArr[$j]){
                  $flag = false;
               }
            }
        }else{
			$flag = true;
        }
        if ($flag==true && !empty($arrStr[$i]) && strlen($arrStr[$i])>0){
        	$pos = strpos(",,".$tags.",",",".$arrStr[$i].",");
        	if(!$pos) $tags .= $arrStr[$i].",";
        }
    }
    $tags = ltrim(rtrim($tags,','),',');
	return $tags;
}

function toChar($mixed,$isint=false,$istrim=false) {
	if (is_array($mixed)) {
		foreach ($mixed as $key => $value) {
			$mixed[$key] = toChar($value,$isint,$istrim);
		}
	} elseif ($isint) {
		$mixed = (int)$mixed;
	} elseif (!is_numeric($mixed) && ($istrim ? $mixed = trim($mixed) : $mixed) && $mixed) {
		$mixed = str_replace(array("\0","%00","\r"),'',$mixed);
		$mixed = preg_replace(
			array('/[\\x00-\\x08\\x0B\\x0C\\x0E-\\x1F]/','/&(?!(#[0-9]+|[a-z]+);)/is'),
			array('','&amp;'),
			$mixed
		);
		$mixed = str_replace(array("%3C",'<'),'&lt;',$mixed);
		$mixed = str_replace(array("%3E",'>'),'&gt;',$mixed);
		$mixed = str_replace(array('"',"'","\t",'  '),array('&quot;','&#39;','    ','&nbsp;&nbsp;'),$mixed);
	}
	return $mixed;
}


function htmlConvert(&$array) {
	if (is_array($array)) {
		foreach ($array as $key => $value) {
			if (!is_array($value)) {
				$array[$key] = htmlspecialchars($value);
			} else {
				HtmlConvert($array[$key]);
			}
		}
	} else {
		$array = htmlspecialchars($array);
	}
}

function ieConvert($msg) {
	if (is_array($msg)) {
		foreach ($msg as $key=>$value) {
			$msg[$key] = ieconvert($value);
		}
	} else {
		$msg = str_replace(array("\t","\r",'  '),array('','','&nbsp; '),$msg);
	}
	return $msg;
}

function delDir($path){
	if (file_exists($path)) {
		if (is_file($path)) {
			P_unlink($path);
		} else {
			$handle = opendir($path);
			while ($file = readdir($handle)) {
				if ($file!='' && !in_array($file,array('.','..'))) {
					if (is_dir("$path/$file")) {
						deldir("$path/$file");
					} else {
						P_unlink("$path/$file");
					}
				}
			}
			closedir($handle);
			rmdir($path);
		}
	}
}

function calculateCredit($creditdb,$upgradeset) {
	$credit = 0;
	foreach ($upgradeset as $key => $val) {
		if ($creditdb[$key] && $val) {
			if ($key == 'rvrc') {
				$creditdb[$key] = round($creditdb[$key]/10,1);
			} elseif ($key == 'onlinetime') {
				$creditdb[$key] = (int)($creditdb[$key]/3600);
			}
			$credit += (int)$creditdb[$key]*$val;
		}
	}
	return (int)$credit;
}

function checkInArray($needle,$haystack) {
	if (!$needle || empty($haystack) || !in_array($needle,$haystack)) {
		return false;
	}
	return true;
}

function utf8_trim($str) {
	$hex = '';
	$len = strlen($str)-1;
	for ($i=$len;$i>=0;$i-=1) {
		$ch = ord($str[$i]);
		$hex .= " $ch";
		if (($ch & 128)==0 || ($ch & 192)==192) {
			return substr($str,0,$i);
		}
	}
	return $str.$hex;
}

/**
 * 过滤数组每个元素值,并进行单引号合并
 *
 * @param array $array 源数组
 * @param boolean $strip 数据是否经过stripslashes处理
 * @return string 合并后字符串
 */
function arrayImplode($array,$strip=true) {
	return implode(',',sqlEscape($array,$strip));
}

function openFile($filename){
	$filedb = explode('<:pm:>',str_replace("\n","\n<:pm:>",readover($filename)));
	$count = count($filedb)-1;
	if ($count > -1 && (!$filedb[$count] || $filedb[$count]=="\r")) {
		unset($filedb[$count]);
	}
	if(empty($filedb)) $filedb[0] = '';
	return $filedb;
}

/**
 * 服务器时间校正后的文件修改时间
 *
 * @param string $file 文件路径
 * @return int 返回修改时间
 */
function fileTime($file) {
	return file_exists($file) ? intval(filemtime($file) + $GLOBALS['db_cvtime']*60) : 0;
}

function readOver($filename,$method='rb'){
	$filename = pathCheck($filename);
	$filedata = '';
	$handle = @fopen($filename,$method);
	if($handle){
		flock($handle,LOCK_SH);
		$filedata = @fread($handle,filesize($filename));
		fclose($handle);
	}
	return $filedata;
}

function writeOver($filename,$data,$method='rb+',$iflock=1,$check=1,$chmod=1){
	$filename = pathCheck($filename,$check);
	touch($filename);
	$handle = fopen($filename,$method);
	if($iflock) flock($handle,LOCK_EX);
	fwrite($handle,$data);
	if($method=='rb+') ftruncate($handle,strlen($data));
	fclose($handle);
	if($chmod) @chmod($filename,0777);
}

function writeAble($pathfile) {
	//fix windows acls bug noizy
	$unlink = false;
	if(substr($pathfile,-1)=='/') $pathfile = substr($pathfile,0,-1);
	if (is_dir($pathfile)) {
		$unlink = true;
		mt_srand((double)microtime()*1000000);
		$pathfile = $pathfile.'/pm_'.uniqid(mt_rand()).'.tmp';
	}
	$fp = @fopen($pathfile,'ab');
	if ($fp===false) return false;
	fclose($fp);
	if ($unlink) @unlink($pathfile);
	return true;
}

//static function
function createFolder($path) {
	if (!is_dir($path)) {
		createFolder(dirname($path));
		@mkdir($path);
		@chmod($path,0777);
		@fclose(@fopen($path.'/index.html','w'));
		@chmod($path.'/index.html',0777);
	}
}

function randStr($lenth) {
	return substr(md5(randNum($lenth)),mt_rand(0,32-$lenth),$lenth);
}

function quotCv($msg){
	return str_replace('"','&quot;',$msg);
}

function __flush($ob=null){
	if (php_sapi_name()!='apache2handler' && php_sapi_name()!='apache2filter') {
		if (outputZip() == 'ob_gzhandler') {
			return;
		}
		if ($ob && ob_get_length()!==false && ob_get_status() && !ObGetMode($GLOBALS['db_obstart'])) {
			@ob_flush();
		}
		flush();
	}
}

function outputZip(){
	static $output_handler = null;
	if ($output_handler === null) {
		if (@ini_get('zlib.output_compression')) {
			$output_handler = 'ob_gzhandler';
		} else {
			$output_handler = @ini_get('output_handler');
		}
	}
	return $output_handler;
}

function randNum($lenth) {
	mt_srand((double)microtime()*1000000);
	$randval = '';
	for ($i = 0; $i<$lenth; $i++) {
		$randval .= mt_rand(0,9);
	}
	return $randval;
}

function Add_S(&$array){
	if (is_array($array)) {
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				Add_S($array[$key]);
			} else {
				$array[$key] = addslashes($value);
			}
		}
	}
}

function encodeDecode($str,$act='ENCODE'){
	if($act != 'ENCODE'){
		$str = base64_decode($str);
	}
	$code = '';
	$key  = substr(md5($GLOBALS['pmServer']['HTTP_USER_AGENT'].$GLOBALS['cfg_hash']),8,18);
	$keylen = strlen($key); $strlen = strlen($str);
	for ($i=0;$i<$strlen;$i++) {
		$k		= $i / $keylen;
		$code  .= $str[$i] ^ $key[$k];
	}
	return ($act!='DECODE' ? base64_encode($code) : $code);
}

function subStrs($content,$length,$add='Y'){
	if (strlen($content)>$length) {
		if ($GLOBALS['cfg_charset']!='utf-8') {
			$retstr = '';
			for ($i=0;$i<$length-2;$i++) {
				$retstr .= ord($content[$i]) > 127 ? $content[$i].$content[++$i] : $content[$i];
			}
			return $retstr.($add=='Y' ? ' ..' : '');
		}
		return utf8_trim(substr($content,0,$length)).($add=='Y' ? ' ..' : '');
	}
	return $content;
}


/**
 * Format a GMT/UTC date/time
 *
 * @param int $timestamp
 * @param string $timeformat
 * @return string
 */
function __getdate($timestamp,$timeformat=null){
	static $format=null,$time=null;
	if (!isset($time)) {
		global $cfg_dateformat,$cfg_timezone,$_dateformat,$_timezone;
		$format = $_dateformat ? $_dateformat : $cfg_dateformat;
		if ($_timezone && $_timezone!='111') {
			$time = $_timezone*3600;
		} elseif ($cfg_timezone && $cfg_timezone!='111') {
			$time = $cfg_timezone*3600;
		} else {
			$time = 0;
		}
	}
	if(empty($timeformat))
		$timeformat = $format;	
	return gmdate($timeformat,$timestamp+$time);
}

function __serialize($array,$ret='',$i=1){
	foreach($array as $k => $v){
		if(is_array($v)){
			$next = $i+1;
			$ret .= "$k\t";
			$ret  = __serialize($v,$ret,$next);
			$ret .= "\n$i\n";
		} else{
			$ret .= "$k\t$v\n$i\n";
		}
	}
	if(substr($ret,-3) == "\n$i\n"){
		$ret = substr($ret,0,-3);
	}
	return $ret;
}

function __unserialize($str,$array=array(),$i=1){
	$str = explode("\n$i\n",$str);
	foreach ($str as $key => $value){
		$k = substr($value,0,strpos($value,"\t"));
		$v = substr($value,strpos($value,"\t")+1);
		if (strpos($v,"\n") !== false){
			$next  = $i+1;
			$array[$k] = __unserialize($v,$array[$k],$next);
		} elseif(strpos($v,"\t") !== false){
			$array[$k] = _array($array[$k],$v);
		} else {
			$array[$k] = $v;
		}
	}
	return $array;
}

function __array($array,$string){
	$k = substr($string,0,strpos($string,"\t"));
	$v = substr($string,strpos($string,"\t")+1);
	if (strpos($v,"\t") !== false){
		$array[$k] = __array($array[$k],$v);
	} else {
		$array[$k] = $v;
	}
	return  $array;
}

function __unlink($filename){
	return @unlink(pathCheck($filename));
}

function __fgets($filename,$value='4096') {
	$getcontent = '';
	if ($handle = @fopen($filename,'rb')) {
		flock($handle,LOCK_SH);
		$getcontent = fread($handle,$value);//fgets调试
		fclose($handle);
	}
	return $getcontent;
}


?>