<?php 
	/*
	* When using the wrapper system this must be called at the top of every page.
	* It basically just says to "start output"
	*/
	ob_start();
    require_once("classes/Deck.class.php");
    require_once("classes/User.class.php");
    
    if (!isset($_COOKIE['user'])) {
        // Not logged in
        header('Location: /');
    } else {
        $user = $_COOKIE['userid'];
        $user = new User($user);
        if (isset($_GET['deckid'])) {
            $deck = new Deck($_GET['deckid']);
            $creator = new User($deck->creatorid);
            if ($deck->creatorid != "" && $deck->pubed == "1") {
                if ($deck->IsCreator($user) || $user->HasViewedDeck($deck->deckid)) {
                    require_once("viewdeck.php");
                } else if ($user->GetAvailableViewCount() > 0) {
                    $user->LogDeckView($deck->deckid);
                    require_once("viewdeck.php");
                } else {
                    require_once("error/noviews.php");
                }
            
                require_once("viewdeck.php");
            } else {
                header('HTTP/1.0 404 Not Found');
                require_once("error/404.php");
            }
        } else {
            header('HTTP/1.0 404 Not Found');
            require_once("error/404.php");
        }
    }
        
    $sTitle = "View Deck";
    require_once("wrapper/wrapper.php");
?>