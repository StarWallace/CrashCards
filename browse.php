<?php 
	/*
	* When using the wrapper system this must be called at the top of every page.
	* It basically just says to "start output"
	*/
	ob_start(); 
?>	

<?php
    function __autoload($sClassName) {
        require_once("classes/$sClassName.class.php");
    }
    
    // Just used as an example
    // Results will be fetched from the database based on some default filtering and sort order
    // (e.g., some combination of new and highly-rated notes, possibly personalized for the user)
    // Future results will depend on the search and filter parameters
    
    $db = new SQLAccess();
    $result = $db->selectQuery("*", "ccDecks", "pubed=1", "upv-dnv DESC");
?>

<link rel="stylesheet" type="text/css" href="wrapper/css/browse.css"/>
<link rel="stylesheet" type="text/css" href="wrapper/css/deck.css"/>

<div id="pageTitle">
    <h3>Browse</h3>
</div>
<div id="numberOfViews">
    <h3>18 Available Views</h3>
</div>
<div class="floatLine"></div>

<div class="white h-spaced" id="browseNav">
	<div id="navFilters">
		<select id="subject">
			<option>Subject</option>
		</select>
		<select id="courseCode">
			<option>Course Code</option>
		</select>
		<select id="year">
			<option>Year</option>
		</select>
	</div>
    <div id="navControls">
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
<br/>
<div id="deckList">

	<?php
        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
            $deck = mysqli_fetch_assoc($result);
            $user = new User($deck['creatorid']);
	?>
	
	<div class="browseItem" deckid="<?php echo $deck['deckid']; ?>">
        <div class="vote">
            <div class="scores">
                <div class="up score">
                    <?php echo $deck['upv']; ?>
                </div>
                <div class="down score">
                    <?php echo $deck['dnv']; ?>
                </div>
            </div>
            <div class="voteControls">
                <div class="up control"></div>
                <div class="down control"></div>
            </div>
        </div>
        <div class="deckTag">
            <a href="
                <?php echo "view.php?deckid=" . $deck['deckid']; ?>
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
            <a href="
                <?php echo "#"; ?>
            ">
                <div id="userName" class="halfRow link corner-spaced">
                    <div class="bold">
                        <?php echo $user->GetDisplayName(); ?>
                    </div>
                </div>
            </a>
        </div>
        <div
            class="clip" deckid="<?php echo $deck['deckid']; ?>"
        >
        
        <!-- FROM PHP, ADD TO DECK ARRAY WHETHER THE DECK IS CLIPPED BY THE CURRENT USER -->
        
        </div>
	</div>
	
	<?php
		}
	?>
</div>

<div class="centred button separated" id="moreResults">
    More Results
</div>

<?php
    $sTitle = "Browse";
    
    require_once("wrapper/wrapper.php");
?>

<script type="text/javascript" src="scripts/browse.js"></script>