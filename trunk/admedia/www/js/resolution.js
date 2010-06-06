// JavaScript Document


　　if (window.navigator.userAgent.indexOf("MSIE")>=1) 
　　{ 
　　var IE1024="style1024.css"; 
　　var IE800=""; 
　　var IE1152="style.css"; 
　　var IEother="style.css";  
　　ScreenWidth(IE1024,IE800,IE1152,IEother) 
　　}else{ 
　　if (window.navigator.userAgent.indexOf("Firefox")>=1) 
　　{ 
　　var Firefox1024="style1024.css"; 
　　var Firefox800=""; 
　　var Firefox1152="style.css"; 
　　var Firefoxother="style.css"; 
　　ScreenWidth(Firefox1024,Firefox800,Firefox1152,Firefoxother) 
　　}else{ 
　　var Other1024="style1024.css"; 
　　var Other800=""; 
　　var Other1152="style.css"; 
　　var Otherother="style.css"; 
　　ScreenWidth(Other1024,Other800,Other1152,Otherother) 
　　} 
　　} 
　　function ScreenWidth(CSS1,CSS2,CSS3,CSS4){ 
　　if ((screen.width == 1024) && (screen.height == 768)){ 
　　setActiveStyleSheet(CSS1); 
　　}else{ 
　　if ((screen.width == 800) && (screen.height == 600)){ 
　　setActiveStyleSheet(CSS2); 
　　}else{ 
　　if ((screen.width == 1152) && (screen.height == 864)){ 
　　setActiveStyleSheet(CSS3); 
　　}else{ 
　　setActiveStyleSheet(CSS4); 
　　}}} 
　　} 
　　function setActiveStyleSheet(title){  
　　document.getElementsByTagName("link")[0].href="css/"+title;  
　　} 

