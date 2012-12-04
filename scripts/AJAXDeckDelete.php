<?php
    
	require_once("../classes/SQLAccess.class.php");
	require_once("../classes/Deck.class.php");
    require_once("../classes/User.class.php");
        
    $result = array(
        "success" => "0",
        "message" => ""
    );
    
    $authError = "You must be logged in to delete this deck.";
    
	$db = new SQLAccess();
    $deckid = $_REQUEST['deckid'];
    $deck = new Deck($deckid);
    
    if (!isset($_COOKIE['user'])) {
        // User not logged in
        $result['message'] = $authError;
    } else {
        $user = unserialize($_COOKIE['user']);
        $creatorid = $user->uid;
        if ($creatorid != $deck->creatorid) {
            // User not creator of deck
            $result['message'] = $authError;
        } else {
            // User is able to delete
            $deleteDeck = $db->deleteQuery("ccDecks", "deckid = $deckid");
            $deleteClip = $db->deleteQuery("ccClips", "deckid = $deckid");
            if ($deleteDeck) {
                $result['success'] = "1";
            }
        }
    }
    
    echo json_encode($result);
?>