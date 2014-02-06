<?php
/*** begin our session ***/
session_start();
/*** check if the users is already logged in ***/
if(isset( $_SESSION['admin'] ))
{
    $message = 'Users is already logged in';
}
/*** check that both the username, password have been submitted ***/
elseif(!isset( $_POST['the_admin'], $_POST['admin_pwd']))
{
    $message = 'Please enter a valid username and password';
}
/*** check the username is the correct length ***/
elseif (strlen( $_POST['the_admin']) > 20 || strlen($_POST['the_admin']) < 4)
{
    $message = 'Incorrect Length for Username';
}
/*** check the password is the correct length ***/
elseif (strlen( $_POST['admin_pwd']) > 20 || strlen($_POST['admin_pwd']) < 4)
{
    $message = 'Incorrect Length for Password';
}
/*** check the username has only alpha numeric characters ***/
elseif (ctype_alnum($_POST['the_admin']) != true)
{
    /*** if there is no match ***/
    $message = "Username must be alpha numeric";
}
/*** check the password has only alpha numeric characters ***/
elseif (ctype_alnum($_POST['admin_pwd']) != true)
{
        /*** if there is no match ***/
        $message = "Password must be alpha numeric";
}
else
{
    /*** if we are here the data is valid and we can insert it into database ***/
    $username = filter_var($_POST['the_admin'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['admin_pwd'], FILTER_SANITIZE_STRING);

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
        $stmt = $dbh->prepare("SELECT uid FROM admin 
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
                $_SESSION['admin'] = $userid;
				$dbh=null;
                /*** successfully logged in ***/
               echo "<script>window.location.href='admin.php'</script>";
			   }
    }
    catch(Exception $e)
    {
        /*** if we are here, something has gone wrong with the database ***/
        $message = 'We are unable to process your request. Please try again later';
    }
}
$dbh=null;
echo "<script>alert('$message. We are now returning to the login page.');window.location.href='adminLogin.php'</script>";
?>


