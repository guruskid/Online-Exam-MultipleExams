<?php 
require_once('main_header.php');
if (!isset($_SESSION['Student']))
	{
	header('Location: index.php');
	}
if ((isset($_POST['Check'])) && (empty($_POST['Check'])!=true) && (isset($_POST['askadmin'])) && (empty($_POST['askadmin'])!=true))
{
$que=addslashes(htmlspecialchars($_POST['askadmin']));
unset($_POST['Check']);
unset($_POST['askadmin']);
$user=$_SESSION['Student'];
$ip=$_SERVER['REMOTE_ADDR'];
$time= date("d.m.Y")." - ".date("h:i A",mktime(date("H")+3,date("i")+30,date("s")));
mysql_select_db("Examination" ,$conn) or die("Error is ::".mysql_error());
$result=mysql_query("INSERT INTO Questions (Question,Name,IP,Time,Visible)
			 VALUES ('$que','$user','$ip','$time','Y')");
if (!$result)
	{
	echo mysql_error();
	}
else
	{
	header('Location: index.php?messgage=Your Question Posted to Admin');
	}
}
?>
<?php
if (isset($_SESSION['Exam']))
{
	if (!isset($_SESSION['Student']))
		{
		header('Location: index.php');
		}
	?>
	<script type="text/javascript">
	var auto_refresh = setInterval(
	function ()
		{
		$('#time').load('Time.php');
		},1000);
	</script>
	<?php
	if (isset($_SESSION['Exam']))
	{
	$Num=$_SESSION['Exam'];
	}
	else
	{
	header('Location: index.php');
	}
	if (isset($_SESSION['Student']))
	{
	$user=$_SESSION['Student'];
	}
	else
	{
	header('Location: index.php');
	}
	mysql_select_db("Examination",$conn) or die(mysql_error());
	$sai=mysql_query("SELECT * FROM Examdetails WHERE Num='".$Num."'");
	while ($row=mysql_fetch_array($sai))
	{
	$Title=$row['Title'];
	$Subject=$row['Subject'];
	$Batch=$row['Batch'];
	$Branch=$row['Branch'];
	$Date=$row['Date'];
	$Time=$row['Display'];
	$H=substr($Time,0,2);
	$M=substr($Time,2,2);
	$m='AM';
	$H=$H-10;
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
	$Time=$H.':'.$M.' '.$m;
	$Endtime=$row['Endat'];
	$Type=$row['Type'];
	$Questions=$row['Questions'];
	}
	include('Exam.php'); 
	?>
	<script>
	$(document).ready(function(){
		$('#notifyreload').click(function(){
		$('#notifypage').load('Notifications.php');
		});
	});
</script>
	<?php
	}
else
{
include ('Exams.php');

}
?>