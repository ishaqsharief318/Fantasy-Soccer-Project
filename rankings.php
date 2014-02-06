<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">
		
		<title>Fantasy Football</title>

		<!-- Bootstrap core CSS -->
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="bootstrap/css/jumbo.css" rel="stylesheet">
		<link href="css/justified-nav.css" rel="stylesheet" type="text/css">	 
		<!-- Custom styles for this template -->
		
		
		<style>
			body{
			background: url('stadium2.jpg'); 
		background-size: 100% 100%;
    background-repeat: no-repeat;
			}
			.custom {
				width: 130px;
			}
			.customtablecell{
			width:180px;
			}
		</style>
		
	</head>
	<script src="jsF/Ajax.js"></script>
	<script>
		function getRankingInformation(str)
			{
				var str=str.split(":");
				for (var i in str) 
				{ 
					if(i<8)
					{
						document.getElementById('rankingInformationTable2').rows[Math.floor((i/2))+1].cells[(i%2)+1].innerText=str[i];
					}
					else
					{
						document.getElementById('rankingInformationTable1').rows[i-8].cells[1].innerText = str[i];
					}
				}		
			}
	</script>
	
	<body>
		<div class="container">
			
			
			<div class="row">
			
					<div class="col-md-4 col-sm-4 col-sm-4">
					
					
					</div>
				
					<div class="col-md-4 col-sm-4">
					<h1>Fantasy Football</h1>
					</div>
				
					<div class="col-md-4 col-sm-4">
					</div>
				</div> <!-- End of row-->
			
				<div class="masthead"> <!-- Row 2 -->
				
					<ul class="nav nav-justified">
						<li><a href="homepage.php">Home</a></li>
						<li><a  href="teammanagement.php">Manage My Team</a> </li>
						<li><a href="searchpage.php">Transfers</a></li>
						<li class='active'><a href="rankings.php">Rankings</a></li>
						<li><a href="changePW.php">Change Password</a></li>
						<li><a href="#" onclick="javascript: if (confirm('Are you sure to sign out?')) window.location.href='signout.php';">Sign-Out</a></li>		
					</ul>
				</div> <!-- End of Masthead div /End of Row 2-->
			
			
				<div class = "row"><!-- Row 3 start -->
					<div class="col-md-3 col-sm-3">
					<br>
					<table class="table table-bordered table-condensed table-hover table-collapsed">
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
						echo "<tr class='active'><th>Accumulated Points</th><td>$total</td></tr>";
						echo "<tr class='active'><th>Ranking</th><td>$ranking</td></tr>";
						echo "<tr class='active'><th>Money</th><td>$money</td></tr></table></div>";
					?>						
					
					
					
					<div class="col-md-8 col-sm-6">
					<br />
					<table class="table table-bordered table-condensed table-hover table-collapsed">
					<caption> <h4>Top Ranking</h4></caption>
					<tr class="active">
							<th> Ranking </th>
							<th> User name </th>
							<th> Team name </th>
							<th> Total Points </th>
						</tr>
					<?php
						if (!isset($_SESSION["uid"]))
						{
						die("Your session has expired!");
						}
						$uid=$_SESSION["uid"];
						$sql="select uid,username,teamname,total from users order by total desc,username asc limit 0,20";
						$result=mysql_query($sql) or die("database connection error!");
						$i=0;$j=1;$point;
						while($row=mysql_fetch_array($result))
						{
							$sqlG="select playername,week_points from consists, players where consists.playerid=players.playerid and uid=$row[0] and players.position='Goalkeepers' order by week_points desc limit 0,1";
							$sqlD="select playername,week_points from consists, players where consists.playerid=players.playerid and uid=$row[0] and players.position='Defenders' order by week_points desc limit 0,1";
							$sqlM="select playername,week_points from consists, players where consists.playerid=players.playerid and uid=$row[0] and players.position='Midfielders' order by week_points desc limit 0,1";
							$sqlF="select playername,week_points from consists, players where consists.playerid=players.playerid and uid=$row[0] and players.position='Forwards' order by week_points desc limit 0,1";
							$resultG=mysql_query($sqlG) or die("database connection error!");
							$resultD=mysql_query($sqlD) or die("database connection error!");
							$resultM=mysql_query($sqlM) or die("database connection error!");
							$resultF=mysql_query($sqlF) or die("database connection error!");
							$rowG=mysql_fetch_array($resultG);
							$rowD=mysql_fetch_array($resultD);
							$rowM=mysql_fetch_array($resultM);
							$rowF=mysql_fetch_array($resultF);
							if($i!=0&&$row['total']<>$point)
								{++$j;}
							++$i;
							$point=$row['total'];
							if ($row['uid']==$uid)
							{
								$style="success";
							}
							else
								$style="active";
							echo "<tr class=$style><td>$j</td>";
							$style="$rowG[0]:$rowG[1]:$rowD[0]:$rowD[1]:$rowM[0]:$rowM[1]:$rowF[0]:$rowF[1]:{$row['teamname']}:{$row['total']}";
							echo "<td><a data-toggle='modal' title='view details of this user' href='#userinformation' onclick='javascript:getRankingInformation(\"$style\")'>{$row['username']}</td>";
							echo "<td>{$row['teamname']}</td>";
							echo "<td>{$row['total']}</td></tr>";
						}
						mysql_close($conn);
					?>
						</table></div>
					<div class="modal fade" id="userinformation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title" id="myModalLabel">User Information</h4>
								</div>
							
								<div class="modal-body">
								<table class="table table-bordered table-condensed table-hover table-collapsed" id="rankingInformationTable1">
								<tr>
									<th> Team name </th>
									<td> name of the user's team </td>
								</tr>
									<th>Total points</th>
									<td> Total points of the user </td>
								</tr>
								</table>
								
								<table class="table table-bordered table-condensed table-hover table-collapsed" id="rankingInformationTable2">
									
									<tr class="active">
										<th> Position </th>
										<th> Player Name </th>
										<th> Weekly Points </th>
									</tr>
									
									<tr>
										<td> GoalKeeper </td>
										<td> Player Name </td>
										<td> Weekly Points </td>
									</tr>
									
									<tr>
										<td> Defender </td>
										<td> Player Name </td>
										<td> Weekly Points </td>
									</tr>
									
									<tr>
										<td> MidFielder </td>
										<td> Player Name </td>
										<td> Weekly Points </td>
									</tr>
									
									<tr>
										<td> Attacker </td>
										<td> Player Name </td>
										<td> Weekly Points </td>
									</tr>
								</table>
	   
								</div>
							
								<div class="modal-footer">
       
								</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->
					
					</div>
					
					<div class="col-md-1 col-sm-3">
					
					</div>
					 
										
				</div> <!-- End of Row 3 -->
			
		
		</div> <!-- End of main Container-->
	</body>

	<script src="js/jquery-1.10.1.min.js"></script>
	<script src ="js/bootstrap.js"> </script>
</html>