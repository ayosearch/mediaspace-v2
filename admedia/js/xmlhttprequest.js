if (window.ActiveXObject && !window.XMLHttpRequest) 
{
	window.XMLHttpRequest = function() 
	{
		return new ActiveXObject((navigator.userAgent.toLowerCase().indexOf('msie 5') != -1 || navigator.userAgent.toLowerCase().indexOf('msie 6') != -1) ? 'Microsoft.XMLHTTP' : 'Msxml2.XMLHTTP');
	};
}

global_fakeOperaXMLHttpRequestSupport = true;

if (window.opera && ( !window.XMLHttpRequest || ! (new window.XMLHttpRequest()).setRequestHeader )) 
{
	global_fakeOperaXMLHttpRequestSupport = true;
	window.XMLHttpRequest = function() 
	{
		this.readyState = 0; 
		this.status = 0; 
		this.statusText = '';
		this._headers = [];
		this._aborted = false;
		this._async = true;
		this.abort = function() 
		{
			this._aborted = true;
		};
		this.getAllResponseHeaders = function() 
		{
			return this.getAllResponseHeader('*');
		};
		this.getAllResponseHeader = function(header) 
		{
			var ret = '';
			for (var i = 0; i < this._headers.length; i++) 
			{
				if (header == '*' || this._headers[i].h == header) 
				{
					ret += this._headers[i].h + ': ' + this._headers[i].v + '\n';
				}
			}
			return ret;
		};
		this.setRequestHeader = function(header, value) 
		{
			this._headers[this._headers.length] = {h:header, v:value};
	    };
		this.open = function(method, url, async, user, password) 
		{
			this.method = method;
			this.url = url;
			this._async = true;
			this._aborted = false;
			if (arguments.length >= 3) 
			{
				this._async = async;
			}
			if (arguments.length > 3) 
			{				
				opera.postError('XMLHttpRequest.open() - user/password not supported');
			}
			this._headers = [];
			this.readyState = 1;
			if (this.onreadystatechange) 
			{
				this.onreadystatechange();
			}
		};
		this.send = function(data) 
		{
			if (!navigator.javaEnabled()) 
			{
				alert("XMLHttpRequest.send() - Java must be installed and enabled.");
				return;
			}
			if (this._async) 
			{
				setTimeout(this._sendasync, 0, this, data);				
			} 
			else 
			{
				this._sendsync(data);
			}
		}
		this._sendasync = function(req, data) 
		{
			if (!req._aborted) 
			{
				req._sendsync(data);
			}
		};
		this._sendsync = function(data) 
		{
			this.readyState = 2;
			if (this.onreadystatechange) 
			{
				this.onreadystatechange();
			}			
			var url = new java.net.URL(new java.net.URL(window.location.href), this.url);
			var conn = url.openConnection();
			for (var i = 0; i < this._headers.length; i++) 
			{
				conn.setRequestProperty(this._headers[i].h, this._headers[i].v);
			}
			this._headers = [];
			if (this.method == 'POST') 
			{
				// POST data
				conn.setDoOutput(true);
				var wr = new java.io.OutputStreamWriter(conn.getOutputStream());
				wr.write(data);
				wr.flush();
				wr.close();
			}
			// read response headers
			// NOTE: the getHeaderField() methods always return nulls for me :(
			var gotContentEncoding = false;
			var gotContentLength = false;
			var gotContentType = false;
			var gotDate = false;
			var gotExpiration = false;
			var gotLastModified = false;
			for (var i = 0; ; i++) 
			{
				var hdrName = conn.getHeaderFieldKey(i);
				var hdrValue = conn.getHeaderField(i);
				if (hdrName == null && hdrValue == null) 
				{
					break;
				}
			if (hdrName != null) 
			{
				this._headers[this._headers.length] = {h:hdrName, v:hdrValue};
				switch (hdrName.toLowerCase()) 
				{
					case 'content-encoding': gotContentEncoding = true; break;
					case 'content-length'  : gotContentLength   = true; break;
					case 'content-type'    : gotContentType     = true; break;
					case 'date'            : gotDate            = true; break;
					case 'expires'         : gotExpiration      = true; break;
					case 'last-modified'   : gotLastModified    = true; break;
				}
			}
		}
		// try to fill in any missing header information
		var val;
		val = conn.getContentEncoding();
		if (val != null && !gotContentEncoding) this._headers[this._headers.length] = {h:'Content-encoding', v:val};
			val = conn.getContentLength();
		if (val != -1 && !gotContentLength) this._headers[this._headers.length] = {h:'Content-length', v:val};
			val = conn.getContentType();
		if (val != null && !gotContentType) this._headers[this._headers.length] = {h:'Content-type', v:val};
			val = conn.getDate();
		if (val != 0 && !gotDate) this._headers[this._headers.length] = {h:'Date', v:(new Date(val)).toUTCString()};
			val = conn.getExpiration();
		if (val != 0 && !gotExpiration) this._headers[this._headers.length] = {h:'Expires', v:(new Date(val)).toUTCString()};
			val = conn.getLastModified();
		if (val != 0 && !gotLastModified) this._headers[this._headers.length] = {h:'Last-modified', v:(new Date(val)).toUTCString()};
		// read response data
			var reqdata = '';
			var stream = conn.getInputStream();
			if (stream) 
			{
				var reader = new java.io.BufferedReader(new java.io.InputStreamReader(stream));
				var line;
				while ((line = reader.readLine()) != null) 
				{
					if (this.readyState == 2) 
					{
					this.readyState = 3;
					if (this.onreadystatechange) 
					{
						this.onreadystatechange();
					}
				}
				reqdata += line + '\n';
			}
			reader.close();
			this.status = 200;
			this.statusText = 'OK';
			this.responseText = reqdata;
			this.readyState = 4;
			if (this.onreadystatechange) 
			{
				this.onreadystatechange();
			}
			if (this.onload) 
			{
				this.onload();
			}
		} 
		else 
		{
			// error
			this.status = 404;
			this.statusText = 'Not Found';
			this.responseText = '';
			this.readyState = 4;
			if (this.onreadystatechange) 
			{
				this.onreadystatechange();
			}
			if (this.onerror) 
			{
				this.onerror();
			}
		}
	};
  };
}
// ActiveXObject emulation
if (!window.ActiveXObject && window.XMLHttpRequest) 
{
	window.ActiveXObject = function(type) 
	{
		switch (type.toLowerCase()) 
		{
			case 'microsoft.xmlhttp':
			case 'msxml2.xmlhttp':
			return new XMLHttpRequest();
		}
		return null;
	};
}

function GetHTML(ServerPage,el) 
{ 
	URL = ServerPage;
	var ajax1 = new XMLHttpRequest();
	var obj = document.getElementById(el); 
	obj.innerHTML = "<br><br><img src='../images/load.gif' align='absMiddle'>&nbsp; &nbsp;<font color=blue>正在载入数据，请稍候..........</font><br><br>";
	ajax1.open("GET", ServerPage, true);
	ajax1.onreadystatechange = function() 
	{ 
		if (ajax1.readyState == 4 && ajax1.status == 200) 
		{
			if(ajax1.responseText.substring(0,11) == '/')
				location.href(ajax1.responseText)
			else
				obj.innerHTML = ajax1.responseText;
		}
	}
	ajax1.send(null);
}

function ProcessData(ServerPage,el) 
{ 
	URL = ServerPage;
	var ajax1 = new XMLHttpRequest();
	var obj = document.getElementById(el); 
	obj.innerHTML = "<br><br><img src='../images/load.gif' align='absMiddle'>&nbsp; &nbsp;<font color=blue>正在处理中，请稍候..........</font><br><br>";
	ajax1.open("GET", ServerPage, true);
	ajax1.onreadystatechange = function() 
	{ 
		if (ajax1.readyState == 4 && ajax1.status == 200) 
		{
			if(ajax1.responseText.substring(0,11) == '/')
				location.href(ajax1.responseText)
			else
				obj.innerHTML = ajax1.responseText;
		}
	}
	ajax1.send(null);
}

function ExecUrl(URL) 
{ 
	var ajax1 = new XMLHttpRequest();
	ajax1.open("GET", URL, true);	
	ajax1.onreadystatechange = function() 
	{ 
		if (ajax1.readyState == 4 && ajax1.status == 200) 
		{			
			eval(ajax1.responseText);
		}
	}
	ajax1.send(null);
}
