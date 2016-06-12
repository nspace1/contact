<?php

	require 'php_script\validation.php';
	require_once 'php_script\sql_connect.php';
	$conn = sql_connect();

	if (isset($_POST['confirm_password']) &&
		isset($_POST['username']) &&
		isset($_POST['password'])) {
		$confirm_password = string_fix($_POST['confirm_password'], $conn);
		$username = string_fix($_POST['username'], $conn);
		$password = string_fix($_POST['password'], $conn);
		$validate=validate_user($username, $password, $confirm_password, $conn);	
		if ($validate == 'true') {	
			$password = md5(trim($password));
			$sql="INSERT INTO users (username, password)
			   VALUES ('$username','$password')"; 
			if (!mysqli_query($conn, $sql)) {
			    $log_sql =  "EROR" . $sql . "<br>" . mysqli_error($conn);
			    header ("location:error.php");
			    exit;
			} 
			header("Location: login.php");
			exit;
		}
	}
	mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Contact mananger</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
<body>
	<header class="header">
		<div class="container">
			<h1>Contact mananger</h1>
		</div>
	</header>
	<main class="main">
		<div class="container">
			<form action="registration.php" method="post" id="reg">				
			<div class="form">
			<input  type="text" name="username"  value="<?=	isset($username)  ? isset($validate['username']) ? empty($validate['username']) ? $username : '' : $username : ''?>"  placeholder="<?= isset($validate['username'])? $validate['username'] : 'Username';?>">
			</div>
			<div class="form">
			<input  type="password" name="password" value="<?=	isset($password)  ? isset($validate['password']) ? empty($validate['password']) ? $password : '' : $password : ''?>" placeholder="<?= isset($validate['password'])? $validate['password'] : 'Password';?>">
			</div>
			<div class="form">
			<input type="password" name="confirm_password"  placeholder="<?= isset($validate['equal'])? $validate['equal'] : 'Confirm password';?>">
			</div>	
			<div class="form">
			<a href="" onclick="document.getElementById('reg').submit('ок'); return false;" style="color:white"><h2>Click to Registration</h2></a>	
			<input type="submit" name="ок" value="Ok" style="visibility: hidden">
			</div>
			</form>	
		</div>	
	</main>
</body>
</html>
