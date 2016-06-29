<?php

	include 'php_script\validation.php';	
	require_once 'php_script\session.php';
	//session_security_login();
	/*session_start();
	if ($_SESSION){
	header ("location:index.php");
	exit;
	}*/
	require_once 'php_script\sql_connect.php';
	$conn = sql_connect();
		
//Login
	if (isset($_POST["login"]) && isset($_POST["password"])){
	 	$login = string_fix($_POST['login'], $conn);
	 	$password = md5(trim(string_fix($_POST['password'], $conn)));
	 	$fail = validate_login_page($login, $_POST['password'], $conn);		
		if ($fail == 'true') {
		 	$sql = "SELECT id, username FROM users WHERE username='$login' and password ='$password'";
		 	$result = mysqli_query($conn, $sql);
		 	if ($result) {
				$log_sql =  "Помилка: " . mysqli_error($conn);
				$row = mysqli_fetch_assoc($result);				
			 	if (mysqli_num_rows($result) == 1) {
			 		session_start();
			 		$_SESSION['auth'] = 'true';
			 		$_SESSION['username'] = $row['username'];
			 		$_SESSION['users_id'] = $row['id'];
			 		
			 		ini_set('session.gc_maxlifetime', 60 * 60 * 24);			 		
			 		$_SESSION['check'] = hash('ripemd128',$_SERVER['REMOTE_ADDR'] .  $_SERVER['HTTP_USER_AGENT']);			 		
			 		header("location: index.php");
			 		exit;
			 	}
			 	else{
			 		$log_sql =  "Wrong password or login" . "<br>" . mysqli_error($conn);
			 		$error['error_login'] = "Wrong password or login";
			 	}
			}			
		}		
	}
//logout
	if (isset($_POST['logout'])){
		logout();
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
			<div class="form">
				<h2>Please login</h2>
			</div>	
			<div class="form">
				<form class="login" action="login.php" method="post">
				<?= isset($fail['login']) ? "<span class='error_f'> " . $fail['login'] . "</span>": '';?>
				<input type="text" name="login" placeholder="Login" >
				<?= isset($fail['password']) ? "<span class='error_f'> " . $fail['password'] . "</span>": '';?>
				<input type="password" name="password" placeholder="Password">
				<input type="submit" value="Sing in"><br><br>
				
			</form><br>
				<span class="form_valid_text"><?= isset($error['error_login']) ? $error['error_login'] : ''; ?></span></p>
			</div>
			<div class="form">
				<a href="registration.php" style="color:white"><h2>Registration</h2></a>
			</div>		
		</div>	
	</main>
</body>
</html>
