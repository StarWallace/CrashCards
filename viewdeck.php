<?php
    require_once("classes/User.class.php");
    $user = new User($deck->creatorid);
?>

<link rel="stylesheet" type="text/css" href="wrapper/css/view.css"/>
<script type="text/javascript" src="scripts/jquery.flippy.min.js"></script>
<script type="text/javascript" src="scripts/jquery.animate-shadow-min.js"></script>

<div class="viewDeck">
    <div class="deckInfo">
        <div class="title"><?php echo $deck->title; ?></div>
        <div class="creator">by <?php echo $user->GetDisplayName(); ?></div>
    </div>
    <div id="cardHolder">
        <div class="white card">
            <div class="text hand-font">
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
        <input type="checkbox" id="randomOrder"/><label for="randomOrder" >Random order</label>
        <br/>
        <input type="checkbox" id="repeatUntilPerfect"/><label for="repeatUntilPerfect" >Repeat until perfect score</label>
        <div id="repeatCorrectDiv">
            <input type="checkbox" id="repeatCorrect"/><label for="repeatCorrect" >Repeat correct answers</label>
        </div>
    </div>
</div>

<script type="text/javascript">
    var deck = new Object();
    deck.cards = new Array();
    <?php
        echo "deck.size = " . $deck->cardcount . ";";
        $deckCards = $deck->GetDeckArray();
        $i = 0;
        foreach ($deckCards as $deck) {
            echo "deck.cards[$i] = new Object();";
            echo "deck.cards[$i].question = \"" . $deck['front'] . "\";";
            echo "deck.cards[$i].answer = \"" . $deck['back'] . "\";";
            echo "deck.cards[$i].done = false;";
            $i++;
        }
    ?>
</script>
<script type="text/javascript" src="scripts/view.js"></script>