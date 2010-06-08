<?php
$cfg_memcache=array('host'=>'127.0.0.1','port'=>11211);
$cfg_name='广告分销平台';
$cfg_http='N';
$cfg_url='/admedia';
$cfg_vdir='/admedia';
$cfg_imgpath="images";
$cfg_csspath="css";
$cfg_jspath="js";
$cfg_pext='.php';
$cfg_dir='.php?';
$cfg_ext='.html';
$cfg_basepath = "/data0/apache/htdocs";
$cfg_upfilepath='/upload/';
$cfg_debug='0';
$cfg_ifopen='0';
$cfg_key='';
$cfg_type='client';
$cfg_urls='';
$cfg_serverurl='';
$cfg_loginurl='admincp.php';
$cfg_loginouturl='admincp.php?action=quit';
$cfg_credit='';
$cfg_regfile='reg.php';
$cfg_charset='utf-8';
$cfg_forcecharset='0';
$cfg_ifjump='1';
$cfg_obstart='9';
$cfg_onlinetime='3600';
$cfg_ipsafemap='';
$cfg_ckpath='/';
$cfg_ckdomain='';
$cfg_siteid='52279fa51733debf967fbe553452c7f6';
$cfg_sitehash='10AFFSBApWWwdSBlsEUwpVCgQPBQUDUFEAAQFQVQMFDQU';
$cfg_hash='*$%1*I*7o6';
$cfg_dateformat='Y-m-d H:i:s';
$cfg_timezone='-8';
$cfg_ftpweb='';
$cfg_userstatus = array("<font color=blue>等待审核</font>","<font color=green>审核通过</font>","<font color=red>审核未通过</font>","<font color=red>进入复审</font>","<font color=black>黑名单</font>");
$cfg_affapplystatus = array("<font color=blue>申请中 </font>","<font color=green>复审中 </font>","<font color=red>申请通过</font>","<font color=red>申请被驳回</font>");
$cfg_gender = array('男','女');
$cfg_affbiztype= array('个人','公司');
$cfg_affcerttype= array('身份证','军官证','护照');
$cfg_newstype = array('系统公告','活动公告','作弊公示','汇款招领 ');
$cfg_helptype = array('常见问题','FAQ');
$cfg_platform = array('aff'=>'站长前台','sys'=>'管理后台');
$cfg_adminstatus = array('停止','开通中');
$cfg_msgstatus = array('未发送','成功','失败');
$cfg_effstatus = array('失败','成功');
$cfg_killdown = array('未修正','<font color=red>已修正</font>');
$cfg_msgset = array('定向','群发');
$cfg_msgsendtype = array('站内消息','邮件提示','手机短信');
$cfg_logsyntype = array('<font color=red>未同步</font>','<font color=green>已同步</font>');
$cfg_yesno = array('<font color=red>否</font>','<font color=green>是</font>');
$cfg_newstatus = array('<font color=red>未发布</font>','<font color=green>已发布</font>','<font color=red>禁止发布</font>');
$cfg_basesort = array('sitetype'=>'站点类型','channeltype'=>'频道类型','clientphase'=>'客户合作阶段','clientsource'=>'客户来源',
'companyscale'=>'企业规模','trade'=>'行业类别','unit'=>'计价单位','bank'=>'支付方式','clientlevel'=>'客户关系级别',
'advtype'=>'广告类型','helpmodule'=>'帮助模块');
$cfg_xforwardip='1';
$cfg_tablelist='';
$cfg_ifsafecv='0';
$cfg_icstyle='8';
$cfg_ictype='1';
$cfg_icsize='90	30	4';
$cfg_sysconfig = array(
	"site_audit"=>"0","adplace_audit"=>"0","low_cpc_price"=>"0","low_cpm_price"=>"0","low_cpa_price"=>"0","low_cpd_price"=>"0",
	"day_low_limit"=>"0","domain_audit"=>"0","aff_reg"=>"0","aff_vcreg"=>"0","get_pass"=>"0","pass_question"=>"",
	"pay_low_price"=>"0","pay_tax"=>"0","pay_manual_fee"=>"0","pay_cycle"=>"1","pay_day"=>"3",
	"cpc_deduct"=>"0","cpm_deduct"=>"0","cpa_deduct"=>"0","cpd_deduct"=>"0","admin_ip_limit"=>"0","admin_ip_list"=>"",
	"smtp_server"=>"","smtp_port"=>"","mail_user"=>"","mail_pass"=>"","sms_url"=>"","sms_mobile"=>"","sms_msg"=>""
);
$cfg_sysrole = array("超级管理员","站长客服","广告编辑(AE)","广告销售","其它");
$cfg_syspaycycle = array("周结","月结","季结");
$cfg_affsource = array("前台注册","后台添加");
$cfg_blackstatus = array("<font color=red>锁定</font>","<font color=green>释放</font>");
$cfg_merclienttype = array("潜在客户","正常客户","失效客户");
$cfg_advpagestatus = array("<font color='red'>停止</font>","<font color='green'>使用中</font>");
$cfg_merchtype = array("不明确","CPC","CPM","CPA","CPD","多种形式");
$cfg_merccpay = array("支票","现金","邮政汇款","电汇","网上银行","线上充值 ");
$cfg_mercctype = array("纸张","传真","电子合同");
$cfg_merccstatus = array("暂停执行","执行中","已到期"); 
$cfg_advfeetype = array("CPC","CPM","CPA","CPD");
$cfg_advstatus = array("<font color='red'>暂停</font>","<font color='green'>运营中</font>");
$cfg_advctitype = array("文字 ","图片","原始代码");
$cfg_advplacestatus = array("<font color='green'>空闲中</font>","<font color='blue'>可定向</font>","<font color='red'>已定向</font>");
$cfg_advselectortype = array("site_type"=>"站长类型","province"=>"省份","domain"=>"域名","keyword"=>"关键字");
$cfg_advselectorfilter = array("选取","过滤");
$cfg_advselectorstatus = array("<font color=red>停止</font>","<font color=green>启用</font>");
$cfg_advbuyaffplace = array("<font color=red>停止</font>","<font color=green>正常投放</font>","<font color=blue>已到期</font>"); 
$cfg_advroletype = array("所有创意随机","选定创意随机","自定义时段");
?>