<?php
	ob_start();
    
    if (isset($_COOKIE['user'])) {
        header('Location: manage.php');
    }
?>

<link rel="stylesheet" type="text/css" href="wrapper/css/welcome.css"/>
    
<a href="signup.php"><div class="facebook h-spaced button" id="getStarted">GET STARTED!</div></a>

<div class="floatLine"></div>

<div class="white h-spaced" id="whatIsThis">
    <strong>Welcome to CrashCards</strong><br/>
    <p>92% of students want better study habits.</p>

    <p>Help us revolutionize study systems, peer collaboration and social note sharing. Join CrashCards and gain instant access to course note-taking material.</p>
</div>

<div class="h-spaced welcomeCard hand-font" id="welcomeCard1">
    Create and share flashcards with fellow students!
</div>

<div class="h-spaced welcomeCard hand-font" id="welcomeCard2">
    Crash course studying that's relevant to your classes!
</div>
    
<?php
	/*
	* When using the wrapper system this must be called at the top of every page.
	* It basically just sets a custom title for the page and then pulls in the wrapper
	*/
    $sTitle = "Welcome";
    
    require_once("wrapper/wrapper.php");
?>