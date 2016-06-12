<?php
		
	//pagination	
	$num_records_per_page = 5;
	$first_page = 1;
	
	if (!isset($_SESSION['page_active'])) {		
		$_SESSION['page_active'] = 1; 
		}		
	
	if (isset($_GET['page_active'])) {
		$_SESSION['page_active'] =$_GET['page_active'];
		}	


	$sql1 = "SELECT id FROM contacts  WHERE users_id = " .$_SESSION['users_id'];
		$res = mysqli_query($conn, $sql1);
		$how_many_records = mysqli_num_rows($res);

	if (mysqli_num_rows($res) !=  0){		
		$last_page = ceil ($how_many_records /  $num_records_per_page);
		if ($_SESSION['page_active'] < 1 ){
			$_SESSION['page_active'] = 1;
		}
		if ($_SESSION['page_active'] > $last_page) {
			$_SESSION['page_active'] = $last_page;
		}
		$start_from = ($_SESSION['page_active']-1) * $num_records_per_page; 
		if ($how_many_records > $num_records_per_page){				
			$next_page = ($_SESSION['page_active'] < $last_page)? $_SESSION['page_active'] + 1:'';
			$next_page2 = ($_SESSION['page_active'] < $last_page-1)? $_SESSION['page_active'] + 2:'';
			$pre_page = ($_SESSION['page_active'] > 1)?  $_SESSION['page_active'] - 1:'';
			$pre_page2 = ($_SESSION['page_active'] > 2)? $_SESSION['page_active'] - 2:'';			
		}	


		if (!isset($_SESSION['cur_sort_l']) and !isset($_SESSION['cur_sort_f']) and !isset($_SESSION['cur_second_sort_l']) and !isset($_SESSION['cur_second_sort_f'])){
			$_SESSION['cur_sort_l'] = 'ASC';	
			$_SESSION['cur_sort_f'] = 'DESC';	
			$_SESSION['cur_second_sort_l'] = 'DESC';
			$_SESSION['cur_second_sort_f'] = 'DESC';
		}


		if (isset($_POST['last']) or isset($_POST['second_sort_f'])){
			$first_field = 'last_name';
			$second_field ='first_name';		
			if (isset($_POST['last'])) {
				switch ($_SESSION['cur_sort_l']) {
					case 'DESC':
						$_SESSION['cur_sort_l'] = 'ASC';					
				 		break;
					case 'ASC':	
						$_SESSION['cur_sort_l'] = 'DESC';					
						break;
				}
				$order_by_lastname = $_SESSION['cur_sort_l'];
				$_SESSION['cur_second_sort_l'] = 'ASC';
				$order_by_firstname = $_SESSION['cur_second_sort_l'];
				$second_symbol_f = '--&#9660';
			}		
//second field
			if (isset($_POST['second_sort_f'])) {
				$order_by_lastname = $_SESSION['cur_sort_l'];		
				switch ($_SESSION['cur_second_sort_l']) {
					case 'DESC':					
						$_SESSION['cur_second_sort_l'] = 'ASC';
						$order_by_firstname = $_SESSION['cur_second_sort_l'];
						$second_symbol_f= '--&#9660';
						break;				
					case 'ASC':
						$_SESSION['cur_second_sort_l'] = 'DESC';
						$order_by_firstname = $_SESSION['cur_second_sort_l'];
						$second_symbol_f= '--&#9650';
						break;
				}			
			}
			if ($_SESSION['cur_sort_l'] == 'ASC'){
				$symbol_l= '&#9660';
			}
			if ($_SESSION['cur_sort_l'] == 'DESC'){
				$symbol_l= '&#9650';
			}
		}

	//first-->last
		if (isset($_POST['second_sort_l']) or isset($_POST['first'])){
			$first_field = 'first_name';
			$second_field ='last_name';				
			if (isset($_POST['first'])) {
				switch ($_SESSION['cur_sort_f']) {
					case 'DESC':
						$symbol_f= '&#9660';
						$_SESSION['cur_sort_f'] = 'ASC';					
				 		break;
					case 'ASC':
						$symbol_f= '&#9650';
						$_SESSION['cur_sort_f'] = 'DESC';					
						break;
				}
				$order_by_lastname = $_SESSION['cur_sort_f'];

				$_SESSION['cur_second_sort_f'] = 'ASC';
				$order_by_firstname = $_SESSION['cur_second_sort_f'];
				$second_symbol_l = '--&#9660';
			}		
//second field
			if (isset($_POST['second_sort_l'])) {			
				$order_by_lastname = $_SESSION['cur_sort_f'];		
				switch ($_SESSION['cur_second_sort_f']) {
					case 'DESC':					
						$_SESSION['cur_second_sort_f'] = 'ASC';
						$order_by_firstname = $_SESSION['cur_second_sort_f'];
						$second_symbol_l= '--&#9660';
						break;				
					case 'ASC':					
						$_SESSION['cur_second_sort_f'] = 'DESC';
						$order_by_firstname = $_SESSION['cur_second_sort_f'];
						$second_symbol_l= '--&#9650';
						break;
				}			
			}		
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


//last-->first
		if (isset($_GET['sort_l']) or isset($_GET['second_sort_f'])){
			$first_field = 'last_name';
			$second_field ='first_name';		
			if (isset($_GET['sort_l'])) {
				switch ($_SESSION['cur_sort_l']) {
					case 'DESC':
						$_SESSION['cur_sort_l'] = 'ASC';					
				 		break;
					case 'ASC':	
						$_SESSION['cur_sort_l'] = 'DESC';					
						break;
				}
				$order_by_lastname = $_SESSION['cur_sort_l'];
				$_SESSION['cur_second_sort_l'] = 'ASC';
				$order_by_firstname = $_SESSION['cur_second_sort_l'];
				$second_symbol_f = '--&#9660';
			}		
//second field
			if (isset($_GET['second_sort_f'])) {
				$order_by_lastname = $_SESSION['cur_sort_l'];		
				switch ($_SESSION['cur_second_sort_l']) {
					case 'DESC':					
						$_SESSION['cur_second_sort_l'] = 'ASC';
						$order_by_firstname = $_SESSION['cur_second_sort_l'];
						$second_symbol_f= '--&#9660';
						break;				
					case 'ASC':
						$_SESSION['cur_second_sort_l'] = 'DESC';
						$order_by_firstname = $_SESSION['cur_second_sort_l'];
						$second_symbol_f= '--&#9650';
						break;
				}			
			}
			if ($_SESSION['cur_sort_l'] == 'ASC'){
				$symbol_l= '&#9660';
			}
			if ($_SESSION['cur_sort_l'] == 'DESC'){
				$symbol_l= '&#9650';
			}
		}
	//first-->last
		if (isset($_GET['second_sort_l']) or isset($_GET['sort_f'])){
			$first_field = 'first_name';
			$second_field ='last_name';				
			if (isset($_GET['sort_f'])) {
				switch ($_SESSION['cur_sort_f']) {
					case 'DESC':
						$symbol_f= '&#9660';
						$_SESSION['cur_sort_f'] = 'ASC';					
				 		break;
					case 'ASC':
						$symbol_f= '&#9650';
						$_SESSION['cur_sort_f'] = 'DESC';					
						break;
				}
				$order_by_lastname = $_SESSION['cur_sort_f'];

				$_SESSION['cur_second_sort_f'] = 'ASC';
				$order_by_firstname = $_SESSION['cur_second_sort_f'];
				$second_symbol_l = '--&#9660';
			}		
//second field
			if (isset($_GET['second_sort_l'])) {			
				$order_by_lastname = $_SESSION['cur_sort_f'];		
				switch ($_SESSION['cur_second_sort_f']) {
					case 'DESC':					
						$_SESSION['cur_second_sort_f'] = 'ASC';
						$order_by_firstname = $_SESSION['cur_second_sort_f'];
						$second_symbol_l= '--&#9660';
						break;				
					case 'ASC':					
						$_SESSION['cur_second_sort_f'] = 'DESC';
						$order_by_firstname = $_SESSION['cur_second_sort_f'];
						$second_symbol_l= '--&#9650';
						break;
				}	
				if ($_SESSION['cur_sort_f'] == 'ASC'){
				$symbol_f= '&#9660';
			}
			if ($_SESSION['cur_sort_f'] == 'DESC'){
				$symbol_f= '&#9650';
			}				
			}
			
		}
	//default 
	if (!isset($order_by_firstname)){
		$order_by_firstname = 'ASC';
		$order_by_lastname = 'ASC';
		$first_field = 'last_name';
		$second_field ='first_name';
		$symbol_l= '&#9660';
		$second_symbol_f = '--&#9660';
	}
		$sql =  "SELECT id, last_name, first_name, cell_phone, work_phone, home_phone, email, best_phone FROM  contacts, best_phone WHERE best_phone.id_contacts = contacts.id AND contacts.users_id =" .$_SESSION['users_id']. " ORDER BY $first_field $order_by_lastname , $second_field $order_by_firstname  LIMIT $start_from, $num_records_per_page";
		$result = mysqli_query($conn, $sql);
		if (!$result) {
			$log_sql =  "Помилка: " . mysqli_error($conn);			
			//echo $log_sql;
			header ("location:error.php");
			exit;
		}
	}	
	mysqli_close($conn);	

	function view_pagination($how_many_records, $num_records_per_page, $pre_page, $pre_page, $pre_page2, $pre_page, $next_page, $next_page2, $next_page, $last_page,  $page){			
			echo "
			<div style='text-align:center'>
				<a href='" . $page . " ?page_active=1'>First page</a>..
				<a href='" . $page . "?page_active=" . $pre_page ."'>&#9664---</a>..
				<a href='" . $page . "?page_active=" . $pre_page2 ."'>". $pre_page2."</a>..
				<a href='" . $page . "?page_active=" . $pre_page ."'>". $pre_page."</a>..<span style='font-size:1.5em;'>". $_SESSION['page_active'] . "</span>..
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