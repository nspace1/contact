<?php

	include 'php_script\validation.php';
	
	require_once 'php_script\session.php';
	//session_security_login();
	session_start();
	if ($_SESSION){
	header ("location:index.php");
}

	require_once 'php_script\sql_connect.php';
	$conn = sql_connect();
	

	$log_sql="";
	$sql="";
	$fail="";


//Login
	if (isset($_POST["login"]) && isset($_POST["password"])){

	 	$login = string_fix($_POST['login'], $conn);
	 	$password = md5(trim(string_fix($_POST['password'], $conn)));

 		$fail = validate_login($login);
		$fail .= validate_password(string_fix($_POST['password'], $conn));
		
		if ($fail == "") {

		 	$sql = "SELECT username FROM users WHERE username='$login' and password ='$password'";
		 	$result = mysqli_query($conn, $sql);

		 	if ($result) {
				$log_sql =  "Помилка: " . mysqli_error($conn);

				$row = mysqli_fetch_assoc($result);
				
			 	if (mysqli_num_rows($result) == 1) {
			 		session_start();
			 		$_SESSION['auth'] = 'true';

			 		$_SESSION['username'] = $row['username'];

			 		//час очікування
			 		ini_set('session.gc_maxlifetime', 60 * 60 * 24);
			 		//ip
			 		$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
			 		//агент
			 		$_SESSION['ua'] = $_SERVER['HTTP_USER_AGENT'];
			 		$_SESSION['check'] = hash('ripemd128',$_SERVER['REMOTE_ADDR'] .  $_SERVER['HTTP_USER_AGENT']);
			 		ini_set('session.use_only_cookies', 1);
			 		header("location: index.php");
			 	}
			 	else{
			 		$log_sql =  "Wrong password or login" . "<br>" . mysqli_error($conn);
			 		$fail .= "Wrong password or login<br>";
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
				<input type="text" name="login" placeholder="Login" required>
				<input type="password" name="password" placeholder="password" required>
				<input type="submit" value="Sing in"><br><br>
				<span class="form_valid_text"><?php echo $fail; ?></span>
			</form>
			</div>
			<div class="form">
				<a href="registration.php" style="color:white"><h2>Registration</h2></a>
			</div>		
		</div>	
	</main>
</body>
</html>
