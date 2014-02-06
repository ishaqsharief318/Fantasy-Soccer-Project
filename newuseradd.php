<?php
include_once "phpF/mysql.php";

if (($_SERVER['REQUEST_METHOD'] == 'POST') && (!empty($_POST['action']))):	/*** begin our session ***/
	$firstname = $_REQUEST['firstname'];
	$lastname = $_REQUEST['lastname'];
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	$password_conf = $_REQUEST['password_conf'];
	$emailid = $_REQUEST['emailid'];
	$team_name = $_REQUEST['team_name'];
	$secret_answer = $_REQUEST['secret_answer'];
	$secret_question = $_REQUEST['secret_question'];
	if (isset($_POST['ajaxrequest'])) { $ajaxrequest = $_POST['ajaxrequest']; }

/*** first check that both the username, password and form token have been sent ***/
	if(!isset( $username, $password ))
	{
		$message =  'Please enter a valid username and password';
	}
	 /*** check the form token is valid ***/
	// if( $_POST['form_token'] != $_SESSION['form_token'])
	// {
		// echo = 'Invalid form submission';
	// }
	 /*** check the username is the correct length ***/
	 elseif (strlen( $username) > 20 || strlen($username) < 4)
	 {
		 $message = 'Incorrect Length for Username';
	 }
	 elseif ($username ==='')
	 {
		 $message = 'Username cannot be blank';
	 }
	 elseif (ctype_alpha($firstname) != true)
	 {
			 /*** if there is no match ***/
		$message =  "First Name cannot contain numbers";
	 }
	 elseif (ctype_alpha($lastname) != true)
	 {
			 /*** if there is no match ***/
		$message =   "Lastname cannot contain numbers";
	 }
	 /*** check the password is the correct length ***/
	 elseif (strlen( $password) > 20 || strlen($password) < 4)
	 {
		$message =  'Incorrect Length for Password';
	 }
	 /*** check the username has only alpha numeric characters ***/
	 elseif (ctype_alnum($username) != true)
	 {
		 /*** if there is no match ***/
		 $message =  "Username must be alpha numeric";
	 }
	 /*** check the password has only alpha numeric characters ***/
	 elseif (ctype_alnum($password) != true)
	 {
			 /*** if there is no match ***/
			 $message =   "Password must be alpha numeric";
			 if ( $ajaxrequest ) { echo "<script>$('#password').after('<div class=\"error\">Sorry, the password must be at least six characters</div>');</script>"; }
	 }
	 elseif ($password != $password_conf)
	 {
		 $message = 'Passwords do not match';
	 }
	else
	{
		/*** if we are here the data is valid and we can insert it into database ***/
		// $firstname = filter_var($firstname, FILTER_SANITIZE_STRING);
		// $lastname = filter_var($lastname, FILTER_SANITIZE_STRING);
		$username = filter_var($username, FILTER_SANITIZE_STRING);
		$password = filter_var($password, FILTER_SANITIZE_STRING);
		// $emailid = filter_var($emailid, FILTER_SANITIZE_STRING);
		// $team_name = filter_var($team_name, FILTER_SANITIZE_STRING);
		

		/*** now we can encrypt the password ***/
		$password = md5( $password );
		
		/*** connect to database ***/
		/*** mysql hostname ***/
		$mysql_hostname = 'silo.cs.indiana.edu';
		//$mysql_hostname = 'localhost';

		/*** mysql username ***/
		$mysql_username = 'b561f13_leile';
		//$mysql_username = 'root';

		/*** mysql password ***/
		$mysql_password = '12345';
		//$mysql_password = '';

		/*** database name ***/
		$mysql_dbname = 'b561f13_leile';
		//$mysql_dbname = 'fantasy';

		try
		{
			$dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);
			/*** echo = a message saying we have connected ***/

			/*** set the error mode to excptions ***/
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			/*** prepare the insert ***/
			$stmt = $dbh->prepare("INSERT INTO users (firstname,lastname,username, password,email,teamname,secret_q,secret_a) VALUES ('$firstname', '$lastname',:username, :password,'$emailid', '$team_name','$secret_question','$secret_answer')");

			/*** bind the parameters ***/
			$stmt->bindParam(':username', $username, PDO::PARAM_STR);
			$stmt->bindParam(':password', $password, PDO::PARAM_STR);

			/*** execute the prepared statement ***/
			$stmt->execute();
			

			/*** unset the form token session variable ***/
			/***unset( $_SESSION['form_token'] ); ***/

			/*** if all is done, say thanks ***/
			echo  'Successful registration. We are going to the teamsetup page!';
				session_start();
				$u = $dbh->lastInsertId();
				$_SESSION["uid"]=$u;
				$sql="select total from users where uid='$u'";
				$result=mysql_query($sql) or die("database connection error!");
				$row=mysql_fetch_array($result);
				$sql1="select count(*) from users where total> $row[0]";
				$result1=mysql_query($sql1) or die("database connection error!");
				$row1=mysql_fetch_array($result1);
				$_SESSION['ranking']=$row1[0]+1;
				mysql_close($conn);
				$dbh=null;
           /*** successfully logged in ***/
			echo "<script>window.location.href='teamsetup.php'</script>";
		}
		catch(Exception $e)
		{
			/*** check if the username already exists ***/
			if( $e->getCode() == 23000)
			{
				$message = 'Username already exists';
			}
			else
			{
				/*** if we are here, something has gone wrong with the database ***/
				$message = 'We are unable to process your request. Please try again later"';
			}
		}
	}
else:
$dbh=null;
echo "<script>window.location.href='homepage.php';</script>";
endif;
$dbh=null;
echo "<script>alert('$message. We are now returning to the home page.');window.location.href='homepage.php';</script>";
?>