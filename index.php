<?php require_once('main_header.php');require_once('Security.php'); ?>

<?php if ((isset($_POST['action'])) && (isset($_SESSION['Student'])) && (empty($_POST['action'])!=true))
{
if ($_POST['action']=='logout')
	if (isset($_SESSION['Exam']))
		{
		unset($_SESSION['Exam']);
		}
	unset($_SESSION['Student']);
	session_destroy();
	header("Location: index.php");
}
?>
<?php if ((isset($_POST['action'])) && (isset($_SESSION['Admin'])) && (empty($_POST['action'])!=true))
{
if ($_POST['action']=='logout')
	if (isset($_SESSION['Exam']))
		{
		unset($_SESSION['Exam']);
		}
	unset($_SESSION['Admin']);
	session_destroy();
	header("Location: index.php");
}
?>
<?php
if((isset($_SESSION['Student'])) && (empty($_SESSION['Student'])!=true))
{
	echo "<div id='bdy'>\n";
	include('Start.php');
}
else if((isset($_SESSION['Admin'])) && (empty($_SESSION['Admin'])!=true))
{
	echo "<div id='adminbody'>\n";
	include('Admin.php');
}
else
{
	if ((isset($_GET['page'])) && ($_GET['page']=='Admin'))
	{
	include('Adminlogin.php');
	echo "<div id='bdy'>\n";
	}
	else
	{
	include('Login.php');
	echo "<div id='bdy'>\n";
	}
}
?>

</div>
<?php 
if(isset($_SESSION['Student']))
{
$user=$_SESSION['Student'];
?>
<script type="text/javascript"> 
$(document).ready(function(){
$(".flip").click(function(){
    $(".panel").slideToggle(1000);
  });
});
</script> 
<div class='panel'>
	<h3 title='Post Question to Admin'>Post Your Question</h3>
	<font size='3px' color='#eee' face='Arial'><?php echo $user; ?>,Please Specify Your Alloted Class and Desk Details with Your Question(Doubt).</font>
	<form method='post' onsubmit="return Post();" >
	<hr color="#1100ff" size="0"/>
	<input type='hidden' name='Check' value="<?php echo $user; ?>" size='7'/>
	<textarea id='askadmin' name='askadmin' placeholder='Ask Admin' >Sir !</textarea>
	<hr color="#1100ff" size="0"/>
	<input type='submit' value='Post Your Question' />
	<br />
	</form>
</div>
<?php
}
?>

<div id="topbar">
<img src='rguktlogo.jpg' id='logo' />
<table cellpadding="8%" id="Head">
<tr>
	<td width="10%" align="right" ><?php if (isset($_SESSION['Student'])){ echo 'Student ID:'; }else if (isset($_SESSION['Admin'])){ echo 'Admin :'; } ?></td>
	<td width="10%" align="left" style='text-shadow:2px 2px 5px #999;text-transform:capitalize;'><?php if (isset($_SESSION['Student'])){echo $_SESSION['Student'];}else if (isset($_SESSION['Admin'])){ echo $_SESSION['Admin']; }  ?></td>
	<td width="50%" align="center"><img src='Logo.png' id='heading-Logo' /></td>
	<td width="10%" align="right" ><?php if (isset($Subject)){echo 'Subject:'; }else{echo 'Date: ';} ?></td>
	<td width="10%" align="left"  style='text-shadow:2px 2px 5px #999;'><?php if (isset($Subject)){echo $Subject;}else{echo date("d/m/Y");} ?></td>
</tr>
<tr>
	<td width="10%" align="right"><?php if (isset($Batch)){echo 'Year:'; } ?></td>
	<td width="10%" align="left" style='text-shadow:2px 2px 5px #999;'><?php if (isset($Batch)){echo $Batch;}?></td>
	<td width="50%"  align="center"></td>
	<td width="10%" align="right"><?php if (isset($Date)){echo 'Date:'; }else{echo 'Clock: ';} ?></td>
	<td width="10%" align="left" style='text-shadow:2px 2px 5px #999;' id='clock'><?php if (isset($Date)){echo $Date;}else{include('Time.php');} ?></td>
</tr>
<tr>
	<td width="10%" align="right"><?php if (isset($Branch)){if($Branch!=''){echo '';}} ?></td>
	<td width="10%" align="left" style='text-shadow:2px 2px 5px #999;'><?php if (isset($Branch)){if($Branch!=''){echo '';}} ?></td>
	<td  aling='center' id='heading'><center><div id='heading' ><?php if (isset($Title)){echo $Title;}else{echo 'PROGRAMMING CLUB';} ?></div></center></td>
	<td width="10%" align="right"><?php if (isset($Time)) {echo 'Time:'; } ?></td>
	<td width="10%" align="left" style='text-shadow:2px 2px 5px #999;'><?php if (isset($Time)) {echo $Time;}; ?> </td>
</tr>
</table>
</div>
<?php
if (!isset($Date)){
?>
<script type="text/javascript">
var auto_refresh = setInterval(
function ()
	{
	$('#clock').load('Time.php');
	},1000);
</script>
<?php } ?>
<div id='footer' >
|<span id='copyrights' title='Click for Copy Rights'> &copy; All Rights Reserved @ PROGRAMMING CLUB ORGANIZER </span>| 
<?php
if (isset($_SESSION['Admin']))
{
echo "<span id='footer-begin' style='text-transform:capitalize;'><form method='post' ><input type='hidden' name='action' value='logout' /><input id='logout' type='submit' style='text-transform:capitalize;' value='| ".$_SESSION['Admin']." Log out |' title='Log out Admin Account' /></form></span> <span id='footer-end' style='text-transform:capitalize;' > | ".$_SESSION['Admin']." IP ".$_SERVER['REMOTE_ADDR']." | </span>";
}
else if (isset($_SESSION['Student']))
{
echo "<span id='footer-begin' style='text-transform:capitalize;'><form method='post' ><input type='hidden' name='action' value='logout' /><input id='logout' type='submit' style='text-transform:capitalize;'  value='| ".$_SESSION['Student']." Log out |' title='Log out Student Account' /></form></span> <span id='footer-end' style='text-transform:capitalize;' > | ".$_SESSION['Student']." IP ".$_SERVER['REMOTE_ADDR']." | </span>";
/** Post Question  to Admin Script  to Remove ass Comment Here on Below Line **/
echo "<span><div class=\"flip\" id=\"nav\" title='Post your question to Admin'>Post Question to Admin</div> |</span>";
/** Post Question  to Admin Script **/
}
else
{
if (isset($_GET['page']))
	{
	if ($_GET['page']=='Admin')
		echo "<span id='footer-begin' > | <a href='index.php' title='Login to Student Account'>Student Login</a> | </span> <span id='footer-end' > | Admin IP ".$_SERVER['REMOTE_ADDR']." | </span>";;
	}
else
	echo "<span id='footer-begin' > | <a href='index.php?page=Admin' title='Login to Admin Account'>Admin Login</a> | </span> <span id='footer-end' > | Student IP ".$_SERVER['REMOTE_ADDR']." | </span>";;
}
?>

</div>
<?php
if ((!isset($_SESSION['Student'])) && (!isset($_SESSION['Admin'])))
{ echo "
<div id='tip' title=\"Tip to fill your details\">
<b>Tip: </b>Login to Take Your Exam.
</div>";
}
?>

<div id='copyrightspage' onclick="this.style.display='none';" title='Click to Close Page'>
	<h3 id='head' >Wed Designers</h3>
	<table cellpadding="5"><tr style="color:white;text-align:left;"><td>K.V.N.H Sai Prasad</td><td><sub>(N110719)</sub><td></tr><tr style="color:white;text-align:left;"><td>K.Raghu Kumar</td><td><sub>(Mentor in Physics)</sub></td></tr></table>
	<br /><sub>Click to Close</sub>
</div>

<script>
$(document).ready(function(){
	$("#copyrightspage").slideUp(0);
	$("#copyrights").click(function(){
	$("#copyrightspage").slideToggle(1000);
	});
});
</script>
<!-- I think Your Verification of My Program was Completed....  Ohh Then How is My Script --->

</body>
</html>
