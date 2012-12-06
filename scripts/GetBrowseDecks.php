<?php
    
	require_once("classes/SQLAccess.class.php");
    require_once("classes/User.class.php");
    
	$db = new SQLAccess();
    
    if (isset($_COOKIE['user'])) {
        //$user = unserialize($_COOKIE['user']);
		$user = $_COOKIE['userid'];
        $user = new User($user);
        $uid = $user->uid;
        $query = "SELECT d.*, (SELECT COUNT(*) FROM ccClips c WHERE c.uid=$uid AND c.deckid = d.deckid) AS clipped FROM ccDecks d WHERE pubed = 1 ";
    } else {
        $query = "SELECT *, 0 AS clipped FROM ccDecks WHERE pubed = 1 ";
    }
        
    // Get passed data
    $subject = isset($_GET['subject']) ? $_GET['subject'] : "";
    $coursecode = isset($_GET['coursecode']) ? $_GET['coursecode'] : "";
    $year = isset($_GET['year']) ? $_GET['year'] : "";
    $sort = isset($_GET['sort']) ? $_GET['sort'] : "";
    $index = isset($_GET['index']) ? $_GET['index'] : 0;
    $offset = $index + 10;
    
    $paramTypes = "";
    $paramValues = array();
    
    
    if ($subject != "") {
        $query .= " AND subject = ? ";
        $paramTypes .= "s";
        $paramValues[] = $subject;
    }
    if ($coursecode != "") {
        $query .= " AND coursecode = ? ";
        $paramTypes .= "s";
        $paramValues[] = $coursecode;
    }
    if ($year != "") {
        $query .= " AND DATE_FORMAT(tstamp, '%Y') = ? ";
        $paramTypes .= "s";
        $paramValues[] = $year;
    }
    if ($sort != "") {
        $query .= " ORDER BY ";
        if ($sort == "Top") {
            $query .= "upv - dnv DESC ";
        } else if ($sort == "New") {
            $query .= "tstamp DESC ";
        } else if ($sort == "Subject") {
            $query .= "subject "; 
        } else if ($sort == "Course Code") {
            $query .= "coursecode ";
        }
    }
    $query .= " LIMIT ?, ? ";
    $paramTypes .= "ii";
    $paramValues[] = $index;
    $paramValues[] = $offset;
    
    $stmt = $db->dbConnect->prepare($query);
        
    switch (count($paramValues)) {
        case 5:
            $stmt->bind_param($paramTypes, $paramValues[0], $paramValues[1], $paramValues[2], $paramValues[3], $paramValues[4]);
            break;
        case 4:
            $stmt->bind_param($paramTypes, $paramValues[0], $paramValues[1], $paramValues[2], $paramValues[3]);
            break;
        case 3:
            $stmt->bind_param($paramTypes, $paramValues[0], $paramValues[1], $paramValues[2]);
            break;
        default:
            $stmt->bind_param($paramTypes, $paramValues[0], $paramValues[1]);
    }
    
    $result = $stmt->execute();
    
    if ($result) {
        $stmt->bind_result($deck['deckid'],
                           $deck['creatorid'],
                           $deck['title'],
                           $deck['coursecode'],
                           $deck['subject'],
                           $deck['tstamp'],
                           $deck['upv'],
                           $deck['dnv'],
                           $deck['cardcount'],
                           $deck['pubed'],
                           $deck['clipped']);
                           
        while ($stmt->fetch()) {
            $user = new User($deck['creatorid']);
            include("browsedeck.php");
        }
    } else {
        
    }
?>