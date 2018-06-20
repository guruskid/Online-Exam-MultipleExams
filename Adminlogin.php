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
$location='Location: index.php?page=Admin&message=Admin+Login+Invalid';
$password=$_POST['PWD'];
mysql_select_db("Examination" ,$conn) or die("Error is ::".mysql_error());
$result = mysql_query("SELECT * FROM Admin WHERE user='$user'");
while($row = mysql_fetch_array($result))
	{
	if ($row['password']==$password)
		{
		$_SESSION['Admin']=$row['user'];
		$location="Location: index.php";
		}
	else
		{
		$location='Location: index.php?page=Admin&message=Wrong+Password';
		}
	}
header($location);
}
?>

<span id='Layer' ></span>
<form method='post' id='Login' onsubmit="return Checkadminlogin()" autocomplete="off">
<div id="box">
<div id="lightbox">
<div id="lightbox_content">
<table id="Login"  border="0px" cellspacing="10" cellpading="10" width="100%">
	<tr align="center">
		<?php 
		if ((isset($_GET['message'])) & (empty($_GET['message'])!=true))
			{
			if (strlen($_GET['message'])<31)
				echo "<h2 align='center'>".htmlspecialchars($_GET['message'])."</h2>";
			else echo "<h2 align='center'>Admin Login</h2>";
			}
		else echo "<h2 align='center'>Admin Login</h2>";
		?>

	</tr>
	<tr>
		<td width="45%">
		Admin Name:
		</td>

		<td width="50%">
		<input type='text' id='user' name='ID' title='Enter your user id' onblur="Loginadminid();" onfocus="Tip('Enter Your User Name');" placeholder="University ID" ></input><br />
		</td>

		<td id="idlogin" width="5%">

		</td>
	</tr>

	<tr>
		<td width="45%">
		Password: 
		</td>

		<td width="50%">
		<input type='password' id='password' name='PWD' onblur="Loginadminpwd();" onfocus="Tip('Enter Your Password');" title='Enter your password' placeholder="Password" ></input><br />
		</td>

		<td id="pwdlogin" width="5%">

		</td>
	</tr>

	<tr>
		<td width="50%">

		</td>

		<td width="50%">
		<input type='submit' id='submit' value="Login" title='Click to Login' onmouseover="Tip('Click to Login');" onfocus="Tip('Click to Login');" style="cursor:pointer;"></input>
		</td>
	</tr>

</table>
</div>
</div>
</div>  
</form>
<script type='text/javascript' src='Validation.js' ></script>
