<?php
require_once('main_header.php');
if ((isset($_SESSION['Student'])) || (isset($_SESSION['Admin'])))
{
header('Location: index.php');
}
?>
<?php
if ((isset($_POST['ID'])) && (empty($_POST['ID'])!=True) && (isset($_POST['PWD'])) && (empty($_POST['PWD'])!=True))
{
$user=$_POST['ID'];
$location='Location: index.php?message=Student+Login+Invalid';
$password=$_POST['PWD'];
mysql_select_db("Examination" ,$conn) or die("Error is ::".mysql_error());
$result = mysql_query("SELECT * FROM Passwords WHERE ID='$user'");
while($row = mysql_fetch_array($result))
	{
	if ($row['Password']==$password)
		{
		$_SESSION['Student']=$row['ID'];
		if(isset($_SESSION['Exam']))
		{
		unset($_SESSION['Exam']);
		}
		$location="Location: index.php";
		}
	else
		{
		$location='Location: index.php?message=Wrong+Password';
		}
	}
header($location);
}
?>


<form method='post' id='Login' autocomplete="off" >
<div id="box">
<div id="lightbox" width="37%">
<div id="lightbox_content">
<table id="Login"  border="0px" cellspacing="10" cellpading="10" width="100%">
	<tr align="center">
		<?php 
		if ((isset($_GET['message'])) & (empty($_GET['message'])!=true))
			{
			if (strlen($_GET['message'])<31)
				echo "<h2 align='center'>".htmlspecialchars($_GET['message'])."</h2>";
			else echo "<h2 align='center'>Student Login</h2>";
			}
		else echo "<h2 align='center'>Student Login</h2>";
		?>

	</tr>
	<tr>
		<td width="45%">
		University ID:
		</td>

		<td width="50%">
		<input type='text' id='user' name='ID' title='Enter your user id' onblur="Loginid();" maxlength="7" onfocus="Tip('Enter Your ID Number');" placeholder="University ID" value="<?php if(isset($_POST['ID'])){echo addslashes(htmlspecialchars($_POST['ID']));} ?>" /><br />
		</td> 

		<td id="idlogin" width="5%">

		</td>
	</tr>

	<tr>
		<td width="45%">
		Password: 
		</td>

		<td width="50%">
		<input type='password' id='password' name='PWD' onblur="Loginpwd();" maxlength="25" onfocus="Tip('Enter Your Examination Password');" title='Enter your password' placeholder="Password" /><br />
		</td>

		<td id="pwdlogin" width="5%">

		</td>
	</tr>

	<tr>
		<td width="50%">

		</td>

		<td width="50%">
		<input type='submit' id='submit' value="Login" title='Click to Login' onmouseover="Tip('Click to Login');" onfocus="Tip('Click to Login');" style="cursor:pointer;" />
		</td>
	</tr>

</table>
</div>
</div>
</div>  
</form>
<script>
function Tip(msg)
{
 var tip=document.getElementById('tip');
 tip.innerHTML='<b>Tip: </b>'+msg;
}
</script>
<?php
if(isset($_SERVER['HTTP_USER_AGENT']))
{
    $agent = $_SERVER['HTTP_USER_AGENT'];
}
if(strlen(strstr($agent,"Firefox")) > 0 )
{ 
  echo "<!-- Using Firefox -->";
}
else
{
echo "<script>alert('Please Use Firefox'); </script>";
}
?>

