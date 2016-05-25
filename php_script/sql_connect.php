<?php
function  sql_connect(){
	 	require_once 'mysql_login.php';
	 	$conn=sql_conn($db_hostname, $db_database, $db_username, $db_password);
	 	return $conn;

	 }

	 function sql_conn($db_hostname, $db_database, $db_username, $db_password){
 		 	 $conn = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);
			  if (mysqli_connect_errno())
			  {
			    echo "Failed to connect to MySQL: " . mysqli_connect_error();
			  }
			  return $conn;
 }
 ?>