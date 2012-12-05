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
        require_once("scripts/AJAXBrowse.php");
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