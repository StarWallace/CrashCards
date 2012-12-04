<?php
/**
* Written by: Kirk McCulloch
* Script called when a user clips a deck of flash cards
* Attributes:
*	deckid - the id of the deck (required)
**/

	require_once("../classes/SQLAccess.class.php");
    require_once("../classes/User.class.php");
    require_once("../classes/Deck.class.php");
	$db = new SQLAccess();
    
    $result = array(
        "success" => "0",
        "message" => ""
    );
	
	//get passed data
    if (isset($_COOKIE['user'])) {
        if (isset($_REQUEST['deckid'])) {
            $user = unserialize($_COOKIE['user']);
            $deckid = $_REQUEST['deckid'];
            $deck = new Deck($deckid);
            if ($deck->creatorid != "") {
                $uid = $user->uid;
                
                $qryClip = $db->selectQuery("*", "ccClips", "uid = $uid AND deckid = $deckid");
                if (mysqli_num_rows($qryClip) < 1) {
                    // Clip the deck
                    $qryClip = $db->insertQuery("ccClips", "uid, deckid", "$uid, $deckid");
                    $result["success"] = "1";
                    $result["message"] = "Deck successfully clipped.";
                } else {
                    // Unclip the deck
                    $qryClip = $db->deleteQuery("ccClips", "uid = $uid AND deckid = $deckid");
                    $result["success"] = "2";
                    $result["message"] = "Deck successfully unclipped.";
                }
                
                if (!$qryClip) {
                    $result["success"] = "0";
                    $result["message"] = "Operation failed.";
                }
                
            } else {
                $result["message"] = "Deck does not exist.";
            }
        } else {
            $result["message"] = "Deck ID required.";
        }
    } else {
        $result["message"] = "You must be logged in to clip this deck.";
    }
    
	//echo the final result of the script
	echo json_encode($result);

?>