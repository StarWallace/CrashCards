<?php
/**
* Written by: Kirk McCulloch
**/
	require_once("../classes/SQLAccess.class.php");
	require_once("../classes/Deck.class.php");
	$db = new SQLAccess();
	
	//if all info given
	if (isset($_REQUEST['creatorid']) && isset($_REQUEST['title']) && isset($_REQUEST['coursecode']) && isset($_REQUEST['subject']) && isset($_REQUEST['cardcount']) && isset($_REQUEST['xml']))
	{
		$creatorid = $_REQUEST['creatorid'];
		$title = $_REQUEST['title'];
		$coursecode = $_REQUEST['coursecode'];
		$subject = $_REQUEST['subject'];
		$cardcount = $_REQUEST['cardcount'];
		$xml = $_REQUEST['xml'];
		
		if (isset($_REQUEST['deckid'])// if is set, this is an existing deck, do an update
		{
			$deckid = $_REQUEST['deckid'];
			//get the existing deck info from the DB and put in a new deck object
			$deck = new Deck($deckid);
			//fill the deck object with the passed in data, thus making any changes
			$deck->FillDeck($deckid, $creatorid, $title, $coursecode, $subject, $deck->tstamp, $deck->upv, $deck->dnv, $cardcount, 0);
			
			//TODO: HOW TO AUTO SET THE TIME STAMP USING CURDATE()
			$db->runQuery("UPDATE ccDecks SET tstamp = CURDATE() WHERE deckid = $deckid");
		}
		else //this is a new deck
		{
			$deck = new Deck(0, $creatorid, $title, $coursecode, $subject, "", 0, 0, $cardcount, 0);
			$dbsave = $deck->SaveDeckToDB();
			
			if (isset($dbsave))
			{
				//get the deckid of the deck just created
				$deckid = $dbsave->fetch_assoc();
				$deckid = $deckid['deckid'];
				
				//get a new deck with the DB stored data
				$deck = new Deck($deckid);
				
				//save the deck
				$deck->SaveDeckXML($xml);
			}
		}
		
		
	}
?>