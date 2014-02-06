<?php
include_once("phpF/checkPageA.php");
include_once "phpF/mysql.php";

/*if(!isset($_SESSION['admin']))
{
	die("Your session has expired!");
}*/
?>
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
			/*background: url('stadium2.jpg'); */
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
	function checkScore(obj)
	{
		var re = /^\d+$/; 
	 if (!re.test(obj)) 
       return false; 
	return true;
	}
	
	function insertMatch(home,away,hscore,ascore,date)
	{
		var home=home.options[home.selectedIndex].value;
		var away=away.options[away.selectedIndex].value;
		var hscore=hscore.value.trim();
		var ascore=ascore.value.trim();
		var date=date.value.trim();
		if(home==""||away==""||date=="")
		{
			document.getElementById("displaymessage").innerHTML="<font color=red>Error: Please offer all the information!</font>";
			return;
		}
		if(!checkScore(hscore)||!checkScore(ascore))
		{
			document.getElementById("displaymessage").innerHTML="<font color=red>Error: Wrong Scores!</font>";
			return;
		}
		var url="insertMatch.php?home="+home+"&away="+away+"&hscore="+hscore+"&ascore="+ascore+"&date="+date;
		//alert (url);
		send_request(url,"displaymessage","GET");
	}
	function disTeam(obj)
	{
		var team=obj.options[obj.selectedIndex].value;
		if(team=="")
		{
		 document.getElementById("displayteam").innerHTML="<font color=red>Error: Please select a team!</font>";
		 return;
		}
		var url="disTeam.php?team="+team;
		send_request(url,"displayteam","GET");
	}
	function updateAvail(obj)
	{
		var url="updateAvail.php?leng="+obj.length;
		var str1,str2;
		for(var i=0;i<obj.length;++i)
		{
			str1="&p"+i+"="+obj[i].id;
			if(obj[i].checked)
			{
				str2="&a"+i+"=1";
			}
			else
				str2="&a"+i+"=0";
			url+=str1;
			url+=str2;
		}
		document.getElementById("displayresult").innerHTML="<font color=green>We are dealing with these changes......</font>";
		send_request(url,"displayresult","GET");
	}
	function updatePlayer(flag)
	{
		document.getElementById("lastupdateonMS").innerHTML="<font color=green>We are updating players......</font>";		
		send_request('updatePlayer/updatePlayer.php?flag='+flag,'lastupdateonS','GET');
		if(document.getElementById('transferavailability').value==2) 
			document.getElementById('transferavailability').value=0;
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
						<li class = "active"><a href="admin.php">Home</a></li>
						<li><a href="#" onclick="javascript: if (confirm('Are you sure to sign out?')) window.location.href='signout.php';">Sign-Out</a></li>	
					</ul>
				</div> <!-- End of Masthead div /End of Row 2-->
			
			<br>
				<div class = "row"><!-- Row 3 start -->
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Match Results</h3>
							</div>
							
							<div class="panel-body">
								<table cellpadding="5">
									<tr>
										<th class="custom"> Home Team </th>
										<td>	
											<select id="hometeam" class="selectpicker customtablecell">
												<option value='' selected>
												</option>
												<option value='Arsenal'>Arsenal	
												</option>
												<option value='Aston Villa'>Aston Villa	
												</option>
												<option value='Cardiff City'>Cardiff City	
												</option>
												<option value='Chelsea'>Chelsea	
												</option>
												<option value='Crystal Palace'>Crystal Palace	
												</option>
												<option value='Everton'>Everton
												</option>
												<option value='Fulham'>Fulham
												</option>
												<option value='Hull City'>Hull City
												</option>
												<option value='Liverpool'>Liverpool
												</option>
												<option value='Man City'>Manchester City
												</option>
												<option value='Man Utd'>	Manchester United	
												</option>
												<option value='Newcastle'>	Newcastle United	
												</option>
												<option value='Norwich'>	Norwich 	
												</option>
												<option value='Southampton'>	Southampton	
												</option>
												<option value='Stoke City'>	Stoke City	
												</option>
												<option value='Sunderland'>	Sunderland
												</option>
												<option value='Swansea'>	Swansea
												</option>
												<option value='Tottenham'>	Tottenham
												</option>
												<option value='West Brom'>	West Bromich Albion
												</option>
												<option value='West Ham'>	West Ham
												</option>
											</select>
										</td>
									</tr>
									<tr>
										<th> Away Team </th>
										<td>	
											<select id="awayteam" class="selectpicker customtablecell">
												<option value='' selected>
												</option>
												<option value='Arsenal'>Arsenal	
												</option>
												<option value='Aston Villa'>Aston Villa	
												</option>
												<option value='Cardiff City'>Cardiff City	
												</option>
												<option value='Chelsea'>Chelsea	
												</option>
												<option value='Crystal Palace'>Crystal Palace	
												</option>
												<option value='Everton'>Everton
												</option>
												<option value='Fulham'>Fulham
												</option>
												<option value='Hull City'>Hull City
												</option>
												<option value='Liverpool'>Liverpool
												</option>
												<option value='Man City'>Manchester City
												</option>
												<option value='Man Utd'>	Manchester United	
												</option>
												<option value='Newcastle'>	Newcastle United	
												</option>
												<option value='Norwich'>	Norwich 	
												</option>
												<option value='Southampton'>	Southampton	
												</option>
												<option value='Stoke City'>	Stoke City	
												</option>
												<option value='Sunderland'>	Sunderland
												</option>
												<option value='Swansea'>	Swansea
												</option>
												<option value='Tottenham'>	Tottenham
												</option>
												<option value='West Brom'>	West Bromich Albion
												</option>
												<option value='West Ham'>	West Ham
												</option>
											</select>
										</td>
									</tr>
									
									<tr>
										<th> Score </th>
										<td>
											<input type="text" class="customtablecell" name="scoreHome" id="scoreHome" 
											placeholder="Home Score" style="width:90px;">
											<input type="text" class="customtablecell" name="scoreAway" id="scoreAway" 
											placeholder="Away Score" style="width:90px;">
										</td>
									</tr>
									
									<tr>
										<th> Date </th>
										<td>
											<input type="date" class="customtablecell" name="date" id="date">
										</td>
									</tr>
								</table>
								<br>
								<div id="displaymessage">
								
								
								</div>
								<br />							
								<button type="button" class="btn btn-primary custom" href="#" id="insertmatch" "name="insertmatch" onclick="javascript:insertMatch(document.getElementById('hometeam'),document.getElementById('awayteam'),document.getElementById('scoreHome'),document.getElementById('scoreAway'),document.getElementById('date'));">Insert Match</button>	
							</div>
						</div>
						
					</div>
					
					<div class="col-md-5">
						
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Player Availability</h3>
							</div>
							<div class="panel-body">
								<table cellpadding="5">
									<tr>
										<th style="width:80px;"> Team </th>
										<td>	
											<select id="team" class="selectpicker customtablecell">
												<option value='' selected>
												</option>
												<option value='Arsenal'>Arsenal	
												</option>
												<option value='Aston Villa'>Aston Villa	
												</option>
												<option value='Cardiff City'>Cardiff City	
												</option>
												<option value='Chelsea'>Chelsea	
												</option>
												<option value='Crystal Palace'>Crystal Palace	
												</option>
												<option value='Everton'>Everton
												</option>
												<option value='Fulham'>Fulham
												</option>
												<option value='Hull City'>Hull City
												</option>
												<option value='Liverpool'>Liverpool
												</option>
												<option value='Man City'>Manchester City
												</option>
												<option value='Man Utd'>	Manchester United	
												</option>
												<option value='Newcastle'>	Newcastle United	
												</option>
												<option value='Norwich'>	Norwich 	
												</option>
												<option value='Southampton'>	Southampton	
												</option>
												<option value='Stoke City'>	Stoke City	
												</option>
												<option value='Sunderland'>	Sunderland
												</option>
												<option value='Swansea'>	Swansea
												</option>
												<option value='Tottenham'>	Tottenham
												</option>
												<option value='West Brom'>	West Bromich Albion
												</option>
												<option value='West Ham'>	West Ham
												</option>
											</select>
										</td>
										
										<td>
											<button type="button" class="btn btn-primary custom" href="#" id="searchteam" name="searchteam" onclick="javascript:disTeam(document.getElementById('team'));"> Display Team </button>
										</td>
									</tr>
								</table>	
								<br>
								<div id="displayteam">
									<!-- This is where ajax prints the selected team with player names -->
									
									<div id ="displayresult">
									
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class ="col-md-3">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Transfers Availability Option</h3>
							</div>
							<div class="panel-body" id="lastupdateon">
							<div id="lastupdateonM">

							</div>
							<br />
								<button type="button" class="btn btn-primary custom" href="#" id="transferavailability" value=0 onclick="javascript:send_request('changePage.php?flag='+this.value,'lastupdateon','GET');document.getElementById('updatedatabase').value=1">Disable Transfers</button>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Transfers Availability Option</h3>
							</div>
							<div class="panel-body" id="lastupdateonS">
							<div id="lastupdateonMS">

							</div>
							<br />
								<button type="button" class="btn btn-primary custom" href="#" id="updatedatabase" onclick="javascript:this.disabled=true;updatePlayer(document.getElementById('updatedatabase').value);">Update Stats</button>
							</div>
						</div>
						
					</div>
				</div>
				
				</div> <!-- End of Row 3 -->
				
				
		
		</div> <!-- End of main Container-->
	</body>
	<?php
	$sql="select * from timedata where timepoint<>'0000-00-00 00:00:00'";
	$result=mysql_query($sql) or die("database connection error!");
	if(mysql_num_rows($result)<1)
	{
		echo "<script>document.getElementById('lastupdateonM').innerHTML='You have no update information.';document.getElementById('transferavailability').value=2</script>";
	}
	else
	{
		$row=mysql_fetch_array($result);
		if($row['access'])
			echo "<script>document.getElementById('lastupdateonM').innerHTML='Last Update on <font color=red>{$row[1]}</font>.';document.getElementById('transferavailability').innerText='Disable Transfers';document.getElementById('transferavailability').value=0</script>";
		else
			echo "<script>document.getElementById('lastupdateonM').innerHTML='Last Update on <font color=red>{$row[1]}</font>.';document.getElementById('transferavailability').innerText='Enable Transfers';document.getElementById('transferavailability').value=1</script>";
	}
	$sql="select timepointS from timedata where timepointS<>'0000-00-00 00:00:00'";
	$result=mysql_query($sql) or die("database connection error!");
	if(mysql_num_rows($result)<1)
	{
		echo "<script>document.getElementById('lastupdateonMS').innerHTML='You have no update information.';document.getElementById('updatedatabase').value=0</script>";
	}
	else
	{
		$row=mysql_fetch_array($result);
		echo "<script>document.getElementById('lastupdateonMS').innerHTML='Last Update on <font color=red>{$row[0]}</font>.';document.getElementById('updatedatabase').value=1</script>";
	}
	?>
	<script src="js/jquery-1.10.1.min.js"></script>
	<script src="jsF/Ajax.js"></script>
	<script src ="js/bootstrap.js"> </script>
</html>