<?php
require_once R_P."lib/db_mysql.php";
$db = new DB($db_host,$db_user,$db_pass,$db_name,$PM,$charset,$pconnect);
$memcache = LOAD::loadClass("Memcache",null);
require_once R_P."require/service.php";	

if(!isset($action) || empty($action)){
	$getpass = getSysConfigByKey("get_pass");
	if($getpass=="1"){
		$questions = getSysConfigByKey("pass_question");
		if($questions){
			$arrquestion = explode(",",$questions);
		}
	}
	include PrintEot($job,'www');
	footer(false);
}else if($action=="save"){
	$objAffUser = LOAD::loadDB("Affiliate");
	$_POST[login_srcpwd] = $_POST[login_pass];
	$_POST[login_pwd]=pwdCode($_POST[login_pass]);
	$_POST[source] = "0";
	if($objAffUser->checkAffiliate($_POST[login_name])){
		$_POST[create_time]=$timestamp;
		$affvcreg = getSysConfigByKey("aff_vcreg");
		$_POST[is_active]=1;//默认手工审核
		$_POST[status]=0;					
		if(strlen($affvcreg)>0){
			if($affvcreg=="1"){//发送邮件
				$_POST[is_active]=0;
				$_POST[status]=0;	
			}
			if($affvcreg=="2"){//自动通过
				$_POST[is_active]=1;
				$_POST[status]=1;
			}			
		}
		$uid = $objAffUser->insertAffiliate($_POST);
		if(strlen($affvcreg)>0){
			if($affvcreg=="1"){//发送邮件
				$_POST[is_active]=0;
				$_POST[status]=0;	
				$to = $_POST[email];
				$from = getSysConfigByKey("pass_question");
				$code = pwdCode($uid.$_POST[mail_user]);
				$subject = "新浪无线广告系统-注册验证"; 
				$msg = "请点击或复制以下连接进行注册验证：<br/><a hrer='http://localhst/admedia/www/valiuser.php?uid=".$uid."&name=".$_POST[login_name]."&code=".$code."'>http://localhst/admedia/www/valiuser.php?uid=".$uid."&name=".$_POST[login_name]."&code=".$code."</a>"; 
				$headers = "From: ".$from."\nReply-To: ".$from; 
				$config = "-f".$from; 
				mail("$to", "$subject", "$msg", "$headers", "$config"); 
				$basename = "index.php";
				adminMsg("reg_mail_sended");
				exit;
			}
			if($affvcreg=="2"){//自动通过
				$basename = "index.php";
				adminMsg("reg_success");
				exit;
			}
			$basename = "index.php";
			adminMsg("reg_syscheck");
			exit;
		}
	}else{
		$basename = $GLOBALS['pmServer']['HTTP_REFERER'];	
		adminMsg("username_exists");
		exit;
	}		
}
?>