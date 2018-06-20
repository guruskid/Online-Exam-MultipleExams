<?php
echo "<div id='body' >";
require_once('main_header.php');
if (!isset($_SESSION['Admin']))
	{
	header('Location: index.php');
	}
mysql_select_db("Examination",$conn) or die(mysql_error());
function Check()
{
	$random = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 10);
	$check=mysql_query("SELECT * FROM Examdetails WHERE Title='".$random."'");
	$count=0;
	while($row = mysql_fetch_array($check))
		{
		$count+=1;
		}
	if ($count!=0)
		{
		Check();
		}
	else
		{
		return $random;
		}
}
$number=Check();
if ((isset($_POST['examtitle'])) && (empty($_POST['examtitle']))!=true)
{
$errorscount=0;
$Examtitle=ucfirst(htmlspecialchars($_POST['examtitle']));
if ((isset($_POST['sub'])) && (empty($_POST['sub']))!=true)
{
$Subject=htmlspecialchars($_POST['sub']);
}
else
{
echo "<div id='error' style='color:red;' >Enter Subject</div>";
$errorscount+=1;
}
$check=mysql_query("SELECT * FROM Examdetails WHERE Title='".$Examtitle."' and Subject='$Subject' and Visible='Y'");
$count=0;
while($row = mysql_fetch_array($check))
	{
	$count+=1;
	}
if ($count!=0)
{
echo "<div id='error' style='color:red;' >Exam ".$Examtitle." and ".$Subject." Already Exists !!!</div>";
$errorscount+=1;
}
if ((isset($_POST['batch'])) && (empty($_POST['batch']))!=true)
{
$Batch=addslashes(htmlspecialchars($_POST['batch']));
}
else
{
echo "<div id='error' style='color:red;' >Choose Batch</div>";
$errorscount+=1;
}
if ((isset($_POST['branch'])) && (empty($_POST['branch']))!=true)
{
	$Branch=addslashes(htmlspecialchars($_POST['branch']));
	if ($Branch=="None")
	{
	$Branch="";
	}
}
else
{
echo "<div id='error' style='color:red;' >Choose Branch</div>";
$errorscount+=1;
}
if ((isset($_POST['examdate'])) && (empty($_POST['examdate']))!=true)
{
$Date=htmlspecialchars($_POST['examdate']);
}
else
{
echo "<div id='error' style='color:red;' >Enter Date</div>";
$errorscount+=1;
}
if ((isset($_POST['start'])) && (empty($_POST['start']))!=true)
{
$ExamStart=htmlspecialchars($_POST['start']);
$Hour=substr($ExamStart,0,2);
$Min=substr($ExamStart,3,2);
$M=substr($ExamStart,6,2);
$Hour+=10;
if ($M=='PM')
	{
	if ($Hour<22)
	{
	$Hour+=12;
	}
	}
$ExamStartt=$Hour.$Min;
}
else
{
echo "<div id='error' style='color:red;' >Enter Exam Starting Time</div>";
$errorscount+=1;
}
if ((isset($_POST['end'])) && (empty($_POST['end']))!=true)
{
$EndExam=htmlspecialchars($_POST['end']);
$Hour=substr($EndExam,0,2);
$Min=substr($EndExam,3,2);
$M=substr($EndExam,6,2);
$Hour+=10;
if ($M=='PM')
	{
	if ($Hour<22)
	{
	$Hour+=12;
	}
	}
$EndExamt=$Hour.$Min;
}
else
{
echo "<div id='error' style='color:red;' >Enter Exam Expeir Time</div>";
$errorscount+=1;
}
if ((isset($_POST['type'])) && (empty($_POST['type']))!=true)
{
$Questiontype=htmlspecialchars($_POST['type']);
$Options=htmlspecialchars($_POST['options']);
}
else
{
echo "<div id='error' style='color:red;' >Choose Question Type</div>";
$errorscount+=1;
}
if ((isset($_POST['ques'])) && (empty($_POST['ques']))!=true)
{
$Questions=htmlspecialchars($_POST['ques']);
if ($Questions>80)
	{
	echo "<div id='error' style='color:red;' >Maximum 80 Questions are allowed.</div>";
	$errorscount+=1;
	}
}
else
{
echo "<div id='error' style='color:red;' >Enter Number of Questions</div>";
$errorscount+=1;
}
if ($errorscount!=0)
{
echo "Errors is ".$errorscount;
}
else
{
$result=mysql_query("INSERT INTO Examdetails (Num,Title,Subject,Batch,Branch,Date,Display,Endat,Type,Options,Questions,Visible)
 VALUES ('$number','$Examtitle','$Subject','$Batch','$Branch','$Date','$ExamStartt','$EndExamt','$Questiontype','$Options','$Questions','Y')");
if (!$result)
	{
	echo "Error Occured :: ".mysqL_error();
	}
else
	{
	echo 
	"
	<table id='result' width='40%' >
	<tr><th>Details of Created Exam</th></tr>
	<tr><td>Title</td><td>$Examtitle</td></tr>
	<tr><td>Batch</td><td>$Batch</td></tr>
	<tr><td>Branch</td><td>$Branch</td></tr>
	<tr><td>Subject</td><td>$Subject</td></tr>
	<tr><td>Date</td><td>$Date</td></tr>
	<tr><td>Exam Start at</td><td>$ExamStart</td></tr>
	<tr><td>Exam Ending at</td><td>$EndExam</td></tr>
	<tr><td>Question Type</td><td>$Questiontype</td></tr>
	<tr><td>No. of Questions</td><td>$Questions</td></tr>
	</table>
	";
	mysql_select_db("exams",$conn);
	$script="CREATE TABLE $number 
	(ID varchar(50),
	PRIMARY KEY(ID),
	IP varchar(50),";
	for ($i=1;$i<=$Questions;$i++)
	{
	$script=$script."Q".$i." varchar(10),\n";
	}
	$script=$script."Logintime varchar(50),
	Submitstatus varchar(1),
	Submittime varchar(50))";
	$rest=mysql_query($script);
	if (!$rest)
		{
		echo "Error Occured on Creating Table :: ".$number."<br>Error is ".mysqL_error();
		}
	else
		{
		echo "<br><blink>Table Created Successfully..!</blink>";
		}
	}
}
}
else
{
?>
<form method="post" name="Newexam" id="Newexamform" onsubmit="return newexam();" >
<table width="60%">
<tr><th>Fill Details to Create Exam</th></tr>
<tr><td>Exam Title (Ex: P2SEM2MT1)</td><td><input type='text' id='etitle' name='examtitle' size="20" /></td><td id='titleprogress'></td></tr>
<tr><td>Subject (Ex: MATHEMATICS)</td><td> <input type='text' id='esub'  name='sub' size="20" /></td></tr>
<tr><td>Batch</td><td>
<select name='batch' id='batch'><option value="PUC1">P1</option><option value="PUC2">P2</option><option value="E1-A">E1 A</option><option value="E1-B">E1 B</option><option value="E2">E2</option><option value="E3">E3</option><option value="E4">E4</option></select>
<select name='branch' id='branch'><option value="None" >None</option><option value="CSE" >CSE</option><option value="ECE" >ECE</option><option value="ME" >Mech</option><option value="CE" >Civil</option><option value="MME" >MME</option><option value='CHE' >CHE</option></select>
</td></tr>
<tr><td>Date </td><td><input type='text' name='examdate' id="examdate" value="<?php echo date("d-m-Y");?>"/></td><td>
</td></tr>
<tr><td>Time to Login</td><td><input type='text' name='start'  id='start' size="20" value="<?php echo date('h:00 A',mktime(date("H")+3,date("i")+30,0,0,0)); ?>"/></td></tr>
<tr><td>Expire Time</td><td><input type='text' name='end' id='end' size="20" value="<?php echo date('h:00 A',mktime(date("H")+6,date("i")+30,0,0,0)); ?>"/></td></tr>
<tr><td>Option Type</td><td><select name='type'><option value="A">A (Capital)</option><option value="1" >1 (Numbers)</option></td></tr>
<tr><td>Maximum No. of Options</td><td><select name='options' ><option value='3'>3</option><option value='4' selected='selected'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option></select></td></tr>
<tr><td>No. of Question (Less Than 48) </td><td><input type='text' id='questions' name='ques' value='20' ></td></tr>
<tr><td></td><td><input type='submit' value='Create Exam' name='submit' /></td></tr>
</table>
* Make Sure Correct Format for Time and Date
</form>
<script type='text/javascript' >
var tit = document.getElementById('etitle');

tit.onkeyup = function(){
    this.value = this.value.toUpperCase();
}
var sub = document.getElementById('esub');

sub.onkeyup = function(){
    this.value = this.value.toUpperCase();
}
function newexam()
{
var title=document.getElementById('etitle').value;
if (title=="" || title==null){alert('Enter Title');return false;}
var sub=document.getElementById('esub').value;
if (sub=="" || sub==null){alert('Enter Subject');return false;}
var date=document.getElementById('examdate').value;
if (date=="" || date==null || date[2]!="-" || date[5]!="-" || date.length!=10){alert('Enter Date in Correct Format.\ni.e., dd-mm-yyyy');return false;}
var start=document.getElementById('start').value;
if (start=="" || start==null || start[2]!=":" || start[5]!=" " || start.length!=8){alert('Enter Start Time in Correct Format.\ni.e., hh:mm AA');return false;}
var end=document.getElementById('end').value;
if (end=="" || end==null || end[2]!=":" || end[5]!=" " || end.length!=8){alert('Enter Ending Time in Correct Format.\ni.e., hh:mm AA');return false;}
var ques=document.getElementById('questions').value;
if (ques==0 || ques==null || ques>60 || ques==''){alert('Enter Number of Questions\nQuestion Must Be Less than 48.');return false;}
var batch=document.getElementById('batch').value;
var branch=document.getElementById('branch').value;
if (batch=="PUC2"){if (branch!="None"){alert('Change Branch for PUC2 ');return false;}}
if (batch=="PUC1"){if (branch!="None"){alert('Change Branch for PUC1');return false;}}
if (batch=="E1-A"){if (branch!="None"){alert('Change Branch for E1-A');return false;}}
if (batch=="E1-B"){if (branch!="None"){alert('Change Branch for E1-B');return false;}}
if (batch=="E2"){if (branch=="None"){alert('Choose Branch for E2');return false;}}
if (batch=="E3"){if (branch=="None"){alert('Choose Branch for E3');return false;}}
if (batch=="E4"){if (branch=="None"){alert('Choose Branch for E4');return false;}}
}
</script>
<?php } ?>
</div>
</body>
</html>
