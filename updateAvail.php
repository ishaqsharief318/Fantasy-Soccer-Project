<?php
include_once("phpF/checkPageA.php");
include_once("phpF/mysql.php");
$leng=$_GET['leng'];
for($i=0;$i<$leng;++$i)
{
	$t1="p$i";
	$t2="a$i";
	$sql="update players set availability = $_GET[$t2] where playerid='$_GET[$t1]'";
	$result=mysql_query($sql) or die("Database connection error!");
}
echo "<font color=green>You have successfully change the player's availability!</font>";
mysql_close($conn);
?>