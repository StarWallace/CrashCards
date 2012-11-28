<?php
    require_once("classes/User.class.php");
    $User = new User();
    $User->Logout();
    header('Location: /');
?>