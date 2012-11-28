<?php
	require_once("../classes/SQLAccess.class.php");
	require_once("../classes/Deck.class.php");
    require_once("../classes/User.class.php");
    
	$db = new SQLAccess();
    $user = unserialize($_COOKIE['user']);
	
    $queryString = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $queryString = $queryString['query'];
    parse_str($queryString, $params);
    $deckid = isset($params['deckid']) ? $params['deckid'] : "";

	//if all info given
	if (isset($_REQUEST['title']) && isset($_REQUEST['coursecode']) && isset($_REQUEST['subject']) && isset($_REQUEST['cardcount']) && isset($_REQUEST['xml']))
	{
		$creatorid = $user->uid;
		$title = $_REQUEST['title'];
		$coursecode = $_REQUEST['coursecode'];
		$subject = $_REQUEST['subject'];
		$cardcount = $_REQUEST['cardcount'];
		$xml = $_REQUEST['xml'];
		
		if ($deckid != "") // if is set, this is an existing deck, do an update
		{
			$deckid = $_REQUEST['deckid'];
			//get the existing deck info from the DB and put in a new deck object
			$deck = new Deck($deckid);
            
            //verify that the deck's original creator is logged in
            if ($user->uid != $deck->creatorid)
            {
                return "<p class='err'>You must be logged in to save this deck.</p>";
            }
            
			//fill the deck object with the passed in data, thus making any changes
			$deck->FillDeck($deckid, $creatorid, $title, $coursecode, $subject, $deck->tstamp, $deck->upv, $deck->dnv, $cardcount, 0);
			
			//TODO: HOW TO AUTO SET THE TIME STAMP USING CURDATE()
            
            $dbsave = $deck->SaveDeckToDB();
            
		}
		else //this is a new deck
		{
			$deck = new Deck();
            $deck->FillDeck(0, $creatorid, $title, $coursecode, $subject, "", 0, 0, $cardcount, 0);
            
			$dbsave = $deck->SaveDeckToDB();
			
			if (isset($dbsave))
			{
				//get the deckid of the deck just created
                $deckid = mysql_insert_id();
            }
		}
        
        if (isset($dbsave))
        {        
            //get a new deck with the DB stored data
            $deck = new Deck($deckid);
            
            //save the deck
            $deck->SaveDeckXML($xml);
        }
	}
?>