<?php
include_once("phpF/checkPage.php");
include_once "mail/emailInfor.php";
include_once "mail/smtp.class.php";
//session_start();
if(!isset($_SESSION["userU"]))
{
	$mes="Sorry, your session has expired. Please re-input. ";
}
else
{
$username=$_SESSION["userU"];
$email=$_SESSION["emailU"];
$realAnswer=$_SESSION["answerU"];
$answer=trim($_GET["answer"]);
if($realAnswer!=$answer)
{
	$mes="Sorry, your answer is incorrect. Please re-input. ";
}
else
{
	$mail = new SMTP();
		$mail->setServer($emailInfor["serverName"], $emailInfor["serverUser"], $emailInfor["password"], $emailInfor["port"], $emailInfor["ssl"]);
		$mail->setFrom($emailInfor["fromEmail"],$emailInfor["fromName"]);
		$mail->setReceiver($email,"Dear " . $username);
		$mail->setMail("Important! Your username for fantasy league", "There is your username: <b>" . $username . "</b>"); 
		$eres=$mail->sendMail();
		if ($eres)
		{
			$mes="Your answer is correct! A mail containing your username has been sent to your email " . $email . ". ";
		}
		else
		{
			$mes="Sorry, something is wrong with the email system. Please re-input later. ";
		}
}
}
echo "<div class='modal-body'>" . $mes . "</div><div class='modal-footer'>";
echo "<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>";
echo "<button type='button' name ='reinputU' class='btn btn-primary' onclick=javascript:restorePageU()>Re-input</button></div>";
unset($_SESSION["useru"]);
unset($_SESSION["emailu"]);
unset($_SESSION["answeru"]);
?>