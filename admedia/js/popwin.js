
function updateCity(obj){
	var pars = "job=affaudit&action=selcity&curid="+obj.value;
	new Ajax.Updater("divCity",'admincp.php', {method: 'get', parameters: pars});
}

function showAffWebsite(curid){
	var url = 'admincp.php?job=affwebsite&action=select&curid='+curid+"&d="+d.getMilliseconds();
    var strClient = OpenWindow(url,530,505,'');
    if(strClient != null){
	    var ClientArray = strClient.replace('***',',').split(',');
	    $("site_name").value = ClientArray[1];
	    $("site_id").value = ClientArray[0];
    }
}

function showAfflist(){
	var url = "admincp.php?job=affauditok&action=select&d="+d.getMilliseconds();
    var strClient = OpenWindow(url,530,505,'');
    if(strClient != null){
	    var ClientArray = strClient.replace('***',',').split(',');
	    $("aff_name").value = ClientArray[1];
	    $("aff_id").value = ClientArray[0];
	    if($("site_id")!=null){
	    	var pars = "job=affsiteaudit&action=selsite&curid="+$("aff_id").value+"&d="+d.getMilliseconds();
	    	new Ajax.Updater("divSite",'admincp.php', {method: 'get', parameters: pars});
	    }
    }
}

function showAffAdPlace(){
	var url = "admincp.php?job=affadplace&action=select&d="+d.getMilliseconds();
    var strClient = OpenWindow(url,530,505,'');
    if(strClient != null){
	    var ClientArray = strClient.replace('***',',').split(',');
	    $("place_name").value = ClientArray[1];
	    $("place_id").value = ClientArray[0];
    }
}

function showAudit(url){
	var selids = checkSelIds();
	if(isEmpty(selids)==true){
	    alert('请选择您需要操作的行！');
	}else{
		url = url+"&d="+d.getMilliseconds();
	    var strClient = OpenWindow(url+"&ids="+selids,530,205,'');//window.open(url+"&ids="+selids,'','');
	    if(strClient != null){
		    window.location.reload();
	    }   
	}
}

function showModelWin(url){
	url = url+"&d="+d.getMilliseconds();	
    var strClient = OpenWindow(url,572,495,'');//window.open(url+"&ids="+selids,'','');
    if(strClient != null){
	    window.location.reload();
    }   
}

function showMsgTpl(){
	var dd= new Date();	
	var url = "$basename?job=sitemsgtpl&action=showdlg&d="+dd.getMilliseconds();
    var retval = window.showModalDialog(url,'','dialogHeight: 490px; dialogWidth: 500px; dialogTop: ' + (screen.availHeight - 250 - 30)/2
                   + 'px; dialogLeft: ' + (screen.availWidth - 490 - 10) / 2 + 'px; edge: Raised; center: Yes; help: Yes; resizable: Yes; '
                   + 'status: Yes;'); 
    if(retval != null){
    	var arrval = retval.split('-');
    	$('title').value = arrval[0];
    	$('content').value = arrval[1];
    }
}

function selAffiliate(affid,affname){
	window.returnValue = affid+'***'+affname;
	window.close();
}

function selMsgtpl(subject,content){
	window.returnValue = subject+"-"+content;
	window.close();
}