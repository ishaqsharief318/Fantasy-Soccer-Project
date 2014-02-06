<?php
include_once("phpF/checkPage.php");
include_once "phpF/mysql.php";
$uid=$_SESSION["uid"];
$pidM=$_GET["pidM"];
$pidS=$_GET["pidS"];
mysql_query("BEGIN"); 
$sql="update consists set sub=1 where uid=$uid and playerid=$pidM";
$sql1="update consists set sub=0 where uid=$uid and playerid=$pidS";
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
echo "<div class='col-md-6 col-sm-6'><br />";
echo "<table class='table table-bordered table-condensed table-hover table-collapsed'>";
echo "<caption> <h4>Playing XI </h4></caption>";				
if (!isset($_SESSION["uid"]))
						{
						die("Your session has expired!");
						}
						$uid=$_SESSION["uid"];
						$sql="select players.playerid, playername, position, club, rating, cost, availability,week_points,accumulated,sub from players inner join consists on players.playerid=consists.playerid where uid = $uid order by sub,position";
						$result=mysql_query($sql) or die("database connection error!");
						echo "<tr class='active'>";
						echo "<th> </th>";
						echo "<th> Player name</th>";
						echo "<th> Position	</th>";
						echo "<th> Club </th>";
						echo "<th> Weekly Points </th>";
						echo "<th> Rating </th>";
						echo "</tr>";
						while($row=mysql_fetch_array($result))
						{
							
							if($row[9]!=1)
							{
								$style="success";
								if($row[6]==0)
								{
									$style="danger";
									$s="Not Good";
								}
								else
									$s="Good";
							echo "<tr class=$style id='M{$row[0]}'>";
							echo "<td><input type='radio' name='myPlayers' id='myPlayers' value='" . $row[0] . "'></td>";
							$style="$row[1]:$row[2]:$row[3]:$row[4]:$row[5]:$s:$row[7]:$row[8]";
							echo "<td><a data-toggle='modal' title='view details of this player' href='#playerinformation' onclick='javascript:getPlayerInformation(\"$style\")'>" . $row[1] . "</a></td>";
							echo "<td>" . $row[2] . "</td>";
							echo "<td>" . $row[3] . "</td>";
							echo "<td>" . $row[7] . "</td>";
							echo "<td>" . $row[4] . "</td></tr>";
							}
							else
							{
							echo "</table></div>";
							break;
							}
						}
						//mysql_data_seek($result,11);
						echo "<div class='col-md-3 col-sm-3'>";
						echo "<br>";
						echo "<table class='table table-bordered table-condensed table-hover table-collapsed'>";
						echo "<caption> <h4>Substitutes </h4> </caption>";
						echo "<tr class='active'>";
						echo "<th>	</th>";
						echo "<th> Player Name </th>";
						echo "<th> Position </th>";
						echo "<th> Rating </th></tr>";
							$style="warning";
							if($row[6]==0)
							{
								$style="danger";
								$s="Not Good";
							}
							else 
								$s="Good";
							echo "<tr class=$style id='S{$row[0]}'>";
							echo "<td><input type='radio' name='myPlayersS' id='myPlayersS' value='" . $row[0] . "'></td>";
							$style="$row[1]:$row[2]:$row[3]:$row[4]:$row[5]:$s:$row[7]:$row[8]";
							echo "<td><a data-toggle='modal' title='view details of this player' href='#playerinformation' onclick='javascript:getPlayerInformation(\"$style\")'>" . $row[1] . "</a></td>";
							echo "<td>" . $row[2] . "</td>";
							echo "<td>" . $row[4] . "</td></tr>";						
						while($row=mysql_fetch_array($result))
						{
							$style="warning";
							if($row[6]==0)
							{
								$style="danger";
								$s="Not Good";
							}
							else 
								$s="Good";
							echo "<tr class=$style id='S{$row[0]}'>";
							echo "<td><input type='radio' name='myPlayersS' id='myPlayersS' value='" . $row[0] . "'></td>";
							$style="$row[1]:$row[2]:$row[3]:$row[4]:$row[5]:$s:$row[7]:$row[8]";
							echo "<td><a data-toggle='modal' title='view details of this player' href='#playerinformation' onclick='javascript:getPlayerInformation(\"$style\")'>" . $row[1] . "</a></td>";
							echo "<td>" . $row[2] . "</td>";
							echo "<td>" . $row[4] . "</td></tr>";
						}
						echo "</table></br>";
echo "<button type='submit' class='btn btn-primary' onclick='swap()'>Swap</button></div>";					
mysql_close($conn);
?>