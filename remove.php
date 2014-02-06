<?php
include_once("phpF/checkPage.php");
include_once "phpF/mysql.php";
$uid=$_SESSION["uid"];
$pid=$_GET["pid"];
$moneyNew=$_GET["money"];
mysql_query("BEGIN"); 
$sql="delete from consists where playerid=$pid";
$sql1="update users set money=$moneyNew where uid=$uid";
$res=mysql_query($sql) or die("database connection error!");
$res1=mysql_query($sql1) or die("database connection error!");
if($res && $res1)
{
	mysql_query("COMMIT");
}
else
{
	mysql_query("ROLLBACK");
	die("Something is wrong with the database system. Please re-try later. ");
}
mysql_query("END");
$sql="select username,money,teamname from users where uid=$uid";
$res=mysql_query($sql) or die("database connection error!");
if(mysql_num_rows($res)<1)
	die("Something is wrong with the database system. Please re-try later!");
$row=mysql_fetch_array($res);
$uname=$row["username"];
$money=$row["money"];
$teamname=$row["teamname"];
$sql="select players.playerid, playername, position, club, rating, cost, availability,week_points,accumulated,sub from players inner join consists on players.playerid=consists.playerid where uid = $uid order by sub,position";
$result=mysql_query($sql) or die("database connection error!");
echo "<table class='table table-bordered table-condensed table-hover table-collapsed' id='userInformation'>";
echo "<tr class='active'><th> User name :</th><td>$uname</td></tr><tr class='active'><th> Team name:</th><td>$teamname</td></tr>";
echo "<tr class='active'><th> Money :</th><td>$money</td></tr></table><br>";
echo "<table class='table table-bordered table-condensed table-hover table-collapsed'>";
echo "<tr><th> </th><th>Player name</th><th>Position</th><th>Club</th><th>Rating</th><th>Cost</th></tr>";
while($row=mysql_fetch_array($result))
{
	if($row[6]==0)
	{
		$style="danger";
		$s="Not Good";
	}
	else 
	{$s="Good";
	if($row[9]==1)
		$style="warning";
		else
		$style="success";}
	echo "<tr class=$style id='M{$row[0]}'>";
	echo "<td id='$row[9]'><input type='radio' name='myPlayers' id='myPlayers' value='" . $row[0] . "'></td>";
	$style="$row[1]:$row[2]:$row[3]:$row[4]:$row[5]:$s:$row[7]:$row[8]";
	echo "<td><a data-toggle='modal' title='view details of this player' href='#playerinformation' onclick='javascript:getPlayerInformation(\"$style\")'>" . $row[1] . "</a></td>";
	echo "<td>" . $row[2] . "</td>";
	echo "<td>" . $row[3] . "</td>";
	echo "<td>" . $row[4] . "</td>";
	echo "<td>" . $row[5] . "</td></tr>";
}
echo "</table>";
mysql_close($conn);
?>