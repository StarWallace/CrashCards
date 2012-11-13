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
    
    $browser = new Browse();
    $decks = $browser->getDecks();
    
?>

<link rel="stylesheet" type="text/css" href="wrapper/css/deck.css"/>

<div class="white spaced" id="browseNav">
	<div id="navFilters">
		<select id="campus">
			<option>Campus</option>
		</select>
		<select id="year">
			<option>Year</option>
		</select>
		<select id="department">
			<option>Department</option>
		</select>
		<select id="courseCode">
			<option>Course Code</option>
		</select>
	</div>
	<div id="navControls">
		<input id="browseTop" type="button" value="TOP"/>
		<input id="browseNew" type="button" value="NEW"/>
	</div>
</div>
<br/>
<div class="white spaced" id="deckList">








	<!-- THIS SHOULD BE PUT INTO A PHP CLASS -->

	<?php
		foreach ($decks as $deck) { 
	?>
	
	<div class="browseItem">
        <div class="vote">
            <div class="up control"></div>
            <div class="score">
                <?php echo $deck->score; ?>
            </div>
            <div class="down control"></div>
        </div>
        <div class="deckTagHolder">
            <div class="deckTag">
                <a href="
                    <?php echo $deck->link; ?>
                ">
                    <div class="halfRow link">
                        <div class="title">
                            <?php echo $deck->title; ?>
                        </div>
                    </div>
                </a>
                <div class="halfRow">
                    <div class="info">
                        <br/>
                        <?php echo "$deck->department $deck->course - $deck->term $deck->year - $deck->campus"; ?>
                    </div>
                    <div class="tags">
                        <br/>
                        <?php echo implode(", ", $deck->tags); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="userTag">
            <a href="
                <?php echo $deck->creator->link; ?>
            ">
                <div id="userName" class="halfRow link">
                    <div>
                        <strong>
                            <?php echo $deck->creator->name; ?>
                        </strong>
                    </div>
                </div>
            </a>
            <div class="halfRow">
                <div>
                    <?php echo $deck->creator->rating; ?>
                </div>
            </div>
        </div>
	</div>
	
	<?php
		}
	?>
  
	<!----------- END ----------->

</div>

<?php
	/*
	* When using the wrapper system this must be called at the top of every page.
	* It basically just sets a custom title for the page and then pulls in the wrapper
	*/
    $sTitle = "Browse";
    
    require_once("wrapper/wrapper.php");
?>