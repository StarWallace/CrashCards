<?php
	ob_start();
    require_once("classes/User.class.php");
	
	$sugar = crypt($_COOKIE['user']);
	echo $_COOKIE['user'];
	
	//$user = unserialize($_COOKIE['user']);
	$user = $_COOKIE['userid'];
    $user = new User($user);
	
	if (is_object($user))
	{
		$user->Logout();
	}
	echo $_COOKIE['user'];
	
	echo "<a href='index.php?$sugar' >Go home</a>";
    header('Location: index.php?' . $sugar);
?>