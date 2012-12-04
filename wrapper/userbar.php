<?php
    require_once("classes/User.class.php");
    $user = unserialize($_COOKIE['user']);
    $displayName = $user->GetDisplayName();
?>

<div class="top fixed" id="topBar">
    <div class="centred white" id="userBar">
        <div class="banner" title="CrashCards"></div>
        <div id="displayName"><?php echo $displayName; ?></div>
        <div class="controlBar">
            <a href="browse.php"><div class="control" id="search" title="Search"></div></a>
            <a href="manage.php"><div class="control" id="yourCards" title="Your Cards"></div></a>
            <a href=""><div class="control" id="settings" title="Settings"></div></a>
            <a href="logout.php"><div class="control" id="logout" title="Log Out"></div></a>
        </div>
    </div>
</div>