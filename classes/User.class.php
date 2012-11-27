<?php
/**
* Written by: Kirk McCulloch
**/
require_once("SQLAccess.class.php");

class User {
	
	public $uid, $email, $name, $alias;
	private $db;
	
	function __construct($uid="")
	{
		$this->db = new SQLAccess();
		
		if ($uid != "")
		{
			$this->db = new SQLAccess();
			//get full user data
			$qryUser = $this->db->selectQuery(
				"*",
				"ccUsers",
				"uid = '" . $uid . "'" );
			$aInfo = $qryUser->fetch_assoc();
			//insert all DB user data into the php object
			$this->FillUser($aInfo['uid'], $aInfo['email'], $aInfo['name'], $aInfo['alias']);
		}
	}
	
	/************************************************************
	*FUNCTION:    GetDisplayName
	*PURPOSE:     To get a display identity for this user
	*NOTES:		  This function assumes that the user object has been filled with valid user data
	*RETURN:      A string to print for user identity display
	************************************************************/
	function GetDisplayName()
	{
		$result = "Anonymous";
		if ($this->alias != "")
		{
			$result = $this->alias;
		}
		elseif ($this->name != "")
		{	
			$result = $this->name;
		}
		return $result;
	}
	
	/************************************************************
	*FUNCTION:    GetCollection
	*PURPOSE:     To get an array of the user's clipped decks
	*NOTES:		  This function assumes that the user object has been filled with valid user data
	*RETURN:      An array of all clipped decks
	************************************************************/
	function GetCollection()
	{
		//query for a list of all clipped decks
		$qryClips = $this->db->selectQuery("deckid", "ccClips", "uid = " . $this->uid);
		$sRows = $qryClips->num_rows;
		//array to store the result
		$aResult = Array();
		
		for ($i = 0; $i < $nRows; $i++)
		{
			//fetch_assoc gets an associative array of the next record in the result set
			// it uses a cursor to always get the NEXT record with each subsequent call
			$clip = $qryClips->fetch_assoc();
			//add this deckid to the array
			$aResult[$i] = $clip['deckid'];
		}
		
		return $aResult;
	}
	
	/**
	* Function: FillUser
	* Purpose: Call this function to insert the DB info into the user object
	* takes in a dbObject
	**/
	function FillUser($uid, $email, $name="", $alias="")
	{
		//all this does is strips off any special characters that might cause problems in
		//SQL, php, or html
		$this->uid = $this->db->dbConnect->escape_string(htmlspecialchars(strip_tags($uid)));
		$this->email = $this->db->dbConnect->escape_string(htmlspecialchars(strip_tags($email)));		
		$this->name = $this->db->dbConnect->escape_string(htmlspecialchars(strip_tags($name)));
		$this->alias = $this->db->dbConnect->escape_string(htmlspecialchars(strip_tags($alias)));
	}
	
	/************************************************************
	*FUNCTION:    ValidateInfo
	*PURPOSE:     Call to check if the existing user info is valid
	*PARAMS:      pass - optional, use only when checking the validity of a password
	*RETURN:      False when all info valid, error string detailing issues otherwise
	************************************************************/
	function ValidateInfo($pass="")
	{
		//start result as blank string to append further information to
		$result = "";
		
		if (preg_match("/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/", $this->email) == 0)
		{
			$result .= "<p class='err'>Invalid email was entered. Can only contain letters, numbers, dots, underscores, and dashes. Use the form john_doe@example.com.</p>";
		}
		if (preg_match("/^[A-Za-z \-']?$/", $this->name) == 0)
		{
			$result .= "<p class='err'>Invalid name was entered. Can only contain letters, dashes, spaces, and apostrophes.</p>";
		}
		//password check
		if ($pass != "") //if the password is not blank
		{
			//use to check for valid password credentials
			if (preg_match("/^(?=.*\d+)(?=.*[a-zA-Z])[0-9a-zA-Z!@#$%]{8,30}/", $pass) == 0)
			{
				$result .= "<p class='err'>Invalid password was entered. Please use at least 1 letter, at least 1 number, and a minimum of 8 characters.</p>";
			}
		}
		if ($result === "")
		{
			$result = false;
		}
		return $result;
	}
	
	/************************************************************
	*FUNCTION:    CheckDupUser
	*PURPOSE:     Call to check if the user object's email is in use by an existing user
	*							 This function assumes that the email attribute is set
	*RETURN:      True on duplicate, false on unused email address
	************************************************************/
	function CheckDupUser()
	{
		$result = false;
		$qryUser = $this->db->selectQuery(
				"uid",
				"ccUsers",
				"email = '" . $this->email . "'" );
		if ($qryUser->num_rows > 0)
		{
			$result = true;
		}
		return $result;
	}
	
	/**
	* Function: Register
	* Purpose: If this user is a new user, call this function to add them to the database
	* takes in a dbObject
	**/
	function Register($email, $pass, $passconf, $name="", $alias="")
	{
		//place the passed in info in the user object
		$this->FillUser("dummy id", $email, $name, $alias);
		//check to see if email already in use
		if ($this->CheckDupUser() === false) 
		{
			//check for any invalid values.
			$result = $this->ValidateInfo($pass);
			
			if ($result === false) //no invalid data found
			{
			
				//hash the password
				$pwHash = crypt($pass);
				//check to see that the password and the confirmation match
				if (crypt($passconf, $pwHash) == $pwHash)
				{
					$qryReg = $this->db->insertQuery(
						"ccUsers",
						"uid, email, name, alias, pass",
						"NULL, '" . $this->email . "', '" . $this->name . "', '" . $this->alias . "', '" . $pwHash . "'");
					$result = $qryReg;	
				}
				else
				{
					$result = "<p class='err'>Password did not match the password confirmation.</p>";
				}
			}
			//no else, error already generated and stored in $result
		}
		else
		{
			$result = "<p class='err'>Email address already in use by another user.</p>";
		}
		
		return $result;
	}

	/************************************************************
	*FUNCTION:    CheckValidCredentials
	*PURPOSE:     Call to check if the credentials match a valid user
	*PARAMS:      email - the email to check
	*             pass - the the password to check
	*RETURN:      True on match, error message string otherwise
	************************************************************/
	function CheckValidCredentials($pass)
	{
		$result = false;
		//query the db for the passed in user name, if found return the stored password hash
		$qryFindUser = $this->db->selectQuery(
				"pass",
				"ccUsers",
				"email = '" . $this->email . "'" );
		//if a user was found with that email address
		if ($qryFindUser->num_rows > 0 )
		{
			//save the db hashed password into $pwHash
			$pwHash = $qryFindUser->fetch_assoc();
			$pwHash = $pwHash['pass'];
			//use the php crypt function to check if the passed in password hashes
			//to the stored hash, while using the stored hash as the salt.
			if (crypt($pass, $pwHash) == $pwHash)
			{
				//the user is a match
				$result = true;
			}
			else
			{
				//the entered password was invalid
				$result = "<p class='err'>Incorrect password.</p>";
			}
		}
		else
		{
			//the entered email was not a match for any user
			$result = "<p class='err'>Could not find a user with that email address.</p>";
		}
		return $result;
	}
	
	function Login($email, $pass)
	{
		$result = false;
		//place the passed in email in the user object
		$this->FillUser("dummy id", $email);
		$isValid = $this->CheckValidCredentials($pass);
		
		//if the user is found to be a valid user
		if ($isValid === true)
		{
			//get full user data
			$qryUser = $this->db->selectQuery(
				"*",
				"ccUsers",
				"email = '" . $this->email . "'" );
			$aInfo = $qryUser->fetch_assoc();
			//insert all DB user data into the php object
			$this->FillUser($aInfo['uid'], $aInfo['email'], $aInfo['name'], $aInfo['alias']);
			//place a copy of the object as a cookie to track the logged in user
			setcookie("user", serialize($this), time()+3600*24*365);
			$result = true;
		}
		else
		{
			//user was not valid, set result to the error message
			$result = $isValid; 
		}
		return $result;
	}
	
	function Logout()
	{
		setcookie("user", "", 0);
		unset($_COOKIE['user']);
	}
	
	function FreshCookie()
	{
		if (isset($_COOKIE['user']))
		{
			setcookie("user", serialize($this), time()+3600*24*365);
			$_COOKIE['user'] = serialize($this);
		}
	}
}
?>