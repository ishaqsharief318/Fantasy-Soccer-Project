<?php
include_once("phpF/checkPage.php");
include_once("phpF/mysql.php");
include_once("phpF/s_questions.php");
$email=trim($_GET["email"]);
$str="select username, secret_q, secret_a from users where email = '" . $email . "'";
$result=mysql_query($str)or die("database connection error!");
if (@mysql_num_rows($result)<1)
{
	echo "<div class='modal-body'> Sorry, your account information is incorrect!</div><div class='modal-footer'>
						<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
						<button type='button' name ='reinput' class='btn btn-primary' onclick=javascript:restorePageU('resU')>Re-input</button>
			  </div>";
}
else
{
@session_start();
echo "<div class='modal-body'>"; 
$row=mysql_fetch_array($result);
$_SESSION["userU"]=trim($row[0]);
$_SESSION["answerU"]=trim($row[2]);
$_SESSION["emailU"]=trim($email);
echo "<table><tr><td><label>Secret Question : </label></td><td>";
echo $s_questions[$row[1]];
echo "</td></tr><tr><td><label>Secret Answer : </label></td><td><input type='text' class='span2' id='answertextU'></td></tr></table></div>";
echo "<div class='modal-footer'>
		<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
			<button type='button' name ='submitFPU' class='btn btn-primary' onclick=javascript:matchAnswerU(document.getElementById('answertextU').value)>Submit</button></div>";
}
mysql_close($conn);
?>