<?php
/**
* Written by: Kirk McCulloch
**/

	require_once("../classes/SQLAccess.class.php");
	require_once("../classes/Deck.class.php");
    require_once("../classes/User.class.php");
    
	$db = new SQLAccess();
    if (isset($_COOKIE['user'])) {
        $user = unserialize($_COOKIE['user']);
    }
    
    $result = array(
        "success" => "0",
        "message" => "",
        "id" => "0"
    );

	//if all info given
	if (isset($_REQUEST['title']) && isset($_REQUEST['coursecode']) && isset($_REQUEST['subject']) && isset($_REQUEST['cardcount']) && isset($_REQUEST['xml']))
	{
        $deckid = $_REQUEST['deckid'];
        $creatorid = $user->uid;
		$title = $_REQUEST['title'];
		$coursecode = $_REQUEST['coursecode'];
		$subject = $_REQUEST['subject'];
		$cardcount = $_REQUEST['cardcount'];
		$xml = $_REQUEST['xml'];
		
		if ($deckid != 0) // if is set, this is an existing deck, do an update
		{
			$deckid = $_REQUEST['deckid'];
			//get the existing deck info from the DB and put in a new deck object
			$deck = new Deck($deckid);
            
            //verify that the deck's original creator is logged in
            if ($creatorid != $deck->creatorid)
            {
                $result['message'] = "You must be logged in to save this deck.";
            }
            
			//fill the deck object with the passed in data, thus making any changes
			$deck->FillDeck($deckid, $creatorid, $title, $coursecode, $subject, $deck->tstamp, $deck->upv, $deck->dnv, $cardcount, 0);
			
            $dbsave = $deck->SaveDeckToDB(true);
            $db->runQuery("UPDATE ccDecks SET tstamp = CURDATE() WHERE deckid = $deckid");
		}
		else //this is a new deck
		{
            
			$deck = new Deck();
            $deck->FillDeck(0, $creatorid, $title, $coursecode, $subject, "", 0, 0, $cardcount, 0);
            
			$dbsave = $deck->SaveDeckToDB();
			
			if ($dbsave)
			{
				//get the deckid of the deck just created
                $deckid = $dbsave;
            }
		}
        
        if ($dbsave)
        {        
            //get a new deck with the DB stored data
            $deck = new Deck($deckid);
            $result['id'] = $deckid;
            
            //save the deck
            $saveDeck = $deck->SaveDeckXML($xml);                
            if (!$saveDeck) {
                $result['message'] = "Deck could not be saved.";
            } else {
                $result['success'] = "1";
                $result['message'] = "Deck saved successfully!";
            }
        } else {
            $result['message'] = "Deck could not be saved.";
        }
	}
    
    echo json_encode($result);
?>