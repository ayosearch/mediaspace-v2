/*************** 自定义公用函数 ********************************/
function popDataOper(url,pwidth,pheight) {
	popw = window.open(url,'popDataOper','width='+pwidth+',height='+pheight+',top=50,left=50,directories=0,location=0,menubar=0,scrollbars=0,toolbar=0,resizeable=0');
	popw.focus();
}

function popDataOper1(url,pwidth,pheight) {
	popw = window.open(url,'popDataOper1','width='+pwidth+',height='+pheight+',top=50,left=50,directories=0,location=0,menubar=0,scrollbars=0,toolbar=0,resizeable=0');
	popw.focus();
}

function popDataOper2(url,pwidth,pheight) {
	popw = window.open(url,'popDataOper2','width='+pwidth+',height='+pheight+',top=50,left=50,directories=0,location=0,menubar=0,scrollbars=0,toolbar=0,resizeable=0');
	popw.focus();
}

function popDetail(url,pwidth,pheight) {
	popw = window.open(url,'popDetail','width='+pwidth+',height='+pheight+',top=50,left=50,directories=0,location=0,menubar=0,scrollbars=1,toolbar=0,resizeable=yes');
	popw.focus();
}

function clickTopMenu(leftUrl,mainUrl) {
	parent.frames["leftFrame"].location.href = leftUrl;
	parent.frames["mainFrame"].location.href = mainUrl;
}

function refreshPage() {
	location.reload(true);
}

function goToUrl(url,pwidth,pheight) {
	window.resizeTo(pwidth,pheight);
	document.location.href = url;
}

function popPrint(url,pwidth,pheight) {
 popw = window.open(url,'popPrint','width='+pwidth+',height='+pheight+',top=50,left=50,directories=0,location=0,menubar=0,scrollbars=1,toolbar=0,resizeable=1');
 popw.focus();
}

function browse_goToPage(url,page) {
	zyform.page.value = page;
	zyform.action = url;
	zyform.submit();
}


function browse_pointPage(url) {
	var ppage = prompt("请输入页数:","");
	if (ppage != null && ppage != '') {
		if (isInteger(ppage)) {
			zyform.page.value = ppage;
			zyform.action = url;
			zyform.submit();
		}
		else alert("请输入有效的数字!");
	}
}

function doDel(url,formObj) {
	if (confirm("确实要删除吗?")) {
		formObj.action = url;
		formObj.submit();
	}
}

function doDel(url) {
	if (confirm("确实要删除吗?")) {
		location.href = url;
	}
	else return false;
}


function doUpdate(url,formObj) {
	formObj.action = url;
	formObj.submit();
}

function browse_doOrder(url,field) {
	zyform.orderfield.value = field;
	if (isEmpty(zyform.order.value)) zyform.order.value = "1";
	else {
		if (zyform.order.value=="1") zyform.order.value = "0";
		else zyform.order.value = "1";
	}
	zyform.action = url;
	zyform.submit();
}

function selectDoc(url,docids) {
	window.showModalDialog(url+"?docIDs="+docids,window,'dialogHeight:400px;dialogWidth:600px;center:yes');	
//	window.open(url+"?docIDs="+docids,'','')
}

function popSelect(url,selectedIds) {
	window.showModalDialog(url+"?selectedids="+selectedIds,window,'dialogHeight:400px;dialogWidth:600px;center:yes');	
//	window.open(url+"?selectedids="+selectedIds,'','');	
//	window.open(url+"?docIDs="+docids,'','')
}

function popModalDialog(url,param,width,height) {
	return window.showModalDialog(url,param,'dialogHeight:'+height+'px;dialogWidth:'+width+'px;center:yes');	
}


function popQuery(queryDialogUrl,param,width,height,listUrl) {
	var rev = popModalDialog(queryDialogUrl,param,width,height);
	if (rev.length>0) {
		zyform.querycon.value = rev;
		zyform.action = listUrl;
		zyform.submit();
	}
}
/*
 * 接收选择的文件
 */
function recSelectDoc(docId,docInfo) {
	zyform.fileIDs.value = docId;
	var ops = zyform.fileList.options;
	while (ops.length>0) ops.remove(0);
	for(i=0;i<docInfo.length;i++) {
		var op = document.createElement ("OPTION");
		op.text = docInfo[i];
		ops.add(op);
	}
}


function recSelection(selectedIds,info) {
	zyform.selectedids.value = selectedIds;
	var ops = zyform.selectedlist.options;
	while (ops.length>0) ops.remove(0);
	for(i=0;i<info.length;i++) {
		var op = document.createElement ("OPTION");
		op.text = info[i];
		ops.add(op);
	}
}


function query(url,conStr) {
  zyform.querycon.value = conStr;
  zyform.action = url;
  zyform.submit();
}

function correctStr(value) {
	var result = "";
	result = value;
	while (result.indexOf("'")>=0) {
		result = result.replace("'","’");
	}

	while (result.indexOf("\"")>=0) {
		result = result.replace("\"","”");
	}
	return result;

}

function checkStr(value) {
	
	if (isEmpty(value)) return false;	
	
	if (containStr(value,"',\"")) {
		return false;
	}
	else {
		return true;
	}
}

/*
 * 是否包含指定字符串,多个字符串可以用逗号分割（或的关系，非且）
 * 返回 true - 表示包含指定字符串
 */
function containStr(value,str) {
	var strs = str.split(",");
	var result = false;
	for (i=0;i<strs.length;i++) {
		if (value.indexOf(strs[i])>-1) {
			result = true;
			break;
		}
	}
	return result;
}

/*
 * 判断指定字符串长度是否超过指定值，超过返回true
 */
function longThan(value,num) {
	if (JHshStrLen(value)>num) return true
	else return false;
}

/********************* 公用函数 ***************************/

//检验是否空
function isEmpty(s)
{   if (s == null) return true;
	s = trim(s);
 	if (s == "")
 		return true;
 	else
 		return false;
}

//去掉字符串头尾的空格
function trim(s)
{
	var i;

    if (s == null) return s;
    //去掉左边空格
    for (i = 0; i < s.length; i++)
        if (s.charAt(i)!=" " || s.charAt(i)!="　") break;
    if (i!=0) s = s.substr(i);
    //去掉右边空格
    for (i = s.length-1; i>=0; i--)
        if (s.charAt(i)!=" " || s.charAt(i)!="　") break;
    if (i!=s.length-1) s = s.substr(0,i+1);
    return s;
}

//检验字符是否是数字
function isDigit (c)
{
	return ((c >= "0") && (c <= "9"))
}

//检验是否整型
function isInteger (s)
{
	var i;

    if (isEmpty(s)) return false;
	s = trim(s);
	if ((s.charAt(0)=="0") && (s.length>1)) return false;	//一串数字不能0打头
    for (i = 0; i < s.length; i++)
    {
        var c = s.charAt(i);
        if (!isDigit(c)) return false;	//不是数字
    }
    return true;
}

//检验是否数字
function isFloat(s)
{   var i;
    var seenDot = false;

    if (isEmpty(s)) return false;
	s = trim(s);
	if (s.charAt(0)==".") return false;	//一串数字不能"."打头
	if (s.charAt(s.length-1)==".") return false;	//一串数字不能"."结尾
    for (i = 0; i < s.length; i++)
    {
        var c = s.charAt(i);
        if ((c == ".") && !seenDot) //在没遇到"."前遇到时设标志
			seenDot = true;
        else if (!isDigit(c)) //不是数字或遇到第二个"."
			return false;
    }
    if (s.charAt(0)=="0")	//0打头
    	if (s.length>1)	//一串数字
	    	if ((s.charAt(1)==".") && (s.length>2))	//0.x
	    		return true;
	    	else
	    		return false;	//一串数字不能0打头
	    else
	    	return true;	//0
    return true;
}

//检察日期，格式yyyy-mm-dd
function isDate(strDate)
{
	var strSeparator = "-"; //日期分隔符
	var strDateArray;
	var intYear;
	var intMonth;
	var intDay;
	var boolLeapYear;
	var i;

    if (isEmpty(strDate)) return false;

	//分割年月日
	strDateArray = strDate.split(strSeparator);
	if(strDateArray.length!=3) return false;

	//判断每项是否数字
	if((strDateArray[0] == "")||(strDateArray[1] == "")||(strDateArray[2] == "")) return false;
	for(i=0;i<=2;i++)
		if ((strDateArray[i].length == 2) && (strDateArray[i].charAt(0) == "0"))
			strDateArray[i] = strDateArray[i].substr(1);
	if(!isInteger(strDateArray[0])||!isInteger(strDateArray[1])||!isInteger(strDateArray[2])) return false;

	intYear = parseInt(strDateArray[0],10);
	intMonth = parseInt(strDateArray[1],10);
	intDay = parseInt(strDateArray[2],10);

	//判断月日是否合法
	if(intYear<1900) return false;
	if(intMonth>12||intMonth<1) return false;
	if((intMonth==1||intMonth==3||intMonth==5||intMonth==7||intMonth==8||intMonth==10||intMonth==12)&&(intDay>31||intDay<1)) return false;
	if((intMonth==4||intMonth==6||intMonth==9||intMonth==11)&&(intDay>30||intDay<1)) return false;

	if(intMonth==2){//判断润年
		if(intDay<1) return false;

		boolLeapYear = false;
		if((intYear%100)==0){
			if((intYear%400)==0) boolLeapYear = true;
		}
		else{
			if((intYear%4)==0) boolLeapYear = true;
		}

		if(boolLeapYear){
			if(intDay>29) return false;
		}
		else{
			if(intDay>28) return false;
		}
	}
	return true;
}

function isDateTime(value) {
	var att = value.split(" ");
	if (att[0]!=null && att[1]!=null && isDate(att[0]) && isTime(att[1])) {
		return true;
	}
	else return false;
}

function isTime(timeStr) {
	// Checks if time is in HH:MM:SS AM/PM format.
	// The seconds and AM/PM are optional.
	
	var timePat = /^(\d{1,2}):(\d{2})(:(\d{2}))?(\s?(AM|am|PM|pm))?$/;
	//var timePat = /^(\d{1,2}):(\d{2})(:(\d{2}))$/;
	
	var matchArray = timeStr.match(timePat);
	if (matchArray == null) {
	//alert("Time is not in a valid format.");
	return false;
	}
	hour = matchArray[1];
	minute = matchArray[2];
	second = matchArray[4];
	ampm = matchArray[6];
	
	if (second=="") { second = null; }
	if (ampm=="") { ampm = null }
	
	if (hour < 0  || hour > 23) {
	//alert("Hour must be between 1 and 12. (or 0 and 23 for military time)");
	return false;
	}
	//if (hour <= 12 && ampm == null) {
	//if (confirm("Please indicate which time format you are using.  OK = Standard Time, CANCEL = Military Time")) {
	//alert("You must specify AM or PM.");
	//return false;
	//}
	if  (hour > 12 && ampm != null) {
	//alert("You can't specify AM or PM for military time.");
	return false;
	}
	if (minute<0 || minute > 59) {
	//alert ("Minute must be between 0 and 59.");
	return false;
	}
	if (second != null && (second < 0 || second > 59)) {
	//alert ("Second must be between 0 and 59.");
	return false;
	}
	return true;
}


//检察开始日期是否大于结束日期，格式yyyy-mm-dd
function compareDate(strBeginDate, strEndDate)
{
	var strSeparator = "-"; //日期分隔符
	var strBeginDateArray, strEndDateArray;;
	var intBeginYear, strEndYear;
	var intBeginMonth, strEndMonth;
	var intBeginDay ,strEndDay;

    if (isEmpty(strBeginDate)) return true;
    if (isEmpty(strEndDate)) return true;

	//分割年月日
	strBeginDateArray = strBeginDate.split(strSeparator);
	intBeginYear = parseInt(strBeginDateArray[0],10);
	intBeginMonth = parseInt(strBeginDateArray[1],10);
	intBeginDay = parseInt(strBeginDateArray[2],10);

	strEndDateArray = strEndDate.split(strSeparator);
	strEndYear = parseInt(strEndDateArray[0],10);
	strEndMonth = parseInt(strEndDateArray[1],10);
	strEndDay = parseInt(strEndDateArray[2],10);


	//判断开始日期是否大于结束日期
	if (intBeginYear > strEndYear) return false;
	if (intBeginMonth > strEndMonth) return false;
	if (intBeginDay > strEndDay) return false;

	return true;
}

function JHshStrLen(sString)
{
	var sStr,iCount,i,strTemp ; 
	iCount = 0 ;
	sStr = sString.split("");
	for (i = 0 ; i < sStr.length ; i ++)
	{
	strTemp = escape(sStr[i]); 
	if (strTemp.indexOf("%u",0) == -1) // 表示是汉字
	{ 
	iCount = iCount + 1 ;
	} 
	else 
	{
	iCount = iCount + 2 ;
	}
	}
	return iCount ;
}


function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_nbGroup(event, grpName) { //v6.0
var i,img,nbArr,args=MM_nbGroup.arguments;
  if (event == "init" && args.length > 2) {
    if ((img = MM_findObj(args[2])) != null && !img.MM_init) {
      img.MM_init = true; img.MM_up = args[3]; img.MM_dn = img.src;
      if ((nbArr = document[grpName]) == null) nbArr = document[grpName] = new Array();
      nbArr[nbArr.length] = img;
      for (i=4; i < args.length-1; i+=2) if ((img = MM_findObj(args[i])) != null) {
        if (!img.MM_up) img.MM_up = img.src;
        img.src = img.MM_dn = args[i+1];
        nbArr[nbArr.length] = img;
    } }
  } else if (event == "over") {
    document.MM_nbOver = nbArr = new Array();
    for (i=1; i < args.length-1; i+=3) if ((img = MM_findObj(args[i])) != null) {
      if (!img.MM_up) img.MM_up = img.src;
      img.src = (img.MM_dn && args[i+2]) ? args[i+2] : ((args[i+1])?args[i+1] : img.MM_up);
      nbArr[nbArr.length] = img;
    }
  } else if (event == "out" ) {
    for (i=0; i < document.MM_nbOver.length; i++) { img = document.MM_nbOver[i]; img.src = (img.MM_dn) ? img.MM_dn : img.MM_up; }
  } else if (event == "down") {
    nbArr = document[grpName];
    if (nbArr) for (i=0; i < nbArr.length; i++) { img=nbArr[i]; img.src = img.MM_up; img.MM_dn = 0; }
    document[grpName] = nbArr = new Array();
    for (i=2; i < args.length-1; i+=2) if ((img = MM_findObj(args[i])) != null) {
      if (!img.MM_up) img.MM_up = img.src;
      img.src = img.MM_dn = (args[i+1])? args[i+1] : img.MM_up;
      nbArr[nbArr.length] = img;
  } }
}

function MM_preloadImages() { //v3.0
 var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
   var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
   if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function ChangeLeft(Str)
{
	//parent.frames[1].frames[0].location="Left.asp?Module="+Str;
}

function selectDate(obj)
{   
	d=new Date();
	result = window.showModalDialog('js/calendar.htm?'+d.getSeconds(),obj.value,'dialogWidth=185px;dialogHeight=210px;status=0;help=0;scroll=0');
	if (result!=null)obj.value = result;
}
