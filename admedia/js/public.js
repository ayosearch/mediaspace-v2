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


/*
 * 提交删除的表单
 * url - 处理删除的jsp
 * formObj - 含有删除数据的表单
 *
 * 排序的升降序自动判断，若原来升序则变为降序
 */

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


/*
 * 提交修改的表单
 * url - 处理修改的jsp
 * formObj - 是含有修改数据的表单
 *
 * 排序的升降序自动判断，若原来升序则变为降序
 */

function doUpdate(url,formObj) {
	formObj.action = url;
	formObj.submit();
}

/*
 * 将结果集按指定字段排序
 * url - 处理翻页的jsp
 * field - 要排序的字段
 *
 * 排序的升降序自动判断，若原来升序则变为降序
 */
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

/*
 * 显示选择文件的窗口
 */
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
function isEmpty(s){  
	if (s == null) return true;
	s = trim(s);
 	if (s == "")
 		return true;
 	else
 		return false;
}

//去掉字符串头尾的空格
function trim(s){
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
function isDigit (c){
	return ((c >= "0") && (c <= "9"))
}

//检验是否整型
function isInteger (s){
	var i;

    if (isEmpty(s)) return false;
	s = trim(s);
	if ((s.charAt(0)=="0") && (s.length>1)) return false;	//一串数字不能0打头
    for (i = 0; i < s.length; i++){
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
    for (i = 0; i < s.length; i++){
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

// -----------------------------------------------------------------------------
// 本函数用于测试字符串sString的长度;
// 注:对本函数来说,1个汉字代表2单位长度;
// 
function JHshStrLen(sString){
	var sStr,iCount,i,strTemp ; 
	iCount = 0 ;
	sStr = sString.split("");
	for (i = 0 ; i < sStr.length ; i ++){
		strTemp = escape(sStr[i]); 
		if (strTemp.indexOf("%u",0) == -1){ // 表示是汉字
			iCount = iCount + 1 ;
		}else{
			iCount = iCount + 2 ;
		}
	}
	return iCount ;
}

function ChangeLeft(Str){
	//parent.frames[1].frames[0].location="Left.asp?Module="+Str;
}

function selectDate(obj)
{   
	d=new Date();
	result = window.showModalDialog('js/calendar.htm?'+d.getSeconds(),obj.value,'dialogWidth=185px;dialogHeight=210px;status=0;help=0;scroll=0');
	if (result!=null)obj.value = result;
}
