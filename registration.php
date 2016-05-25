<?php

	require 'php_script\validation.php';

	require_once 'php_script\sql_connect.php';
	$conn = sql_connect();

	$log_sql="";
	$sql="";
	$fail="";
	
	$validate = "";
	$username = "";
	$password = "";
	$confirm_password= "";

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
			    $log_sql =  "Помилка запису в БД" . $sql . "<br>" . mysqli_error($conn);
			    header ("location:error.php");
			} 
			header("Location: login.php");
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
			<input  type="text" name="username"  value="<?php echo $username; ?>" maxlength="30" placeholder="Username">
			</div>
			<div class="form">
			<input  type="password" name="password" value="<?php echo $password; ?>" maxlength="30" placeholder="Password">
			</div>
			<div class="form">
			<input type="password" name="confirm_password" value="<?php echo $confirm_password; ?>" maxlength="30" placeholder="Confirm password">
			</div>	
			<div class="form">
			<a href="" onclick="document.getElementById('reg').submit('ок'); return false;" style="color:white"><h2>Click to Registration</h2></a>
			<span class="form_valid_text"><?php echo $validate; ?></span>
			<input type="submit" name="ок" value="Ok" style="visibility: hidden">
			</div>
			</form>	
		</div>	
	</main>
</body>
</html>
