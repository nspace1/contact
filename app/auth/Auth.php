<?php

require_once 'app/DB/QueriesToDB.php';

class Auth
{
    public $error;
    public $fail;

    public function authorization($login, $password) {

        $DB = new QueriesToDB;
        $login = string_fix($login, $DB->getConn());
        $password = md5(trim(string_fix($password, $DB->getConn())));
        $this->fail = validate_login_page($login, $password, $DB->getConn());

        if ($this->fail == 'true') {
            $sql = "SELECT id, username FROM users WHERE username='$login' and password ='$password'";

            $result = $DB->selectDB($sql);   

            if ($result) {				
                

                if (mysqli_num_rows($result) == 1) {
                    session_start();
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION['auth'] = 'true';
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['users_id'] = $row['id'];

                    ini_set('session.gc_maxlifetime', 60 * 60 * 24);			 		
                    $_SESSION['check'] = hash('ripemd128',$_SERVER['REMOTE_ADDR'] .  $_SERVER['HTTP_USER_AGENT']);			 		
                    header("location: index.php");
                    exit;
                }
                else {
                    $log_sql =  "Wrong password or login" . "<br>" . mysqli_error($DB->getConn());
                    $this->error['error_login'] = "Wrong password or login";
                }
            }			
        }    
    }
    
    function logout(){
	session_start(); 
	session_unset();
	session_destroy();
	header ('location:login.php');
	exit;
}

    function session_security_login(){
	session_start();
	if ($_SESSION['auth'] == 'true'){
	header ("location:index.php");
	exit;
	}
	if ($_SESSION['check'] != hash('ripemd128',$_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'])){
		logout();
	}
}

    function session_security(){
	session_start();
	if (!$_SESSION['auth']){
		header ("location:login.php");
		exit;
	}
	if ($_SESSION['check'] != hash('ripemd128',$_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'])){
		logout();
	}
}
    
}

