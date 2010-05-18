
	function checkfrm(){
		if(isEmpty($("low_cpc_price").value)==true || isInteger($("low_cpc_price").value)==false){
			alert("广告最低单价-CPC不能为空且为数字");
			return false;
		}
		if(isEmpty($("low_cpm_price").value)==true || isInteger($("low_cpm_price").value)==false){
			alert("广告最低单价-CPM不能为空且为数字");
			return false;
		}
		if(isEmpty($("low_cpa_price").value)==true || isInteger($("low_cpa_price").value)==false){
			alert("广告最低单价-CPA不能为空且为数字");
			return false;
		}
		if(isEmpty($("low_cpd_price").value)==true || isInteger($("low_cpd_price").value)==false){
			alert("广告最低单价-CPD不能为空且为数字");
			return false;
		}
		if(isEmpty($("day_low_limit").value)==true || isInteger($("day_low_limit").value)==false){
			alert("最低结算额不能为空且为数字");
			return false;
		}
		if(isEmpty($("pay_tax").value)==true || isInteger($("pay_tax").value)==false){
			alert("税不能为空且为数字");
			return false;
		}
		if(isEmpty($("pay_manual_fee").value)==true || isInteger($("pay_manual_fee").value)==false){
			alert("手续费不能为空且为数字");
			return false;
		}
		$$('input[type="radio"][name="get_pass"]').each(function(node){
			if(node.checked==true && node.value=="1" && isEmpty($("pass_question").value)==true){
				alert("请输入站长密码问题，多个问题请用逗号分隔");
			}
		});
		return false;
		if($("pay_cycle").value=="3"){
			if(isEmpty($("pay_season_day_0").value) || isEmpty($("pay_season_day_1").value) || isEmpty($("pay_season_day_2").value) || isEmpty($("pay_season_day_3").value)){
				alert("季结日期必须输入完整");
				return false;
			}else{
				$("pay_day").value=$("pay_season_day_0").value+","+$("pay_season_day_1").value+","+$("pay_season_day_2").value+","+$("pay_season_day_3").value;
			}
		}
		if(isEmpty($("cpc_deduct").value)==true || isInteger($("cpc_deduct").value)==false){
			alert("CPC默认修正不能为空且为数字");
			return false;
		}
		if(isEmpty($("cpm_deduct").value)==true || isInteger($("cpm_deduct").value)==false){
			alert("CPM默认修正不能为空且为数字");
			return false;
		}
		if(isEmpty($("cpa_deduct").value)==true || isInteger($("cpa_deduct").value)==false){
			alert("CPA默认修正不能为空且为数字");
			return false;
		}
		if(isEmpty($("cpd_deduct").value)==true || isInteger($("cpd_deduct").value)==false){
			alert("CPD默认修正不能为空且为数字");
			return false;
		}
		if($("admin_ip_limit").value=="1" && isEmpty($("admin_ip_list").value)==true){
			alert("请输入管理后台允许登陆IP列表");
			return false;
		}						
		return false;								
	}
	function showIpLimit(val){
		if(val==1){
			$("tdIpList").style.display="block";
		}else{
			$("tdIpList").style.display="none";
		}
	}
	function showPayDate(val){
		for(var i=1;i<=3;i++){
			if(i==val){
				$("tdPayDate"+i).style.display="block";
			}else{
				$("tdPayDate"+i).style.display="none";
			}
		}
	}
	function showPassQuestion(val){
		if(val==1){
			$("tdPassQuestion").style.display="block";
		}else{
			$("tdPassQuestion").style.display="none";
		}
		$("get_pass").value=""+val;
	}

