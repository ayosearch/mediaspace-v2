if (!window.XMLHttpRequest)
{
    window.XMLHttpRequest = function()
    {
        return new ActiveXObject("Microsoft.XMLHTTP");
    }
}

function $(id)
{
    return document.getElementById(id);
}

String.prototype.ellipsis = function(len)
{
    var k = 0;
    var ret = "";
    for (var i = 0; i < this.length; i++)
    {
        var u = this.charCodeAt(i);
        k += (u < 128 ? 1 : 2);
        if (k == len) break;
        if (k > len)
        {
            i--;
            break;
        }
    }
    return i == this.length ? this : this.substr(0, i) + "...";
};

String.prototype.UDecode = function()
{
    var ret = this;
    ret = ret.replace(/&#x([A-Fa-f0-9]{4});|&#([\d]{1,5});/gi, function()
    {
        if (arguments[1])
            return String.fromCharCode(parseInt("0x" + arguments[1]));
        return String.fromCharCode(parseInt(arguments[2]));
    });
    return ret;
};

String.prototype.HTMLEncode = function()
{
    var ret = this;
    ret = ret.replace(/&/g, "&amp;");
    ret = ret.replace(/</g, "&lt;");
    ret = ret.replace(/>/g, "&gt;");
    ret = ret.replace(/\"/g, "&quot;");
    return ret;
};

String.prototype.HTMLDecode = function()
{
    var ret = this;
    ret = ret.replace(/&quot;/g, "\"");
    ret = ret.replace(/&gt;/g, ">");
    ret = ret.replace(/&lt;/g, "<");
    ret = ret.replace(/&amp;/g, "&");
    return ret;
};

var mo = window.MOExplorer =
{
    list: [],
    serial: 0,
    text: "",
    html: "",
    http: null,
    intl: null,
    env: {},
    init: function(ctl) {
        var reg = /(\w+)=(\w+)/g;
        var arr;
        while ((arr = reg.exec(ctl)) != null) {
            eval("mo.env[\"" + arr[1] + "\"] = " + arr[2]);
            mo.check(arr[1]);
        }
        mo.ua = window.navigator.userAgent;
        mo.isMoz = mo.ua.match(/gecko/i) ? true : false;
        mo.isOpera = mo.ua.match(/opera/i) ? true : false;
        mo.isIE = (!mo.isOpera && mo.ua.match(/msie/i)) ? true : false;

        if (!mo.isMoz && !mo.isOpera && !mo.isIE) {
            alert("不支持的浏览器");
        }
        var dest = getQueryString("URL");
        if (dest != "") {
            mo.action("request", "get", dest, "");
        }
    },
    check: function(n) {
        var obj;
        switch (n) {
            case "title":
            case "address":
            case "tool":
            case "status":
                var obj = $(n);
                if (mo.env[n]) {
                    if ($(n) != null) {
                        $(n).style.display = "";
                        eval("mo." + n + " = obj");
                    }
                }
                break;
            case "back":
            case "front":
            case "refresh":
            case "source":
            case "code":
                var obj = $(n);
                if (!mo.env[n]) {
                    obj.style.display = "none";
                }
                break;
            default:
                break;
        }
    },
    setTitle: function(s) {
        if (mo.env["title"]) {
            mo.title.title = s;
            mo.title.innerHTML = (s).ellipsis(35);
        }
    },
    write: function(s) {
        if (mo.area == null) mo.area = $("area");
        mo.html = mo.area.innerHTML = s;
    },
    setStatus: function(s) {
        if (mo.env["status"]) {
            if (mo.title.title != null) mo.title.title = null;
            mo.status.innerHTML = s;
        }
    },
    setAddr: function(s) {
        if (mo.env["address"]) {
            if (mo.addr == null) mo.addr = $("addr");
            mo.addr.value = s;
        }
    },
    control: function(state) {
        var lst = ["go", "back", "front", "refresh", "source", "code"];
        var obj;
        for (var i = 0; i < lst.length; i++) {
            obj = $(lst[i])
            if (obj) obj.disabled = state;
        }
    },
    action: function(cmd, argv, dest, data) {
        var arr;
        switch (cmd) {
            case "request":
                arr = [argv, dest, mo.getData(data)];
                mo.request(arr[0], arr[1], arr[2], "forward");
                mo.list[mo.serial++] = arr;
                break;
            case "back":
                if (mo.serial - 2 < 0) break;
                arr = mo.list[mo.serial-- - 2];
                mo.request(arr[0], arr[1], arr[2], "backward");
                break;
            case "front":
                if (mo.serial < mo.list.length) {
                    arr = mo.list[mo.serial++];
                    mo.request(arr[0], arr[1], arr[2], "forward");
                }
                break;
            case "refresh":
                if (mo.list.length > 0) {
                    arr = mo.list[mo.serial - 1];
                    mo.request(arr[0], arr[1], arr[2], "forward");
                }
                break;
            case "source":
                mo.debug(mo.text);
                break;
            case "code":
                mo.debug(mo.html);
                break;
            case "key":
                if (argv.keyCode == 13) {
                    if (argv.srcElement) {
                        mo.action("request", "get", argv.srcElement.value, "");
                    }
                    else if (argv.target) {
                        mo.action("request", "get", argv.target.value, "");
                    }
                }
                break;
        }
    },
    request: function(strMethod, strURL, strData, strWard) {

        //if (strURL.toString().indexOf("http://") == -1) strURL = "http://" + strURL;
       // if (strURL.match(/^http:\/\//i) == null) {
         //   alert("不支持的访问地址: \r\n" + strURL);
        //    return false;
        //}
        if (mo.intl) {
            clearInterval(mo.intl);
            mo.intl = null;
        }
        mo.control(true);
        mo.URL = mo.formatURL(strURL.HTMLDecode());
        mo.setAddr(mo.URL);
        //mo.host = mo.getHost(mo.URL);
        //mo.path = mo.getPath(mo.URL);
        mo.ward = strWard;
        mo.setStatus("正在连接...请等待" + mo.URL.ellipsis(32));
        var http = new XMLHttpRequest();
        var uri = "/admedia/admin/wapconvert.php?method=" + strMethod + "&url=" + escape(mo.URL) + "&data=" + escape(strData) + "&random=" + Math.random();
        http.open("GET", uri, true);
        http.onreadystatechange = function() {
            switch (http.readyState) {
                case 1:
                    mo.setStatus("正在转换压缩内容 [1%]");
                    break;
                case 2:
                    mo.setStatus("正在请求发送数据 [20%]");
                    break;
                case 3:
                    mo.setStatus("接收数据下载内容 [60%]");
                    break;
                case 4:
                    mo.setStatus("下载完毕 [100%]");
                    mo.text = http.responseText;
                    if (http.status == 200) {
                        mo.parse(mo.text.UDecode());
                    }
                    else {
                        mo.debug(mo.text);
                    }
                    delete http;
                    http = null;
                    mo.control(false);
                    break;
            }
        };
        http.send(null);
    },
    getHost: function(strURL) {
        return strURL.match(/http:\/\/([^\/]+)/i)[1];
    },
    getPath: function(strURL) {
        var tmp = strURL.match(/http:\/\/[^\/]+([^\?]*)/i)[1];
        var pos = tmp.lastIndexOf("/");
        if (pos != -1) {
            tmp = tmp.substring(0, pos + 1);
        }
        if (tmp == "") tmp = "/";
        return tmp;
    },
    getData: function(strData) {
        var reg = /%24[\(]{0,1}([\w%]+)[\)]{0,1}/g;
        var arr;
        var ret = "";
        var pos = 0;
        var obj, tmp;
        while ((arr = reg.exec(strData)) != null) {
            ret += strData.substring(pos, arr.index);
            pos = arr.index + arr[0].length;
            tmp = arr[1].match(/(.+?)%3A(n|e|u)/i);
            if (tmp) {
                obj = $(decodeURIComponent(tmp[1]));
            }
            else {
                obj = $(decodeURIComponent(arr[1]));
            }
            if (obj) ret += encodeURIComponent(obj.value);
        }
        ret += strData.substring(pos);
        return ret;
    },
    parse: function(strData) {
        var reg = /(href|src|onpick|onenterforward|onenterbackward|ontimer)[\s]*=[\s]*[\"\']([^\"\']+)[\"\']/g;
        var arr;
        var ret = "";
        var pos = 0;
        var tmp = "";
        arr = strData.match(/<\!\-\-mo\.target:(.+?)\-\->/);
        if (arr) {
            mo.host = mo.getHost(arr[1]);
            mo.path = mo.getPath(arr[1]);
            mo.setAddr(arr[1]);
        }
        while ((arr = reg.exec(strData)) != null) {
            ret += strData.substring(pos, arr.index);
            pos = arr.index + arr[0].length;
            ret += arr[1] + "=\"" + mo.formatURL(arr[2]) + "\"";
        }
        ret += strData.substring(pos);
        ret = mo.formatAnchor(ret);
        mo.forward = mo.getEvent(ret, "onenterforward");
        mo.backward = mo.getEvent(ret, "onenterbackward");
        mo.timer = mo.getEvent(ret, "ontimer");
        ret = ret.replace(/href=[\"\']([^\"\']+)[\"\']/g, "href=\"javascript:void(0)\" onclick=\"mo.action('request', 'get', '$1', '')\" title=\"$1\"");
        ret = ret.replace(/<input(.+?)(name)=[\"\']([^\"\']+)[\"\']/g, "<input$1id=\"$3\"");
        ret = ret.replace(/<a\starget=/g, "<a href=");
        arr = ret.match(/<(card)[^>]*>([\s\S]+)<\/\1>/);
        mo.write(arr ? arr[2] : "不支持的文档格式");
        arr = ret.match(/<card.+?title=[\"\']([^\"\']+)[\"\']/);
        mo.setTitle(arr ? arr[1].HTMLDecode() : "???");
        if (mo.forward.length == 3 && mo.forward[1] != "" && mo.ward == "forward") {
            mo.action("request", mo.forward[0], mo.forward[1], mo.getData(mo.forward[2]));
        }
        else if (mo.backward.length == 3 && mo.backward[1] != "" && mo.ward == "backward") {
            mo.action("request", mo.backward[0], mo.backward[1], mo.getData(mo.backward[2]));
        }
        else if (mo.timer.length == 3 && mo.timer[1] != "") {

            mo.intl = AddInterval(mo.action, mo.getTimer(ret), "request", mo.timer[0], mo.timer[1], mo.getData(mo.timer[2]));
        }
    },
    formatAnchor: function(strData) {
        var reg = /<anchor[^>]*>([\s\S]*?)<go([^>]+?)>([\s\S]+?)<\/go>([\s\S]*?)<\/anchor>/g;
        var arr;
        var ret = "";
        var pos = 0;
        while ((arr = reg.exec(strData)) != null) {
            ret += strData.substring(pos, arr.index);
            pos = arr.index + arr[0].length;
            var strHref = mo.getAttr(arr[2], "href");
            var strMethod = mo.getAttr(arr[2], "method");
            var strFiled = mo.getField(arr[3]);
            if (strMethod == "") strMethod = "get";
            ret += "<a target=\"javascript:void(0)\" onclick=\"mo.action('request', '" + strMethod + "','" + strHref + "','" + strFiled + "')\" title=\"" + strHref + "\">" + arr[1] + arr[4] + "</a>";
        }
        ret += strData.substring(pos);
        return ret;
    },
    getAttr: function(strData, strName) {
        var reg = new RegExp(strName + "=[\\\"\\\']([^\\\"\\\']+?)[\\\"\\\']");
        var arr = strData.match(reg);
        if (arr) return arr[1];
        return "";
    },
    getField: function(strData) {
        var reg = /<postfield([^>]+)>/g;
        var arr;
        var ret = [];
        while ((arr = reg.exec(strData)) != null) {
            ret.push(mo.getAttr(arr[1], "name") + "=" + encodeURIComponent(mo.getAttr(arr[1], "value").HTMLDecode()));
        }
        return ret.join("&");
    },
    getEvent: function(strData, strName) {
        var reg1 = "<onevent\\s+type=[\\\"\\\']" + strName + "[\\\"\\\']>[\\\s\\\S]*?<go([^>]+?)>([\\\s\\\S]*?)<\\\/go>[\\\s\\\S]*?</onevent>";
        var reg2 = "<onevent\\s+type=[\\\"\\\']" + strName + "[\\\"\\\']>[\\\s\\\S]*?<go([^>]+?)>[\\\s\\\S]*?</onevent>";
        var reg3 = "<card.+?" + strName + "=[\\\"\\\']([^\\\"\\\']+)[\\\"\\\'][^>]*>";
        var ret = [];
        if ((arr = strData.match(new RegExp(reg1))) != null) {
            ret[0] = mo.getAttr(arr[1], "method");
            ret[1] = mo.getAttr(arr[1], "href");
            ret[2] = mo.getField(arr[2]);
            if (ret[0] == "") ret[0] = "get";
            if (ret[1] != "") ret[1] = mo.formatURL(ret[1]);
        }
        else if ((arr = strData.match(new RegExp(reg2))) != null) {
            ret[0] = mo.getAttr(arr[1], "method");
            ret[1] = mo.getAttr(arr[1], "href");
            ret[2] = "";
            if (ret[0] == "") ret[0] = "get";
            if (ret[1] != "") ret[1] = mo.formatURL(ret[1]);
        }
        else if ((arr = strData.match(new RegExp(reg3))) != null) {
            ret[0] = "get";
            ret[1] = arr[1];
            ret[2] = "";
            if (ret[1] != "") ret[1] = mo.formatURL(ret[1]);
        }
        return ret;
    },
    formatURL: function(strURL) {
        var ret = strURL;
        //if (strURL.substring(0, 7).toLowerCase() == "http://") {
       //     ret = strURL;
      //  }
      //  else if (strURL.substring(0, 7).toLowerCase() == "wtai://") {
       //     ret = strURL;
      //  }
      //  else if (strURL.substring(0, 1) == "/") {
      //      ret = "http://" + mo.host + strURL;
      //  }
     //   else {
        //    var tmp = mo.path;
         //   var ptr = strURL;
         //   var arr;
         //   while ((arr = ptr.match(/^\.\.\/(.+)$/)) != null) {
        //        tmp = tmp.replace(/[^\/]+\/$/, "");
        //        ptr = arr[1];
        //    }
        //    if ((arr = ptr.match(/^\.\/(.+)$/)) != null) {
        //        ptr = arr[1];
        //    }
        //    ret = "http://" + mo.host + tmp + ptr;
       // }
        ret = ret.replace(/\s/g, "");
        var arr = ret.match(/^(.+)#/);
        if (arr) ret = arr[1];
        //alert(ret);
        return ret;
    },
    getTimer: function(s) {
        var ret = s.match(/<timer\s+value=[\"\'](\d+)[\"\'][^>]+>/);
        if (ret) return parseInt(ret[1]) * 100;
        return 3000;
    },
    debug: function(s) {
        var op = window.open("", "debug", "width=500,height=400,scrollbars=yes");
        op.document.open();
        op.document.write("<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><title>查看源代码-模拟手机浏览器</title><style>*{font:16px Courier New}</style><scr" + "ipt>window.onload = function(){window.focus();};</scr" + "ipt></head><body>" + String(s).HTMLEncode() + "</body></html>");
        op.document.close();
    }
};

function getQueryString(strName)
{
    var reg = new RegExp("[\\\?&]" + strName + "=([^&]*)", "i");
    var arr = location.href.match(reg);
    if (arr) return unescape(arr[1]);
    return "";
}

function AddInterval(func, ms)
{
    var argv = Array.prototype.slice.call(arguments, 2);
    var newFunc = function()
    {
        func.apply(null, argv);
    };
    return window.setInterval(newFunc, ms);
}