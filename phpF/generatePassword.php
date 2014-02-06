<?php
function generatePassword()
{
	$array=array
	(array("0","1","2","3","4","5","6","7","8","9"),
	 array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J","k","K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T","u","U","v","V","w","W","x","X","y","Y","z","Z"));
	$length=rand(4,20);
	$start=rand(0,1);
	for($i=0;$i<$length;++$i)
	{
		if($start)
			$pos=rand(0,51);
		else
			$pos=rand(0,9);
		@$res=$res . $array[$start][$pos];
		$start=1-$start;
	}
	return $res;
}
?>