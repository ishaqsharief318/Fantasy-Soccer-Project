<?php
	@session_start();
	if(!isset($_SESSION['uid']))
	{
		echo"<script>window.location.href='index.php'</script>";
	}

?>