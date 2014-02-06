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
		<link href="jumbotron.css" rel="stylesheet">
		
		<style>
			.custom {
				width: 130px;				
			}
			.customtablecell{
				width: 180px;
			}
		</style>
		
	</head>
	<script src="jsF/Ajax.js"></script>
	<link href="css/background.css" rel="stylesheet">
<script>
var arrayClub=new Array();
var arrayPlayer=new Array();
var arraySub=new Array();
arraySub[0]=-11;
arraySub[1]=-4;
var arrayPosition=new Array();
arrayPosition["Goalkeepers"]=-1;
arrayPosition["Defenders"]=-4;
arrayPosition["Midfielders"]=-4;
arrayPosition["Forwards"]=-2;
var arrayPositionSub=new Array();
arrayPositionSub["Goalkeepers"]=-1;
arrayPositionSub["Defenders"]=-1;
arrayPositionSub["Midfielders"]=-1;
arrayPositionSub["Forwards"]=-1;
function checkNum(obj) 
{ 	var re = /^[1-9]+(\.\d+)?$|^-?0(\.\d+)?$|^[1-9]+[0-9]*(\.\d+)?$/; 
	 if (!re.test(obj)) 
       return false; 
	return true;
}
	
function search(name,position,tname,costL,costU)
	{
		var name=name.value;
		var costL=costL.value.trim();
		var costU=costU.value.trim();
		var position=position.options[position.selectedIndex].value;
		var tname=tname.options[tname.selectedIndex].value;
		searchP(name,position,tname,costL,costU,1,"searchRes","",0);		
	}
function searchP(name,position,tname,costL,costU,page,res,sort,order)
	{
		if(name==""&&position==""&&tname==""&&costL==""&&costU=="")
		{
			document.getElementById("searchRes").innerText="You need to offer some search criteria!";
			return;
		}
		var st=String.fromCharCode(160);
		var tname=tname.replace(st," ");
		var url="searchPlayer.php?page="+page+"&name="+name+"&position="+position+"&tname="+tname;
		url=(sort=="")?url:url+"&sort="+sort+"&order="+order;
		if(costL!=""||costU!="")
			{
				if(costU=="")
					{
						if(!checkNum(costL)){
						document.getElementById("searchRes").innerText="Cost must be a nonnegtive number!";
						return;}
						else
						url=url+"&costL="+costL+"&costU=";
					}
				else if(costL=="")
				{
					{
						if(!checkNum(costU)){
						document.getElementById("searchRes").innerText="Cost must be a nonnegative number!";
						return;}
						else
						url=url+"&costU="+costU+"&costL=";
					}
				}
				else
				{
					if(!checkNum(costL)||!checkNum(costU)){
						document.getElementById("searchRes").innerText="Cost must be a nonnegtive number!";
						return;}
						else
						{
							if(parseFloat(costL)>parseFloat(costU))
							{
								document.getElementById("searchRes").innerText="Minimum cost cannot be bigger than maximum cost!";
								return;
							}
							else
							url=url+"&costL="+costL+"&costU="+costU;
						}
				}
				
			}
		else
		{
			url=url+"&costL=&costU=";
		}
		send_request(url,res,"GET");		
	}
	
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
	function remove1()
	{
		var check=playerChecked(document.getElementsByName('myPlayers'));
		if(!check)
		{
			alert("Error: Please select one player to be removed from your team!");
			return;
		}
		var objM=document.getElementById("M"+check);
		var money=document.getElementById('userInformation').rows[2].cells[1].innerText;
		money=parseFloat(money);

		money=(100*money+100*parseFloat(objM.cells[5].innerText))/100;

	var url="remove.php?&pid="+check+"&money="+money;
	if(confirm("Are you sure to remove this player?"))
		send_request(url,"resT","GET");
	
	arrayClub[objM.cells[3].innerText]-=1;
	arrayPlayer[check]=false;
	var tab=document.getElementById("M"+check);
	if(tab.cells[0].id=="1")
	{
	arrayPositionSub[objM.cells[2].innerText]-=1;
	arraySub[1]--;
	}
	else
	{
	arrayPosition[objM.cells[2].innerText]-=1;
	arraySub[0]--;	
	}
	}
	function add(obj)
	{
		var check=playerChecked(obj);
		if(!check)
		{
			alert("Error: Please select one player to add into your team!");
			return;
		}
		if(arrayPlayer[check]==true)
		{
			alert("You cannot have two identical players in your team!");
			return;
		}
		if(arraySub[0]>=0)
		{
			alert("Error: You have already got totally eleven starting players");
			return;
		}
		var objS=document.getElementById("S"+check);
		if(arrayPosition[objS.cells[2].innerText]>=0)
		{
			alert("Error: You have got enough "+objS.cells[2].innerText+"!");
			return;
		}
		if(arrayClub[objS.cells[3].innerText]>=3)
		{
			alert("You cannot have more than 3 players from the same club!");
			return;
		}
		var money=document.getElementById('userInformation').rows[2].cells[1].innerText;
		money=parseFloat(money);

		money=(100*money-100*parseFloat(objS.cells[4].innerText))/100;
		if(money<0)
		{
			alert("You do not have enough money!");
			return;
		}

	var url="add.php?&pid="+check+"&money="+money+"&sub=0";
	if(confirm("Are you sure you want this player?"))
		send_request(url,"resT","GET");
	
	if(arrayClub[objS.cells[3].innerText] === undefined) 
		arrayClub[objS.cells[3].innerText]=1; 
	else arrayClub[objS.cells[3].innerText]+=1;
	arrayPlayer[check]=true;
	arrayPosition[objS.cells[2].innerText]+=1;
	arraySub[0]++;
	}
	
	function addSub(obj)
	{
		var check=playerChecked(obj);
		if(!check)
		{
			alert("Error: Please select one player to add into your team!");
			return;
		}
		if(arrayPlayer[check]==true)
		{
			alert("You cannot have two identical players in your team!");
			return;
		}
		if(arraySub[1]>=0)
		{
			alert("Error: You have already got totally four substitutes!");
			return;
		}
		var objS=document.getElementById("S"+check);
		if(arrayPositionSub[objS.cells[2].innerText]>=0)
		{
			alert("Error: You have got enough "+objS.cells[2].innerText+"!");
			return;
		}
		if(arrayClub[objS.cells[3].innerText]>=3)
		{
			alert("You cannot have more than 3 players from the same club!");
			return;
		}
		var money=document.getElementById('userInformation').rows[2].cells[1].innerText;
		money=parseFloat(money);
		money=(100*money-100*parseFloat(objS.cells[4].innerText))/100;
		if(money<0)
		{
			alert("You do not have enough money!");
			return;
		}

	var url="add.php?&pid="+check+"&money="+money+"&sub=1";
	if(confirm("Are you sure you want this player?"))
		send_request(url,"resT","GET");
	
	if(arrayClub[objS.cells[3].innerText] === undefined) 
		arrayClub[objS.cells[3].innerText]=1; 
	else arrayClub[objS.cells[3].innerText]+=1;
	arrayPlayer[check]=true;
	arrayPositionSub[objS.cells[2].innerText]+=1;
	arraySub[1]++;
	}
	</script>
	
	<body>
		<div class="container">
		<!-- Modal -->
			<!-- To display the modal, generate the following hyperlink:
			<a data-toggle="modal" data-target="#playerinformation"> Player name </a>
			-->
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
				</div> <!-- End of row-->
			
				<div class="masthead"> <!-- Row 2 -->
				
					<ul class="nav nav-justified">
						<li><a href="homepage.php">Home</a></li>
						<li><a href="teammanagement.php">Manage My Team</a> </li>
						<li><a href="searchpage.php">Transfers</a></li>
						<li><a href="rankings.php">Rankings</a></li>
						<li><a href="changePW.php">Change Password</a></li>
						<li><a href="#" onclick="javascript: if (confirm('Are you sure to sign out?')) window.location.href='signout.php';">Sign-Out</a></li>		
					</ul>
				</div> <!-- End of Masthead div /End of Row 2-->
<div class = 'row'><br>	
<div class='col-md-5' id='resT'>
<?php
include_once("phpF/checkPage.php");
include_once "phpF/mysql.php";
$uid=$_SESSION["uid"];
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
	echo "<script>if(arrayClub['$row[3]'] === undefined) arrayClub['$row[3]']=1; else arrayClub['$row[3]']+=1; arrayPlayer['$row[0]']=true;arraySub[$row[9]]+=1;if($row[9]==1)arrayPositionSub['$row[2]']+=1; else arrayPosition['$row[2]']+=1;</script>";
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
	echo "<tr class=$style id='M{$row[0]}' >";
	echo "<td id='$row[9]'><input type='radio' name='myPlayers' id='myPlayers' value='" . $row[0] . "'></td>";
	$style="$row[1]:$row[2]:$row[3]:$row[4]:$row[5]:$s:$row[7]:$row[8]";
	echo "<td><a data-toggle='modal' title='view details of this player' href='#playerinformation' onclick='javascript:getPlayerInformation(\"$style\")'>" . $row[1] . "</a></td>";
	echo "<td>" . $row[2] . "</td>";
	echo "<td>" . $row[3] . "</td>";
	echo "<td>" . $row[4] . "</td>";
	echo "<td>" . $row[5] . "</td></tr>";
}
echo "</table>";
?>
</div>			
					
					<div class="col-md-2">
							<br><br><br><br><br><br><br><br><br><br>
							
							
							<center>
								<button type="button" class="btn btn-primary custom" href="#" id="add" name="add" onclick="add(document.getElementsByName('searchPlayers'))">
								<span class="glyphicon glyphicon-arrow-left"> </span>&nbsp; Add &nbsp;
								</button> 
							</center>
							<br>
							<br>
							<center>
								<button type="button" class="btn btn-primary custom" href="#" id="addsub" name="addsub" onclick="addSub(document.getElementsByName('searchPlayers'))">
								<span class="glyphicon glyphicon-arrow-left"> </span>&nbsp; Add Substitute &nbsp;
								</button> 
							</center>
							<br>
							<br>
							<center>
								<button type="button" class="btn btn-primary custom" href="#" id="remove" name="remove" onclick="remove1()">
								&nbsp; Remove &nbsp;<span class="glyphicon glyphicon-trash"></span>
								</button> 
							</center>
					</div>
					 
					<div class="col-md-5">
						<table cellpadding="5" >
							<tr>
								<td>
									<label class="control-label">Name</label>
								</td>
								<td>
									<input type="text" id="searchbyplayername" placeholder="Enter Player Name" class="customtablecell">
								</td>	
								<td>
								</td>
							</tr>
							
							<tr>
								<td>
									<label class="control-label">Position</label>
								</td>
										
								<td>
									<select id="searchbyplayerposition" class="selectpicker customtablecell">
										<option value='' selected>
										</option>
										<option value='Forwards'>Forward</option>
										<option value='Midfielders'>Midfield
										</option>
										<option value='Defenders'>Defender</option>
										<option value='Goalkeepers'>Goalkeeper
										</option>
									</select>
								</td>
								<td>
								</td>

							</tr>	
						
							<tr>
								<td>
									<label class="control-label">Club</label>
								</td>
								<td>	
									<select id="searchbyteamname" class="selectpicker customtablecell">
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
								</td>
								
							</tr><!-- Table row end for searchByTeam-->
							
							<tr><!-- Table row start for Cost based Search -->
								<td>
									<label class="control-label">Cost</label>
								</td>
								
								<td>
									<input type="text" id="searchbylowerlimit" placeholder="Enter Minimum Cost" class="customtablecell">
								</td>
								<td>
								
								</td>
							</tr>
							<tr>
								<td>
								
								</td>
								
								<td>
								<input type="text" id="searchbyupperlimit" placeholder="Enter Maximum Cost" class="customtablecell">
								</td>
								
								<td>
								<button type="button" name ="searchplayers" class="btn btn-primary" onClick=search(document.getElementById('searchbyplayername'),document.getElementById('searchbyplayerposition'),document.getElementById('searchbyteamname'),document.getElementById('searchbylowerlimit'),document.getElementById('searchbyupperlimit'))>Search</button>
								</td>
								
							</tr>
							<!-- Table row end for Cost based Search -->
							
												
						</table> <!-- End of Search Table -->
							<div id="searchRes">
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
	echo "<script>document.getElementById('remove').disabled=true</script>";
	echo "<script>document.getElementById('add').disabled=true</script>";
	echo "<script>document.getElementById('addsub').disabled=true</script>";
}
mysql_close($conn);
?>
	<script src="js/jquery-1.10.1.min.js"></script>
	<script src ="js/bootstrap.js"> </script>
</html>