<?php

	//pagination	
	if (isset($_GET['page_active'])) {
		$page_active =$_GET['page_active'];
	}
	elseif (isset($_POST['page_active'])){
		$page_active =$_POST['page_active'];
	}
	else{
		$page_active = 1; 
	}	
	$sql1 = "SELECT id FROM contacts  WHERE users_id = " .$_SESSION['users_id'];
		$res = mysqli_query($conn, $sql1);
		$how_many_records = mysqli_num_rows($res);
	if (mysqli_num_rows($res) !=  0){		
		$last_page = ceil ($how_many_records /  NUM_RECORDS_PER_PAGE);
		if ($page_active < 1 ){
			$page_active = 1;
		}
		if ($page_active > $last_page) {
			$page_active = $last_page;
		}
		$start_from = ($page_active-1) * NUM_RECORDS_PER_PAGE; 
		if ($how_many_records > NUM_RECORDS_PER_PAGE){				
			$next_page = ($page_active < $last_page)? $page_active + 1:'';
			$next_page2 = ($page_active < $last_page-1)? $page_active + 2:'';
			$pre_page = ($page_active > 1)?  $page_active - 1:'';
			$pre_page2 = ($page_active > 2)? $page_active - 2:'';			
		}	



		if (isset($_POST['check_all'])){
			if (!isset($_SESSION['cheked_all'])){
				$_SESSION['cheked_all'] = '';				
			}
			switch ( $_SESSION['cheked_all'] ) {
				case 'checkAll':					
					while ($row = mysqli_fetch_assoc($res)) {
						$chek_all[] = $row['id'];
					}
					$_SESSION['cheked'] = $chek_all;
					$_SESSION['cheked_all'] = '';
					break;
				case '':				
					unset($_SESSION['cheked']);
					$_SESSION['cheked_all'] = 'checkAll';
					break;
			}	
		}


		if (isset($_POST['second_sort_l']) or isset($_POST['first']) or isset($_POST['last']) or isset($_POST['second_sort_f'])){			
			foreach ($_POST as $key => $value) {
				$key = explode('=', $key);
				if ($key[0] == 'id'){			    	
			    	$cheked[] = $key[1];
			    }			    		    	
			}

			if (isset($_SESSION['view_id']) and isset($_SESSION['cheked']) and isset($cheked)){
						$list_id = array_intersect($_SESSION['view_id'], $_SESSION['cheked']);						
						foreach ($list_id as $key => $value) {
							if (!in_array($value, $cheked)){
								
								unset($_SESSION['cheked'][$key]);
							}
						foreach ($_SESSION['view_id'] as $key => $value) {								
							}
						}  	
				    }
			
		
			if (isset($_SESSION['cheked']) and isset($cheked)){			
				$_SESSION['cheked'] = $_SESSION['cheked'] + $cheked;
			}
			elseif (isset($cheked)){
				$_SESSION['cheked'] = $cheked;			
			}
		}


//sort
					
		if (isset($_POST['last']) and isset($_POST['order_lastname'])){
			if ($_POST['order_lastname'] == 'DESC'){
				$order_lastname = 'ASC';
			}
			elseif ($_POST['order_lastname'] == 'ASC'){
				$order_lastname = 'DESC';
			}
			$order_firstname = $_POST['order_firstname'];
		}	
		if (isset($_POST['first']) and isset($_POST['order_firstname'])){
			if ($_POST['order_firstname'] == 'DESC'){
				$order_firstname = 'ASC';
			}
			elseif ($_POST['order_firstname'] == 'ASC') {
				$order_firstname = 'DESC';
			}
			$order_lastname = $_POST['order_lastname'];
		} 
		if (!isset($_POST['order_lastname']) and !isset($_POST['order_firstname'])) {	
			$order_lastname = DEFAULT_ORDER_LASTNAME;
			$order_firstname = DEFAULT_ORDER_FIRSTNAME;
		}
//combine pagination and sort 
		if (isset($_GET['order_lastname']) and isset($_GET['order_firstname'] )){
			$order_lastname = $_GET['order_lastname'];
			$order_firstname = $_GET['order_firstname'];
		}

		$sql =  "SELECT id, last_name, first_name, cell_phone, work_phone, home_phone, email, best_phone FROM  contacts, best_phone WHERE best_phone.id_contacts = contacts.id AND contacts.users_id =" .$_SESSION['users_id']. " ORDER BY last_name $order_lastname , first_name $order_firstname  LIMIT $start_from," .  NUM_RECORDS_PER_PAGE;
		$result = mysqli_query($conn, $sql);
		if (!$result) {
			$log_sql =  "Помилка: " . mysqli_error($conn);				
			header ("location:error.php");
			exit;
		}
	}	
	mysqli_close($conn);	


	function view_pagination($how_many_records, $pre_page, $pre_page, $pre_page2, $pre_page, $next_page, $next_page2, $next_page, $last_page, $order_lastname, $order_firstname,$page_active, $page){			
			echo "
			<div style='text-align:center'>
				<a href='" . $page . " ?page_active=1&order_lastname=" . $order_lastname  . "&order_firstname=" . $order_firstname  . "'>First page</a>..
				<a href='" . $page . "?page_active=" . $pre_page ."&order_lastname=" . $order_lastname  . "&order_firstname=" . $order_firstname  . "'>&#9664---</a>..
				<a href='" . $page . "?page_active=" . $pre_page2 ."&order_lastname=" . $order_lastname  . "&order_firstname=" . $order_firstname  . "'>". $pre_page2."</a>..
				<a href='" . $page . "?page_active=" . $pre_page ."&order_lastname=" . $order_lastname  . "&order_firstname=" . $order_firstname  . "'>". $pre_page."</a>..<span style='font-size:1.5em;'>". $page_active . "</span>..
				<a href='" . $page . "?page_active=" . $next_page ."&order_lastname=" . $order_lastname  . "&order_firstname=" . $order_firstname  . "'>". $next_page."</a>..
				<a href='" . $page . "?page_active=" .$next_page2 ."&order_lastname=" . $order_lastname  . "&order_firstname=" . $order_firstname  . "'>". $next_page2."</a>..
				<a href='" . $page . "?page_active=" . $next_page ."&order_lastname=" . $order_lastname  . "&order_firstname=" . $order_firstname  . "'>---&#9654</a>..
				<a href='" . $page . "?page_active=" . $last_page ."&order_lastname=" . $order_lastname  . "&order_firstname=" . $order_firstname  . "&order_lastname=" . $order_lastname  . "&order_firstname=" . $order_firstname  . "'>Last page</a>
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

	function view_contacts_add_contact_from_list_php($result){
		
		unset($_SESSION['view_id']);
		while ($row = mysqli_fetch_assoc($result)) { 
				$best_phone = '';
				$checked ='';
			if ($row["best_phone"] == 'cell'){
				$best_phone = $row["cell_phone"];
			}
			elseif ($row["best_phone"] == 'work'){
				$best_phone = $row["work_phone"];
			}
				elseif ($row["best_phone"] == 'home'){
				$best_phone = $row["home_phone"];
			}	
			if (isset($_SESSION['cheked'])){				
				if  (in_array($row['id'], $_SESSION['cheked'])){
					$checked = 'checked';
				
				}				
			}
			$_SESSION['view_id'][] = $row['id'];
			
			echo 
				"<tr>
					<td><input type='checkbox' name=id=". $row['id'] ."  value='". $row['email'] ."'"; echo !empty($checked) ? 'checked' : ''; echo"  ></td>
					<td>" . $row["last_name"] . "</td>
					<td>".  $row["first_name"] . "</td>
					<td>" . $row["email"] . "</td>
					<td>" . $best_phone ."</td>
				</tr>";
			
		} 
	}