<?php
include_once("phpF/checkPageA.php");
include_once("phpF/mysql.php");
$home=trim($_GET["home"]);
$away=trim($_GET["away"]);
$hscore=trim($_GET["hscore"]);
$ascore=trim($_GET["ascore"]);
$date=trim($_GET["date"]);
$sql="insert into matches(real_team_home,real_team_away,match_day,score) values('$home','$away','$date','$hscore:$ascore')";
$result=mysql_query($sql) or die("Database connection error!");
echo "You have successfully inserted the match $home $hscore:$ascore $away";
mysql_close($conn);
?>