<?php
include_once("phpF/checkPage.php");
include_once "phpF/mysql.php";
$uid=$_SESSION['uid'];
$newP=$_GET['newP'];
$oldP=$_GET['oldP'];
if (strlen( $newP) > 20 || strlen($newP) < 4)
	 {
		echo '<font color=red>Incorrect Length for Password</font>';
		return;
	 }
if (ctype_alnum($newP) != true)
	 {
		echo "<font color=red>Password must be alpha numeric</font>";
		return;
	 }
$sql="update users set password = md5('$newP') where uid=$uid and password=md5('$oldP')";
$result=mysql_query($sql) or die("database connection error!");
if(mysql_affected_rows()>0)
	echo "<font color=green>Change successfully!</font>";
else
	echo "<font color=red>Not Change successfully!</font>"
?>