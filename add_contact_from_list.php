<?php
	require_once 'php_script\session.php';
	session_security();

	include 'php_script\validation.php';

	require_once 'php_script\sql_connect.php'; 

	$conn = sql_connect();

	$log_sql="";

	$sort_l ="";
	$sort_f ="";
	$symbol_f ="";
	$symbol_l ="";
	$best_phone=''; 
	$username = $_SESSION['username'];

//write records
	if (isset($_GET["sort_l"])) {
		$sort_l = string_fix($_GET['sort_l'], $conn);
	}	

	if (isset($_GET["sort_f"])) {
		$sort_f = string_fix($_GET['sort_f'], $conn);
		if ($sort_f == 'first_descending' or $sort_f== ""){
			$sort_f = 'first_ascending';
		}
		elseif ($sort_f == 'first_ascending'){
		$sort_f = 'first_descending';
		}		
	}	

	if ($sort_l == 'last_ascending' or $sort_l == "" and (!isset($_GET["sort_f"])) ){
		$sql = "SELECT id, last_name, first_name, cell_phone, work_phone, home_phone, email, best_phone FROM users_contacts, contacts LEFT OUTER JOIN best_phone ON best_phone.id_contacts = contacts.id WHERE users_contacts.username = '$username' AND contacts.id = users_contacts.id_contacts ORDER BY last_name";
		$symbol_l= '&#9660';
		$sort_l = 'last_descending';
					}
	elseif ($sort_l == 'last_descending'){
			$sql = "SELECT id, last_name, first_name, cell_phone, work_phone, home_phone, email, best_phone FROM users_contacts, contacts LEFT OUTER JOIN best_phone ON best_phone.id_contacts = contacts.id WHERE users_contacts.username = '$username' AND contacts.id = users_contacts.id_contacts ORDER BY last_name DESC";
			$symbol_l= '&#9650';
			$sort_l = 'last_ascending';	
	}
	elseif ($sort_f == 'first_descending'){
			$sql = "SELECT id, last_name, first_name, cell_phone, work_phone, home_phone, email, best_phone FROM users_contacts, contacts LEFT OUTER JOIN best_phone ON best_phone.id_contacts = contacts.id WHERE users_contacts.username = '$username' AND contacts.id = users_contacts.id_contacts ORDER BY first_name DESC";
			$symbol_f= '&#9650';
				
	}
	elseif ($sort_f == 'first_ascending'){
			$sql = "SELECT id, last_name, first_name, cell_phone, work_phone, home_phone, email, best_phone FROM users_contacts, contacts LEFT OUTER JOIN best_phone ON best_phone.id_contacts = contacts.id WHERE users_contacts.username = '$username' AND contacts.id = users_contacts.id_contacts ORDER BY first_name";
			$symbol_f= "&#9660";
	}


	$result = mysqli_query($conn, $sql);
	if (!$result) {
		$log_sql =  "Помилка: " . mysqli_error($conn);
		echo $log_sql;
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Contact mananger</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js_scripts\jquery-2.2.3.min.js"></script>
</head>
<body>
	<header class="header">
		<div class="container">
			<h1>Contact mananger</h1>
		</div>
	</header>
	<nav class="page-navigation">
		<div class="container">
			<ul>
				<li><a href="index.php">Contacts</a></li>
				<li><a href="event.php">Event</a></li>
			</ul>
			<form class="login" action="login.php" method="post">
			<span class="session_va"><?php echo $_SESSION['username']; ?></span>
				<input type="submit" name="logout" value="Logout">
			</form>
		</div>
	</nav>
	<main>
		<div class="container">
			<div class='content_view'>
				<span style='text-align: right'><h3>SELECTION MAIN PAGE</h3></span>
					<form action='event.php' method="post">
						<input type='submit' name="ACCEPT" value= 'ACCEPT'>
						<input type='button' value= 'CANCEL' onclick="location.href='event.php'">
						<table>
							<thead>
								<tr><th>
										all
										<input type="checkbox" name="checkAll" value="checkAll">
										
									</th>
									<th><a href="add_contact_from_list.php?sort_l=<?php echo $sort_l;?>">Last </a><?php echo $symbol_l ?></th>
									<th><a href="add_contact_from_list.php?sort_f=<?php echo $sort_f;?>">First </a><?php echo $symbol_f ?></th>
									<th>Email</th>
									<th>Best Phone</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$i=1;
									while ($row = mysqli_fetch_assoc($result)) { 
										if ($row["best_phone"] == 'cell'){
											$best_phone = $row["cell_phone"];
										}
										elseif ($row["best_phone"] == 'work'){
											$best_phone = $row["work_phone"];
										}
											elseif ($row["best_phone"] == 'home'){
											$best_phone = $row["home_phone"];
										}
										echo 
											"<tr>
												<td>
													<input type='checkbox' name=". $i ."  value=". $row["email"] .">								
														
													</td>
												<td>" . $row["last_name"] . "</td>
												<td>".  $row["first_name"] . "</td>
												<td>" . $row["email"] . "</td>
												<td>" . $best_phone ."</td>
											</tr>";
										++$i;
									} 

									mysqli_close($conn);
								?>						
							</tbody>
						</table>
					<input type='submit' name="ACCEPT" value= 'ACCEPT'>
					<input type='button' value= 'CANCEL' onclick="location.href='event.php'">
				</form>
			</div>
		</div>	
	</main>
</body>
</html>


