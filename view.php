<?php 
	/*
	* When using the wrapper system this must be called at the top of every page.
	* It basically just says to "start output"
	*/
	ob_start();
    require_once("classes/Deck.class.php");
    
    if (!isset($_COOKIE['user'])) {
        // Not logged in
        header('Location: /');
    } else {
        if (isset($_GET['deckid'])) {
            $deck = new Deck($_GET['deckid']);
            if ($deck->creatorid != "") {
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