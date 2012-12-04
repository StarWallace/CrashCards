<?php
/**
* Written by: Kirk McCulloch
**/
    /****************************************************************
     *CLASS:  SQLAccess
     *Purpose:  Create a connection to a MySQL Server.  Create and
     *          execute a query statement. Uses MySQLi
     ****************************************************************/
    class SQLAccess
    {
        public $dbConnect;
        
        /************************************************************
         *Constructor
         *Purpose:  To create a connection to a MySQL server and open a database
         *          on that server.
         *Params:   sServer - name of the MySQL server
         *          sUser - name of the user
         *          sPassword - password associated with the user
         *          sDatabase - name of the database to use
         ************************************************************/
        function __construct($sServer="localhost", $sUser="cc_manager", $sPassword="Cr@sh", $sDatabase="CrashCards")
        {
            //Connect to the MySQL server and open the database
            @$this->dbConnect = new mysqli($sServer, $sUser, $sPassword, $sDatabase);
            
            //Check the connection
            if ($this->dbConnect->connect_error)
            {
                print "Connection Failed:  " . $this->dbConnect->connect_error;
                exit();
            }
        }//end constructor
        
        /*************************************************************
         *Function: selectQuery
         *Purpose:  This method will construct a SELECT query and execute it
         *Params:   sColumnList - list of columns to be displayed
         *          sTableList - List of table(s) used in the query and the JOINS required
         *          sCondition - any restrictions on the query
         *          sSort - how to order the query results
         *          sOpts - other options to the query
         *Return:   qryResult - the results after executing the query
         *************************************************************/
        function selectQuery($sColumnList, $sTableList, $sCondition="", $sSort="", $sOpts="")
        {
            $sQryStatement = "SELECT $sColumnList FROM $sTableList";
                              
            if ($sCondition != "")
            {
                $sQryStatement .= " WHERE $sCondition";
            }
            
            if ($sSort != "")
            {
                $sQryStatement .= " ORDER BY $sSort";                
            }
            
            if ($sOpts != "")
            {
                $sQryStatement .= $sOpts;
            }
            //print $sQryStatement;
            return $this->runQuery($sQryStatement);
        }//end of selectQuery
        
        /*************************************************************
         *Function: insertQuery
         *Purpose:  executes and insert statement
         *Params:   sTable - the table to insert into
         *          sColumnList - the columns to insert into
         *          sValues - the values in each column
         *Returns:  qryResult - the results after executing the query
         *************************************************************/
        function insertQuery($sTable, $sColumnList, $sValues)
        {
            $sQryStatement = "INSERT INTO $sTable ($sColumnList) VALUES ($sValues)";
            
            return $this->runQuery($sQryStatement);
        }//end of insert query
        
        /************************************************************
         *Function: updateQuery
         *Purpose:  executes a statement to update the values of a table
         *Params:   sTable - tables you wish to update
         *          aValues - associative array storing the values to be updated
							where the index is the field name and the value is the NEW value
         *          sPrimaryKey
         *Returns:  qryResult - the results after executing the query
         ************************************************************/
        function updateQuery($sTable, $aValues, $sPrimaryKey)
        {
            $sQryStatement = "UPDATE $sTable SET ";
            
            foreach($aValues as $sFieldName=>$sFieldValue)
            {
                if ($sFieldName != $sPrimaryKey)
                {
                    $sQryStatement .= $sFieldName . "='" .
                        $this->dbConnect->real_escape_string ($sFieldValue) . "', ";
                }
            }
            $sQryStatement = rtrim($sQryStatement, ", ");
            
            $sQryStatement .= " WHERE " . $sPrimaryKey . "=" . $aValues[$sPrimaryKey];
            
            $this->runQuery($sQryStatement);
            return $this->dbConnect->affected_rows;
        }
        
         function updater($aValues, $sPrimaryKey)
        {
            $sQryStatement = "UPDATE ftUsers SET user_status = '" . $aValues;
            
            $sQryStatement .= "' WHERE user_id = " . $sPrimaryKey;
            
            $this->runQuery($sQryStatement);
            return $this->dbConnect->affected_rows;
        }
        
		 /************************************************************
         *Function: deleteQuery
         *Purpose:  executes a statement to delete one or more records
         *Params:   sTable - tables you wish to delete from
         *          sCondition - associative array storing the values to be updated
         *Returns:  qryResult - the results after executing the query
         ************************************************************/
        function deleteQuery($sTable, $sCondition)
        {
            //Construct the query
            $delStatement = "DELETE FROM $sTable WHERE $sCondition";
            
            //Run the query
            $this->runQuery($delStatement);
            
            //Return the number of affected rows
            return $this->dbConnect->affected_rows;
        }
        
        /************************************************************
         *Function: runQuery
         *Purpose:  this method will execute the query statement and
         *          return the query result set
         *Params:   sQryStatement - the query statement as a string
         *Returns:  qryResult - the query result
         *          TRUE if query statement executed successfully else FALSE
         *          For SELECT, SHOW, DESCRIBE or EXPLAIN mysqli_query()
         *          will return a result object.
         ***********************************************************/
        function runQuery($sQryStatement)
        {
            //Execute query
            $qryResult = @$this->dbConnect->query($sQryStatement);
            
            //Check to see if it executed with errors or not
            if(!$qryResult)
            {
                return "Query Failed: " . $this->dbConnect->error;
                exit();
            }
            
            return $qryResult;
        }//end of runQuery
        
        /************************************************************
         *Function: displayRecords
         *Purpose:  This is a helper method to display the records returned
         *          by a query.  This will be used for error checking only
         *Params:   qryResult - query result set
         ************************************************************/
        function displayRecords($qryResult)
        {
            echo "<table class='auto' border='2' style='margin-left: auto; margin-right: auto; text-align:center'>\n";
            $nRows = $qryResult->num_rows;
            $nFields = $qryResult->field_count;
            
            //Create the header row by looking up the field names
            echo "<tr>\n";
            
            for($i=0; $i<$nFields;$i++)
            {
                $fieldInfo = $qryResult->fetch_field();
                echo "<th>$fieldInfo->name</th>\n";
            }
            
            echo "</tr>\n";
            
            //$aRow is an associative array that will store the query resuls
            //$sFieldValue is used to print the contents of each field in each record
            for ($i = 0; $i < $nRows; $i++)
            {
                echo "<tr>\n";
                
                $aRow = $qryResult->fetch_assoc();
                foreach($aRow as $sFieldValue)
                {
                    echo "<td>" . htmlspecialchars($sFieldValue) . "</td>";                    
                }
                echo "</tr>\n";
            }
            echo "</table>";
        }//end displayRecords
        
        /******************************************************************
         *Function: createArray
         *Purpose:  Creates an associative array
         *Params:   $qryResult - The first column will be in index of the array,
         *                       and the second column will be the value.
         *Returns:  $aResult - an associative array constructed from the rows
         *          and columns of the query result set.
         ******************************************************************/
        function createArray($qryResult)
        {
            $nRows = $qryResult->num_rows;
            $aResult = array();
            
            for($i = 0; $i < $nRows; $i++)
            {
                $aRow = $qryResult->fetch_array(MYSQLI_NUM);
                
                //build the array here
                $aResult[$aRow[0]] = $aRow[1];
                //Debugging:  to help figure this out, what's an aRow look like?
                //print "<pre>";
                //print_r($aRow);
                //print "</pre>\n";
            }
            
            return $aResult;
        }
        
		/***************************************
		* FUNCTION:	findPrimaryKey
		* PURPOSE:	Find the name od the primary key field from a given query
		* PARAMS:	qryResult - the query result set to find the primary key in
		* RETURNS:	the name of the primary key field, or FALSE if there is no
		* 		primary key in the result set
		* ASSUME:	there is only a single primary key. If there are multiple primary
		* 		keys, just return one of them
		**************************************/
		function findPrimaryKey($qryResult)
		{
			//set the return value to false
			$sReturn = "false";
			//get the fields from the query
			$aFields = $qryResult->fetch_fields();
			//loop for all the fields
			foreach ($aFields as $obFieldInfo)
			{
			//if this field is the primary key
			if( $obFieldInfo->flags & 2)
			{
				//set the return value to the name of the primary key field
				$sReturn = $obFieldInfo->orgname;
			}
			}
			//return the return value
			return $sReturn;
		}
         
        /************************************************************
         *FUNCTION:    getXMLString
         *PURPOSE:     Return and XML string represneting a result set.
         *PARAMS:      qryResult - the result set to be converted to XML
         *             sEntity - the name of the top level entities in the XML doc
         *             sRoot - the name of the root element in teh XML document
         *RETURN:      XML String
         ************************************************************/
        function getXMLString($qryResult, $sEntity, $sRoot)
        {
            //Create a new DOMDocument
            $obDom = new DOMDocument("1.0", "UTF-8");
            
            //Create the root node of the tree
            $obRootNode = $obDom->createElement($sRoot);
            
            //And, add the root node to the document
            $obDom->appendChild($obRootNode);
            
            while ($aRow = $qryResult->fetch_assoc())
            {
                //make a top-level node for the row
                $obRowNode = $obDom->createElement($sEntity);
                
                //aadd the row node as a child of the root element
                $obRootNode->appendChild($obRowNode);
                //for all columns in this row
                foreach($aRow as $sField=>$sValue)
                {
                    //Create a node for this column
                    $obColumnNode = $obDom->createElement($sField);
                    
                    //add the node as a child of the row
                    $obRowNode->appendChild($obColumnNode);
                    
                    //Create a text node that contains the value in this column.
                    //and add it as a child of teh column element
                    $obTextNode = $obDom->createTextNode($sValue);
                    $obColumnNode->appendChild($obTextNode);
                }
            }
            
            $obDom->formatOutput = true;
            return $obDom->saveXML();
        }
        
        /************************************************************
         *Destructor
         *Purpose:  To close the MySQL connection
         *************************************************************/
        function __destruct()
        {
            @$this->dbConnect->close();
        }
    }//end of class
?>
