<?php
require_once('main_header.php');
if (!isset($_SESSION['Admin']))
	{
	header('Location: index.php');
	}
?>
<table width="100%" id='adminhead' >
<tr>
<td ><a id='nav1' class='nav' onclick="color(1);" target='admincontent' href='Newexam.php'>Create New Exam</a></td>
<td ><a id='nav2' class='nav' onclick="color(2);" target='admincontent' href='Examdata.php' >Exam Details</a></td>
<td ><a id='nav3' class='nav' onclick="color(3);" target='admincontent' href='Deleteexam.php' >Remove Exam</a></td>
<td ><a id='nav4' class='nav' onclick="color(4);" target='admincontent' href='Postnotification.php' >Notifications</a></td>
</tr>
</table>
<iframe id='admincontent'  src='Examdata.php' name='admincontent' ></iframe>

<script type='text/javascript' >
function color(x)
{
for (var i=1;i<=4;i++)
{
var navhead=document.getElementById('nav'+i);
if (i==x)
{
navhead.style.color='#fff';
navhead.style.backgroundColor='#555';
navhead.style.borderColor='#ddd';
}
else
{
navhead.style.color='#000';
navhead.style.backgroundColor='#eef';
navhead.style.borderColor='#555';
}
}
}
color(2);
</script>
</body>
</html>