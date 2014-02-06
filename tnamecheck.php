<?php
mysql_connect('silo.cs.indiana.edu', 'b561f13_leile', '12345');  
mysql_select_db('b561f13_leile'); 
/* mysql_connect('localhost', 'root', '');  
mysql_select_db('fantasy');   */
  
//get the teamname  
$team_name = mysql_real_escape_string($_POST['team_name']);  
  
//mysql query to select field teamname if it's equal to the teamname that we check '  
$result = mysql_query('select teamname from users where teamname = "'. $team_name .'"');  
  
//if number of rows fields is bigger them 0 that means it's NOT available '  
if(mysql_num_rows($result)>0){  
    //and we send 0 to the ajax request  
    echo 0;  
}else{  
    //else if it's not bigger then 0, then it's available '  
    //and we send 1 to the ajax request  
    echo 1;  
}  

?>