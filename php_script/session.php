<?php
function logout(){
	session_start(); 
	session_unset();
	session_destroy();
	header ('location:login.php');
}

function session_security_login(){
	session_start();
	if ($_SESSION['auth'] == 'true'){
	header ("location:index.php");
	}
	if ($_SESSION['check'] != hash('ripemd128',$_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'])){
		logout();
	}
}

function session_security(){
	session_start();
	if (!$_SESSION['auth']){
		header ("location:login.php");
	}
	if ($_SESSION['check'] != hash('ripemd128',$_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'])){
		logout();
	}
}
?>