<?php
set_time_limit(0);
function calculation($playername,$club)
{
include_once("checkPageA.php");
include_once "mysql.php";
$sql="select week_point_prev,week_points,rating,cost from players where playername=\"$playername\" and club='$club'";
$result=mysql_query($sql) or die("database connection error!");
$row=mysql_fetch_array($result);
$old=$row[0];
$new=$row[1];
$rating=$row[2];
$cost=$row[3];
$large;
$small;
$flag;
$incr=0; //This must be initialized to zero. 

// RATING CALCULATION
if($old=0 && $new=0) //player does not play 2 matches back to back
	{
		$rating = $rating-0.5;
	}
else if($old>0 && $new=0) //Player does not play one match
	{
		$rating = $rating; //Rating remains the same
	}
else
	{
		if($old > $new)
		{
			$large = $old;
			$small = $new;
			$flag= -1;
		}
		else
		{
			$large = $new;
			$small = $old;
			$flag = 1;
		}
		
		if($old=0 && $new>0)	// Plays a match after missing previous match ->map rating to[0,1]
			{
				$incr = (($large - $small)/100) * $flag;
			}
		else
			{
				@$incr = (($large - $small)/$large) * $flag;
			}
	}
	
if($rating + $incr <4.0)
	{	
		$rating = 4.0;
	}
else if($rating+$incr >10.0)
	{
		$rating = 10.0 ;
	}
else
	{
		$rating = $rating + $incr;
	}	
	
//COST CALCULATION
 $perc = ($incr/$rating);
 $cost_incr = $cost * $perc;
 
 if( $cost+$cost_incr>=15.0)
	{
		$cost=15.0;
	}
	
 if($cost + $cost_incr <=3.0)
	{
		$cost = 3.0;
	}
else 
	{
	$cost = $cost + $cost_incr;
	}
$sql="update players set rating=$rating,cost=$cost where playername=\"$playername\" and club='$club'";
echo "<script>alert('$sql')</script>";
$result=mysql_query($sql) or die("database connection error!");
}
?>