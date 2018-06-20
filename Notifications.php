<?php
require_once('main_header.php');
?>
<?php
mysql_select_db("Examination",$conn) or die(mysql_error());
if ((isset($_GET['deletenotify'])) && (empty($_GET['deletenotify'])!=true))
{
$id=$_GET['deletenotify'];
$result = mysql_query("UPDATE Notifications SET Visible='N' WHERE ID='$id' and Visible='Y'") or die(mysql_error());  
header('Location: Postnotification.php');
}
$result = mysql_query("SELECT * FROM Notifications WHERE Visible='Y' ORDER BY Priority DESC") or die(mysql_error());
echo "\n<table width='100%'>";
while ($row = mysql_fetch_array($result)) 
	{
	$id=$row['id'];
	$notification=$row['Notification'];
	$notification=substr(chunk_split($notification, 30, '
	'), 0, -1);
	echo "\n\t<tr title='Posted at ".$row['Time']."' ><td ";
	if ($row['Priority']==2)
		{
		echo " style='color:red;font-weight:bold;text-decoration:blink;' ";
		}
	echo " id='notify'  width='80%'>".$notification."</td>";
	if (isset($_SESSION['Admin']))
		{
		echo "<td id='notify'  width='20%' ><a style='color:black;font-weight:bold;' href='?deletenotify=$id' >Delete</a></td>";
		}
	echo "</tr>";
	}
	echo "\n</table>";
?>