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








	<!-- THIS SHOULD BE PUT INTO A PHP CLASS -->

	<?php
		//foreach ($decks as $deck) { 
        for ($i = 0; $i < 10; $i++) {
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
        <div class="clip"></div>
	</div>
	
	<?php
		}
	?>
  
	<!----------- END ----------->

</div>

<div class="centred button separated" id="moreResults">
    More Results
</div>

<?php
	/*
	* When using the wrapper system this must be called at the top of every page.
	* It basically just sets a custom title for the page and then pulls in the wrapper
	*/
    $sTitle = "Browse";
    
    require_once("wrapper/wrapper.php");
?>

<script type="text/javascript" src="scripts/browse.js"></script>