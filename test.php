<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" 
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>滑鼠框選效果</title>
<style>
*{
padding:0;
margin:0;
}
#bottom{
position:absolute;
bottom:0px;
width:100%;
height:40px;
border:1px solid #000;
background:#000;
color:#fff;
}
.tempDiv{
border:1px dashed blue;
background:#5a72f8;
position:absolute;
width:0;
height:0;
filter:alpha(opacity:10);
opacity:0.1
}
</style>
<script type = "text/javascript">
window.onload = function(){
var stateBar = document.getElementById("bottom");
document.onmousedown = function(e){
var posx = e.clientX;
var posy = e.clientY;
var div = document.createElement("div");
div.className = "tempDiv";
div.style.left = e.clientX "px";
div.style.top = e.clientY "px";
document.body.appendChild(div);
document.onmousemove = function(ev){
div.style.left = Math.min(ev.clientX, posx)   "px";
div.style.top = Math.min(ev.clientY, posy)   "px";
div.style.width = Math.abs(posx - ev.clientX) "px";
div.style.height = Math.abs(posy - ev.clientY) "px";
stateBar.innerHTML = "MouseX: "   ev.clientX   "<br/>MouseY: "   ev.clientY;
document.onmouseup = function(){
div.parentNode.removeChild(div);
document.onmousemove = null;
document.onmouseup = null;
}
}
}
}
</script>
</head>
<body>
<div id = "bottom"></div>
</body>
</html>