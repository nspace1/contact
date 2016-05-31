
<?php
	require_once 'php_script\session.php';
	session_security();

	require_once 'php_script\validation.php';

	require_once 'php_script\sql_connect.php';
	$conn = sql_connect();

	require_once 'mail.php';

	$to="";
	$log_sql="";
	$msg_add_mail="";
	$msg_visibility="visibility: hidden";
	$send_address="";
	
	$username=$_SESSION['username'];

// list mail in field To:
	if (isset($_POST['ACCEPT'])){
		if (isset($_POST['checkAll'])){
			$sql = "SELECT email FROM contacts, users_contacts WHERE users_contacts.username = '$username' AND contacts.id = users_contacts.id_contacts";
			$result = mysqli_query($conn, $sql);
			if (! $result) {				
				header ("location:error.php");
			}
			while ($row = mysqli_fetch_assoc($result)) {
				$to .= $row["email"] . ", ";
			}
		}
		else {
			foreach ($_POST as $key => $value) {
				if ($value != "ACCEPT" and $value != "checkAll"){			    	
			    	$to =$to . $value . ", ";
			    }
			}
		}
		$to = substr($to,0,-2);
	}
	if (isset($_POST['send'])){		

//Add not exist email and insert event_sendmail
		$to1 = string_fix($_POST['to'], $conn);
		$tok = strtok($to1, " ,\n\t");
		while ($tok) {
			$sql = "SELECT id, email FROM contacts, users_contacts WHERE users_contacts.username = '$username' AND contacts.id = users_contacts.id_contacts AND contacts.email='$tok'";    		
    		$result=mysqli_query($conn, $sql);
    		if   (mysqli_num_rows($result)) {
    			$row = mysqli_fetch_assoc($result);
    			$id_contacts = $row['id'];

    			
			}
			else {
				$log_sql =$log_sql . "  no_ " .$tok;
				$msg_add_mail[] = $tok;

			}
//list mail to send
			$send_address[] = $tok;
			    		$tok = strtok(" ,\n\t");
		}
			
	}
//insert not exist email
	if(isset($_POST['add_ev_msg'])) {			
			foreach ($_POST as $key => $value) {
			    if ($value != "add_ev_msg" ){
			    	$email = strtolower(string_fix($_POST["$key"], $conn));
			    	$sql = "INSERT INTO contacts (email)
					VALUES ('$email')";

					if (mysqli_query($conn, $sql)) {	

						$id_contacts = mysqli_insert_id($conn);	
						$sql = "INSERT INTO users_contacts (username, id_contacts)
							VALUES ('$username', '$id_contacts')";
						if (mysqli_query($conn, $sql)) {
								$log_sql = "Запис успішно додано";							
						}
						else {
								$log_sql =  "Помилка запису в БД" . $sql . "<br>" . mysqli_error($conn);
								header ("location:error.php");
						}	
						$sql1= "INSERT INTO best_phone (id_contacts) VALUES ('$id_contacts')";
						if (!mysqli_query($conn, $sql1)) {
							$log_sql =  "Error write to DB" . $sql1 . "<br>" . mysqli_error($conn);
						}
					}
					else {
						$log_sql =  "Помилка запису в БД" . $sql . "<br>" . mysqli_error($conn);
						echo $log_sql;
						header ("location:error.php");
					}		
		    	}
	    	}
	    	header("Location: index.php");
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
	<main>
		<div class="container">
			<div id='content_view_ev'>
				<div class="msg" style="<?php if ($msg_add_mail !== "") echo "visibility: visible"; ?>">
					<small>This address is not in your contact mananger</small><br><br>
					<form action="event.php" method="post" id="msg_form">
						<?php 
							$i = 1;
							foreach ($msg_add_mail as $value ) {
								echo "<input type='checkbox' name=". $i ."  value=". $value .">" . $value . "<br>";
								++$i;
							}
						?>
						<input type='hidden' name='add_ev_msg' value='add_ev_msg'>
						<input type="submit" name="add_email"  id="add_email"  style="visibility: hidden;" ><br>
						<a href="" onclick="document.getElementById('msg_form').submit('add_email'); return false;">Add to contact mananger</a><br>
						<a href="event.php" >Go to My Albums/Events</a>
					</form>
				</div>
				<span style='text-align: right'><h3>EVENT</h3></span>
				<form name="event_form" action="event.php" method="post">
					<table>
						<tr>
							<td>
								<a href="add_contact_from_list.php">To:</a>
							</td>
							<td>
									<input  type="email" multiple name="to" cols="100" value="<?php echo $to; ?>" style="width:100%">
							</td> 
						</tr>
						<tr>
							<td>
								Subject:
							</td>
							<td>
								<input type="text" name="subject" maxlength="59"  value="" style="width:100%">
							</td>
						</tr>
						<tr>
							<td>
								Event:
							</td>
							<td>
								<textarea name="event" rows="8" cols="70"style="resize: none;" ></textarea>
							</td>
						</tr>
						<tr>
							<td>
								<input type="hidden" name="date_event" value="<?php  echo date("Y-m-d H:i:s");?>">
								<input type="submit" name="send" value="Send">
							</td><td></td>
						</tr>		
					</table>
			</form>			
		</div>			
	</div>	
</main>
</body>
</html>
<?php
mysqli_close($conn);
?>


