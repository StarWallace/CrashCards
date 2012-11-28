<?php
    function __autoload($sClassName) {
        require_once("classes/$sClassName.class.php");
    }

    if (!isset($_POST) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['confirm'])) {
        // stay on this page
    } else {
        // create new user and redirect to manage.php
        $User = new User();
        $registerResult = $User->Register($_POST['email'], $_POST['password'], $_POST['confirm'], $_POST['name'], $_POST['alias']);
        if ($registerResult == 1) {
            $loginResult = $User->Login($_POST['email'], $_POST['password']);
            if ($loginResult != true) {
                // Login failure
                $error = $loginResult;
            } else {
                // Registration and login success
                header('Location: manage.php');
            }
        } else {
            // Registration failure
            $error = $registerResult;
        }
    }
?>

<?php 
	/*
	* When using the wrapper system this must be called at the top of every page.
	* It basically just says to "start output"
	*/
	ob_start(); 
?>

<link rel="stylesheet" type="text/css" href="wrapper/css/signup.css"/>

<div id="welcome">Welcome!</div>
<div class="white h-spaced v-spaced separated shadow" id="message">As a member of CrashCards you will enjoy making and sharing flash cards that directly relate to your studies! Settling in is painless, so let's get started!</div>
<div class="white h-spaced v-spaced separated" id="form" onsubmit="return validateForm()">
    <form id="signup-form" action="signup.php" method="POST">
        <div>
            <?php
                echo isset($error) ? $error : "";
            ?>
        </div>
        <div class="row">
            <div class="label"><label for="email">Email</label></div>
            <input name="email" id="email" autofocus maxlength="30" tabindex="1"
                    <?php
                        echo isset($_POST) && isset($_POST['email']) ? "value=\"" . $_POST['email'] . "\"" : "";
                    ?>
            />
            <div class="note" id="emailNote">First, we need your email.</div>
        </div>
        <div class="row hidden">
            <div class="label"><label for="password">Password</label></div>
            <input name="password" type="password" id="password" maxlength="30" tabindex="2"/>
            <div class="note" id="passwordNote">Next we need a password.</div>
        </div>
        <div class="row hidden">
            <div class="label"><label for="confirm">Confirm</label></div>
            <input name="confirm" type="password" id="confirm" tabindex="3"/>
            <div class="note" id="confirmNote">Now just confirm your password...</div>
        </div>
        <div class="row hidden">
            <div class="label"><label for="name">Name</label></div>
            <input name="name" id="name" maxlength="30" tabindex="4"
                    <?php
                        echo isset($_POST) && isset($_POST['name']) ? "value=\"" . $_POST['name'] . "\"" : "";
                    ?>
            />
            <div class="note" id="nameNote"></div>
        </div>
        <div class="row hidden">
            <div class="label"><label for="alias">Alias</label></div>
            <input name="alias" id="alias" maxlength="30" tabindex="5"
                    <?php
                        echo isset($_POST) && isset($_POST['alias']) ? "value=\"" . $_POST['alias'] . "\"" : "";
                    ?>
            />
            <div class="note" id="aliasNote"></div>
        </div>
        <div class="centred signup" tabindex="6">
            <div class="button" id="signup" tabindex="7">Sign Up</div>
            <div class="button" id="next" tabindex="7">Next</div>
        </div>
    </form>
</div>

<?php
	/*
	* When using the wrapper system this must be called at the top of every page.
	* It basically just sets a custom title for the page and then pulls in the wrapper
	*/
    $sTitle = "Sign Up";
    
    require_once("wrapper/wrapper.php");
?>

<script type="text/javascript" src="scripts/signup.js"></script>