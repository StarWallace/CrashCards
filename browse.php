<?php
	ob_start(); 
?>	

<?php
    function __autoload($sClassName) {
        require_once("classes/$sClassName.class.php");
    }
    require_once("scripts/GetFullLists.php");
    
    if (isset($_COOKIE['userid'])) {
        $user = $_COOKIE['userid'];
        $user = new User($user);
        $availableViews = $user->GetAvailableViewCount();
    } else {
        $availableViews = 0;
    }
    
?>

<link rel="stylesheet" type="text/css" href="wrapper/css/browse.css"/>
<link rel="stylesheet" type="text/css" href="wrapper/css/deck.css"/>

<div id="pageTitle">
    <h3>Browse</h3>
</div>
<div id="numberOfViews">
    <h3><?php echo $availableViews; ?> Available Views</h3>
</div>
<div class="floatLine"></div>

<div class="white h-spaced" id="browseNav">
	<div id="navFilters">
		<select id="subject">
			<option value="">- All Subjects -</option>
            <?php
                $subjects = GetSubjectList();
                for ($i = 0; $i < count($subjects); $i++) {
                    echo "<option>" . $subjects[$i]['subject'] . "</option>";
                }
            ?>
		</select>
		<select id="courseCode">
			<option value="">- All Courses -</option>
            <?php
                $coursecodes = GetCoursecodeList();
                for ($i = 0; $i < count($coursecodes); $i++) {
                    echo "<option>" . $coursecodes[$i]['coursecode'] . "</option>";
                }
            ?>
		</select>
		<select id="year">
			<option value="">- All Years -</option>
            <?php
                $years = GetYearList();
                for ($i = 0; $i < count($years); $i++) {
                    echo "<option>" . $years[$i]['year'] . "</option>";
                }
            ?>
		</select>
	</div>
    <div id="navControls">
        <label for="sortOrder">Sort by:</label>
        <select id="sortOrder">
            <option>New</option>
            <option>Top</option>
            <option>Subject</option>
            <option>Course Code</option>
        </select>
    </div>
</div>
<br/>
<div id="deckList">
    <?php
        $_GET['subject'] = "";
        $_GET['coursecode'] = "";
        $_GET['year'] = "";
        $_GET['sort'] = "New";
        $_GET['index'] = "0";
        require_once("scripts/GetBrowseDecks.php");
    ?>
</div>
<div class="centred button separated" id="moreResults">
    More Results
</div>
<div class="white shadow h-spaced v-spaced separated text-centred" style="display: none;" id="message"></div>

<?php
    $sTitle = "Browse";
    
    require_once("wrapper/wrapper.php");
?>

<script type="text/javascript" src="scripts/vote.js"></script>
<script type="text/javascript" src="scripts/clip.js"></script>
<script type="text/javascript" src="scripts/browse.js"></script>