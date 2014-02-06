 <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

    <title>Fantasy Football</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="bootstrap/css/jumbo.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="jumbotron.css" rel="stylesheet">

    	<script src="js/jquery.min.js"></script>
		<script src="jsF/Ajax.js"></script>
<script>	
$(document).on('click','#usernameradio',function()
{
	  $("#emailtext").prop("disabled", true);
	  $("#usernametext").prop("disabled", false);
	  $("#emailtext").prop("value","");
})

$(document).on('click','#emailradio',function()
{
	  $("#emailtext").prop("disabled", false);
	  $("#usernametext").prop("disabled", true);
	  $("#usernametext").prop("value","");
})


$(document).on('hidden','#forgotPassword',function () 
{
	restorePage();
})

//these are some javascript tools.
function getQuestion(userName,email)
{
	var flag,user,url;
	if(userName.disabled)
	{
		flag=0;
		user=email.value;
	}
	else
	{
		flag=1;
		user=userName.value;
	}
	
	url="getQuestion.php?"+"flag="+flag+"&user="+user;
	send_request(url,"res","GET");
}

function matchAnswer(aText)
{
	url="matchAnswer.php?"+"answer="+aText;
	document.getElementById("res").innerHTML="<font color='green'>Your request is now under processing. It may take several seconds. We appreciate your patience... </font>";
	send_request(url,"res","GET");
}

function restorePage()
{
	var str="<div class='modal-body'><table><tr><td><input type='radio'  name='entry' id='usernameradio' value='usernameradio' checked>";
	str+="<label>Username</label></td>";
	str+="<td><input type='text' class='span2' id='usernametext'></td></tr> <tr><td><input type='radio' name='entry' id='emailradio' value='emailradio'>";
	str+="<label>Email</label></td><td><input type='email' class='span2' id='emailtext' disabled></td></tr></table></div>";
	str+="<div class='modal-footer'><button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>";
	str+="<button type='button' name ='submitfinal' class='btn btn-primary' onclick=javascript:getQuestion(document.getElementById('usernametext'),document.getElementById('emailtext'))>Submit</button></div>"
	document.getElementById("res").innerHTML= str;
}								 					

function getQuestionU(email)
{
	url="getQuestionU.php?"+"email="+email;
	send_request(url,"resU","GET");
}

function matchAnswerU(aText)
{
	url="matchAnswerU.php?"+"answer="+aText;
	document.getElementById("resU").innerHTML="<font color='green'>Your request is now under processing. It may take several seconds. We appreciate your patience... </font>";
	send_request(url,"resU","GET");
}

function restorePageU()
{
	var str=" <div class='modal-body'><table><tr><td><label>Email</label></td><td><input type='email' class='span2' id='usertext'></td></tr></table></div>";
	str+="<div class='modal-footer'><button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>";
	str+="<button type='button' name ='subfinal' class='btn btn-primary' onclick=javascript:getQuestionU(document.getElementById('usertext').value)>Submit</button></div>";
	document.getElementById("resU").innerHTML= str;
}						 								 						
</script>
<script src ="js/bootstrap.js"> </script>
<style>
.modal-content{
width:700px;
}
#flip1,#flip2,#flip3, #flip4
		{
			padding:10px;
			background-color: #006abc;
		}
	#panel1,#flip1,#panel2,#flip2,#panel3,#flip3,#panel4,#flip4
		{
			padding:5px;
			text-align:left;
			border:solid 1px #c3c3c3;
			border-radius:10px;
		}
	#panel1,#panel2,#panel3,#panel4
		{
			background-color: #f3f3f3;
			padding:10px;
			display:none;
		}
	.reducewidth
		{	
	margin-top:-50px;
		}

</style>
  </head>

  <body>
<?php

/*** begin our session ***/
session_start();
if(isset($_SESSION['uid']))
	{
		echo"<script>window.location.href='homepage.php'</script>";
	}
/*** set a form token ***/
$form_token = md5( uniqid('auth', true) );

/*** set the session form token ***/
$_SESSION['form_token'] = $form_token;
?>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Fantasy Football</a>
        </div>
        <div class="navbar-collapse collapse">
          <form class="navbar-form navbar-right" method="post" action="checkuser.php" name="login_form">
            <div class="form-group">
               <input type="text" placeholder="Username" name ="username_reg" id="username_reg" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" name="password_reg" id="password_reg" class="form-control">
            </div>
            <input type="hidden" name="action" value="submit" />
            <button type="submit" class="btn btn-success">Sign in</button>			 
			<a data-toggle="modal" href="#forgotPassword" id="fpass" onclick=restorePage()>ForgotPassword</a> &nbsp;
			<a data-toggle="modal" href="#forgotUsername" id="fuser" onclick=restorePageU()>Forgot Username</a> &nbsp;
			<a href="adminLogin.php" align="center">Admin </a><span class="clearfix"></span>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </div>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>Fantasy Football</h1>
        <p>Bring out the football manager in you!</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
        <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Register &raquo;
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">New User Registration</h4>
      </div>
      <div class="modal-body">
       <form class="form-inline" form id="new_user" method="post" action="newuseradd.php" name="check_form">
		<span id="formerror" class="error"></span>
              <p><input type="text" class="span2" maxlength = "20" name="firstname" required id="firstname" placeholder="First Name" pattern = "[A-Za-z]{0,10}" title = "Cannot contain Numbers"></p>
			  <p><input type="text" class="span2" maxlength = "20" name="lastname" required id="lastame" placeholder="Last Name" pattern = "[A-Za-z]{0,10}" title = "Cannot Contain Numbers"></p>
			  <p><input type="text" class="span2" maxlength = "20" name="username" required id="username" placeholder="Username" min = "3" title = "Should be Alpha numeric">
			  <input type='button' class="btn btn-success btn-mini" id='check_username_availability' value='Check Availability'></p>
			  <div id='username_availability_result'></div> 
			  <p class="help-block" style="font-size:12px"> Username should be between 4-20 characters long. must be alpha numeric</p>
              <p><input type="password" class="span2" name="password" placeholder="Password"></p>
			  <p class="help-block" style="font-size:12px"> Password must be between 4-20 characters long. Must be alpha-numeric</p>
			  <p><input type="password" class="span2" name="password_conf" placeholder="Re - Enter Password"></p>
			  <p><input type="email" class="span4" name="emailid" required id="emailid" placeholder="Email ID"></p>
			  <p><input type="text" class="span2" name="team_name" required id="team_name" placeholder="Team name"></p>
			  <p class="help-block" style="font-size:12px"> Select your Unique team name.
			  <input type='button' class="btn btn-success btn-mini" id='check_teamname_availability' value='Check Availability'></p>
			  <div id='teamname_availability_result'></div>
			  <p>
                  <select name="secret_question" id="secret_question">
					<option checked>Select one of the below ....</option>
                     <option value ="0">The name of the city where you were born</option>
                     <option value ="1">The name of your first pet</option>
                     <option value ="2">What is your mother's maiden name</option>
                  </select>
                </p>
                <p><input type="text" class="span2" name="secret_answer" required id="secret_answer" placeholder="Secret Answer"></p>
                <p><input type="hidden" value="submit" /><br />
              <button type="submit" name="action" value = "submit" class="btn btn-primary" >Register</button></p>
            </form>
      </div>
      <div class="modal-footer">
       
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
		<!-- Modal -->
		<div class="modal fade custommodalwidth" id="forgotPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="forgotpassword">ForgotPassword</h4>
			  </div>
			<!-- div id="res" is for the result of ajax -->
			  <div id="res">
			  <div class="modal-body">
			 <table><tr><td><input type="radio"  name="entry" id="usernameradio" value="usernameradio" checked>
								 <label>Username</label></td>
								 <td><input type="text" class="span2" id="usernametext"></td></tr>
								 <tr><td><input type="radio" name="entry" id="emailradio" value="emailradio">
								 <label>Email</label></td>
								 <td><input type="email" class="span2" id="emailtext" disabled></td></tr></table>						
			  </div>
			
			  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" name ="submitfinal" class="btn btn-primary" onclick=javascript:getQuestion(document.getElementById("usernametext"),document.getElementById("emailtext"))>Submit</button>
			  </div>
			  </div>
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
				<div class="modal fade" id="forgotUsername" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" >ForgotUsername</h4>
				  </div>
			
				  <div id="resU">
				  <div class="modal-body">
				 <table cellpadding="5">
					<tr>
						<td>
							 <label>Email</label>
						</td>
									 
						<td>
							<input type="email" class="span2" id="usertext">
						</td>
					</tr>		
				</table>
				</div>
				  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="button" name ="subfinal" class="btn btn-primary" onclick=javascript:getQuestionU(document.getElementById("usertext").value)>Submit</button>
				  </div>
				  </div>
				</div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
      </div>
    </div>

    <div class="container reducewidth">
      <div class="row">
        <h2 style="text-align:center;">Rules</h2>
      </div>
		
		<div class="row">
        <div class="col-md-3">
		  <div id="flip1" style="color:white;text-align:center;"><strong>SELECTING INITIAL SQUAD<strong>
		  </div>		
		  <div id="panel1"> 
			<i><u>Squad Size</i></u><br/>
				To join the game select a fantasy football squad of up to 15 players, consisting of:<br/>
				2 Goalkeepers<br/>
				5 Defenders<br/>
				3 Forwards<br/>
				
				<i><u>Budget</i></u><br/>
				The total value of your initial squad must not exceed $90 million.<br>
				<i><u>Players per team</i></u><br>
				You can select up to 3 players from a single Barclays Premier League team.
			</div>

			
		</div>
       
        <div class="col-md-3">
			<div id="flip2" style="color:white;text-align:center;"><strong>MANAGING YOUR TEAM<strong>
			</div>		
			
			<div id="panel2"> 
				<i><u>Choosing Your Starting 11</i></u><br>
				From your squad, select at most 11 players by the Gameweek deadline to form your team.
				All your points for the Gameweek will be scored by these players.<br>
			</div>
        </div>
        <div class="col-md-3">
			<div id="flip3" style="color:white;text-align:center;"><strong>MAKING TRANSFERS<strong>
			</div>		
			
			<div id="panel3"> 
				After selecting your squad you can buy and sell players in the transfer market. Unlimited transfers can be made at any point in the league except during matchdays.
				<br>
				<i><u>Player prices</i></u><br>
				Player prices change during the season dependent on the popularity of the player in the transfer market. Player prices do not change until the season starts.
				The price shown on your transfers page is a player's selling price. This selling price may be less than the player's current purchase price.
			</div>
        </div>
		 <div class="col-md-3">
			<div id="flip4" style="color:white; text-align:center;"><strong>SCORING<strong>
			</div>		
			<div id="panel4"> 
			During the season, your fantasy football players will be allocated points based on their performance in the Barclays Premier League. Based on the accumulated points, a player rating will be allocated to each player which will eventually affect the changes in his cost value.
			</div>
		 </div>
      </div>
	
      <hr>

      <footer>
        <p>&copy; B561 Project Fall 2013</p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="jsF/teamname.js"></script>
    <script src="jsF/unamecheck.js"></script>
	<script> 
			$(document).ready(function(){
			$("#flip1").click(function(){
			$("#panel1").slideToggle("slow");
			});
			$("#flip2").click(function(){
			$("#panel2").slideToggle("slow");
			});
			$("#flip3").click(function(){
			$("#panel3").slideToggle("slow");
			});
			$("#flip4").click(function(){
			$("#panel4").slideToggle("slow");
			});
			});
			
		</script>
<div hidden="hidden">	
	<?php include('unamecheck.php'); ?>
</div>

  </body>
</html>