<?php

// validate form login
	function validate_user($username, $password, $confirm_password, $conn){				
			$fail="";
			$error['username'] = validate_username($username,  $conn);
			$error['password'] = validate_password($password);	
			
			if ($confirm_password != $password) {			
				$fail .= "Confirm Password and Password not equal<br>";
			}		
			foreach ($error as $value) {
		       	$fail .= $value;
		    }
			if ($fail == ""){
				return true;
			}
			else{
				return $fail;
			}
	}

	function validate_add_edit($first_name, $last_name, $email, $home_phone, $work_phone, $cell_phone, $address1, $address2, $city, $state,	$zip, $country,	$birth_day, $conn){

		$fail="";
		$error['First'] = validate_text_30($first_name);
		$error['Last']= validate_text_30($last_name);
		$error['Email']= validate_email($email);
		$error['Home']= validate_phone($home_phone);
		$error['Work']= validate_phone($work_phone);
		$error['Cell']= validate_phone($cell_phone);
		$error['Address1'] = validate_text_30($address1);
		$error['Address2']= validate_text_30($address2);
		$error['City']= validate_text_30($city);
		$error['State']= validate_text_30($state);
		$error['ZIP']= validate_zip($zip);
		$error['Country']= validate_text_30($country);
		$error['Birthday']= validate_birth_day($birth_day);

		foreach ($error as $key => $value) {
			if ($value != '') {
			$fail .=$key. ':  ';
			$fail .=$value . '<br>';
			}
		}
			
			if ($fail == ""){
				return true;
			}
			else{
				return $fail;
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
			return "Заповніть поле Username<br>";
		}
		else if (strlen($field) < 3) {

			return "Username повинен містити > 3 символів<br>";
		}
		else if (preg_match("/[^a-zA-Z0-9_-]/", $field)){
			return "Username може містити букви, цифри, -, _ <br>";
		}

		
		$sql= "SELECT username FROM users WHERE username='$field'";
		    $result=mysqli_query($conn, $sql);
    		if   (mysqli_num_rows($result)) {
    			 return "Username is exist<br>";
    		}
	 	return "";
	}
	function validate_login($field) {
		if ($field == "") {
			return "Заповніть поле Username<br>";
		}
		else if (strlen($field) < 3) {

			return "Username повинен містити > 3 символів<br>";
		}
		else if (preg_match("/[^a-zA-Z0-9_-]/", $field)){
			return "Username може містити букви, цифри, -, _ <br>";
		}
		
	 	return "";
	}

	function validate_password($field) {
		if ($field == ""){
			return "Заповніть поле Password<br>";
		}
		else if (strlen($field) < 6){
			return "Password повинен містити > 6 символів<br>";
		}
		return "";
	}


	function validate_email($field) {
		if ($field == ""){
			return "Введіть адрес електронної пошти<br>";
		}
		else if (!((strpos($field, ".") > 0) &&	(strpos($field, "@") > 0)) || preg_match("/[^a-zA-Z0-9.@_-]/", $field)){
			return "Email має невірний формат<br>";
		}
		return "";
	}


// перевірка на спецсимволи

	function string_fix($str, $conn){
		return htmlentities(mysqli_real_escape_string($conn, $str));
	}
/*

	function get_post($var) {
		global $conn;
		if (get_magic_quotes_gpc()) $_POST[$var] = htmlentities(stripslashes($_POST[$var]));
		return htmlentities(mysqli_real_escape_string($conn, $_POST[$var]));
	}

	function get_get($var) {		
		global $conn;
		if (get_magic_quotes_gpc()) $_GET[$var] = htmlentities(stripslashes($_GET[$var]));
		return htmlentities(mysqli_real_escape_string($conn, $_GET[$var]));
	 }

	 */

?>

