<?php
function  sql_connect(){
	
		require_once 'config_contact_mananger.php';
		
	 	$conn=sql_conn();
	 	return $conn;
	 }

	 function sql_conn(){
 		 	 $conn = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
 		 	 mysqli_set_charset( $conn, 'utf8');
			  if (mysqli_connect_errno())
			  {
			    echo "Failed to connect to MySQL: " . mysqli_connect_error();
			  }
			  return $conn;
 }
 ?>