<?php require_once('main_header.php'); 
if (!isset($_SESSION['Student']))
	{
	header('Location: index.php');
	}
?>
<?php
if (isset($_SESSION['Exam']))
{
header('Location: index.php');
}
?>
<?php
if ((isset($_POST['Exam'])) & (empty($_POST['Exam'])!=true))
{
$user=$_SESSION['Student'];
$Num=htmlspecialchars($_POST['Exam']);
mysql_select_db("exams",$conn);
$res=mysql_query("SELECT * FROM ".$Num." WHERE ID='".$user."'");
$login="";
$submit="";
$count=0;
if (isset($_SESSION['Exam']))
		{
		unset($_SESSION['Exam']);
		}
while ($row=mysql_fetch_array($res))
		{
		$count=1;
		$login=$row['Logintime'];
		$submit=$row['Submitstatus'];
		}
if ($submit=="Y")
{
echo "Already Submitted";
}
else
{
$ptime=date("h:i A",(mktime(date("H")+3,date("i")+30,date("s")+1,0,0,0)));
	$Hour=substr($ptime,0,2);
	$Min=substr($ptime,3,2);
	$M=substr($ptime,6,2);
	$Hour+=10;
	if ($M=='PM')
		{
		if ($Hour<22){$Hour+=12;}
		}
	$ptime=$Hour.$Min;
	mysql_select_db("Examination",$conn);
	$result=mysql_query("SELECT * FROM Examdetails WHERE Num='$Num'");
	while($row=mysql_fetch_array($result))
		{
		$starttime=$row['Display'];
		$endtime=$row['Endat'];
		}
	if ($ptime<$starttime)
	{
	$H=substr($starttime,0,2);
	$M=substr($starttime,2,2);
	$m='AM';
	$H-=10;
	if ($H>=12)
		{
		$m='PM';
		}
	if ($H>12)
		{
		$H=$H-12;
		}
	if ($H<10)
		{
		$H='0'.$H;
		}
	$startt=$H.':'.$M.' '.$m;
	echo "
	Please Wait Going to Back Page...
	<meta http-equiv='refresh' content='0' />";
	}
	else if ($ptime>$endtime)
	{
	$H=substr($endtime,0,2);
	$M=substr($endtime,2,2);
	$m='AM';
	$H-=10;
	if ($H>=12)
		{
		$m='PM';
		}
	if ($H>12)
		{
		$H=$H-12;
		}
	if ($H<10)
		{
		$H='0'.$H;
		}
	$close=$H.':'.$M.' '.$m;
	echo "
	Please Wait Going to Back Page...
	<meta http-equiv='refresh' content='0' />";
	}
	else
	{
	mysql_select_db('exams');
	$time=date("h:i:s A",mktime(date("h")+3,date("i")+30,date("s")));
	$res=mysql_query("INSERT INTO ".$Num." (ID,IP,Logintime,Submitstatus) VALUES ('".$user."','".$_SERVER['REMOTE_ADDR']."','".$time."','N')");
	if (!$res){echo mysql_error();}
	$_SESSION['Exam']=$Num;
	unset($_POST);
	header('Location: index.php');
	}
	
}
}
else
{
?>
<table cellpadding="5" id='tab' >
<tr>
<h2 id='avail'>Available Exams</h2>
<tr id='prib1'>
<th width="21%" >Title</th>
<th width="20%" >Subject</th>
<th width="15%" >Close Time</th>
<th width="17%" >Login</th>
<th width="17%" >Submit</th>
<th width="10%" >Status</th>
</tr>
<?php
$radioid=1;
$c=1;
if (isset($_SESSION['Student']))
{
	mysql_select_db("Examination",$conn);
	$user=$_SESSION['Student'];
	$result=mysql_query("SELECT * FROM Data WHERE ID='$user'");
	while($row=mysql_fetch_array($result))
	{
	$batch=$row['Batch'];
	$branch=$row['Branch'];
	}
	mysql_select_db("Examination",$conn);
	$date=date("d-m-Y");
	$ptime=date("h:i A",(mktime(date("H")+3,date("i")+30,date("s")+1,0,0,0)));
	$Hour=substr($ptime,0,2);
	$Min=substr($ptime,3,2);
	$M=substr($ptime,6,2);
	$Hour+=10;
	if ($M=='PM')
		{
		if ($Hour<22)
		{
		$Hour+=12;
		}
		}
	$ptime=$Hour.$Min;
	$result=mysql_query("SELECT * FROM Examdetails WHERE Batch='$batch' AND Branch='$branch' AND Visible='Y' AND Date='$date' ORDER BY Endat ASC");
	$count=0;
	while($row=mysql_fetch_array($result))
	{
	$c+=1;
	$p=($c%2);
	$count+=1;
	$Num=$row['Num'];
	$Examtitle=$row['Title'];
	$Sub=$row['Subject'];
	$Batch=$row['Batch'];
	$Branch=$row['Branch'];
	$date=$row['Date'];
	$Starttime=$row['Display'];
	$Endtime=$row['Endat'];
	$Type=$row['Type'];
	$Options=$row['Options'];	
	$Questions=$row['Questions'];
	$login="";
	$ip="";
	$submit="";
	$submittime="";
	mysql_select_db("exams",$conn);
	$res=mysql_query("SELECT * FROM ".$Num." WHERE ID='".$user."'");
	while ($row=mysql_fetch_array($res))
		{
		$login=$row['Logintime'];
		$submit=$row['Submitstatus'];
		$submittime=$row['Submittime'];
		$ip=$row['IP'];
		}
	if ($ip==null)
	{
	$ip='Take Exam';
	}
	else
	{
	$ip='Taken Exam From IP '.$ip;
	}
	$H=substr($Endtime,0,2);
	$M=substr($Endtime,2,2);
	$m='AM';
	$H-=10;
	if ($H>=12)
		{
		$m='PM';
		}
	if ($H>12)
		{

		$H=$H-12;
		}
	if ($H<10)
		{
		$H='0'.$H;
		}
	$Close=$H.':'.$M.' '.$m;
	if ($submit=="Y")
	{
	echo "<tr title='".$ip."' id='prib$p'><td>".$Examtitle."</td><td>".$Sub."</td><td>$Close</td><td>".$login."</td><td>".$submittime."</td><td><input type='button' onclick=\"alert('$user already submitted this exam.')\" value='Submitted' /></td></tr>\n";
	}
	else
	{
	if ($Endtime<$ptime)
	{
	
	echo "<tr title='".$ip."' id='prib$p'><td>".$Examtitle."</td><td>".$Sub."</td><td>$Close</td><td>".$login."</td><td>".$submittime."</td><td><input type='button' onclick=\"alert('Exam Login Time Up')\" value='Time Up' /></td></tr>\n";
	}
	else if ($Starttime>$ptime)
	{
	$H=substr($Starttime,0,2);
	$M=substr($Starttime,2,2);
	$m='AM';
	$H-=10;
	if ($H>=12)
		{
		$m='PM';
		}
	if ($H>12)
		{
		$H=$H-12;
		}
	if ($H<10)
		{
		$H='0'.$H;
		}
	$ctime=$H.':'.$M.' '.$m;
	echo "<tr title='".$ip."' id='prib$p'><td>".$Examtitle."</td><td>".$Sub."</td><td>$Close</td><td>".$login."</td><td>".$submittime."</td><td><input type='button' onclick=\"alert('Exam Display Visible at $ctime.')\" value='Time to Exam' /></td></tr>\n";
	}
	else
	{
	echo "<tr title='".$ip."' id='prib$p'><td>".$Examtitle."</td><td>".$Sub."</td><td>$Close</td><td>".$login."</td><td>".$submittime."</td><td><form method='post' ><input type='hidden' name='Exam' value='$Num' /><input type='submit' value='Take Exam' /></form></td></tr>\n";
	$radioid+=1;
	}
	}
	
	}
	echo "
</table>
	
	";
}
	?>
<div id="notificationarea" style='visibility:visible;' title='Notifications'>
<img src='Logobg.jpg' id='logobg' />
<marquee id="notifications" bgcolor="#fff" scrolldelay="100" onmouseover="this.setAttribute('scrollamount',0,0);" onmouseout="this.setAttribute('scrollamount',3,0);" behavior="slid" scrollamount="3" hspace="10%" direction="up" speed="1" style="">
<div id='notifypage' title='Notifications'>
<?php include("Notifications.php"); ?>
</div>
</marquee>
</div>
<script type="text/javascript">
var auto_refresh = setInterval(
function ()
	{
	$('#notifypage').load('Notifications.php');
	},100000);
</script>
<script type="text/javascript">
var auto_refresh = setInterval(
function ()
	{
	$('#bdy').load('Exams.php');
	},30000);
</script>
<?php
}
?>