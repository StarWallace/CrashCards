<?php
    require_once("classes/User.class.php");
    
    //$user = unserialize($_COOKIE['user']);
	$user = $_COOKIE['userid'];
	$user = new User($user);
	
    $referenceName = $user->GetReferenceName();
?>

<div class="top fixed" id="topBar">
    <div class="centred white" id="userBar">
        <a href="index.php?"><div class="banner" title="CrashCards"></div></a>
        <div id="displayName"><?php echo $referenceName; ?></div>
        <div class="controlBar">
            <a href="browse.php"><div class="control" id="search" title="Search"></div></a>
            <a href="manage.php"><div class="control" id="yourCards" title="Your Cards"></div></a>
            <a href="settings.php"><div class="control" id="settings" title="Settings"></div></a>
            <a href="logout.php?<?php echo crypt($_COOKIE['user']); ?>"><div class="control" id="logout" title="Log Out"></div></a>
        </div>
    </div>
</div>