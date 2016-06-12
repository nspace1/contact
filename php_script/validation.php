<?php

// validate form login
	function validate_user($username, $password, $confirm_password, $conn){				
			$t = 'true';
			$error['username'] = validate_username($username,  $conn);	
			$error['password'] = validate_password($password);				
			if ($confirm_password != $password) {			
			$error['equal']	= "Confirm Password and Password not equal";
			}					
			foreach ($error as $key => $value) {
				if (!empty($value)) {
					$t = 'false';
				}
			}
			if ($t == 'true'){
				return true;
			}
			else{
				return $error;
			}
	}

	function validate_login_page($login, $password, $conn){				
			$t = 'true';
			$error['login'] = validate_login($login,  $conn);			
			$error['password'] = validate_password($password);						
			foreach ($error as $key => $value) {
				if (!empty($value)) {
					$t = 'false';
				}
			}
			if ($t == 'true'){
				return true;
			}
			else{
				return $error;
			}
	}

	function validate_add_edit($first_name, $last_name, $email, $home_phone, $work_phone, $cell_phone, $address1, $address2, $city, $state,	$zip, $country,	$birth_day, $conn){
		$t = 'true';		
		$error['first'] = validate_text_30($first_name);
		$error['last']= validate_text_30($last_name);
		$error['email']= validate_email($email);
		$error['home']= validate_phone($home_phone);
		$error['work']= validate_phone($work_phone);
		$error['cell']= validate_phone($cell_phone);
		$error['address1'] = validate_text_30($address1);
		$error['address2']= validate_text_30($address2);
		$error['city']= validate_text_30($city);
		$error['state']= validate_text_30($state);
		$error['zip']= validate_zip($zip);
		$error['country']= validate_text_30($country);
		$error['birthday']= validate_birth_day($birth_day);
		foreach ($error as $key => $value) {
			if (!empty($value)) {
				$t = 'false';
				break;
			}
		}
		if ($t == 'true'){
			return true;
		}
		else{
			return $error;
		}
	}


	function validate_text_30($field) {
		return (strlen($field) > 30) ? "Field is limited to 30 characters" : "";
	}

	function validate_birth_day($field) {
		if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $field)){
			return "Please enter the date according to the example 1989-8-18";
		}
		 	$y = substr( $field, 0, 4 );
            $m = substr( $field, 5, 2 );
            $d = substr( $field, 8, 2 );
            
		if (!checkdate( $m, $d, $y )){
			return "Please enter correct date";
		}		
	}

	function validate_zip($field) {
		if (strlen($field) > 10){
			return "Field is limited to 10 characters";
		}
		if (preg_match('/[^0-9.-]/', $field)){
			return "The field can contain only numbers";
		}
	}                                                                                                                                                     
                             
	function validate_phone($field) {
		if (strlen($field) > 20){
			return "Field is limited to 20 characters";
		}
		if (preg_match('/[^0-9-+]+$/', $field)){
			return "The field can contain only numbers";
		}		
	}




	function validate_username($field, $conn) {
		if ($field == "") {
			return "Please enter Username";
		}
		else if (strlen($field) < 3) {

			return "Username повинен містити > 3 символів";
		}
		else if (preg_match("/[^a-zA-Z0-9_-]/", $field)){
			return "Username може містити букви, цифри, -, _ ";
		}		
		$sql= "SELECT username FROM users WHERE username='$field'";
		    $result=mysqli_query($conn, $sql);
    		if   (mysqli_num_rows($result)) {
    			 return "Username is exist";
    		}	 	
	}
	function validate_login($field) {
		if ($field == "") {
			return "Please enter Username";
		}
		else if (strlen($field) < 3) {

			return "Please enter > 3 chars";
		}
		else if (preg_match("/[^a-zA-Z0-9_-]/", $field)){
			return "Username can contain a-zA-Z0-9_- ";
		}		
	 	
	}

	function validate_password($field) {		
		if ($field == ""){
			return "Please enter Password";		
		}
		else if (strlen($field) < 6){
			return "Please enter > 6 chars";
		}
		
	}


	function validate_email($field) {
		if ($field == ""){
			return "Please enter email";
		}
		else if (!((strpos($field, ".") > 0) &&	(strpos($field, "@") > 0)) || preg_match("/[^a-zA-Z0-9.@_-]/", $field)){
			return "Email has a wrong format";
		}
	}



	function string_fix($str, $conn){
		return htmlentities(mysqli_real_escape_string($conn, $str));
	}

?>

