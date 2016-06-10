<?php
	$log_sql="";
	$symbol_f ='';
	$symbol_l ='';
	$best_phone = '';	
	//pagination	
	$num_records_per_page = 5;
	$first_page = 1;
		
	if (isset($_GET['page_active'])) {
		$page_active =$_GET['page_active'];
	}
	else {
		$page_active = 1; 
	}	
	$sql1 = "SELECT id FROM contacts  WHERE users_id = " .$_SESSION['users_id'];
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
			$next_page = ($page_active < $last_page)? $page_active + 1:'';
			$next_page2 = ($page_active < $last_page-1)? $page_active + 2:'';
			$pre_page = ($page_active > 1)?  $page_active - 1:'';
			$pre_page2 = ($page_active > 2)? $page_active - 2:'';			
		}	
	// sort records	
	// write contact records
		$sort_l ='last_ascending';
		$sort_f ='first_ascending';
		if (isset($_GET["sort_l"]) or $sort_l =='last_ascending') {
			$sort_l = (isset($_GET['sort_l'])) ? string_fix($_GET['sort_l'], $conn) : $sort_l;
			if ($sort_l == 'last_ascending' ){
				$sql =  "SELECT id, last_name, first_name, cell_phone, work_phone, home_phone, email, best_phone FROM  contacts, best_phone WHERE best_phone.id_contacts = contacts.id AND contacts.users_id =" .$_SESSION['users_id']. " ORDER BY last_name LIMIT $start_from, $num_records_per_page";
				$symbol_l= '&#9660';
				$sort_l = 'last_descending';
			}
			else{
				$sql = "SELECT id, last_name, first_name, cell_phone, work_phone, home_phone, email, best_phone FROM  contacts, best_phone WHERE best_phone.id_contacts = contacts.id AND contacts.users_id = " .$_SESSION['users_id']. " ORDER BY last_name DESC LIMIT $start_from, $num_records_per_page";
				$symbol_l= '&#9650';
				$sort_l = 'last_ascending';	
			}
		}	
		if (isset($_GET["sort_f"])) {
			$sort_f = string_fix($_GET['sort_f'], $conn);
			if ($sort_f == 'first_ascending'){
				$sql = "SELECT id, last_name, first_name, cell_phone, work_phone, home_phone, email, best_phone FROM  contacts, best_phone WHERE best_phone.id_contacts = contacts.id AND contacts.users_id = " .$_SESSION['users_id']. " ORDER BY first_name LIMIT $start_from, $num_records_per_page";
				$symbol_f= "&#9660";
				$sort_f = 'first_descending';
			}
			else{
				$sql = "SELECT id, last_name, first_name, cell_phone, work_phone, home_phone, email, best_phone FROM  contacts, best_phone WHERE best_phone.id_contacts = contacts.id AND contacts.users_id = " .$_SESSION['users_id']. " ORDER BY first_name DESC LIMIT $start_from, $num_records_per_page";
				$symbol_f= '&#9650';
				$sort_f = 'first_ascending';
			}
		}		
		$result = mysqli_query($conn, $sql);
		if (!$result) {
			$log_sql =  "Помилка: " . mysqli_error($conn);			
			echo $log_sql;
			header ("location:error.php");
			exit;
		}
	}	
	mysqli_close($conn);	

	function view_pagination($how_many_records, $num_records_per_page, $pre_page, $pre_page, $pre_page2, $pre_page, $next_page, $next_page2, $next_page, $last_page, $page_active, $page){			
			echo "
			<div style='text-align:center'>
				<a href='" . $page . " ?page_active=1'>First page</a>..
				<a href='" . $page . "?page_active=" . $pre_page ."'>&#9664---</a>..
				<a href='" . $page . "?page_active=" . $pre_page2 ."'>". $pre_page2."</a>..
				<a href='" . $page . "?page_active=" . $pre_page ."'>". $pre_page."</a>..<span style='font-size:1.5em;'>". $page_active . "</span>..
				<a href='" . $page . "?page_active=" . $next_page ."'>". $next_page."</a>..
				<a href='" . $page . "?page_active=" .$next_page2 ."'>". $next_page2."</a>..
				<a href='" . $page . "?page_active=" . $next_page ."'>---&#9654</a>..
				<a href='" . $page . "?page_active=" . $last_page ."'>Last page</a>
			</div>";
	}

	function view_contacts_list_index_php($result, $res){		
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
								<input type='hidden' name='email' value=". $row["email"] .">
								<input type='hidden' name='delete' value='yes'>
								<input type='submit' value='delete'>							
							</form></td>
					</tr>";
			} 
		}
	}

	function view_contacts_add_contact_from_list_php($result, $best_phone){
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
					<td><input type='checkbox' name=". $i ."  value=". $row["email"] ."></td>
					<td>" . $row["last_name"] . "</td>
					<td>".  $row["first_name"] . "</td>
					<td>" . $row["email"] . "</td>
					<td>" . $best_phone ."</td>
				</tr>";
			++$i;
		} 
	}