<?php
include_once "phpF/mysql.php";
/*** begin our session ***/
session_start();
/*** check if the users is already logged in ***/
if(isset( $_SESSION['uid'] ))
{
    $message = 'Users is already logged in';
}
/*** check that both the username, password have been submitted ***/
elseif(!isset( $_POST['username_reg'], $_POST['password_reg']))
{
    $message = 'Please enter a valid username and password';
}
/*** check the username is the correct length ***/
elseif (strlen( $_POST['username_reg']) > 20 || strlen($_POST['username_reg']) < 4)
{
    $message = 'Incorrect Length for Username';
}
/*** check the password is the correct length ***/
elseif (strlen( $_POST['password_reg']) > 20 || strlen($_POST['password_reg']) < 4)
{
    $message = 'Incorrect Length for Password';
}
/*** check the username has only alpha numeric characters ***/
elseif (ctype_alnum($_POST['username_reg']) != true)
{
    /*** if there is no match ***/
    $message = "Username must be alpha numeric";
}
/*** check the password has only alpha numeric characters ***/
elseif (ctype_alnum($_POST['password_reg']) != true)
{
        /*** if there is no match ***/
        $message = "Password must be alpha numeric";
}
else
{
    /*** if we are here the data is valid and we can insert it into database ***/
    $username = filter_var($_POST['username_reg'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password_reg'], FILTER_SANITIZE_STRING);

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
        /*** $message = a message saying we have connected ***/

        /*** set the error mode to excptions ***/
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /*** prepare the select statement ***/
        $stmt = $dbh->prepare("SELECT uid FROM users 
                    WHERE username = :username AND password = :password");

        /*** bind the parameters ***/
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR, 40);

        /*** execute the prepared statement ***/
        $stmt->execute();

        /*** check for a result ***/
        $userid = $stmt->fetchColumn();

        /*** if we have no result then fail boat ***/
        if($userid == false)
        {
                $message = 'Login Failed';
        }
        /*** if we do have a result, all is well ***/
        else
        {
                /*** set the session userid variable ***/
                $_SESSION['uid'] = $userid;
				$sql="select total from users where uid='$userid'";
				$result=mysql_query($sql) or die("database connection error!");
				$row=mysql_fetch_array($result);
				$sql1="select count(*) from users where total> $row[0]";
				$result1=mysql_query($sql1) or die("database connection error!");
				$row1=mysql_fetch_array($result1);
				$_SESSION['ranking']=$row1[0]+1;
				mysql_close($conn);
				$dbh=null;
                /*** successfully logged in ***/
               echo "<script>window.location.href='homepage.php'</script>";
			   }
    }
    catch(Exception $e)
    {
        /*** if we are here, something has gone wrong with the database ***/
        $message = 'We are unable to process your request. Please try again later';
    }
}
$dbh=null;
echo "<script>alert('$message. We are now returning to the home page.');window.location.href='homepage.php'</script>";
?>

