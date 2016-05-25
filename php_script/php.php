<?php

//create_db();
  
  
require_once 'sql_connect.php';
$conn = sql_connect();
create_contacts($conn);
create_events($conn);
create_users($conn);
create_users_contacts($conn);
create_events_sendmail($conn);
create_users_events($conn);
create_best_phone($conn);

$log_sql="";
 function create_users_contacts($conn){      
    
    $sql = "CREATE TABLE users_contacts (
    id_contacts INT(6) UNSIGNED,
    username VARCHAR(30)
    )";

    if (mysqli_query($conn, $sql)) {
      echo "Create table users_contacts<br>";
    }
    else {
      echo "Error create table users_contacts: <br>" . mysqli_error($conn);
    }
  }

  function create_best_phone($conn){      
    
    $sql = "CREATE TABLE best_phone (
    id_contacts INT(6) UNSIGNED,
    best_phone VARCHAR(6)
    )";

    if (mysqli_query($conn, $sql)) {
      echo "Create table best_phone<br>";
    }
    else {
      echo "Error create table best_phone: <br>" . mysqli_error($conn);
    }
  }

  function create_users_events($conn){      
    
    $sql = "CREATE TABLE users_events (
    id_events INT(6) UNSIGNED,
    username VARCHAR(30)
    )";

    if (mysqli_query($conn, $sql)) {
      echo "Create table users_events<br>";
    }
    else {
      echo "Error create table users_events: <br>" . mysqli_error($conn);
    }
  }

  function create_events_sendmail($conn){      
    
    $sql = "CREATE TABLE events_sendmail (
    id_contacts INT(6) UNSIGNED,
    id_events INT(6) UNSIGNED
    )";

    if (mysqli_query($conn, $sql)) {
      echo "Create table events_sendmail<br>";
    }
    else {
      echo "Error create table events_sendmail: <br>" . mysqli_error($conn);
    }
  }

  function create_users($conn){     
   
    $sql = "CREATE TABLE users (
    username VARCHAR(30) NOT NULL  PRIMARY KEY,
    password VARCHAR(60) NOT NULL
    )";
    if (mysqli_query($conn, $sql)) {
      echo "Create table users<br>";
    }
    else {
      echo "Error create table users: <br>" . mysqli_error($conn);
    }    
  }

  function create_events($conn){      
    
    $sql = "CREATE TABLE events (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    subject VARCHAR(60),
    event MEDIUMTEXT,
    date_event DATETIME
      )";

    if (mysqli_query($conn, $sql)) {
      echo "Create table events";
    }
    else {
      echo "Error create table events: " . mysqli_error($conn);
    }
  }

  function create_contacts($conn){ 
    

    $sql = "CREATE TABLE contacts (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
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
    )";

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