<?php
require_once('main_header.php');
if (!isset($_SESSION['Admin']))
	{
	header('Location: index.php');
	}
?>

<?php
mysql_select_db("Examination",$conn) or die(mysql_error());
if ((isset($_GET['deletequestion'])) && (empty($_GET['deletequestion'])!=true))
{
$id=htmlspecialchars($_GET['deletequestion']);
$result = mysql_query("UPDATE Questions SET Visible='N' WHERE ID='$id'") or die(mysql_error());  
header('Location: Postnotification.php');
}
$result = mysql_query("SELECT * FROM Questions WHERE Visible='Y' ORDER BY id DESC") or die(mysql_error());  
echo "<table width='100%' >";
while ($row = mysql_fetch_array($result)) 
	{
	$id=$row['id'];
	echo "\n\t<tr title='Posted by ".$row['Name']." at ".$row['Time']."' ><td ";
	echo " id='notify' width='80%' >".$row['Question']."</td>";
	if (isset($_SESSION['Admin']))
		{
		echo "<td id='notify' width='20%'><a style='color:black;font-weight:bold;' href='?deletequestion=$id' >Delete</a></td>";
		}
	echo "</tr>";
	}
	echo "\n</table>";
?>