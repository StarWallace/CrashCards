<?php
/**
* Written by: Kirk McCulloch
**/
require_once("SQLAccess.class.php");

class Deck 
{
        
	public $deckid, $creatorid, $title, $coursecode, $subject, $tstamp, $upv, $dnv, $cardcount, $pubed;
	private $db;

	function __construct($deckid="", $creatorid="", $title="", $coursecode="", $subject="", $tstamp="", $upv="", $dnv="", $cardcount="", $pubed="")
	{
		//all cases need this
		$this->db = new SQLAccess();
		//if we have a deckid
		if ($deckid != "")
		{
			//if we have a creator id (assume all other attributes also passed in)
			if ($creatorid != "")
			{
				//fill deck object with all data
				$this->FillDeck($deckid, $creatorid, $title, $coursecode, $subject, $tstamp, $upv, $dnv, $pubed);
			}
			else //else only the deckid is passed, get the full object from the DB
			{
				//get full user data
				$qryDeck = $this->db->selectQuery(
					"*",
					"ccDecks",
					"deckid = '" . $deckid . "'" );
				$aInfo = $qryDeck->fetch_assoc();
				//insert all DB user data into the php object
				$this->FillDeck($aInfo['deckid'], $aInfo['creatorid'], $aInfo['title'], $aInfo['coursecode'], $aInfo['subject'], $aInfo['tstamp'], $aInfo['upv'], $aInfo['dnv'], $aInfo['cardcount'], $aInfo['pubed']);
			}
		}
	}
    
	/************************************************************
	*FUNCTION:    FillDeck
	*PURPOSE:     Fills the deck object with the passed in data strips all special chars and tags for safety
	************************************************************/
    function FillDeck($deckid, $creatorid, $title="", $coursecode="", $subject="", $tstamp="", $upv="", $dnv="", $cardcount="", $pubed="")
    {
		//all this does is strips off any special characters that might cause problems in
		//SQL, php, or html
		$this->deckid = $this->db->dbConnect->escape_string(htmlspecialchars(strip_tags($deckid)));
		$this->creatorid = $this->db->dbConnect->escape_string(htmlspecialchars(strip_tags($creatorid)));	
		$this->title = $this->db->dbConnect->escape_string(htmlspecialchars(strip_tags($title)));
		$this->coursecode = $this->db->dbConnect->escape_string(htmlspecialchars(strip_tags($coursecode)));
		$this->subject = $this->db->dbConnect->escape_string(htmlspecialchars(strip_tags($subject)));
		$this->tstamp = $this->db->dbConnect->escape_string(htmlspecialchars(strip_tags($tstamp)));	
		$this->upv = $this->db->dbConnect->escape_string(htmlspecialchars(strip_tags($upv)));
		$this->dnv = $this->db->dbConnect->escape_string(htmlspecialchars(strip_tags($dnv)));	
		$this->cardcount = $this->db->dbConnect->escape_string(htmlspecialchars(strip_tags($cardcount)));	
		$this->pubed = $this->db->dbConnect->escape_string(htmlspecialchars(strip_tags($pubed)));
    }
    
	/************************************************************
	*FUNCTION:    CheckIfClipped
	*PURPOSE:     check if this deck is already clipped by the user
	*NOTE:		  This function assumes that the deck object has its attributes filled
	*RETURN:      true or false
	************************************************************/
	function CheckIfClipped($uid)
	{
		//check the db for an existing clip
		$qryCheck = $this->db->selectQuery("*", "ccClips", "uid = $uid AND deckid = " . $this->deckid);
		//if the check query found an existing clip entry, true, else false
		$result = ($qryCheck->num_rows > 0);
		
		return $result;
	}
	
	/************************************************************
	*FUNCTION:    GetDeckXML
	*PURPOSE:     returns the XML string of the cards for this deck
	*NOTE:		  This function assumes that the deck object has its attributes filled
	*RETURN:      a string with the xml data
	************************************************************/
    function GetDeckXML()
    {
    	$result = null;
    	if (isset($this->deckid) && isset($this->creatorid))
    	{
    		$deckPath = "decks/" . $this->creatorid . "-" . $this->deckid . ".xml";
			//read the xml fil into a string
			$result = file_get_contents($deckPath);
    	}
    	return $result;
    }    
	
	/************************************************************
	*FUNCTION:    GetDeckArray
	*PURPOSE:     returns an array of the cards for this deck
	*NOTE:		  This function assumes that the deck object has its attributes filled
	*RETURN:      an array with the cards data
	************************************************************/
	function GetDeckArray()
	{
		$xmlStr = $this->GetDeckXML();
		$xmlOb = simplexml_load_string($xmlStr);
		$xmlArr = $this->objectsIntoArray($xmlOb);
		return $xmlArr['card'];
	}
	
	/************************************************************
	*FUNCTION:    CheckDupUser
	*PURPOSE:     Call to check if the user object's email is in use by an existing user
	*							 This function assumes that the email attribute is set
	*RETURN:      True on duplicate, false on unused email address
	************************************************************/
	function SaveDeckXML($xml)
	{
		//path string for the deck location and name
		$deckPath = $_SERVER['DOCUMENT_ROOT'] . "/decks/" . $this->creatorid . "-" . $this->deckid . ".xml";
		//open file handler, will be created if it does not exist
        $fp = fopen($deckPath, "w+");
		//write xml into file
		fwrite($fp, $xml);
		//close file handler
		fclose($fp);
	}
	
	/************************************************************
	*FUNCTION:    CheckDupUser
	*PURPOSE:     Call to check if the user object's email is in use by an existing user
	*							 This function assumes that the email attribute is set
	*RETURN:      True on duplicate, false on unused email address
	************************************************************/
	function SaveDeckToDB($update=false)
	{
		$result = false;
		//if this is an update save
		if ($update == true)
		{
			$aUpdate = Array();
			$aUpdate['deckid'] = $this->deckid;
			$aUpdate['creatorid'] = $this->creatorid;
			$aUpdate['title'] = $this->title;
			$aUpdate['coursecode'] = $this->coursecode;
			$aUpdate['subject'] = $this->subject;
			$aUpdate['tstamp'] = $this->tstamp;
			$aUpdate['upv'] = $this->upv;
			$aUpdate['dnv'] = $this->dnv;
			$aUpdate['cardcount'] = $this->cardcount;
			$aUpdate['pubed'] = $this->pubed;
			$qrySave = $this->db->updateQuery("ccDecks", $aUpdate, "deckid");
			$result = $qrySave;
		}
		else //this is a new deck save
		{
			$qrySubject = $this->db->selectQuery("subject", "ccSubjects", "subject = '" . $this->subject . "'");
			if ($qrySubject->num_rows < 1) //if the subject does not exist
			{
				$qrySubject = $this->db->insertQuery("ccSubjects", "subject", "'" . $this->subject . "'");
			}
			$qryCourse = $this->db->selectQuery("coursecode", "ccCourses", "coursecode = '" . $this->coursecode . "'");
			if ($qryCourse->num_rows < 1) //if the coursecode does not exist
			{
				$qryCourse = $this->db->insertQuery("ccCourses", "coursecode, subject", "'" . $this->coursecode . "', '" . $this->subject . "'");
			}
			$qrySave = $this->db->insertQuery(
						"ccDecks",
						"deckid, creatorid, title, coursecode, subject, tstamp, upv, dnv, cardcount, pubed",
						"NULL, '" . $this->creatorid . "', '" . $this->title . "', '" . $this->coursecode . "', '" . $this->subject . "', CURDATE(), " . $this->upv . ", " . $this->dnv . ", " . $this->cardcount . ", " . $this->pubed);
			$result = mysqli_insert_id($this->db->dbConnect);
		}
		return $result;
	}
	
	/************************************************************
	*FUNCTION:    objectsIntoArray
	*PURPOSE:     Helper method to convert XML to an array
	************************************************************/
	function objectsIntoArray($arrObjData, $arrSkipIndices = array())
	{
		$arrData = array();
		
		// if input is object, convert into array
		if (is_object($arrObjData)) 
		{
			$arrObjData = get_object_vars($arrObjData);
		}
		
		if (is_array($arrObjData)) 
		{
			foreach ($arrObjData as $index => $value) 
			{
				if (is_object($value) || is_array($value)) 
				{
					$value = $this->objectsIntoArray($value, $arrSkipIndices); // recursive call
				}
				if (in_array($index, $arrSkipIndices)) 
				{
					continue;
				}
				$arrData[$index] = $value;
			}
		}
		return $arrData;
	}
    
}
?>