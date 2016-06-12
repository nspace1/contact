<?php
	require_once 'php_script\session.php';
	session_security();
	include 'php_script\validation.php';
	require_once 'php_script\sql_connect.php'; 
	$conn = sql_connect();

	if (isset($_POST['ACCEPT'])){
		if (isset($_POST['checkAll'])){
			$sql = "SELECT email FROM contacts WHERE users_id = " .$_SESSION['users_id'];
			$result = mysqli_query($conn, $sql);
			if (! $result) {				
				header ("location:error.php");
				exit;
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
		if ($to != ''){
			header("Location: event.php?to=$to");
			exit;
		}
		else{
			header("Location: event.php");
			exit;
		}

	}
	

	require 'php_script\view_contacts_list.php';


	

	//header
	require 'pages\header.php';
?>
	<main>
		<div class="container">
			<div class='content_view'>
				<span style='text-align: right'><h3>SELECTION MAIN PAGE</h3></span>
					<form action='add_contact_from_list.php' method="post">
						<input type='submit' name="ACCEPT" value= 'ACCEPT'>
						<input type='button' value= 'CANCEL' onclick="location.href='event.php'">
						<table>
							<thead>
								<tr><th>
										all										
										<input type="image" name="check_all" value="check_all" src="img\unchecked.png">
									</th>
																
									


									<th><input  type="submit" name="last"   value='Last' class='button_to_link'>  <?= (isset($symbol_l))? $symbol_l : '' ?> &nbsp;&nbsp; 
									<input  type="submit" name="second_sort_l"   value='<?= (isset($second_symbol_l))? $second_symbol_l : ''; ?>' class='button_to_link'>
									</th>

									<th><input  type="submit" name="first"   value='First' class='button_to_link'>  <?= (isset($symbol_f))? $symbol_f : '' ?> &nbsp;&nbsp; 
									<input  type="submit" name="second_sort_f"   value='<?= (isset($second_symbol_f))? $second_symbol_f : ''; ?>' class='button_to_link'></th>
									<th>Email</th>
									<th>Best Phone</th>
								</tr>
							</thead>
							<tbody>
								<?php
									//php_script\view_contacts_list.php
									view_contacts_add_contact_from_list_php($result, $res);
								?>						
							</tbody>
						</table>
					<input type='submit' name="ACCEPT" value= 'ACCEPT'>
					<input type='button' value= 'CANCEL' onclick="location.href='event.php'">
				</form>
				<?php
				if ($how_many_records > $num_records_per_page){		
					//php_script\view_contacts_list.php									
					view_pagination($how_many_records, $num_records_per_page, $pre_page, $pre_page, $pre_page2, $pre_page, $next_page, $next_page2, $next_page, $last_page, 'add_contact_from_list.php');		
				}
				?>		
			</div>
		</div>	
	</main>
</body>
</html>


