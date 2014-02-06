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
	function playerChecked(obj)
	{
		if(obj==null)
			return false;
		for (var i=0;i<obj.length;++i)
		{
		if(obj[i].checked)
		{
			return  obj[i].value;
		}
		}
		return false;
	}
	function swap()
	{
		var check1=playerChecked(document.getElementsByName('myPlayers'));
		var check2=playerChecked(document.getElementsByName('myPlayersS'));
		if(!(check1&&check2))
		{
			alert("Error: Please select two players for your swap!");
			return;
		}
		var objM=document.getElementById("M"+check1);
		var objS=document.getElementById("S"+check2);
		if(objM.cells[2].innerText!=objS.cells[2].innerText)
		{

			alert("You can only swap players of the same position!");
			return;
		}
	var url="swap.php?pidM="+check1+"&pidS="+check2;
	if(confirm("Are you sure you want this swap?"))
		send_request(url,"res","GET");
	}
	</script>
	
	<body>
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
						<li class = "active"><a  href="teammanagement.php">Manage My Team</a> </li>
						<li><a href="searchpage.php">Transfers</a></li>
						<li><a href="rankings.php">Rankings</a></li>
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
						if(mysql_num_rows($res)<1)
							die("Something is wrong with the database system. Please re-try later!");
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
						echo "<tr class='active'><th>Money</th><td>$money</td></tr></table></div>";
					?>
					
					<div id="res">
					
					<div class="col-md-6 col-sm-6">
						
						<br>
					<table class="table table-bordered table-condensed table-hover table-collapsed">
					<?php
						$uid=$_SESSION["uid"];
						$sql="select players.playerid, playername, position, club, rating, cost, availability,week_points,accumulated,sub from players inner join consists on players.playerid=consists.playerid where uid = $uid order by sub,position";
						$result=mysql_query($sql) or die("database connection error!");
						if(mysql_num_rows($result)>0)
						{
						echo "<caption> <h4>Playing XI </h4></caption>";
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
						echo "<button type='submit' class='btn btn-primary' id='swap' onclick=\"javascript:swap();\">Swap</button>";
						}
						else
						{
						echo "You have no players now. Pick someone and have fun!";
						echo "</table></br>";
						}
						
					?>
						
					</div>
				</div>
					 
										
				</div> <!-- End of Row 3 -->
			
		
		</div> <!-- End of main Container-->
	</body>
<?php
$sql="select access from timedata";
$result=mysql_query($sql) or die("database connection error!");
$row=mysql_fetch_array($result);
if(!$row[0])
{
echo "<script>document.getElementById('swap').disabled=true</script>";
}
mysql_close($conn);
?>
	<script src="js/jquery-1.10.1.min.js"></script>
	<script src ="js/bootstrap.js"> </script>
</html>