<?php
	function delete_contacts($conn){			
		$form_ask_delete ='true';
		$id = string_fix($_POST['id'], $conn);
	//select Last and first to ask msg		
		if (isset($_POST['delete']) && isset($_POST['ask'])) {	
			$id=$_POST['id'];
			$sql = "DELETE contacts, best_phone FROM contacts JOIN best_phone ON id = '$id' AND id_contacts = '$id' AND users_id =" . $_SESSION['users_id']; 
			if (!mysqli_query($conn, $sql)) {
				$log_sql .='Error delete<br>';
				header ('location:error.php');
				exit;
			}
		header ('location:index.php');
		exit;
		}
		return 'true';
	}