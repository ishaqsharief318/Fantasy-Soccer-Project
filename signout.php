<?php
$url="index.php";
?>
<html>   
<head>   
<meta http-equiv="refresh" content="1;url=<?php echo $url; ?>">   
</head>   
<body>   
You are signing out...  
</body> 
</html>  
<?php
session_start();
session_unset();
?>