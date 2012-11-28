<?php 
	/*
	* When using the wrapper system this must be called at the top of every page.
	* It basically just says to "start output"
	*/
	ob_start(); 
?>	

<link rel="stylesheet" type="text/css" href="wrapper/css/edit.css"/>

<div class="cardControls">
    <div class="button publishDeck">Publish</div>
    <div class="button saveDeck">Save</div>
</div>

<div class="deckInfo white">
    <div class="fields">
        <div class="column">
            <div class="row">
                <div class="label"><label for="deckTitle">Title</label></div>
                <input id="deckTitle"/>
                <div class="info-tooltip" id="titleInfo"
                     help="Example help text for deck title"
                ></div>
            </div>
            <div class="row">
                <div class="label"><label for="deckSubject">Subject</label></div>
                <input id="deckSubject"/>
                <div class="info-tooltip" id="subjectInfo"
                     help="Example help text for subject"
                ></div>
            </div>
            <div class="row">
                <div class="label"><label for="deckCourseCode">Course Code</label></div>
                <input id="deckCourseCode"/>
                <div class="info-tooltip" id="courseCodeInfo"
                     help="Example help text for course info"
                ></div>
            </div>
        </div>
        <div class="column" id="autocomplete"></div>
        <div class="column" id="message"></div>
    </div>
</div>

<br/>

<div class="cardList white" id="sortable">
    <div class="cardRow">
        <div class="number">1</div>
        <div class="minDisplay">
            <div>
                <div class="bold">Front</div><br/>
                <div class="cardSummary"></div>
            </div>
            <div>
                <div class="bold">Back</div><br/>
                <div class="cardSummary"></div>
            </div>
        </div>
        <div class="remove"></div>
    </div>
    
</div>

<div class="cardControls">
    <div class="button publishDeck">Publish</div>
    <div class="button saveDeck">Save</div>
    <div class="button" id="newCard">New Card</div>
</div>

<?php
	/*
	* When using the wrapper system this must be called at the top of every page.
	* It basically just sets a custom title for the page and then pulls in the wrapper
	*/
    $sTitle = "Edit Deck";
    
    require_once("wrapper/wrapper.php");
?>

<script type="text/javascript" src="scripts/edit.js"></script>
<script type="text/javascript" src="scripts/tooltip.js"></script>