<!DOCTYPE html>
<html>
<head>
	<title>404 Not Found</title>
	<meta http-equiv='refresh' content='2,index.php' />
	<style>
	div#msg
	{
	position:fixed;
	top:40%;
	left:30%;
	width:40%;
	text-align:center;
	padding:20px;
	overflow:auto;
	background:#a0a;
	font-weight:bold;
	color:#fff;
	border:2px solid #fff;
	border-radius:15px;
	-moz-border-radius:15px;
	box-shadow:0px 0px 50px #000;
	-moz-box-shadow:0px 0px 50px #000;
	z-index:2;
	}
	div#layer{
	position:fixed;
	top:0%;
	left:0%;
	width:100%;
	height:100%;
	background:#eee;
	opacity:0.9;
	z-index:1;
	}
	</style>
</head>
<body>
<div id='layer'></div>
<div id='msg' >
404 Not Found
</div>
<script>
var mymsg='<font color="pink">'+document.URL+'</font> Not Found on this Server.';
document.getElementById('msg').innerHTML=mymsg;
</script>
</body>
</html>
