<?php
	$getpass = getSysConfigByKey("get_pass");
	if($getpass=="1"){
		$questions = getSysConfigByKey("pass_question");
		if($questions){
			$arrquestion = explode(",",$questions);
		}
	}

	$certtype = $cfg_affcerttype[$AffUser[cert_type]];
	$sex = $cfg_gender[gender];
	$biztype = $cfg_affbiztype[biz_type];
	include PrintEot($job,'www');
	footer(false);
?>