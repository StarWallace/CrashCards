<?php
/**
* Written by: Kirk McCulloch
**/
require_once("../classes/SQLAccess.class.php");

$db = new SQLAccess();
$result = null;

if (isset($_REQUEST['for']) && isset($_REQUEST['sample']))
{
	//for is used to determine what to query for
	$for = $_REQUEST['for'];
	$sample = $_REQUEST['sample'];
	
	if ($for == "coursecode")
	{
		//query the DB for the top 10 items 'Like' our sample
		$sColumnList = "DISTINCT coursecode";
		$sTable = "ccDecks";
		$sCondition = "coursecode LIKE '" . $sample . "%'";
		$sLimit = "LIMIT 10";
		$qryMatch = $db->selectQuery($sColumnList, $sTable, $sCondition, "", $sLimit);
	}
	elseif ($for == "subject")
	{
		$sColumnList = "DISTINCT subject";
		$sTable = "ccDecks";
		$sCondition = "subject LIKE '" . $sample . "%'";
		$sLimit = "LIMIT 10";
		$qryMatch = $db->selectQuery($sColumnList, $sTable, $sCondition, "", $sLimit);
	}
	
	$nRows = $qryMatch->num_rows;
    echo "<ul class='sugestion'>";   
    //for each record in the query
    for ($i = 0; $i < $nRows; $i++)
    {
        //Retrieve each individaul's information and add
        //it to a string that will print out the page
        $aRow = $qryMatch->fetch_assoc();
		
        //$x = 0;
        foreach($aRow as $key=>$sFieldValue)
        {
            //handles any special characters within any of the values
            //passed in form the query
            $aRowVals[$key] = htmlspecialchars($sFieldValue);                            
            //$x++;
        }
		
		//print out the sujestion
		echo "<li id='sugestion$i' class='sugestion'>" . $aRowVals[$for] . "</li>";
    }  
	echo "</ul>"
	
}
?>