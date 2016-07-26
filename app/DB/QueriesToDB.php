<?php

//namespace app\DB;

require_once 'app/DB/Database.php';

class QueriesToDB
{
     public function getConn()
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        return $conn;
    }
    
    public function insertOrUpdateDB($sql)
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        $result = $conn->query($sql);   
        
        if (result === false) {
            $log_sql =  "error" . $sql . "<br>" . mysqli_error($conn);
            header ("location:error.php");
            exit;
        } else {
            return $result;
        } 
    }
    
    public function selectDB($sql) 
    {                
        $db = Database::getInstance();
        $conn = $db->getConnection();        
        $result = $conn->query($sql);
        
        if (result !== false) {
            return $result;
        } else {
            $log_sql =  "error" . $sql . "<br>" . mysqli_error($conn);
            header ("location:error.php");
            exit;
        }        
    }
}


