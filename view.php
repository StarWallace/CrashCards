<?php 
	/*
	* When using the wrapper system this must be called at the top of every page.
	* It basically just says to "start output"
	*/
	ob_start(); 
?>	

<link rel="stylesheet" type="text/css" href="wrapper/css/view.css"/>
<script type="text/javascript" src="scripts/jquery.flippy.min.js"></script>
<script type="text/javascript" src="scripts/jquery.animate-shadow-min.js"></script>


<div class="viewDeck">
    <div class="deckInfo">
        <div class="title">&lt;Deck Title&gt;</div>
        <div class="creator">by &lt;Deck Author&gt;</div>
    </div>
    <div id="cardHolder">
        <div class="white card">
            <div class="text">
                <div class="question"></div>
                <div class="answer"></div>
            </div>
        </div>
    </div>
    <div class="controlBar">
        <div class="control" id="checkMark"></div>
        <div class="control" id="xMark"></div>
        <div class="control" id="flip"></div>
        <div id="scoreRecords">
            <div class="half-row">
                <span id="bestScoreLabel">Best Score:</span>
                <span id="bestScore"></span>
            </div>
            <div class="half-row">
                <span id="lastScoreLabel">Last Score:</span>
                <span id="lastScore"></span>
            </div>
        </div>
        <div id="progress">
            <span id="currentIndex">1</span>
            of
            <span id="deckSize"></span>
        </div>
        <div id="score">0%</div>
    </div>
    <div class="white options">
        <input type="checkbox" id="randomOrder"/>Random order
        <br/>
        <input type="checkbox" id="repeatUntilPerfect"/>Repeat until perfect score
        <div id="repeatCorrectDiv">
            <input type="checkbox" id="repeatCorrect"/>Repeat correct answers
        </div>
    </div>
</div>

<?php
	/*
	* When using the wrapper system this must be called at the top of every page.
	* It basically just sets a custom title for the page and then pulls in the wrapper
	*/
    $sTitle = "View Deck";
    
    require_once("wrapper/wrapper.php");
?>

<script type="text/javascript" src="scripts/view.js"></script>