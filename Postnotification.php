<?php
require_once('main_header.php');
if (!isset($_SESSION['Admin']))
	{
	header('Location: index.php');
	}
?>
<?php
if (isset($_SESSION['Admin']))
	{
	$user=$_SESSION['Admin'];
	}
else
	{
	header('Location: index.php');
	}
$ip=$_SERVER['REMOTE_ADDR'];
$time= date("d.m.Y")." - ".date("h:i A",mktime(date("H")+3,date("i")+30,date("s")));
if (isset($_POST['notification']) && (empty($_POST['notification'])!=true))
{
$notification=htmlspecialchars($_POST['notification']);
$pri=htmlspecialchars($_POST['priority']);
mysql_select_db("Examination" ,$conn) or die("Error is ::".mysql_error());
$result=mysql_query("INSERT INTO Notifications (Notification,Name,IP,Time,Priority,Visible)
			 VALUES ('$notification','$user','$ip','$time','$pri','Y')");
if (!$result)
	{
	echo mysql_error();
	}
else
	{
	header('Location: Postnotification.php');
	}
}	
?>
<div id="adminquestions" title='Questions'>
<marquee id="admin" bgcolor="#fff" scrolldelay="100" onmouseover="this.setAttribute('scrollamount',0,0);" onmouseout="this.setAttribute('scrollamount',3,0);" behavior="slid" scrollamount="3" hspace="10%" direction="up" speed="1"><?php include("Questions.php"); ?>

</marquee>
</div>
<form id='notification' method='post' style="position:fixed;left:32%;top:10%;width:40%;"  onsubmit='return Check();'>
<table width='100%'>
<tr><h2 slign='center'>Notifications Posting for Students</h2></tr>
<tr><td>Priority: </td><td><select name='priority' ><option value='1' >Normal</option><option value='2' >High</option></select></tr>
<tr><td>Notification: </td><td><textarea name='notification' id='ntfy' ></textarea></td></tr>
<tr><td></td><td><input type='submit' value='Post' /></td></tr></table>
<br /><br />
<font face='Arail' ><pre>
<--- Question Asked By Students  

		Notifications Posted by Admin ---></pre></font>
</form>
<script>
function Check()
{
ntf=document.getElementById('ntfy').value;
if (ntf=='' || ntf=='\n' || ntf=='\n\n' || ntf==' ' || ntf==null){alert('Enter Notification');return false;}
}
</script>
<div id="adminnotificationarea" title='Notifications'>
<marquee id="adminnotifications" bgcolor="#fff" scrolldelay="100" onmouseover="this.setAttribute('scrollamount',0,0);" onmouseout="this.setAttribute('scrollamount',3,0);" behavior="slid" scrollamount="3" hspace="10%" direction="up" speed="1">
<div id='adminnotifypage' title='Notifications'>
<?php include("Notifications.php"); ?>
</div>
</marquee>
</div>
<script type="text/javascript">
var auto_refresh = setInterval(
function ()
	{
	$('#adminnotifypage').load('Notifications.php');
	},10000);
</script>
<script type="text/javascript">
var auto_refresh = setInterval(
function ()
	{
	$('#admin').load('Questions.php');
	},10000);
</script>
</body>
</html>