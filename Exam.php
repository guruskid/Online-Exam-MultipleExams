<?php
require_once('main_header.php'); 
if (!isset($_SESSION['Student']))
	{
	header('Location: index.php');
	}
?>
<div id="notificationarea" style='visibility:visible;' title='Notifications'>
<span id="notifyreload" title='Click to Reload Notifications' >Refresh <img src='load719.gif' width='20px'/></span>
<img src='Logobg.jpg' id='logobg' />
<marquee id="notifications" bgcolor="#fff" scrolldelay="100" onmouseover="this.setAttribute('scrollamount',0,0);" onmouseout="this.setAttribute('scrollamount',3,0);" behavior="slid" scrollamount="3" hspace="10%" direction="up" speed="1" style="">
<div id='notifypage' title='Notifications'>
<?php include("Notifications.php"); ?>
</div>
</marquee>
</div>
<?php 
if ((isset($_POST['Checkpost'])) && ($_POST['Checkpost']=='Yes'))
{
unset($_POST['Checkpost']);
mysql_select_db('exams',$conn);
$result=mysql_query("SELECT * FROM $Num WHERE ID='$user'");
while ($row=mysql_fetch_array($result))
{
$Status=$row['Submitstatus'];
$IP=$row['IP'];
}
if ($Status=="N")
{
for ($i=1;$i<=$Questions;$i++)
	{
	$Name='Q'.$i.'Ans';
	eval("\$Name = \"$Name\";");
	$Question='Q'.$i;
	eval("\$Question = \"$Question\";");
	if (isset($_POST[$Name]))
	{
	$Ans=htmlspecialchars($_POST[$Name]);
	$result=mysql_query("UPDATE $Num SET $Question='$Ans' WHERE ID='$user'");
	unset($_POST[$Name]);
	}
	else
	{
	$Ans="-";
	$result=mysql_query("UPDATE $Num SET $Question='$Ans' WHERE ID='$user'");
	}
	}
$Time=date("h:i:s A",mktime(date("h")+3,date("i")+30,date("s")));
$result=mysql_query("UPDATE $Num SET Submittime='$Time' WHERE ID='$user'");
$result=mysql_query("UPDATE $Num SET Submitstatus='Y' WHERE ID='$user'");
}
else
{
echo "<script>alert('Sorry Your Data already Submitted from IP ".$ip."!!\nPlease Consult Your HRT !!! ');</script>";
}
unset($_SESSION['Exam']);
echo "
<script>
var status=document.getElementById('status');
status.innerHTML=\"Please wait or <a href=''>click here</a> to go to index page.....\";
</script>
<meta http-equiv='refresh' content='0' />";
}
else
{
?>
<div id='exampage' style='visibility:visibile;'>

<?php
if($Num)
{
mysql_select_db('Examination',$conn);
$re=mysql_query("SELECT * FROM Examdetails WHERE Num='$Num'");
while($r=mysql_fetch_array($re))
{
$Questions=$r['Questions'];
$Qtype=$r['Type'];
$Options=$r['Options'];
$Type=array();
if ($Qtype=="A"){for($i=65;$i<65+$Options;$i++){array_push($Type,chr($i));}}
else if ($Qtype=="a"){for($i=97;$i<97+$Options;$i++){array_push($Type,chr($i));}}
else if ($Qtype=="1"){for($i=1;$i<1+$Options;$i++){array_push($Type,$i);}}
shuffle($Type);
}
if ($Questions)
{
$i=1;
while($i<$Questions)
{
if (($Questions/$i)<6)
	{
	$c=($i+1)/2;
	$r=ceil($Questions/$i);
	break;
	}
$i+=2;
}
$i=1;
echo "<form id='answers' method='post' onsubmit='return Submit();' align='center'>
<input type='hidden' name='Checkpost' value='Yes' />
";
echo '<table width="100%" cellspacing="0" cellpadding="0" >';
while ($i<=($r*2))
{
echo '
<tr>
';
for ($k=1;$k<=$c;$k++)
	{
	$q=$i+($r*(2*($k-1)));
	if ($q<=$Questions)
		{
		if ($q<10)
		{
		$s="0".$q;
		}
	else
		{
		$s=$q;
		}
		$script="\n<table id='question'><tr><td>$s.</td>";
		shuffle($Type);
		foreach ($Type as $Single)
			{
			$script.="<td><div class='radio' title='Set Answer $Single for Question $s' id='Q".$q.$Single."' onclick=\"return Manual_Radio('$q','$Single');\">  ".$Single."<input type='radio' id='Radio".$q.$Single."' name='Q".$q."Ans' value='".$Single."' style='visibility:hidden;' /></div></td>";
			}
		$script.="</tr></table>\n";
		echo "<td>".$script."</td>\n\n";
		}
	else{
		echo '';
		}
	}
echo '
</tr>
';
$i++;
}
echo '</table>
';
?>
<div id='progressarea' title='Progress'>
<hr color="#eee" size="0"/>
<div id='time' ><?php include("Time.php"); ?></div>
<hr color="#eee" size="0" />
<div id='progress' >
Java Script Not Working
</div>
<hr color="#eee" size="0" />
<input type='submit' value='Submit' title='Submit Your Examination' />
<hr color="#eee" size="0" />
</form>
</div>
<?php
}
}
?>

</div>
<script type="text/javascript">
window.onbeforeunload = function() { return "Message"; };
function Progress()
{
var progress=document.getElementById('progress');
var form=document.getElementById('answers');
var count=0;
for (var i=0;i<form.length;i++)
{
	if (form.elements[i].type=='radio')
		{
		if(form.elements[i].checked)
			{
			count=count+1;
			}
		}
}
var Script="Answered "+count+" out of "+<?php echo $Questions; ?>+" Questions.";
progress.innerHTML=Script;
return Script;
}
function Submit()
{
var Script=Progress();
if(!confirm(Script+"\n Submit ?"))
	{
	return false;
	}
}
Progress();
function Manual_Radio(Question,Option)
{
var options = [ <?php foreach($Type as $Prasad){ echo '"'.$Prasad.'",';} ?>]
for (var i=0;i<options.length;i++)
	{
	if (options[i]==Option)
		{
		var div=document.getElementById('Q'+Question+Option);
		div.style.color='#666';;
		div.style.backgroundColor='#eee';
		var radio=document.getElementById('Radio'+Question+Option);
		radio.checked=true;
		}
	else
		{
		var div=document.getElementById('Q'+Question+options[i]);
		div.style.color='#eee';
		div.style.backgroundColor='#bbb';
		var radio=document.getElementById('Radio'+Question+options[i]);
		radio.checked=false;
		}
	}
Progress();
}
Progress();
function Post()
{
var ans=confirm('Your Current Answers will lost if you post Question\nYour have to click answers again\nContinue...')
if (ans != true)
	{
	return false;
	}
}
</script>

<?php
}
?>