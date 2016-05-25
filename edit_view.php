
	<?php

		require_once 'php_script\session.php';
		session_security();

		require_once 'php_script\validation.php';

		require_once 'php_script\sql_connect.php';
		$conn = sql_connect();

		$log_sql="";

		$first_name = "";
		$last_name = "";
		$email = "";
		$home_phone = "";
		$work_phone = "";
		$cell_phone = "";
		$best_phone = "";
		$address1 = "";
		$address2 = "";
		$city = "";
		$state = "";
		$zip = "";
		$country = "";
		$birth_day = "";
		$home_check = "";
		$work_check = "";
		$cell_check = "";
		$form_button = "add";
		$validate='';
		$username = $_SESSION['username'];
		

//edit record in fields
	if (isset($_POST['id']) && isset($_POST['edit_view'])) {
	    $id = string_fix($_POST['id'], $conn);
		$sql = "SELECT * FROM contacts LEFT OUTER JOIN best_phone on contacts.id = best_phone.id_contacts WHERE contacts.id ='$id'" ; 
		if (!mysqli_query($conn, $sql)) {
			$log_sql .=  "Error " . $sql . "<br>" . mysqli_error($conn);
			header ("location:error.php");
		}

		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		
		$first_name = $row["first_name"];
		$last_name = $row["last_name"];
		$email = $row["email"];
		$home_phone = $row["home_phone"];
		$work_phone = $row["work_phone"];
		$cell_phone = $row["cell_phone"];		
		$address1 = $row["address1"];
		$address2 = $row["address2"];
		$city = $row["city"];
		$state = $row["state"];
		$zip = $row["zip"];
		$country = $row["country"];
		$birth_day = $row["birth_day"];
		$form_button = "edit";
		
		$best_phone = $row["best_phone"];		
		if ($best_phone == 'home') {
			$home_check = "checked";
		}
		elseif ($best_phone == 'cell') {
			$cell_check = "checked";
		}
		elseif ($best_phone == 'work') {
			$work_check = "checked";
		}	
	}

//add/edit record
	if (isset($_POST["first_name"]) &&
		isset($_POST['last_name']) &&
		isset($_POST['email']) &&
		isset($_POST['home_phone']) &&
		isset($_POST['work_phone']) &&
		isset($_POST['cell_phone']) &&
		isset($_POST['address1']) &&
		isset($_POST['address2']) &&
		isset($_POST['city']) &&
		isset($_POST['state']) &&
		isset($_POST['zip']) &&
		isset($_POST['country']) &&
		isset($_POST['birth_day']))
	{
		$first_name = string_fix($_POST['first_name'], $conn);
		$last_name = string_fix($_POST['last_name'], $conn);
		$email = strtolower(string_fix($_POST['email'], $conn));
		$home_phone = string_fix($_POST['home_phone'], $conn);
		$work_phone = string_fix($_POST['work_phone'], $conn);
		$cell_phone = string_fix($_POST['cell_phone'], $conn);
		$address1 = string_fix($_POST['address1'], $conn);
		$address2 = string_fix($_POST['address2'], $conn);
		$city = string_fix($_POST['city'], $conn);
		$state = string_fix($_POST['state'], $conn);
		$zip = string_fix($_POST['zip'], $conn);
		$country = string_fix($_POST['country'], $conn);
		$birth_day = string_fix($_POST['birth_day'], $conn);
		$id_edit = string_fix($_POST['id_edit'], $conn);
		
		if (!isset($_POST['best_phone'])) {
			
		}
		elseif (string_fix($_POST['best_phone'], $conn) == 'work') {
			$best_phone = 'work';
		}
		elseif (string_fix($_POST['best_phone'], $conn) == 'home') {
			$best_phone = 'home';
		}
		elseif (string_fix($_POST['best_phone'], $conn) == 'cell') {
			$best_phone = 'cell';
		}
		if ($cell_phone !== ''){
			$best_phone = 'cell';
			}
			elseif ($home_phone !== ''){
			$best_phone = 'home';
			}
			elseif ($work_phone !== ''){
			$best_phone = 'work';
			}
			else{
				$best_phone = '';
			}
		


		$validate = validate_add_edit($first_name, $last_name, $email, $home_phone, $work_phone, $cell_phone, $address1, $address2, $city, $state,	$zip, $country,	$birth_day, $conn);
		if ($validate == 'true'){
	
//  if button add insert
			if (isset($_POST["add"])){
				$sql = "INSERT INTO contacts (first_name, last_name, email, home_phone, work_phone, cell_phone, address1, address2, city, state, zip, country, birth_day)
					VALUES ('$first_name', '$last_name', '$email', '$home_phone', '$work_phone', '$cell_phone', '$address1', '$address2', '$city', '$state', '$zip', '$country', '$birth_day' )";

				if (!mysqli_query($conn, $sql)) {
					$log_sql =  "Error write to DB" . $sql . "<br>" . mysqli_error($conn);
					header ("location:error.php");
				}

				$id_contacts = mysqli_insert_id($conn);
				$sql = "INSERT INTO users_contacts (username, id_contacts)
						VALUES ('$username', '$id_contacts')";

				if (!mysqli_query($conn, $sql)) {	
					$log_sql =  "Error write to DB" . $sql . "<br>" . mysqli_error($conn);
					header ("location:error.php");
				}

				$sql = "INSERT INTO best_phone (best_phone, id_contacts)
						VALUES ('$best_phone', '$id_contacts')";

				if (!mysqli_query($conn, $sql)) {
						$log_sql =  "Error write to DB" . $sql . "<br>" . mysqli_error($conn);
						header ("location:error.php");
				}
				header("Location: index.php");
			}
			 

//if button edit UPDATE
			if (isset($_POST["edit"])) {			

				$sql = "UPDATE contacts SET
				first_name = '$first_name', 
				last_name = '$last_name',
				email = '$email',
				home_phone = '$home_phone',
				work_phone = '$work_phone',
				cell_phone = '$cell_phone',				
				address1 = '$address1',
				address2 = '$address2',
				city = '$city',
				state = '$state',
				zip = '$zip',
				country = '$country',
				birth_day = '$birth_day'
				WHERE id=$id_edit";

				if (!mysqli_query($conn, $sql)) {
					$log_sql =  "Error write to DB" . $sql . "<br>" . mysqli_error($conn);
					header ("location:error.php");
				}
				$sql = "UPDATE best_phone SET
				best_phone = '$best_phone'				
				WHERE id_contacts=$id_edit";

				if (mysqli_query($conn, $sql)) {
					$log_sql =  "Error write to DB" . $sql . "<br>" . mysqli_error($conn);
					header ("location:error.php");
				}
			header("Location: index.php");
			}
		}

	}
	mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Contact manager</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<scrip src="js_scripts\sort.js"></scrip>
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
			<div class="form" >
				<form action="edit_view.php" method="post">
					<table>
					<caption style="text-align:right;"><h2>Contact Details</h2></caption>
					<tbody>
						<tr>
							<td>First</td><td></td>
							<td><input type="text" name="first_name"   value="<?php echo $first_name; ?>"></td>
						</tr>
						<tr>
							<td>Last</td><td></td>
							<td><input type="text" name="last_name"  value="<?php echo $last_name; ?>"></td>
						</tr>
						<tr>
							<td>Email</td><td></td>
							<td><input type="text" name="email"  value="<?php echo $email; ?>"></td>
						</tr>
						<tr>
							<td>Home</td>
							<td><input type="radio" name="best_phone" value="home"   <?php echo $home_check; ?>></td>
							<td><input type="tel" name="home_phone"  value="<?php echo $home_phone; ?>"></td>
						</tr>
						<tr>
							<td>Work</td>
							<td><input type="radio" name="best_phone" value="work" <?php echo $work_check; ?> ></td>
							<td><input type="tel" name="work_phone" value="<?php echo $work_phone; ?>" ></td>
						</tr>
						<tr>
							<td>Cell</td>
							<td><input type="radio" name="best_phone" value="cell" <?php echo $cell_check; ?>></td>
							<td><input type="tel" name="cell_phone"   value="<?php echo $cell_phone; ?>"></td>
						</tr>
						<tr>
							<td>Address 1</td><td></td>
							<td><input type="text" name="address1"  value="<?php echo $address1; ?>"></td>
						</tr>
						<tr>
							<td>Address 2</td><td></td>
							<td><input type="text" name="address2"  value="<?php echo $address2; ?>"></td>
						</tr>
						<tr>
							<td>City</td><td></td>
							<td><input type="text" name="city"  value="<?php echo $city; ?>"></td>
						</tr>
						<tr>
							<td>State</td><td></td>
							<td><input type="text" name="state"  value="<?php echo $state; ?>"></td>
						</tr>
						<tr>
							<td>ZIP</td><td></td>
							<td><input type="text" name="zip"   value="<?php echo $zip; ?>"></td>
						</tr>
						<tr>
							<td>Country</td><td></td>
							<td><input type="text" name="country"  value="<?php echo $country; ?>"></td>
						</tr>
						<tr>
							<td>Birthday</td><td></td>
							<td><input type="text" name="birth_day"  placeholder="YYYY-MM-DD" value="<?php echo $birth_day; ?>"></td>
						</tr>
						<tr>
							<td>								
								<input type='submit' name="<?php echo $form_button; ?>" value="<?php echo $form_button; ?>">								
								<input type="hidden" name="id_edit" value="<?php echo $id; ?>"></td><td></td><td></td>
						</tr>	
						<tr>
							<td colspan='3'>
								<span class="form_valid_text"><?php echo $validate; ?></span>
							</td>
						</tr>			
					</tbody>
					</table>
				</form>
			</div>
		</div>
	</main>
</body>
</html>
