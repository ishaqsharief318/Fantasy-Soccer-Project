<?php
include_once("phpF/checkPageA.php");
include_once "phpF/mysql.php";
$team=$_GET['team'];
$sql="select playerid,playername,availability from players where club='$team' order by position";
$result=mysql_query($sql) or die("database connection error!");
echo "<table class='table table-bordered table-condensed table-hover table-collapsed' id='teamTable'>";
echo "<tr><th> Player Name </th><th> Availability </th>";
while($row=mysql_fetch_array($result))
{
	echo "<tr><td>$row[1]</td>";
	if($row[2]==1)	
		echo "<td><input type='checkbox' name='playerAvail' id='$row[0]' checked></td>";
	else
		echo "<td><input type='checkbox' name='playerAvail' id='$row[0]'></td></tr>";
}
echo "</table>";
echo "<div id='displayresult'></div><br />";
echo "<button type='button' class='btn btn-primary custom' href='#' id='updateavailability' style='float:right' name='updateavailability' onclick=\"javascript:updateAvail(document.getElementsByName('playerAvail'));\"> Update </button>";
echo "<div id='floatclearer' style='clear:both'></div>";										
mysql_close($conn);
?>