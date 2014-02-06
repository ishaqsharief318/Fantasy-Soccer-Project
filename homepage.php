<html>
	<head>
	
	<title>Fantasy League Football</title>
	<meta charset="utf-8">
	<link rel ="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">	
	<link href="css/justified-nav.css" rel="stylesheet" type="text/css">	 
		 <style type="text/css">
			body{
			
			}
			table { 
			table-layout: fixed; 
			}
			table th, table td {
			overflow: hidden;
			}
			
		</style>
	<script>
	function getPlayerInformation(str)
	{
		var str=str.split(":");
		for (var i in str) 
		{ 
			if(i==5)
			{
				if(str[i]=="Good")
				{
					document.getElementById('playerInformationTable').rows[i].cells[1].style.color="green";
				}
				else
				{
					document.getElementById('playerInformationTable').rows[i].cells[1].style.color="red";
				}
			}
			document.getElementById('playerInformationTable').rows[i].cells[1].innerText = str[i];
		}
		
	}
	</script>
	</head>

	<body>
		<script src="js/jquery-1.10.1.min.js"></script>
		<script src ="js/bootstrap.js"></script>
		<div class="container">
		<div class="modal fade" id="playerinformation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="forgotpassword" style="text-align:center;">Player Information</h4>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		
						</div>
			
						<div class="modal-body">
							<table class="table table-bordered table-condensed table-hover" id="playerInformationTable">
								<tr>
									<th> Player Name</th>
									<td>Name of Player</td>
								</tr>
								
								<tr>
									<th> Position</th>	
									<td>Player Position</td>
								</tr>
								
								<tr>
									<th>Club</th>
									<td>Name of Club</td>
								</tr>
								<tr>
									<th>Rating</th>
									<td>Player Rating</td>
								</tr>								
								<tr>
									<th> Cost</th>
									<td>Cost of Player</td>
								</tr>
				
								<tr>
								<th> Fitness</th>
								<td>display Availability</td>
								</tr>
								<tr>
									<th> Weekly Points Obtained</th>
									<td> Points of Player</td>
								</tr>
				
								<tr>
									<th>Accumulated Points</th>	
									<td>Overall Points</td>
								</tr>

							</table>
						</div>
			
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
			  
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
			<div class="row">
		
				<div class="col-md-4">
				</div>
			
				<div class="col-md-4">
				<h1>Fantasy Football</h1>
				</div>
			
				<div class="col-md-4">
				</div>
			</div>
			
			<div class="masthead">
			
					<ul class="nav nav-justified">
						<li class="active">
							<a href="homepage.php">Home</a></li>
							<li><a href="teammanagement.php">Manage My Team</a> </li>
							<li><a href="searchpage.php">Transfers</a></li>
							<li><a href="rankings.php">Rankings</a></li>
							<li><a href="changePW.php">Change Password</a></li>
							<li><a href="#" onclick="javascript: if (confirm('Are you sure to sign out?')) window.location.href='signout.php';">Sign-Out</a></li>						
					</ul>
			</div>
			<br>
			<div class="row">
				<div class="col-md-3">
    
    		<table class="table table-bordered table-condensed table-hover" style="background-color:white">
 					<caption> <h4>User Statistics</h4></caption>
					<?php
						include_once("phpF/checkPage.php");
						include_once "phpF/mysql.php";
						$uid=$_SESSION["uid"];
						$ranking=$_SESSION['ranking'];
						$sql="select * from users where uid=$uid";
						$res=mysql_query($sql) or die("database connection error!");
						$row=mysql_fetch_array($res);
						$uname=$row["username"];
						$money=$row["money"];
						$teamname=$row["teamname"];
						$wpoints=$row['points'];
						$total=$row['total'];
						echo "<tr class='active'><th>User Name</th><td>$uname</td></tr>";
						echo "<tr class='active'><th>Team Name</th><td>$teamname</td></tr>";
						echo "<tr class='active'><th>Weekly Points</th><td>$wpoints</td></tr>";
						echo "<tr class='active'><th>Total Points</th><td>$total</td></tr>";
						echo "<tr class='active'><th>Ranking</th><td>$ranking</td></tr>";
						echo "<tr class='active'><th>Money</th><td>$money</td></tr>";
					?>				
				</table></div>
				<div class="col-md-5">
				<table class="table table-bordered table-condensed table-hover table-collapsed">
					<caption> <h4> My Players </h4></caption>
					<?php
						$uid=$_SESSION["uid"];
						$sql="select players.playerid, playername, position, club, rating, cost, availability,week_points,accumulated,sub from players inner join consists on players.playerid=consists.playerid where uid = $uid order by sub,position";
						$result=mysql_query($sql) or die("database connection error!");
						echo "<tr class='active'>";
						echo "<th> Player name </th>";
						echo "<th> Position	</th>";
						echo "<th> Weekly Points </th>";
						echo "</tr>";
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
						echo "<tr class=$style>";
						$style="$row[1]:$row[2]:$row[3]:$row[4]:$row[5]:$s:$row[7]:$row[8]";
						echo "<td><a data-toggle='modal' title='view details of this player' href='#playerinformation' onclick='javascript:getPlayerInformation(\"$style\")'>" . $row[1] . "</a></td>";
						echo "<td>" . $row[2] . "</td>";
						echo "<td>" . $row[7] . "</td></tr>";
						}
					?>
				</table>
				</div>
			
				<div class="col-md-4">
						<table class="table table-bordered table-condensed table-hover table-collapsed" style="background-color:white">
						<caption> <h4> Recent Matches </h4></caption>
						<?php
						$sql="select match_day, real_team_home, real_team_away, score from matches where datediff(current_date,match_day)<=7 order by match_day desc limit 0, 20";
						$result=mysql_query($sql) or die("database connection error!");
						echo "<tr>";
						echo "<th class='col-sm-2'> Date </th>";
						echo "<th class='col-sm-2'> Home Team </th>";
						echo "<th class='col-sm-1'> Score </th>";
						echo "<th class='col-sm-2'> Away Team </th>";
						echo "</tr>";
						while($row=mysql_fetch_array($result))
						{
							echo "<td> $row[0] </td>";
							echo "<td> $row[1] </td>";
							echo "<td> $row[3] </td>";
							echo "<td> $row[2] </td></tr>";
						}
						?>
					</table>
				
				</div>
			
			</div>
	
		</div>
	</body>
	
</html>