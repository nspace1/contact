<?php

require_once 'app/DB/QueriesToDB.php';

class Event
{
    public $msg_add_mail="";
    public $send_address="";
    
    
    public function send($to)
    {
   
        require_once 'app/DB/QueriesToDB.php';
        $DB = new QueriesToDB;

        unset($view_id);
        //Add not exist email and insert event_sendmail
        $to1 = string_fix($to, $DB->getConn());
        $tok = strtok($to1, " ,\n\t");
        
        while ($tok) {
            $sql = "SELECT id, email FROM contacts WHERE contacts.email='$tok' AND users_id =" . $_SESSION['users_id'];
            $result=mysqli_query($DB->getConn(), $sql);
            
            if   (mysqli_num_rows($result)) {
                $row = mysqli_fetch_assoc($result);
                $id_contacts = $row['id'];
            } else {
                $this->msg_add_mail[] = $tok;
            }
        //list mail to send
            $this->send_address[] = $tok;
            $tok = strtok(" ,\n\t");
        }
    }
    
    public function insertNotExistEmail($post)
    {
        $DB = new QueriesToDB;
        foreach ($_POST as $key  => $value) {
            if ($value != "add_ev_msg" and $value != "Add to contact mananger"  ){
                $email = strtolower(string_fix($_POST["$key"], $DB->getConn()));
                $sql = "INSERT INTO contacts (email, users_id)
                VALUES ('$email',".$_SESSION['users_id'] . ")";

                if ($DB->insertOrUpdateDB($sql)) {	
                    $id_contacts = mysqli_insert_id($DB->getConn());							
                    $sql= "INSERT INTO best_phone (id_contacts, best_phone) VALUES ('$id_contacts', 'cell')";
                    $DB->insertOrUpdateDB($sql); 
                }
            }
        }
    	header("Location: index.php");
    	exit;
    }
}