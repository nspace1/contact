<?php 
	//db_config
	if (file_exists('php_script\mysql_login.php')) {
    	require_once 'php_script\mysql_login.php';    		
	}
	else{
            define('DB_HOSTNAME', 'localhost');
            define('DB_DATABASE', 'contact_mananger');
            define('DB_USERNAME', 'naaa');
            define('DB_PASSWORD', '98465703');
	}

	//pagination
        define('NUM_RECORDS_PER_PAGE', '2');	
        define('PAGE_AMOUNT_NUMBER', '4');
       

	//sort
	const DEFAULT_ORDER_FIRSTNAME = 'ASC';
	const DEFAULT_ORDER_LASTNAME = 'ASC';


