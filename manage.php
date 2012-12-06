<?php
	ob_start();
    
    function __autoload($sClassName) {
        require_once("classes/$sClassName.class.php");
    }
    
    // Member-only page
    if (!isset($_COOKIE['user'])) {
        header('Location: /');
    } else {
        //$user = unserialize($_COOKIE['user']);
		$user = $_COOKIE['userid'];
        $user = new User($user);
    }
    
    $decks = $user->GetDecks();
    $clipDecks = $user->GetCollection();
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
                <option>Subject</option>
                <option>Course Code</option>
                <option>Year</option>
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
		foreach ($decks as $deck) {
	?>
	<div class="browseItem">
        <div class="vote">
            <div class="scores">
                <div class="up score">
                    <?php
                        if ($deck['pubed'] == "1") {
                            echo $deck['upv'];
                        }
                    ?>
                </div>
                <div class="down score">
                    <?php
                        if ($deck['pubed'] == "1") {
                            echo $deck['dnv'];
                        }
                    ?>
                </div>
            </div>
            <div class="voteControls">
                <div class="up control"></div>
                <div class="down control"></div>
            </div>
        </div>
        <div class="deckTag">
            <a href="
                <?php
                    if ($deck['pubed'] == "1") {
                        echo "view.php?deckid=" . $deck['deckid'];
                    } else {
                        echo "#";
                    }
                ?>
            ">
                <div class="halfRow link">
                    <div class="title corner-spaced">
                        <?php echo $deck['title']; ?>
                    </div>
                </div>
            </a>
            <div class="halfRow">
                <div class="info">
                    <br/>
                    <?php echo $deck['subject'] . " - " . $deck['coursecode'] . " - " . substr($deck['tstamp'], 0, 4); ?>
                </div>
            </div>
        </div>
        <div class="userTag">
            <?php
                // If deck not published
                if ($deck['pubed'] == 0) {
            ?>
            <div class="draftTag"></div>
            <?php
                }
            ?>
            <div id="cardCount" class="bottom">
                <?php echo $deck['cardcount']; ?> Cards
            </div>
            <?php
                // If deck not published
                if ($deck['pubed'] == 0) {
            ?>
            <div class="deck-links">
                <a href="
                    <?php echo "edit.php?deckid=" . $deck['deckid']; ?>
                ">
                    <div class="button">Edit</div>
                </a>
                <div class="button publish" deckid="<?php echo $deck['deckid']; ?>">Publish</div>
            </div>
            <?php
                }
            ?>
        </div>
        <div class="remove removeCard createdDeck" deckid="<?php echo $deck['deckid']; ?>" title="Delete Deck"></div>
	</div>
	<?php
		}
	?>
</div>











<?php
    if (count($clipDecks) > 0) {
?>
    <div id="browseNav">
            <div class="left bold title">Clipped Decks</div>
        <div id="navControls">
            <div class="right h-spaced">
                <label for="sortOrder">Sort by:</label>
                <select id="sortOrder">
                    <option>Top</option>
                    <option>New</option>
                    <option>Subject</option>
                    <option>Course Code</option>
                    <option>Year</option>
                </select>
            </div>
        </div>
        <div class="floatLine"></div>
    </div>

<?php
    }
?>

<div id="deckList">
	<?php
		foreach ($clipDecks as $clipDeck) {
        $deck = new Deck($clipDeck);
        $user = new User($deck->creatorid);
	?>
	<div class="browseItem">
        <div class="vote">
            <div class="scores">
                <div class="up score">
                    <?php echo $deck->upv; ?>
                </div>
                <div class="down score">
                    <?php echo $deck->dnv; ?>
                </div>
            </div>
            <div class="voteControls">
                <div class="up control"></div>
                <div class="down control"></div>
            </div>
        </div>
        <div class="deckTag">
            <a href="<?php echo "view.php?deckid=" . $deck->deckid; ?>">
                <div class="halfRow link">
                    <div class="title corner-spaced">
                        <?php echo $deck->title; ?>
                    </div>
                </div>
            </a>
            <div class="halfRow">
                <div class="info">
                    <br/>
                    <?php echo $deck->subject . " - " . $deck->coursecode . " - " . substr($deck->tstamp, 0, 4); ?>
                </div>
            </div>
        </div>
        <div class="userTag">
            <a href="
                <?php echo "#"; ?>
            ">
                <div id="userName" class="halfRow link corner-spaced">
                    <div class="bold">
                        <?php echo $user->GetDisplayName(); ?>
                    </div>
                </div>
            </a>
            <div id="cardCount" class="bottom">
                <?php echo $deck->cardcount; ?> Cards
            </div>
        </div>
        <div class="remove removeCard clippedDeck" deckid="<?php echo $deck->deckid;?>" title="Unclip Deck"></div>
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