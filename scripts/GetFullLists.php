<?php
    
    function GetSubjectList() {
        $query = "SELECT DISTINCT s.subject FROM ccSubjects s JOIN ccDecks d ON s.subject = d.subject WHERE d.pubed = 1";
        return GetFullList($query);
    }
    
    function GetCoursecodeList() {
        $query = "SELECT DISTINCT c.coursecode FROM ccCourses c JOIN ccDecks d ON c.coursecode = d.coursecode WHERE d.pubed = 1";
        return GetFullList($query);
    }
    
    function GetYearList() {
        $query = "SELECT DISTINCT DATE_FORMAT(tstamp, '%Y') AS year FROM ccDecks WHERE pubed = 1";
        return GetFullList($query);
    }
    
    function GetFullList($query) {
        
        $db = new SQLAccess();
        $result = $db->runQuery($query);
        $nRows = $result->num_rows;
        $aResult = Array();
        
        for ($i = 0; $i < $nRows; $i++) {
            $aResult[$i] = $result->fetch_assoc();
        }
        
        return $aResult;
    }
?>