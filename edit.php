<?php
	ob_start();
    require_once("classes/Deck.class.php");
    require_once("classes/User.class.php");
    
    if (!isset($_COOKIE['user'])) {
        // Not logged in
        header('Location: /');
    } else {
        // Set user object
        $user = unserialize($_COOKIE['user']);
        if (isset($_GET['deckid'])) {
            $deck = new Deck($_GET['deckid']);
            if ($deck->creatorid == '') {
                // Deck does not exist
                header('HTTP/1.0 404 Not Found');
                require_once("error/404.php");
            } else if (!$deck->IsCreator($user->uid)) {
                // Not creator the deck, cannot edit
                header('HTTP/1.0 403 Forbidden');
                require_once("error/403.php");
            } else {
                // User is creator of this deck
                require_once("editdeck.php");
            }
        } else {
            // No deckid
            require_once("editdeck.php");
        }
    }
    
    $sTitle = "Edit Deck";
    require_once("wrapper/wrapper.php");
?>