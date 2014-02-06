<?php
include_once("phpF/checkPage.php");
include_once("phpF/mysql.php");
include_once("phpF/s_questions.php");
// if it is "username"
if(trim($_GET["flag"])=="1")
	$cond="username";
// otherwise
else
	$cond="email";
$user=trim($_GET["user"]);
$str="select username, email, secret_q, secret_a from users where " . $cond . " = " . "'" . $user . "'";
$result=mysql_query($str) or die("database connection error!");
if (@mysql_num_rows($result)<1)
{
	echo "<div class='modal-body'> Sorry, your account information is incorrect!</div><div class='modal-footer'>
						<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
						<button type='button' name ='reinput' class='btn btn-primary' onclick=javascript:restorePage()>Re-input</button>
			  </div>";
}
else
{
//echo "<form method='post' action='matchAnswer.php' name='forgot_password'>";
@session_start();
echo "<div class='modal-body'>"; 
$row=mysql_fetch_array($result);
$_SESSION["user"]=trim($row[0]);
$_SESSION["answer"]=trim($row[3]);
$_SESSION["email"]=trim($row[1]);
echo "<table><tr><td><label>Secret Question: </label></td><td>";
echo $s_questions[$row[2]];
echo "</td></tr><tr><td><label>Secret Answer: </label></td><td><input type='text' class='span2' id='answerertext'></td></tr></table></div>";
echo "<div class='modal-footer'>
		<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
			<button type='button' name ='submitFP' class='btn btn-primary' onclick=javascript:matchAnswer(document.getElementById('answerertext').value)>Submit</button></div>";
}
mysql_close($conn);
?>