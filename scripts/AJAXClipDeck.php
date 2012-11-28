<?php
/**
* Written by: Kirk McCulloch
* Script called when a user clips a deck of flash cards
* Attributes:
*	uid - the id of the sending user (required)
*	deckid - the id of the deck (required)
*	unclip - switch, telling wether to unclip or not, set to anything (i.e. true)
**/

	require_once("../classes/SQLAccess.class.php");
	$db = new SQLAccess();
	
	//get passed data
	$uid = $_REQUEST['uid'];
	$deckid = $_REQUEST['deckid'];
	$result = true; //default to true
	
	if (isset($_REQUEST['unclip'])) //if unclip is set
	{
		//unclip
		$qryClip = $db->deleteQuery("ccClips", "uid = $uid AND deckid = $deckid");
		$result = $result && $qryClip; //determine result from old result and the new result
	}
	else //else clip
	{
		//insert the new clip
		$qryClip = $db->insertQuery("ccClips", "uid, deckid", "$uid, $deckid");
		$result = $result && $qryClip; //determine result from old result and the new result
	}
	//echo the final result of the script
	echo $result;

?>