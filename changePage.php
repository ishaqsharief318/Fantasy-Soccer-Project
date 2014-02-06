<?php
include_once("phpF/checkPageA.php");
include_once("phpF/mysql.php");
$flag=$_GET['flag'];
if($flag==2)
{
	$sql="insert into timedata(access,timepoint) values(0,now())";
	$result=mysql_query($sql) or die("Database connection error!");
}
else
{
$sql="update timedata set access = $flag,timepoint=now()";
$result=mysql_query($sql) or die("Database connection error!");
}
$sql="select * from timedata";
$result=mysql_query($sql) or die("database connection error!");
$row=mysql_fetch_array($result);
if($flag==1)
{
echo "<div id='lastupdateonM'>";
echo "You have successfully enable the transfer page!<br />Last Update on <font color=red>{$row[1]}</font>.</div><br />";
echo "<button type='button' class='btn btn-primary custom' href='#' id='transferavailability' value=0 onclick=\"javascript:send_request('changePage.php?flag='+this.value,'lastupdateon','GET');document.getElementById('updatedatabase').value=1;\">Disable Transfers</button>";
}							
else
{
echo "<div id='lastupdateonM'>";
echo "You have successfully disable the transfer page!<br />Last Update on <font color=red>{$row[1]}</font>.</div><br />";
echo "<button type='button' class='btn btn-primary custom' href='#' id='transferavailability' value=1 onclick=\"javascript:send_request('changePage.php?flag='+this.value,'lastupdateon','GET');document.getElementById('updatedatabase').value=1;\">Enable Transfers</button>";
}
mysql_close($conn);
?>