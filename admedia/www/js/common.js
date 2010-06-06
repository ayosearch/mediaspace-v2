var d = new Date();

function cknum(who) {
	if(isNaN(who.value)){window.status="此处只能输入数字!";who.value="";}
}

function ckall(lid) {
	if(lid.length){
		for(i=0;i<lid.length;i++) lid[i].checked=true;
	}else{
		lid.checked=true;
	}
}

function ckother(lid) {
	if(lid.length){
		for(i=0;i<lid.length;i++){
			if(lid[i].checked){lid[i].checked=false;}else{lid[i].checked=true;}
		}
	}else{
		if(lid.checked){lid.checked=false;}else{lid.checked=true;}
	}
}

//自制ToolTip提示框<a href=xxx.asp hint="提示信息">调用方式</a>
function showPopupText() {
	var obj = event.srcElement;
	MouseX=event.x;
	MouseY=event.y;
	if(obj.hint!=null && obj.hint!=""){
		dypopLayer.innerHTML = obj.hint;
		dypopLayer.style.left=MouseX+12;
		dypopLayer.style.top=MouseY+12+document.body.scrollTop;
		dypopLayer.style.display = "";
	}else{
		dypopLayer.style.display='none';
	}
}
document.write("<div id='dypopLayer' style='position:absolute;z-index:1000;background-color: #F7FAFD;color:#666666; border: 1px #666666 solid;font-size: 12px;padding:2,2,2,2; display:none;'></div>");
document.onmouseover=showPopupText;
//自制windows
function windows(w_url, w_x, w_y, w_scrolls, w_resize){
	var mywindow =window.open(w_url, "mywin", "width="+ w_x +", height="+ w_y +", scrollbars="+ w_scrolls +", resizable="+ w_resize +", statusbars=0")
	mywindow.focus();
}

function ReFresh(Page){
	var pagevalue=document.form.count.value;
	var pageNo = document.form.page.value;
	if(isNaN(parseInt(pageNo)) || parseInt(pageNo)<=0 || parseInt(pageNo)>32767) pageNo=1;
	if(isNaN(parseInt(pagevalue)) || parseInt(pagevalue)<=0 || parseInt(pagevalue)>32767) pagevalue=50;
	var url=Page+"&count="+pagevalue+"&page="+pageNo;
	document.location=url;
}

function okcancel(DelPage){//删除部分
	var check=false;
	if(Object(document.form.ids)!="[object]") return;
	if(isNaN(document.form.ids.length)==true){
		if(document.form.ids.checked==true){
			check = true;
		}
	}else{
		for (i=0;i<document.form.ids.length;i++){
			if (document.form.ids[i].checked == true) {
				check=true;
			}
		}
	}
	if(check==true){
		if(confirm("确定要删除所选项吗?")){
			window.location = DelPage;
			document.form.submit();
		}
	}
}

function allchecked(){//全部选择
	if(Object(document.form.ids)!="[object]") return;
	if($('allSelect').value == "all"){
		if(isNaN(document.form.ids.length)==true){
			document.form.ids.checked = true;
		}else{
			for(var i=0;i<document.form.ids.length;i++){
				document.form.ids[i].checked = true;
			}
		}
		$('allSelect').value = "clear";		
	}else{
		if(isNaN(document.form.ids.length)==true){
			document.form.ids.checked = false;
		}else{
			for(var i=0;i<document.form.ids.length;i++){
				document.form.ids[i].checked = false;
			}
		}
		$('allSelect').value = "all";
	}
}

function openWin(url){
	window.open(url,"tar","width=600px,height=450px,toolbar=no");
}

function ConfirmAlter(url,msg){
	var check=false;
	if(Object(document.form.ids)!="[object]") return;
	if(isNaN(document.form.ids.length)==true){
		if(document.form.ids.checked==true){
			check = true;
		}
	}else{
		for (i=0;i<document.form.ids.length;i++){
			if (document.form.ids[i].checked == true) {
				check=true;
			}
		}
	}
	if(check==true){
		if(confirm(msg)){
			document.form.action=url;
			document.form.submit();
		}
	}
	
}

function ConfirmUrlDel(url,msg){	
	if(confirm(msg)){
		window.location = url;
	}
}

function ConfirmExport(url,msg){	
	if(confirm(msg)){
		window.frames("ifrExport").location = url;
	}
}

function checkSelIds(){
	var check=false;
	var selID = '';
	if(Object(document.form.ids)!="[object]") return;
	if(isNaN(document.form.ids.length)==true){
		if(document.form.ids.checked==true){			
			check = true;
			selID = document.form.ids.value;
		}
	}else{
		for (i=0;i<document.form.ids.length;i++){
			if (document.form.ids[i].checked == true){
				check=true;
			}
		}
	}
	if(check==true){
		for (i=0;i<document.form.ids.length;i++){
		    if (document.form.ids[i].checked == true){
			    selID+=document.form.ids[i].value+',';
		    }
	    }
	}
	return selID;
}

function ConfirmDel(url,msg){
	var selID = checkSelIds();
	if(isEmpty(selID)==false){
		if(confirm(msg)){
			window.location = url+'&ids='+selID;
			//document.form.action=url;
			//document.form.submit();
		}
	}else{
	    alert('请选择您需要操作的行！');
	}
}

function ConfirmOpen(url,str2,height,width,scrollbar){
	var check=false;
	var selID = '';
	if(Object(document.form.ids)!="[object]") return;
	
	if(isNaN(document.form.ids.length)==true){
		if(document.form.ids.checked==true){			
			check = true;
			selID = document.form.ids.value;
		}
	}else{
		for (i=0;i<document.form.ids.length;i++){
			if (document.form.ids[i].checked == true){
				check=true;
			}
		}
	}
	if(check==true){		
		for (i=0;i<document.form.ids.length;i++){
		    if (document.form.ids[i].checked == true)
		    {
			    selID+=document.form.ID[i].value+',';
		    }
	    }
		//window.location = url+'&SelID='+selID;
	    OpenNormalWindow(url+'&SelID='+selID,str2,height,width,scrollbar)
	}else{
	    alert('请选择您需要操作的行！');
	}
}

function Search(url,page,count,ac){
	//if(Object(document.searchFrm.StartTime)=="[object]" && isEmpty(document.searchFrm.StartTime.value)==true && isEmpty(document.searchFrm.EndTime.value)==true){
		//alert("请输入开始日期或结束日期");
		//return;
	//}
	document.searchFrm.action = url+"?action="+ac+"&page="+page+"&count="+count;
	document.searchFrm.submit();
}

function OpenNormalWindow(str1,str2,height,width,scrollbar){
	var str = "scrollbars="+scrollbar+",toolbar=no,resize=no,height=" + height + ",innerHeight=" + height;
	str += ",width=" + width + ",innerWidth=" + width;
	if (window.screen) {
		var ah = screen.availHeight - 30;
		var aw = screen.availWidth - 10;
		var xc = (aw - width) / 2;
		var yc = (ah - height) / 2;
		str += ",left=" + xc + ",screenX=" + xc;
		str += ",top=" + yc + ",screenY=" + yc;
	}
	window.open(str1,str2,str);
}

function OpenWindow(Url,Width,Height,WindowObj){
	var ReturnStr=showModalDialog(Url,WindowObj,'dialogWidth:'+Width+'px;dialogHeight:'+Height+'px; dialogTop: ' + (screen.availHeight - Height - 30) / 2 + 'px;dialogLeft: ' + (screen.availWidth - Width - 10) / 2 + 'px; edge: Raised; center: Yes; help: Yes; resizable: Yes; status: Yes;');
	return ReturnStr;
}

function SwitchTd(obj,itype,num) {
	try{
		var mod = 0;
		if(num%parseInt($('count').value)==0) mod = parseInt($('count').value);
		else mod = num%parseInt($('count').value);				
		if(Object(document.form.ids)=="[object]"){
			if(itype=="click"){
				obj.className='tdalert';
				if(isNaN(document.form.ids.length)==false){
					document.form.ids[mod-1].checked=!document.form.ids[mod-1].checked;
					if(document.form.ids[mod-1].checked==false) obj.className='tablerow';
				}else{
					document.form.ids.checked=!document.form.ids.checked;
					if(document.form.ids.checked==false) obj.className='tablerow';		
				}
			}else if(itype=="over"){
				if(isNaN(document.form.ids.length)==false){
					if(document.form.ids[mod-1].checked==false) obj.className='tablerow';
				}else{
					if(document.form.ids.checked==false) obj.className='tablerow';
				}
			}else if(itype=="out"){
				if(isNaN(document.form.ids.length)==false){
					if(obj.className!='tdalert' && document.form.ids[mod-1].checked==false) obj.className='';
				}else{
					if(obj.className!='tdalert' && document.form.ids.checked==false) obj.className='';
				}
			}
		}
	}
	catch (e) {
	    window.setTimeout("SwitchTd();",500,obj,itype,num);
	}
}



function openAlter(url,msg){
	var check=false;
	var selID = "";
	if(Object(document.form.ID)!="[object]") return;
	
	if(isNaN(document.form.ID.length)==true){
		if(document.form.ID.checked==true)
		{
			check = true;
			selID += document.form.ID.value+",";
		}
	}else{
		for (i=0;i<document.form.ID.length;i++){
			if (document.form.ID[i].checked == true){
				check=true;
				selID += document.form.ID[i].value+",";
			}
		}
	}
	if(check==true){
		if(confirm(msg)){
			//document.form.target="_blank";
			//document.form.action=url;
			
			window.open(url+"&ids="+selID,"tar","width=650px,height=450px,toolbar=no");
			//document.form.submit();
		}
	}
}

function AllWidthCss(page,num){	
	var first = (page-1)*num;
	if($("allref").value=='+'){
		$("allref").value='-';
		for(var i=1; i<=num; i++){
			var intcount = first+i;
			$("b"+intcount+"").value='-';
			$("a"+intcount+"").style.overflow='';
		}
	}else{
		$("allref").value='+';
		for(var j=1; j<=num; j++){
			var intcount1 = first+j;
			//alert("'b"+intcount1+"'");
			$("b"+intcount1+"").value='+';
			$("a"+intcount1+"").style.overflow='hidden';
		}
	}
}

function WidthCss(ea,eb){	
	if($(eb).value=='+'){
		$(eb).value='-';
		$(ea).style.overflow='';
	}else{
		$(eb).value='+';
		$(ea).style.overflow='hidden';
	}
}