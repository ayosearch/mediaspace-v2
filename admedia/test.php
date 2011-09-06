<?php
$testStr = "1,2,2,3,3,3,4,,,,";
echo rtrim($testStr,',')."<br/>";
if(strstr($testStr,"0")){
	echo "--:".substr($testStr,"-");
}
echo "</br/>"; 
echo "imagecreatetruecolor:".function_exists('imagecreatetruecolor');
echo "</br/>"; 
echo "imagecolorallocate:".function_exists('imagecolorallocate');
echo "</br/>"; 
echo "imagepng:".function_exists('imagepng');
echo "</br/>"; 
echo "imagettftext:".function_exists('imagettftext');
echo "</br/>"; 
echo "imagecreatefromjpeg:".function_exists('imagecreatefromjpeg');
echo "</br/>"; 
echo "imagecopymerge:".function_exists('imagecopymerge');
echo "</br/>"; 

$style=8;
$tt = $style & 1;
echo "$style & 1:$tt"."<br/>";

list($usec, $sec) = explode(" ",microtime());

$timestamp = date('y-M-d H:m:s.ss');
$usec = intval($usec*10000);
$chars = md5($usec."sinacn");

echo "<br/>".$chars."<br/>";

$cdate = date('Y/m/d H:i:s',$adv[create_time]);

//$chars = md5(uniqid(mt_rand(), true));

//echo $chars;

?>
<img src="testimg.php"/>