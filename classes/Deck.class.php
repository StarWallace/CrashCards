<?php
require_once("SQLAccess.class.php");

class Deck 
{
        
	public $deckid, $creatorid, $year, $title, $coursecode, $prof, $campus, $desc, $pubed;
	private $db;

	function __construct()
	{
		$this->db = new SQLAccess();
	}

	function __construct($deckid, $creatorid, $year, $title, $coursecode, $prof, $campus, $desc, $pubed)
	{
		$this->db = new SQLAccess();
		$this->FillDeck($deckid, $creatorid, $year, $title, $coursecode, $prof, $campus, $desc, $pubed);
	}
    
    function FillDeck($deckid, $creatorid, $year, $title, $coursecode, $prof, $campus, $desc, $pubed)
    {
		//all this does is strips off any special characters that might cause problems in
		//SQL, php, or html
		$this->deckid = $this->db->dbConnect->escape_string(htmlspecialchars(strip_tags($deckid)));
		$this->creatorid = $this->db->dbConnect->escape_string(htmlspecialchars(strip_tags($creatorid)));
		$this->year = $this->db->dbConnect->escape_string(htmlspecialchars(strip_tags($year)));		
		$this->title = $this->db->dbConnect->escape_string(htmlspecialchars(strip_tags($title)));
		$this->coursecode = $this->db->dbConnect->escape_string(htmlspecialchars(strip_tags($coursecode)));
		$this->prof = $this->db->dbConnect->escape_string(htmlspecialchars(strip_tags($prof)));
		$this->campus = $this->db->dbConnect->escape_string(htmlspecialchars(strip_tags($campus)));
		$this->desc = $this->db->dbConnect->escape_string(htmlspecialchars(strip_tags($desc)));
		$this->pubed = $this->db->dbConnect->escape_string(htmlspecialchars(strip_tags($pubed)));
    }
    
    function GetDeckXML()
    {
    	$result = null;
    	if (isset($this->deckid) && isset($this->creatorid))
    	{
    		$result = "decks/" . $this->creatorid . "-" . $this->deckid . ".xml";
    	}
    	return $result;
    }    
    
}
?>