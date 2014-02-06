<?php
include_once("phpF/checkPage.php");
include_once "phpF/mysql.php";
include_once "phpF/generatePassword.php";
include_once "mail/emailInfor.php";
include_once "mail/smtp.class.php";
//session_start();
if(!isset($_SESSION["user"]))
{
	$mes="Sorry, your session has expired. Please re-input. ";
}
else
{
$username=$_SESSION["user"];
$email=$_SESSION["email"];
$realAnswer=$_SESSION["answer"];
$answer=trim($_GET["answer"]);
if($realAnswer!=$answer)
{
	$mes="Sorry, your answer is incorrect. Please re-input. ";
}
else
{
	$newP=generatePassword();
	$sql="update users set password = md5('" . $newP . "') where username = '" . $username . "'";
	$res=mysql_query($sql) or die("database connection error!");
	if(mysql_affected_rows()>0)
	{
		$mail = new SMTP();
		$mail->setServer($emailInfor["serverName"], $emailInfor["serverUser"], $emailInfor["password"], $emailInfor["port"], $emailInfor["ssl"]);
		$mail->setFrom($emailInfor["fromEmail"],$emailInfor["fromName"]);
		$mail->setReceiver($email,"Dear " . $username);
		$mail->setMail("Important! Your new passowrd for fantasy league", "There is your new password: <b>" . $newP . "</b>"); 
		$eres=$mail->sendMail();
		if ($eres)
		{
			$mes="Your answer is correct! A mail containing your new password has been sent to your email " . $email . ". ";
		}
		else
		{
			$mes="Sorry, something is wrong with the email system. Please re-input later. ";
		}
	}
	else
	{
		$mes="Sorry, something is wrong with the database system. Please re-input later. ";
	}	
}
}
echo "<div class='modal-body'>" . $mes . "</div><div class='modal-footer'>";
echo "<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>";
echo "<button type='button' name ='reinput' class='btn btn-primary' onclick=javascript:restorePage()>Re-input</button></div>";
unset($_SESSION["user"]);
unset($_SESSION["email"]);
unset($_SESSION["answer"]);
mysql_close($conn);
?>