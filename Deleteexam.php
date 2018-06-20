<?php require_once('main_header.php'); 
if (!isset($_SESSION['Admin']))
	{
	header('Location: index.php');
	}
?>
<?php 
if (isset($_POST['Examdelete']))
{
$num=htmlspecialchars($_POST['Examdelete']);
mysql_select_db("Examination",$conn);
$result=mysql_query("UPDATE Examdetails SET Visible='N' WHERE Num='$num' AND Visible='Y'");
header('Location: Deleteexam.php');
}
else
{
?>

<div id='body' >
<table cellpadding="10" width="100%">
	<tr id='prib1'><th width="8%">S.No</th><th width="20%">Exam Title</th><th width="8%">Batch</th><th width="8%">Subject</th><th width="10%">Date</th><th width="10%">End Time</th><th width="10%">Students</th><th width="8%">Logins</th><th width="8%" >Submits</th><th width="10%">Remove</th></tr>
<?php
$batches=array('PUC1','PUC2','E1-A','E1-B','E2','E3','E4');
$nub=0;
$c=0;
foreach($batches as $prib)
{
$i=($c)%2;
mysql_select_db("Examination",$conn);
	$result=mysql_query("SELECT * FROM Examdetails WHERE Visible='Y' AND Batch='$prib'  ORDER BY Display ASC");
	$count=0;
	while($row=mysql_fetch_array($result))
	{
	$count+=1;
	$Num=$row['Num'];
	$Examtitle=$row['Title'];
	$Subject=$row['Subject'];
	$Batch=$row['Batch'];
	$Branch=$row['Branch'];
	$Date=$row['Date'];
	$Starttime=$row['Display'];
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
	$Startt=$H.':'.$M.' '.$m;
	$Endtime=$row['Endat'];
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
	$Endt=$H.':'.$M.' '.$m;	
	$Type=$row['Type'];
	$Questions=$row['Questions'];
	$Total=0;
	$logins=0;
	$submits=0;
	$Br='';
	if ($count==1)
		{
		$c+=1;
		}
	if ($Branch!='')
		{
		$Br=" - ".$Branch;
		}
	$Class=$Batch.$Br;
	mysql_select_db("Examination",$conn);
	$re=mysql_query("SELECT * FROM Data WHERE Batch='$Batch' AND Branch='$Branch'");
	while ($rows=mysql_fetch_array($re))
		{
		$Total+=1;
		}
	mysql_select_db("exams",$conn);
	$re=mysql_query("SELECT * FROM $Num");
	while ($rows=mysql_fetch_array($re))
		{
		$logins+=1;
		if ($rows['Submitstatus']=="Y")
			{
			$submits+=1;
			}
		}
	$nub+=1;
	echo "\t<tr align='center' id='prib$i'><form method='post' onsubmit=\"return Confirmdelete('$Examtitle',$nub);\" ><td><sup>$nub.</sup> <input type='checkbox' name='Agree' id='agree$nub' /></td><td>$Examtitle</td><td>$Class</td><td>$Subject</td><td>$Date</td><td>$Endt</td><td>$Total</td><td>$logins</td><td>$submits</td><td><input type='hidden' name='Examdelete' value='$Num' /><input type='submit' value='Delete Exam' /></td></form></tr>";
	}
}
?>

</table>
</div>
<script>
function Confirmdelete(title,nub)
{
var agree=document.getElementById('agree'+nub);
if (agree.checked)
{
var cd=confirm("Are You Sure You really wish to delete "+title+" ?");
if (cd==false)
	{
	return false;
	}
}
else
{
alert('Please Check on Checkbox');
return false;
}
}
</script>
<?php
}
?>
</body>
</html>