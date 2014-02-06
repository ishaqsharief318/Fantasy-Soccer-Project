<?php
include_once("phpF/checkPage.php");
include_once("phpF/mysql.php");
$name=trim($_GET["name"]);
$position=trim($_GET["position"]);
$tname=trim($_GET["tname"]);
$costL=trim($_GET["costL"]);
$costU=trim($_GET["costU"]);
if ($name=="")
	$cond1="1=1";
else
	$cond1="playername LIKE \"%" . $name . "%\"";	
if ($position=="")
	$cond2="1=1";
else
	$cond2="position='" . $position . "'";
if ($tname=="")
	$cond3="1=1";
else
	$cond3="club='" . $tname . "'";
if ($costL!=""&&$costU!="")
{
	$cond4="cost >= $costL and cost <= $costU";
}
else if($costL!="")
{
	$cond4="cost >= $costL";
}
else if($costU!="")
{
	$cond4="cost <= $costU";
}
else
	$cond4="1=1";
$sql="select count(*) from players where $cond1 and $cond2 and $cond3 and $cond4";
$result=mysql_query($sql) or die("Database connection error!");
$searchTotal=mysql_fetch_array($result);
$searchTotal=$searchTotal[0];
if ($searchTotal<1)
{
	echo "no such players found!";
}
else
{
	$pagesize=8;
	$pagenum=ceil($searchTotal/$pagesize);
	$page=(isset($_GET["page"]))?intval($_GET["page"]):1;
	$page=($page<1)?1:$page;
	$page=($page>$pagenum)?$pagenum:$page;
	$pagestart=($page-1)*$pagesize;
	if(!isset($_GET["sort"]))
		$sql="select playerid, playername, position, club, rating, cost, availability,week_points,accumulated from players where $cond1 and $cond2 and $cond3 and $cond4 limit $pagestart, $pagesize";
	else
	{
		$sort=$_GET["sort"];
		$order=$_GET["order"];
		$datasort=($order=="0")?" order by $sort asc":" order by $sort desc";
		$sql="select playerid, playername, position, club, rating, cost, availability,week_points,accumulated from players where $cond1 and $cond2 and $cond3 and $cond4 $datasort limit $pagestart, $pagesize";
	}
	$result=mysql_query($sql) or die("Database connection error!");
	$tname=str_replace(" ","&nbsp;",$tname);
	echo "<table class='table table-bordered table-condensed table-hover'> <tr>";
	if (isset($_GET["sort"])&&$_GET["order"]=="0")
		{
			if($_GET["sort"]=="playername")
				$sortcond1="searchP('$name','$position','$tname','$costL','$costU',1,'searchRes','playername',1)";
			else
				$sortcond1="searchP('$name','$position','$tname','$costL','$costU',1,'searchRes','playername',0)";
			if($_GET["sort"]=="position")
				$sortcond2="searchP('$name','$position','$tname','$costL','$costU',1,'searchRes','position',1)";
			else
				$sortcond2="searchP('$name','$position','$tname','$costL','$costU',1,'searchRes','position',0)";
			if($_GET["sort"]=="club")
				$sortcond3="searchP('$name','$position','$tname','$costL','$costU',1,'searchRes','club',1)";
			else
				$sortcond3="searchP('$name','$position','$tname','$costL','$costU',1,'searchRes','club',0)";
			if($_GET["sort"]=="cost")
				$sortcond4="searchP('$name','$position','$tname','$costL','$costU',1,'searchRes','cost',1)";
			else
				$sortcond4="searchP('$name','$position','$tname','$costL','$costU',1,'searchRes','cost',0)";
			if($_GET["sort"]=="availability")
				$sortcond5="searchP('$name','$position','$tname','$costL','$costU',1,'searchRes','availability',1)";
			else
				$sortcond5="searchP('$name','$position','$tname','$costL','$costU',1,'searchRes','availability',0)";
		}
	else
	{
		$sortcond1="searchP('$name','$position','$tname','$costL','$costU',1,'searchRes','playername',0)";
		$sortcond2="searchP('$name','$position','$tname','$costL','$costU',1,'searchRes','position',0)";
		$sortcond3="searchP('$name','$position','$tname','$costL','$costU',1,'searchRes','club',0)";
		$sortcond4="searchP('$name','$position','$tname','$costL','$costU',1,'searchRes','cost',0)";
		$sortcond5="searchP('$name','$position','$tname','$costL','$costU',1,'searchRes','availability',0)";
	}
	
	echo "<th> </th><th><a href=javascript:$sortcond1>Name</a></th><th><a href=javascript:$sortcond2>Position</a></th><th><a href=javascript:$sortcond3>Club</a></th><th><a href=javascript:$sortcond4>Cost</a></th><th><a href=javascript:$sortcond5>Fitness</a></th></tr>";
while($row=mysql_fetch_array($result))
{
	if($row[6]==1)
		{
			$style="success";
			$s="Good";
		}
	else
		{
			$style="danger";
			$s="Not good";
		}
	echo "<tr class=$style id='S{$row[0]}'>";
	echo "<td><input type='radio' name='searchPlayers' id='searchPlayers' value='" . $row[0] . "'></td>";
	$style="$row[1]:$row[2]:$row[3]:$row[4]:$row[5]:$s:$row[7]:$row[8]";
	echo "<td><a data-toggle='modal' title='view details of this player' href='#playerinformation' onclick='javascript:getPlayerInformation(\"$style\")'>" . $row[1] . "</a></td>";
	echo "<td>" . $row[2] . "</td>";
	echo "<td>" . $row[3] . "</td>";
	echo "<td>" . $row[5] . "</td>";
	$s=($row[6]==1)?"<font color='green'>Good</font>":"<font color='red'>Not Good</font>";
	echo "<td>" . $s . "</td></tr>";
}
echo "</table>";
$prev=$page-1;
$next=$page+1;
echo "<a title='first page' href=javascript:searchP('$name','$position','$tname','$costL','$costU',1,'searchRes','',0)>&lt;&lt;</a>";
echo "&nbsp;&nbsp;&nbsp;";
if ($prev>0)
echo "<a title='previous page' href=javascript:searchP('$name','$position','$tname','$costL','$costU',$prev,'searchRes','',0)>&lt;</a>";
echo "&nbsp;&nbsp;&nbsp;";
echo "<select id='gotopage' class='selectpicker input-medium' onChange=javascript:searchP('$name','$position','$tname','$costL','$costU',this.options[this.selectedIndex].value,'searchRes','',0)>";
for($i=1;$i<=$pagenum;++$i)
{
	if($i==$page)
	echo "<option value='$i' selected>$i</option>";
	else
	echo "<option value='$i'>$i</option>";
}
echo "</select>";
echo "&nbsp;&nbsp;&nbsp;";
if ($next<=$pagenum)
echo "<a title='next page' href=javascript:searchP('$name','$position','$tname','$costL','$costU',$next,'searchRes','',0)>&gt;</a>";
echo "&nbsp;&nbsp;&nbsp;";
echo "<a title='last page' href=javascript:searchP('$name','$position','$tname','$costL','$costU',$pagenum,'searchRes','',0)>&gt;&gt</a>";
}
mysql_close($conn);
?>