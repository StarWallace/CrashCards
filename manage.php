<?php
	ob_start(); 
?>	

<?php
    function __autoload($sClassName) {
        require_once("classes/$sClassName.class.php");
    }   
?>

<link rel="stylesheet" type="text/css" href="wrapper/css/browse.css"/>
<link rel="stylesheet" type="text/css" href="wrapper/css/deck.css"/>
<link rel="stylesheet" type="text/css" href="wrapper/css/manage.css"/>

<div id="tutorial" class="white h-spaced v-spaced separated">
    <div id="tutorialContent">
        Show tutorial content here.
    </div>
    <div class="dismiss remove close"></div>
    <div class="dismiss bottom">
        <input id="dismissManageTutorial" type="checkbox"/>
        <label for="dismissManageTutorial">Got it. Don't show this again.</label>
    </div>
</div>

<div id="browseNav">
        <div class="left bold title">Your Decks</div>
    <div id="navControls">
        <div class="right h-spaced">
            <label for="sortOrder">Sort by:</label>
            <select id="sortOrder">
                <option>Top</option>
                <option>New</option>
            </select>
        </div>
        <a href="edit.php">
            <div class="button" id="newDeck">New Deck</div>
        </a>
    </div>
    <div class="floatLine"></div>
</div>

<div id="deckList">
	<?php
		//foreach ($decks as $deck) { 
        for ($i = 0; $i < 2; $i++) {
	?>
	<div class="browseItem">
        <div class="vote">
            <div class="scores">
                <div class="up score">
                    <?php echo "21"; ?>
                </div>
                <div class="down score">
                    <?php echo "3"; ?>
                </div>
            </div>
            <div class="voteControls">
                <div class="up control"></div>
                <div class="down control"></div>
            </div>
        </div>
        <div class="deckTag">
            <a href="
                <?php echo "#link"; ?>
            ">
                <div class="halfRow link">
                    <div class="title corner-spaced">
                        <?php echo "Example Deck #0"; ?>
                    </div>
                </div>
            </a>
            <div class="halfRow">
                <div class="info">
                    <br/>
                    <?php echo "&lt;Subject&gt; - &lt;Course Code&gt; - &lt;Year&gt;"; ?>
                </div>
            </div>
        </div>
        <div class="userTag">
            <?php
                // If deck not published
                if (!$i) {
            ?>
            <div class="draftTag"></div>
            <?php
                }
            ?>
            <div id="cardCount" class="bottom">
                14 cards
            </div>
            <div class="deck-links">
                <div class="button">Edit</div>
                <div class="button">Publish</div>
            </div>
        </div>
        <div class="remove removeCard" title="Delete Deck"></div>
	</div>
	<?php
		}
	?>
</div>












<div id="browseNav">
        <div class="left bold title">Clipped Decks</div>
    <div id="navControls">
        <div class="right h-spaced">
            <label for="sortOrder">Sort by:</label>
            <select id="sortOrder">
                <option>Top</option>
                <option>New</option>
            </select>
        </div>
    </div>
    <div class="floatLine"></div>
</div>

<div id="deckList">
	<?php
		//foreach ($decks as $deck) { 
        for ($i = 0; $i < 2; $i++) {
	?>
	<div class="browseItem">
        <div class="vote">
            <div class="scores">
                <div class="up score">
                    <?php echo "21"; ?>
                </div>
                <div class="down score">
                    <?php echo "3"; ?>
                </div>
            </div>
            <div class="voteControls">
                <div class="up control"></div>
                <div class="down control"></div>
            </div>
        </div>
        <div class="deckTag">
            <a href="
                <?php echo "#link"; ?>
            ">
                <div class="halfRow link">
                    <div class="title corner-spaced">
                        <?php echo "Example Deck #0"; ?>
                    </div>
                </div>
            </a>
            <div class="halfRow">
                <div class="info">
                    <br/>
                    <?php echo "&lt;Subject&gt; - &lt;Course Code&gt; - &lt;Year&gt;"; ?>
                </div>
            </div>
        </div>
        <div class="userTag">
            <a href="
                <?php echo "#user0"; ?>
            ">
                <div id="userName" class="halfRow link corner-spaced">
                    <div class="bold">
                        <?php echo "user0"; ?>
                    </div>
                </div>
            </a>
        </div>
        <div class="remove removeCard" title="Unclip Deck"></div>
	</div>
	<?php
		}
	?>
</div>





<?php
    $sTitle = "Manage Decks";
    require_once("wrapper/wrapper.php");
?>

<script type="text/javascript" src="scripts/manage.js"></script>