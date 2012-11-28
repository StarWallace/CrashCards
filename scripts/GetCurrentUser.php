<?php
/**
* Written by: Kirk McCulloch
* Script called to get the currently logged in user from the cookie
* Use in places where it is unsafe to pass the user id
**/

	echo (isset($_COOKIE['user'])) ? json_encode(unserialize($_COOKIE['user'])) : "NULL";

?>