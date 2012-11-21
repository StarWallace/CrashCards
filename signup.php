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
    <form id="signup-form" action="puckoverglass.com" method="POST">
        <div class="row">
            <div class="label"><label for="email">Email</label></div>
            <input id="email" autofocus maxlength="30" tabindex="1"/>
            <div class="note" id="emailNote">First, we need your email.</div>
        </div>
        <div class="row hidden">
            <div class="label"><label for="password">Password</label></div>
            <input type="password" id="password" maxlength="30" tabindex="2"/>
            <div class="note" id="passwordNote">Next we need a password.</div>
        </div>
        <div class="row hidden">
            <div class="label"><label for="confirm">Confirm</label></div>
            <input type="password" id="confirm" tabindex="3"/>
            <div class="note" id="confirmNote">Now just confirm your password...</div>
        </div>
        <div class="row hidden">
            <div class="label"><label for="name">Name</label></div>
            <input id="name" maxlength="30" tabindex="4"/>
            <div class="note" id="nameNote"></div>
        </div>
        <div class="row hidden">
            <div class="label"><label for="alias">Alias</label></div>
            <input id="alias" maxlength="30" tabindex="5"/>
            <div class="note" id="aliasNote"></div>
        </div>
        <div class="centred signup" tabindex="6">
            <input type="submit" class="button" id="signup" value="Sign Up" tabindex="7" disabled="disabled"/>
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