<?php
echo 
"<!DOCTYPE html>
<html>
<head>
	<title>Contact manager</title>
	<meta charset='UTF-8'>
	<link rel='stylesheet' type='text/css' href='css/normalize.css'>
	<link rel='stylesheet' type='text/css' href='css/style.css'>	 
</head>
<body>
	<header class='header'>
		<div class='container'>
			<h1>Contact mananger</h1>
		</div>
	</header>
	<nav class='page-navigation'>
		<div class='container'>
			<ul>
				<li><a href='index.php'>Contacts</a></li>
				<li><a href='event.php'>Event</a></li>
			</ul>
			<form class='login' action='login.php' method='post'>
			<span class='session_va'>". $_SESSION['username'] ."</span>
				<input type='submit' name='logout' value='Logout'>
			</form>
		</div>
	</nav>";