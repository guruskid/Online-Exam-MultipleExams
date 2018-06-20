<?php
echo "<!--\n
* This is Information will be add to Database for Security Purpose

==================================================
		User Information
==================================================\n";
$type="None";
$user="None";
if (isset($_SESSION['Admin']))
	{
	$type="Admin";
	$user=$_SESSION['Admin'];
	echo "\tUser Type: \t\t".$type."\n\tAdmin Name: \t\t".$user."\n";
	}
if (isset($_SESSION['Student']))
	{
	$type="Student";
	$user=$_SESSION['Student'];
	echo "\tUser Type: \t\t".$type."\n\tStudent ID: \t".$user."\n";
	}
$location="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
echo "\tLocation: \t\t".$location;
echo "\n";
$ip=$_SERVER['REMOTE_ADDR'];
echo "\tIP: \t\t\t".$ip;
echo "\n";
$time= date("d.m.Y")." - ".date("h:i:s A",mktime(date("h")+3,date("i")+30,date("s")));
echo "\tTime: \t\t\t".$time;
echo "\n==================================================

-->\n";
mysql_select_db("Examination" ,$conn) or die("Error is ::".mysql_error());
/*$result=mysql_query("INSERT INTO History (Type,User,IP,Time,Location)
			 VALUES ('$type','$user','$ip','$time','$location')");
if (!$result)
	{
	echo mysql_error();
	}
*/	
?>
