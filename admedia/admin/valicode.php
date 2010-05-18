<?php
define('CO',"1");
	
require_once('global.php');

//$imgpath = R_P.$cfg_imgpath;

require_once(R_P.'require/lang.php');
require_once(R_P.'require/load.php');
require_once(R_P.'require/util.php');
require_once(R_P.'require/safe.php');

require_once(R_P.'lib/imgcode.class.php');

header('Pragma:no-cache');
header('Cache-control:no-cache');

ob_start();

$imgcode = new PM_ImgCode();
$imgcode->out();

$vccode = $imgcode->code;
Cookie("imgcode",md5($vccode.$_GET['ts']));

ob_end_flush();
exit;

?>