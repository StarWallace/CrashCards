<?php
    require_once("classes/User.class.php");
	
	$sugar = crypt($_COOKIE['user']);
	echo $_COOKIE['user'];
	
    //$User = new User();
	$User = unserialize($_COOKIE['user']);
	if (is_object($User))
	{
		$User->Logout();
	}
	echo $_COOKIE['user'];
	
	echo "<a href='index.php?$sugar' >Go home</a>";
    header('Location: index.php?' . $sugar);
?>