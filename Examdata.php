<?php
include_once('connect.php');
?>
<?php
if (isset($_SESSION['Admin']))
{
if ((isset($_POST['Examdata'])) && (empty($_POST['Examdata'])!=true))
{ 
	mysql_select_db("Examination",$conn);
	$Num=htmlspecialchars($_POST['Examdata']);
	$script='<table style="text-align:center;">
	<tr style="text-align:center;border:1px solid #999;">
	<th>S.No</th>
	<th>ID</th>';
	$Title='Unknown';
	$result=mysql_query("SELECT * FROM Examdetails WHERE Num='$Num'");
	while($row=mysql_fetch_array($result))
	{
	$Questions=$row['Questions'];
	$Title=$row['Title'];
	$Subject=$row['Subject'];
	$Branch=$row['Branch'];
	$Date=$row['Date'];
	}
	if ($Questions)
	{
	$i=1;
	while ($i<=$Questions)
	{
	$script=$script.'<th>Q'.($i).'</th>';
	$i+=1;
	}
	$script=$script."<th>IP</th><th>Login Time</th><th>Submit Time</th><th>Submit Status</th><th> </th>";
	$i=1;
	while ($i<=$Questions)
	{
	$script=$script.'<th>Q'.($i).'M</th>';
	$i+=1;
	}
	$script=$script."<th></th><th>Total Marks</th></tr>
	<tr style='text-align:center;border:1px solid #1199ff;color:green;'><td>0</td><td>Key</td>";
	$i=1;
	while($i<=(($Questions*2)+6))
		{
		$script.="<td></td>";
		$i++;
		}
	$script=$script. "</tr>";
	}
	mysql_select_db('exams');
	$result=mysql_query("SELECT * FROM $Num");
	$SNo=1;
	while ($row=mysql_fetch_array($result))
	{
	$ID=$row['ID'];
	$IP=$row['IP'];
	$LoginTime=$row['Logintime'];
	$SubmitTime=$row['Submittime'];
	$SubmitStatus=$row['Submitstatus'];
	$script.="<tr style='text-align:center;border:1px solid #999;'><td align='center'>$SNo</td><td align='center'>$ID</td>";
	$i=1;
	while($i<=$Questions)
		{
		$Ans=$row["Q".$i];
		$script.="<td align='center'>$Ans</td>";
		$i++;
		}
	$script.="<td align='center' >$IP</td><td align='center'>$LoginTime</td><td align='center'>$SubmitTime</td><td align='center'>$SubmitStatus</td><td></td>";
	$l=1;
	while($l<=$Questions)
		{
		while($l<=$Questions)
		{
			$i=$l+66;
			$c="";
			if ($i>90)
			{
				$c.=chr((($i-90)/26)+65);
				$c.=chr((($i-90)%26)+64);
			}
			else
			{
				$c.=chr($i);
			}
			$script=$script."<td>=if(".$c."2=".$c.($SNo+2).",1,0)</td>";
			$l++;
		}
		}
		$sta=($Questions)+7+65;
		$e=$sta+$Questions-1;
		$star="";
		$en="";
		if ($sta>90)
		{
		$star.=chr((($sta-90)/26)+65);
		$star.=chr((($sta-90)%26)+64);
		}
		else
		{
		$star.=chr($sta);
		}
		if ($e>90)
		{
		$en.=chr((($e-90)/26)+65);
		$en.=chr((($e-90)%26)+64);
		}
		else
		{
		$en.=chr($e);
		}
	$script.="<td></td><td>=SUM(".$star.($SNo+2).":".$en.($SNo+2).")</td></tr>";
	$SNo+=1;
	}
	$script.='</table>';
if($Branch!=""){$xlsbranch="_".$Branch;}else{$xlsbranch="";}
$xlsname=$Title.$xlsbranch.'_'.$Subject.'_'.$Date;
$xlsname= strtoupper(str_replace(' ', '', $xlsname));
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Disposition: attachment;filename=".$xlsname.".xls");
header("Content-Transfer-Encoding: binary ");
echo strip_tags("$script",'<table><th><tr><td>'); 
}
else
{
?>
<!DOCTYPE html>
<html>
<head>
	<title id="title">Examination</title>
	<link rel="stylesheet" href="Style.css" />
	<meta http-equiv='refresh' content='5' />
</head>
<body>
<div id='body' >
<table cellpadding="10" width="100%">
<tr id='prib1'><th width="5%">S.No</th><th width="16%">Exam Title</th><th width="8%">Batch</th><th width="8%">Subject</th><th width="10%">Date</th><th width="7%">Start</th><th width="7%">End</th><th width="8%">Students</th><th width="8%">Logins</th><th width="8%" >Submits</th><th width="8%">Get Data</th></tr>
<?php
$batches=array('PUC1','PUC2','E1-A','E1-B','E2','E3','E4');
$nub=0;
$c=0;
foreach($batches as $prib)
{
$i=($c)%2;
mysql_select_db("Examination",$conn);
	$result=mysql_query("SELECT * FROM Examdetails WHERE Visible='Y' AND Batch='$prib' ORDER BY Display ASC");
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
	$re=mysql_query("SELECT * FROM Data WHERE Batch='$Batch' AND Branch='$Branch' ");
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
	$nub=$nub+1;
	echo "<tr align='center' id='prib$i'><td>$nub .</td><td>$Examtitle</td><td>$Class</td><td>$Subject</td><td>$Date</td><td>$Startt</td><td>$Endt</td><td>$Total</td><td>$logins</td><td>$submits</td><td><form method='post' ><input type='hidden' name='Examdata' value='".$Num."' /><input type='submit' title='Get XLS Sheet of Answers' value='Get Data' /></form></td></tr>";
}
}
?>

</table>
</div>
<?php
}
}
else
{
header('Location: index.php');
}
?>
</body>
</html>
