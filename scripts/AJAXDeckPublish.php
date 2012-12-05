<?php
    
	require_once("../classes/SQLAccess.class.php");
	require_once("../classes/Deck.class.php");
    require_once("../classes/User.class.php");
        
    $result = array(
        "success" => "0",
        "message" => ""
    );
    
    $authError = "You must be logged in to publish this deck.";
    $publishedError = "This deck has already been published.";
    
	$db = new SQLAccess();
    $deckid = $_REQUEST['deckid'];
    $deck = new Deck($deckid);
    
    if (!isset($_COOKIE['user'])) {
        // User not logged in
        $result['message'] = $authError;
    } else if ($deck->pubed == 1) {
        // Deck already published
        $result['message'] = $publishedError;
    } else {
        //$user = unserialize($_COOKIE['user']);
		$user = $_COOKIE['userid'];
        $user = new User($user);
        $creatorid = $user->uid;
        if ($creatorid != $deck->creatorid) {
            // User not creator of deck
            $result['message'] = $authError;
        } else {
            // User is able to publish
            $stmt = $db->dbConnect->prepare("UPDATE ccDecks SET tstamp=CURDATE(), pubed = 1 WHERE deckid = ?");
            $stmt->bind_param('i', $deck->deckid);
            $publish = $stmt->execute();
            
            if ($publish) {
                $result['success'] = "1";
            }
        }
    }
    
    echo json_encode($result);
?>