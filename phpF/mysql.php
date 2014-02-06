<?php
$mysql_server_name='silo.cs.indiana.edu';
$mysql_username='b561f13_leile';
$mysql_password='12345';
$mysql_database='b561f13_leile';
/* $mysql_server_name='localhost';
$mysql_username='root';
$mysql_password='';
$mysql_database='fantasy'; */
$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die('Could not connect: ' . mysql_error());
mysql_select_db($mysql_database,$conn);
mysql_query("SET NAMES UTF8");
?>