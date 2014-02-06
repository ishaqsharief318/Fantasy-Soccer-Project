<?php
include_once("phpF/checkPage.php");
include_once "phpF/mysql.php";
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
	function changePW(oP,nP,nPa)
	{
		if(oP==""||nP==""||nPa=="")
		{
		document.getElementById("displaymessage").innerHTML="<font color=red>Error: Please offer all the information!</font>"
		return;
		}
		if(nP!=nPa)
		{
		document.getElementById("displaymessage").innerHTML="<font color=red>Error: The new passwords are not the same!</font>"
		return;
		}
		var url="changePassword.php?newP="+nP+"&oldP="+oP;
		send_request(url,"displaymessage","GET");
		document.getElementById("Opassword").value='';
		document.getElementById("Npassword").value='';
		document.getElementById("NpasswordA").value='';
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
						<li><a href="rankings.php">Rankings</a></li>
						<li class='active'><a href="changePW.php">Change Password</a></li>
						<li><a href="#" onclick="javascript: if (confirm('Are you sure to sign out?')) window.location.href='signout.php';">Sign-Out</a></li>		
					</ul>
				</div> <!-- End of Masthead div /End of Row 2-->
			
			<br>
				<div class = "row"><!-- Row 3 start -->
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Change Password</h3>
							</div>
							
							<div class="panel-body">
								<table cellpadding="5">
									<tr>
										<th class="custom"> Old Password </th>
										<td>	
											<input type="password" class="customtablecell" name="Opassword" id="Opassword" 
											placeholder="Old Password">
										</td>
									</tr>
									<tr>
										<th> New Password </th>
										<td>	
											<input type="password" class="customtablecell" name="Npassword" id="Npassword" 
											placeholder="New Password">
										</td>
									</tr>
									
									<tr>
										<th> Confirm </th>
										<td>
											<input type="password" class="customtablecell" name="NpasswordA" id="NpasswordA" 
											placeholder="Re-type New Password">
										</td>
									</tr>
								</table>
								<div id="displaymessage">
								
								
								</div>
								<?php						
								echo "<button type='button' class='btn btn-primary custom' href='#' id='changePW' name='changePW' onclick=\"javascript:changePW(document.getElementById('Opassword').value,document.getElementById('Npassword').value,document.getElementById('NpasswordA').value);\">Change</button>";	
								?>
							</div>
						</div>
						
					</div>
				
							
					</div>
				</div>
	</body>
	<script src="js/jquery-1.10.1.min.js"></script>
	<script src="jsF/Ajax.js"></script>
	<script src ="js/bootstrap.js"> </script>
</html>