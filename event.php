
<?php
	require_once 'php_script\session.php';
	session_security();
	require_once 'php_script\validation.php';
	require_once 'php_script\sql_connect.php';
	$conn = sql_connect();

	$msg_add_mail="";	
	$send_address="";
	
	if (isset($_POST['send'])){
		unset($_SESSION['cheked']);
		unset($_SESSION['cheked_all']);
		unset($_SESSION['view_id']);
//Add not exist email and insert event_sendmail
		$to1 = string_fix($_POST['to'], $conn);
		$tok = strtok($to1, " ,\n\t");
		while ($tok) {
			$sql = "SELECT id, email FROM contacts WHERE contacts.email='$tok' AND users_id =" . $_SESSION['users_id'];
    		$result=mysqli_query($conn, $sql);
    		if   (mysqli_num_rows($result)) {
    			$row = mysqli_fetch_assoc($result);
    			$id_contacts = $row['id'];    			
			}
			else {				
				$msg_add_mail[] = $tok;
			}
//list mail to send
			$send_address[] = $tok;
			    		$tok = strtok(" ,\n\t");
		}			
	}
//insert not exist email
	if(isset($_POST['add_ev_msg'])) {			
		foreach ($_POST as $key  => $value) {
			
		    if ($value != "add_ev_msg" and $value != "Add to contact mananger"  ){
		    	$email = strtolower(string_fix($_POST["$key"], $conn));
		    	$sql = "INSERT INTO contacts (email, users_id)
				VALUES ('$email',".$_SESSION['users_id'] . ")";

				if (mysqli_query($conn, $sql)) {	
					$id_contacts = mysqli_insert_id($conn);							
					$sql1= "INSERT INTO best_phone (id_contacts) VALUES ('$id_contacts')";
					if (!mysqli_query($conn, $sql1)) {
						$log_sql =  "Error write to DB" . $sql1 . "<br>" . mysqli_error($conn);
						header ("location:error.php");
						exit;
					}
				}
				else {
					$log_sql =  "error" . $sql . "<br>" . mysqli_error($conn);
					
					header ("location:error.php");
					exit;
				}		
	    	}
    	}
    	header("Location: index.php");
    	exit;
	}
	 //header
	mysqli_close($conn);
	require 'pages\header.php';
?>
	<main>
		<div class="container">
			<div id='content_view_ev'>
			<?php
				if ($msg_add_mail !== "") {
					echo
					"<div class='msg'>
						<small>This address is not in your contact mananger</small><br><br>
						<form action='event.php' method='post' id='msg_form'>";							
								$i = 1;
								foreach ($msg_add_mail as $value ) {
									echo "<input type='checkbox' name=". $i ."  value=". $value .">" . $value . "<br>";
									++$i;
								}
							?>
							<input type='hidden' name='add_ev_msg' value='add_ev_msg'>
							<br>
							<input  type="submit" name="add_email"  id="add_email" value='Add to contact mananger' class='button_to_link'> 
							<a href="event.php" >Go to My Albums/Events</a>
						</form>
					</div>
				<?php	
				}
				?>
				<span style='text-align: right'><h3>EVENT</h3></span>
				<form name="event_form" action="event.php" method="post">
					<table>
						<tr>
							<td>
								<a href="add_contact_from_list.php">To:</a>
							</td>
							<td>
								<input  type="email" multiple name="to" cols="100" value="<?= isset($_GET['to']) ? $_GET['to'] : '' ?>" style="width:100%">
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



