<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<?php 
include_once("../phpF/checkPageA.php");
include_once "../phpF/calculation.php";
include_once "../phpF/mysql.php";
set_time_limit(0);
mysql_set_charset('ISO-8859-1',$conn);
$objDOM = new DOMDocument();
//$content = utf8_encode(file_get_contents('links.xml'));
$objDOM->load('links.xml'); //make sure path is correct

$note = $objDOM->getElementsByTagName("link");
  // for each note tag, parse the document and get values for
  // tasks and details tag.
mysql_query("BEGIN"); 
  foreach( $note as $value )
  {
    $player = $value->getElementsByTagName("name");
    $player_name  = $player->item(0)->nodeValue;
	$playername = addslashes(trim($player_name));

    $club = $value->getElementsByTagName("club");
    $club_name  = trim($club->item(0)->nodeValue);
	
	
	$points = $value->getElementsByTagName("points");
    $point_value  = trim($points->item(0)->nodeValue);
	$sql="update players set week_points=$point_value,timepoint=now() where playername=\"$playername\" and club='$club_name'";
	$result=mysql_query($sql) or die("database connection error!");
	calculation($playername,$club_name);	
  }
$sql="select users.uid,sum(players.week_points) from users,consists,players where users.uid=consists.uid and consists.playerid=players.playerid and sub=0 group by users.uid";
$result=mysql_query($sql) or die("database connection error!");
while($row=mysql_fetch_array($result))
{
	$sql1="update users set points=$row[1],total=total+$row[1] where uid=$row[0]";
	$result1=mysql_query($sql1) or die("database connection error!");
}
if($result)
{
	mysql_query("COMMIT");
}
else
{
	mysql_query("ROLLBACK");
	echo ("<font color=red>Something is wrong with the database system. Please re-try later.</font>");
	return;
}
mysql_query("END");
$flag=$_GET['flag'];
if($flag==0)
{
	$sql="insert into timedata(timepointS) values(now())";
	$result=mysql_query($sql) or die("Database connection error!");
}
else
{
$sql="update timedata set timepointS = now()";
$result=mysql_query($sql) or die("Database connection error!");
}
$sql="select timepointS from timedata";
$result=mysql_query($sql) or die("database connection error!");
$row=mysql_fetch_array($result);
echo "<div id='lastupdateonMS'>";
echo "You have updated players' information successfully!<br />Last Update on <font color=red>{$row[0]}</font></div><br />";
echo "<button type=\"button\" class=\"btn btn-primary custom\" href=\"#\" id=\"updatedatabase\" disabled onclick=\"javascript:updatePlayer(document.getElementById('updatedatabase').value);\">Update Stats</button>";
mysql_close($conn);  
?>
