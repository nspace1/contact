<?php

//create_db();
  
  
require_once 'sql_connect.php';
$conn = sql_connect();
create_contacts($conn);
create_users($conn);
create_best_phone($conn);

$log_sql="";


  function create_best_phone($conn){      
    
    $sql = "CREATE TABLE best_phone (
    id_contacts INT(6) AUTO_INCREMENT PRIMARY KEY,
    best_phone VARCHAR(6)
    )CHARACTER SET=utf8";

    if (mysqli_query($conn, $sql)) {
      echo "Create table best_phone<br>";
    }
    else {
      echo "Error create table best_phone: <br>" . mysqli_error($conn);
    }
  }

 

  function create_users($conn){     
   
    $sql = "CREATE TABLE users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(60) NOT NULL
    )CHARACTER SET=utf8";
    if (mysqli_query($conn, $sql)) {
      echo "Create table users<br>";
    }
    else {
      echo "Error create table users: <br>" . mysqli_error($conn);
    }    
  }

  
  function create_contacts($conn){ 
    

    $sql = "CREATE TABLE contacts (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    users_id INT(6),
    first_name VARCHAR(30), 
    last_name VARCHAR(30),
    email VARCHAR(50),
    home_phone VARCHAR(20),
    work_phone VARCHAR(20),
    cell_phone VARCHAR(20),
    address1 VARCHAR(50),
    address2 VARCHAR(50),
    city VARCHAR(30),
    state VARCHAR(30),
    zip VARCHAR(10),
    country VARCHAR(30),
    birth_day DATE
    ) CHARACTER SET=utf8";

    if (mysqli_query($conn, $sql)) {
    	echo "Create table contacts";
    }
    else {
    	echo "Error create table contacts: " . mysqli_error($conn);
    }
  }


  // create db 
  function create_db() {
   require_once  'mysql_login.php';
    
    $conn = mysqli_connect($db_hostname, $db_username, $db_password);
        if (mysqli_connect_errno())
        {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
    $sql = "CREATE DATABASE contact_mananger";
    if (mysqli_query($conn, $sql)) {
    		echo "DB is created";
    }
    else {
    		echo "Error create DB"  . mysqli_error($conn);
    }
    mysqli_close($conn);
  }
  echo $log_sql;
  mysqli_close($conn);
  ?>