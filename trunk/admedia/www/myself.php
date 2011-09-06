<?php
	$getpass = getSysConfigByKey("get_pass");

	if($action=="editbank"){
		$objAffUser = LOAD::loadDB("Affiliate");
		$db_payinfolist = $objAffUser->getAffPayInfoByAffId($AffUser[id]);
		if($db_payinfolist){
			$db_payinfo = $db_payinfolist[0];
			$op_paymethodlist = loadBaseSortList("bank",$db_payinfo[pay_method]);
		}else{
			$op_paymethodlist = loadBaseSortList("bank");
		}		
	}else if($action=="editquestion"){
		$questions = getSysConfigByKey("pass_question");
		if($questions){
			$arrquestion = explode(",",$questions);
		}
	}else if($action=="save"){
		$objAffUser = LOAD::loadDB("Affiliate");
		$objAffUser->updateAffiliate($AffUser[id],$_POST);
	}else if($action=="saveeditbank"){
		$objAffUser = LOAD::loadDB("Affiliate");
		if(empty($_POST[bank_id]) || strlen($_POST[bank_id])==0){
			$objAffUser->insertAffPayInfo($_POST);
		}else{
			$objAffUser->updateAffPayInfo($_POST[bank_id],$_POST);
		}
		ObHeader($index_file."&action=editbank");
	}else if($action=="saveeditpass"){
		$oldpass = pwdCode($_POST[login_oldpass]);
		if($oldpass!=$AffUser[login_pwd]){
			adminMsg("password_old_notequal");
			exit;
		}else if($_POST[login_pass]!=$_POST[login_repass]){
			adminMsg("password_new_notequal");
			exit;
		}else{
			$_POST[login_srcpwd] = $_POST[login_pwd];
			$_POST[login_pwd]=pwdCode($_POST[login_srcpwd]);
			$objAffUser->updateAffiliate($AffUser[id],$_POST);
		}
		ObHeader($index_file."&action=editpass");
	}else if($action=="saveeditquestion"){
		$objAffUser = LOAD::loadDB("Affiliate");
		$objAffUser->updateAffiliate($AffUser[id],$_POST);
		ObHeader($index_file."&action=editquestion");
	}
	include PrintEot($job,'www');
	footer(false);
?>