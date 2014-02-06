<?php
session_start();
if(isset($_SESSION['admin']))
	{
		echo"<script>window.location.href='admin.php'</script>";
	}
?>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Fantasy Football</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="bootstrap/css/jumbo.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="jumbotron.css" rel="stylesheet">
	<link href="css/admincss.css" rel = "stylesheet">

    
  </head>
  <body>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title"><strong>With Admin Access comes Great Responsibility</strong></h1>
            <div class="account-wall">
                <img class="profile-img" src="img/administrator.jpg" height= "140" width ="140" alt="">
                <form class="form-signin" method='post' action='adminauth.php'>
                <input type="text" class="form-control" name="the_admin" id="the_admin" placeholder="Admin Username" required autofocus>
                <input type="password" class="form-control" name="admin_pwd" id="admin_pwd" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit">
                    Sign in</button><br />                
                <a href="index.php" align="center">Log in as a user. </a><span class="clearfix"></span>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>