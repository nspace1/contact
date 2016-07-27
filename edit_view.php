
<?php
	require_once 'php_script\session.php';
	session_security();
	require_once 'php_script\validation.php';
	require_once 'php_script\sql_connect.php';
	$conn = sql_connect();		
	
	$form_button = 'add';
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

		if (isset($_POST['best_phone'])) {
                    if (string_fix($_POST['best_phone'], $conn) == 'work') {
                            $best_phone = 'work';
                    } elseif (string_fix($_POST['best_phone'], $conn) == 'home') {
                            $best_phone = 'home';
                    } elseif (string_fix($_POST['best_phone'], $conn) == 'cell') {
                            $best_phone = 'cell';
                    }
		} else{
                    if ($cell_phone !== ''){
                            $best_phone = 'cell';
                    } elseif ($home_phone !== ''){
                            $best_phone = 'home';
                    } elseif ($work_phone !== ''){
                            $best_phone = 'work';
                    } else{
                            $best_phone = '';
                    }
		}		
		$validate = validate_add_edit($first_name, $last_name, $email, $home_phone, $work_phone, $cell_phone, $address1, $address2, $city, $state,	$zip, $country,	$birth_day, $conn);
		if ($validate == 'true'){
	
//  if button add insert
			if (isset($_POST["add"])){
				$sql = "INSERT INTO contacts (users_id, first_name, last_name, email, home_phone, work_phone, cell_phone, address1, address2, city, state, zip, country, birth_day)
					VALUES ('" .$_SESSION['users_id']. "','$first_name', '$last_name', '$email', '$home_phone', '$work_phone', '$cell_phone', '$address1', '$address2', '$city', '$state', '$zip', '$country', '$birth_day' )";

				if (!mysqli_query($conn, $sql)) {
					$log_sql =  "Error write to DB" . $sql . "<br>" . mysqli_error($conn);
					header ("location:error.php");
				}

				$id_contacts = mysqli_insert_id($conn);				

				$sql = "INSERT INTO best_phone (best_phone, id_contacts)
						VALUES ('$best_phone', '$id_contacts')";

				if (!mysqli_query($conn, $sql)) {
						$log_sql =  "Error write to DB" . $sql . "<br>" . mysqli_error($conn);
						header ("location:error.php");
				}
				header("Location: index.php");
				exit;
			}
			 

//if button edit UPDATE
			if (isset($_POST["edit"])) {			

				$sql = "UPDATE contacts c JOIN best_phone b ON c.id='$id_edit' AND b.id_contacts='$id_edit' AND users_id =" . $_SESSION['users_id'] . " SET
				c.first_name = '$first_name', 
				c.last_name = '$last_name',
				c.email = '$email',
				c.home_phone = '$home_phone',
				c.work_phone = '$work_phone',
				c.cell_phone = '$cell_phone',				
				c.address1 = '$address1',
				c.address2 = '$address2',
				c.city = '$city',
				c.state = '$state',
				c.zip = '$zip',
				c.country = '$country',
				c.birth_day = '$birth_day',
				b.best_phone = '$best_phone'";

				if (!mysqli_query($conn, $sql)) {
					$log_sql =  "Error write to DB" . $sql . "<br>" . mysqli_error($conn);
					header ("location:error.php");
					exit;
				}
			header("Location: index.php");
			exit;
			}
		}
	}
	mysqli_close($conn);

		//header
	require 'pages\header.php';
?>
	<main class="main">
		<div class="container">
			<div class="form" >
				<form action="edit_view.php" method="post">
					<table>
					<caption style="text-align:right;"><h2>Contact Details</h2></caption>
					<tbody>
						<tr>
							<td>First</td><td></td>
							<td> 
								<?= isset($validate['first'])? "<span class='error_f'> " . $validate['first']. "</span>": '';?>
								<input type="text" name="first_name" value="<?= isset($first_name)  ?  $first_name : '' ?>"></td>
						</tr>
						<tr>
							<td>Last</td><td></td>
							 <td>
								<?= isset($validate['last'])? "<span class='error_f'> " . $validate['last']. "</span>": '';?>
								<input type="text" name="last_name"  value="<?=	isset($last_name) ? $last_name : ''?>"></td>
						</tr>
						<tr>
							<td>Email</td><td></td>		
							 <td>
								<?= isset($validate['email'])? "<span class='error_f'> " . $validate['email']. "</span>": '';?>
								<input type="text" name="email"  value="<?=	isset($email) ? $email : ''?>"></td>
						</tr>
						<tr>
							<td>Home</td>
							<td><input type="radio" name="best_phone" value="home" <?= isset($home_check) ? $home_check : ''?>></td>
							<td>
								<?= isset($validate['home'])? "<span class='error_f'> " . $validate['home']. "</span>": '';?>
								<input type="tel" name="home_phone" value="<?=	isset($home_phone)  ?  $home_phone : ''?>"></td>
						</tr>
						<tr>
							<td>Work</td>
							<td><input type="radio" name="best_phone" value="work" <?= isset($work_check) ? $work_check : ''?> ></td>
							<td>
								<?= isset($validate['work'])? "<span class='error_f'> " . $validate['work']. "</span>": '';?>
								<input type="tel" name="work_phone" value="<?=	isset($work_phone)  ?  $work_phone : ''?>"></td>
						</tr>
						<tr>
							<td>Cell</td>
							<td><input type="radio" name="best_phone" value="cell" <?= isset($cell_check) ? $cell_check : ''?>></td>
							<td>
								<?= isset($validate['cell'])? "<span class='error_f'> " . $validate['cell']. "</span>": '';?>
								<input type="tel" name="cell_phone" value="<?=	isset($cell_phone)  ?  $cell_phone : ''?>"></td>
						</tr>
						<tr>
							<td>Address 1</td><td></td>
							<td>
								<?= isset($validate['address1'])? "<span class='error_f'> " . $validate['address1']. "</span>": '';?>
								<input type="text" name="address1"  value="<?=	isset($address1) ? $address1 : ''?>"></td>
						</tr>
						<tr>
							<td>Address 2</td><td></td>

							<td>
								<?= isset($validate['address2'])? "<span class='error_f'> " . $validate['address2']. "</span>": '';?>
								<input type="text" name="address2"  value="<?=	isset($address2) ? $address2 : ''?>"></td>
						</tr>
						<tr>
							<td>City</td><td></td>
							<td>
								<?= isset($validate['city'])? "<span class='error_f'> " . $validate['city']. "</span>": '';?>
								<input type="text" name="city"  value="<?=	isset($city) ? $city : ''?>"></td>
						</tr>
						<tr>
							<td>State</td><td></td>
							<td>
								<?= isset($validate['state'])? "<span class='error_f'> " . $validate['state']. "</span>": '';?>
								<input type="text" name="state"  value="<?=	isset($state) ? $state : ''?>"></td>
						</tr>
						<tr>
							<td>ZIP</td><td></td>
							<td>
								<?= isset($validate['zip'])? "<span class='error_f'> " . $validate['zip']. "</span>": '';?>
								<input type="text" name="zip"  value="<?=	isset($zip) ? $zip : ''?>"></td>
						</tr>
						<tr> 
							<td>Country</td><td></td>
							<td>
								<?= isset($validate['country'])? "<span class='error_f'> " . $validate['country']. "</span>": '';?>
								<input type="text" name="country" value="<?=	isset($country)  ?  $country : ''?>"></td>
						</tr>
						<tr>
							<td>Birthday</td><td></td>
							<td>
								<?= isset($validate['birthday'])? "<span class='error_f'> " . $validate['birthday']. "</span>": '';?>
								<input type="text" name="birth_day"  placeholder="YYYY-MM-DD" value="<?=	isset($birth_day)  ?  $birth_day : ''?>"></td>							
						</tr>
						<tr>
							<td>								
								<input type='submit' name="<?php echo $form_button; ?>" value="<?php echo $form_button; ?>">								
								<input type="hidden" name="id_edit" value="<?php echo $id; ?>"></td><td></td><td></td>
						</tr>								
					</tbody>
					</table>
				</form>
			</div>
		</div>
	</main>
</body>
</html>
