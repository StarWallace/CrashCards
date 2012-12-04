<?php
/**
* Written by: Kirk McCulloch
* Script called when a user up votes or down votes a deck of flash cards
* Requires:
*	deckid - the id of the deck
*	uid - the id of the sending user
*	isupv - boolean (1/0) telling wether to upvote or not
*		1: upvote 
*		0: downvote
**/
    
	require_once("../classes/SQLAccess.class.php");
    require_once("../classes/User.class.php");
    require_once("../classes/Deck.class.php");
    
	$db = new SQLAccess();
    
    $result = array(
        "success" => 1,
        "message" => "",
        "up" => "0",
        "down" => "0"
    );
    
    $deckid = $_REQUEST['deckid'];
    $deck = new Deck($deckid);
	
    if ($deck->creatorid == "" || $deck->pubed == "0") {
        $result["message"] = "Deck not found.";
    } else if (!isset($_COOKIE['user'])) {
        $result["message"] = "You must be logged in to vote for this deck.";
    } else {
        $user = unserialize($_COOKIE['user']);
        
        //get passed data
        $uid = $user->uid;
        $isupv = $_REQUEST['isupv'];
        
        //$result = true; //default to true

        //check the db for an existing vote
        $qryCheck = $db->selectQuery("*", "ccVotes", "deckid = $deckid AND uid = $uid");
        
        //create an arry to store update data for the deck table
        $aDeck = Array();
        $aDeck['deckid'] = $deckid;
        
        //if a vote has already been made
        if ($qryCheck->num_rows > 0)
        {
            //delete the old vote
            $qryVote = $db->deleteQuery("ccVotes", "deckid = $deckid AND uid = $uid");
            $result["success"] = $qryVote;
            //insert the new vote
            $qryVote = $db->insertQuery("ccVotes", "deckid, uid, isupv", "$deckid, $uid, $isupv");
            $result["success"] = $result["success"] && $qryVote; //determine result from old result and the new result
        
            //get the old vote data
            $oldVote = $qryCheck->fetch_assoc();
            
            // if ($oldVote['isupv'] == 1)//if the old vote was an upvote
            // {
                // $aDeck['upv'] = "upv-1"; //decrement the upv
            // }
            // else //else it was a downvote
            // {
                // $aDeck['dnv'] = "dnv-1"; //decrement the dnv
            // }
            
            //determine what to decrement based on the old vote
            $aDeck['upv'] = ($oldVote['isupv'] == 1)  ? "upv-1" : "upv"; //if upv, decrement upv
            $aDeck['dnv'] = ($oldVote['isupv'] == 0)  ? "dnv-1" : "dnv"; //if dnv, decrement dnv
            //decrement the applicable deck vote count
            $stmt = $db->dbConnect->prepare("UPDATE ccDecks SET upv=" . $aDeck['upv'] . ", dnv=" . $aDeck['dnv'] . " WHERE deckid=?");
            $stmt->bind_param('i', $aDeck['deckid']);
            $qryDeck = $stmt->execute();
            
            $result["success"] = $result["success"] && $qryDeck; //determine result from old result and the new result
            
            //increment the vote count for the new vote
            //repurpose the old deck array
            $aDeck['upv'] = ($isupv == 1)  ? "upv+1" : "upv"; //if upv, increment upv
            $aDeck['dnv'] = ($isupv == 0)  ? "dnv+1" : "dnv"; //if dnv, increment dnv
            $stmt = $db->dbConnect->prepare("UPDATE ccDecks SET upv=" . $aDeck['upv'] . ", dnv=" . $aDeck['dnv'] . " WHERE deckid=?");
            $stmt->bind_param('i', $aDeck['deckid']);
            $qryDeck = $stmt->execute();
            $result["success"] = $result["success"] && $qryDeck; //determine result from old result and the new result
        }
        else //this is a totally new vote
        {
            //insert the new vote
            $qryVote = $db->insertQuery("ccVotes", "deckid, uid, isupv", "$deckid, $uid, $isupv");
            $result["success"] = $result["success"] && $qryVote; //determine result from old result and the new result
            
            //increment the vote count for the new vote
            $aDeck['upv'] = ($isupv == 1)  ? "upv+1" : "upv"; //if upv, increment upv
            $aDeck['dnv'] = ($isupv == 0)  ? "dnv+1" : "dnv"; //if dnv, increment dnv
            
            $stmt = $db->dbConnect->prepare("UPDATE ccDecks SET upv=" . $aDeck['upv'] . ", dnv=" . $aDeck['dnv'] . " WHERE deckid=?");
            $stmt->bind_param('i', $aDeck['deckid']);
            $qryDeck = $stmt->execute();
            
            $result["success"] = $result["success"] && $qryDeck; //determine result from old result and the new result
        }
        
        $voteTotal = $db->selectQuery("upv, dnv", "ccDecks", "deckid=$deckid");
        $voteTotal = $voteTotal->fetch_assoc();
        if ($result["success"]) {
            $result["success"] = "1";
            $result["up"] = $voteTotal['upv'];
            $result["down"] = $voteTotal['dnv'];
        } else {
            $result["success"] = "0";
        }
    }
	//echo the final result of the script
	echo json_encode($result);
?>