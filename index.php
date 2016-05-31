
<?php
	
	require_once 'php_script\session.php';
	session_security();
	
	require_once 'php_script\validation.php';
	
	require_once 'php_script\sql_connect.php';
	$conn = sql_connect();
	
	$log_sql='';
	 
//Delete contact
	$form_ask_delete ='';

	if (isset($_POST['delete'])) {
		
		$form_ask_delete ='true';
		$id = string_fix($_POST['id'], $conn);
	//select Last and first to ask msg
		$sql = "SELECT last_name, first_name, email FROM contacts WHERE id = '$id'";		
		$del_name=mysqli_fetch_assoc(mysqli_query($conn, $sql));

			
		if (isset($_POST['delete']) && isset($_POST['ask'])) {			
			$sql = "DELETE FROM contacts WHERE id = '$id'"; 
			if (!mysqli_query($conn, $sql)) {
				$log_sql .='Error delete<br>';
				header ('location:error.php');
			}
			$sql = "DELETE FROM users_contacts WHERE id_contacts = '$id'"; 
			if (!mysqli_query($conn, $sql)) {
				$log_sql .='Error delete<br>';
				header ('location:error.php');
			}
			$sql = "DELETE FROM best_phone WHERE id_contacts = '$id'"; 
			if (!mysqli_query($conn, $sql)) {
				$log_sql .='Error delete<br>';
				header ('location:error.php');
			}
		header ('location:index.php');
		}

	}

// write contact records
	//sort
	$sort_l ='';
	$sort_f ='';
	$symbol_f ='';
	$symbol_l ='';
	$best_phone = '';
	$username = $_SESSION['username'];

	


	if (isset($_GET["sort_l"])) {
		$sort_l = string_fix($_GET['sort_l'], $conn);
	}	

	if (isset($_GET["sort_f"])) {
		$sort_f = string_fix($_GET['sort_f'], $conn);
		if ($sort_f == 'first_descending' or $sort_f== ''){
			$sort_f = 'first_ascending';
		}
		elseif ($sort_f == 'first_ascending'){
		$sort_f = 'first_descending';
		}		
	}	
	//pagination
	$next_page = '';
		$next_page2 = '';				
		$pre_page = '';
		$pre_page2 = '';
		//$last_page = '';
		$num_records_per_page = 5;
		$first_page = 1;
		
	if (isset($_GET['page_active'])) {
		$page_active =$_GET['page_active'];
	}
	else {
		$page_active = 1; 
	}	


	$sql1 = "SELECT id FROM contacts, users_contacts  WHERE users_contacts.username = '$username'  AND contacts.id = users_contacts.id_contacts";
		$res = mysqli_query($conn, $sql1);
		$how_many_records = mysqli_num_rows($res);
	if (mysqli_num_rows($res) !=  0){
		
			$last_page = ceil ($how_many_records /  $num_records_per_page);
			if ($page_active < 1 ){
				$page_active = 1;
			}
			if ($page_active > $last_page) {
				$page_active = $last_page;
			}
			$start_from = ($page_active-1) * $num_records_per_page; 

		if ($how_many_records > $num_records_per_page){
				
				if ($page_active < $last_page){
					$next_page= $page_active + 1;
				}
				if ($page_active < $last_page-1){
					$next_page2 =  $page_active + 2;
				}								
				if ($page_active > 1){
					$pre_page = $page_active - 1;
				}
				if ($page_active > 2){
					$pre_page2 = $page_active - 2;
				}
				
		}	
	// sort records
		//echo "&#9650";▲
		//echo "&#9660";▼

		if ($sort_l == 'last_ascending' or $sort_l == "" and (!isset($_GET["sort_f"])) ){
			$sql = "SELECT id, last_name, first_name, cell_phone, work_phone, home_phone, email, best_phone FROM users_contacts, contacts, best_phone WHERE best_phone.id_contacts = contacts.id AND users_contacts.username = '$username' AND contacts.id = users_contacts.id_contacts ORDER BY last_name LIMIT $start_from, $num_records_per_page";
			
			$symbol_l= '&#9660';
			$sort_l = 'last_descending';
						}
		elseif ($sort_l == 'last_descending'){
				$sql = "SELECT id, last_name, first_name, cell_phone, work_phone, home_phone, email, best_phone FROM users_contacts, contacts LEFT OUTER JOIN best_phone ON best_phone.id_contacts = contacts.id WHERE users_contacts.username = '$username' AND contacts.id = users_contacts.id_contacts ORDER BY last_name DESC LIMIT $start_from, $num_records_per_page";
				$symbol_l= '&#9650';
				$sort_l = 'last_ascending';	
		}
		elseif ($sort_f == 'first_descending'){
				$sql = "SELECT id, last_name, first_name, cell_phone, work_phone, home_phone, email, best_phone FROM users_contacts, contacts LEFT OUTER JOIN best_phone ON best_phone.id_contacts = contacts.id WHERE users_contacts.username = '$username' AND contacts.id = users_contacts.id_contacts ORDER BY first_name DESC LIMIT $start_from, $num_records_per_page";
				$symbol_f= '&#9650';
					
		}
		elseif ($sort_f == 'first_ascending'){
				$sql = "SELECT id, last_name, first_name, cell_phone, work_phone, home_phone, email, best_phone FROM users_contacts, contacts LEFT OUTER JOIN best_phone ON best_phone.id_contacts = contacts.id WHERE users_contacts.username = '$username' AND contacts.id = users_contacts.id_contacts ORDER BY first_name LIMIT $start_from, $num_records_per_page";
				$symbol_f= "&#9660";
		}

		$result = mysqli_query($conn, $sql);
		if (!$result) {
			$log_sql =  "Помилка: " . mysqli_error($conn);			
			echo $log_sql;
			header ("location:error.php");
		}
	}		
		

?>
<!DOCTYPE html>
<html>
<head>
	<title>Contact manager</title>
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
	<main class="main">
		<div class="container">
			<div class='content_view'>
				<div class="msg" style="<?php if ($form_ask_delete !== "") echo "visibility: visible"; ?>">					
					<p>Are you want to delete this contact?
					<p> <?php echo $del_name['last_name'] ."   " . $del_name['first_name']."   " . $del_name['email'] ?>
					<form action="index.php" method="post" >
						<input type='hidden' name="ask" value="ok">
						<input type='hidden' name="id" value="<?php echo $_POST['id']; ?>">

						<input style = 'float:left;' type='submit' name="delete" value="Delete">
						<input style = 'float:right;' type='button'  value= 'CANCEL' onclick="location.href='index.php'">								
					</form>
				</div>
				<span style='text-align: right'><h3>MANAGEMENT MAIN PAGE</h3></span>
				<table>
					<form action='edit_view.php'>
					<input type='submit' value= 'ADD'>		
					</form>
					<thead>
						<tr>
							<th><a href="index.php?sort_l=<?php echo $sort_l;?>">Last </a><?php echo $symbol_l ?></th>
							<th><a href="index.php?sort_f=<?php echo $sort_f;?>">First </a><?php echo $symbol_f ?></th>
							<th>Email</th>
							<th>Best Phone</th>
						</tr>
					</thead>
					<tbody>
			<?php		
							
			if (mysqli_num_rows($res) !=  0){
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
					elseif ($row["best_phone"] == ''){
						$best_phone ='';
					}

					echo 
						"<tr>
							<td>" . $row["last_name"] . "</td>
							<td>".  $row["first_name"] . "</td>
							<td>" . $row["email"] . "</td>
							<td>" . $best_phone ."</td>
							<td>
								<form  method='post' action='edit_view.php'>
									<input type='hidden' name='id' value=". $row["id"] .">
									<input type='hidden' name='edit_view' value='yes'>
									<input type='submit' value='edit/view'>
								
								</form></td>
							<td>
								<form  method='post' action='index.php'>
									<input type='hidden' name='id' value=". $row["id"] .">
									<input type='hidden' name='delete' value='yes'>
									<input type='submit' value='delete'>
								
								</form></td>
						</tr>";
				} 
			}
				mysqli_close($conn);
				?>
					
						</tbody>
					</table>
				<form action='edit_view.php'>			
				<input type='submit' value= 'ADD'>				
				</form>
				<div style='text-align:center'>
				<?php
					if ($how_many_records > $num_records_per_page){
						echo "<a href='index.php?page_active=1'>First page</a>..";
						echo "<a href='index.php?page_active=" . $pre_page ."'>&#9664---</a>..";
						echo "<a href='index.php?page_active=" . $pre_page2 ."'>". $pre_page2."</a>..";
						echo "<a href='index.php?page_active=" . $pre_page ."'>". $pre_page."</a>..<span style='font-size:1.5em;'>". $page_active .'</span>..';										
						echo "<a href='index.php?page_active=" . $next_page ."'>". $next_page."</a>..";
						echo "<a href='index.php?page_active=" .$next_page2 ."'>". $next_page2."</a>..";
						echo "<a href='index.php?page_active=" . $next_page ."'>---&#9654</a>..";
						echo "<a href='index.php?page_active=" . $last_page ."'>Last page</a>";
					}
				?>
				</div>
			</div>			
		</div>	
	</main>	
</body>
</html>


