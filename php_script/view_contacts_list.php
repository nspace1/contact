<?php
//sort	

if (isset($_GET['page_active'])) {
        $page_active =$_GET['page_active'];
    }
    elseif (isset($_POST['page_active'])) {
        $page_active =$_POST['page_active'];
    }
    else {
        $page_active = 1; 
    }	
     require_once 'app/DB/QueriesToDB.php';
    
    

 function sorting(){
    global $order_firstname;
    global $order_lastname;
     
    if (isset($_GET['last']) and isset($_GET['order_lastname'])){
        if ($_GET['order_lastname'] == 'DESC'){
            $order_lastname = 'ASC';
        }
        elseif ($_GET['order_lastname'] == 'ASC'){
            $order_lastname = 'DESC';
        }
        $order_firstname = $_GET['order_firstname'];
    }	
    if (isset($_GET['first']) and isset($_GET['order_firstname'])){
        if ($_GET['order_firstname'] == 'DESC'){
            $order_firstname = 'ASC';
        }
        elseif ($_GET['order_firstname'] == 'ASC') {
            $order_firstname = 'DESC';
        }
        $order_lastname = $_GET['order_lastname'];
    } 
    if (!isset($_GET['order_lastname']) and !isset($_GET['order_firstname'])) {	
        $order_lastname = DEFAULT_ORDER_LASTNAME;
        $order_firstname = DEFAULT_ORDER_FIRSTNAME;
    }
}

 sorting();
$pagination =  pagination($page_active);
 
function pagination($page_active){    
      
    global $start_from;
    global $res;
    global $order_firstname;
    global $order_lastname;
    global $how_many_records;        

    
    $sql1 = "SELECT id FROM contacts  WHERE users_id = " .$_SESSION['users_id'];
    $DB = new QueriesToDB;
    $res = $DB->selectDB($sql1);    
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

    //combine pagination and sort 
        if (isset($_GET['order_last']) and isset($_GET['order_firstname'])){
            $order_lastname = $_GET['order_last'];
            $order_firstname = $_GET['order_firstname'];
        }
    }
    if ($how_many_records > NUM_RECORDS_PER_PAGE){	
        $page = 'index.php';

        $pre_page = ($page_active > 1)?  $page_active - 1:'';
        
        ob_start();
        echo
            "<div style='text-align:center'>
                <a href='" . $page . " ?page_active=1&order_last=" . $order_lastname  . "&order_firstname=" . $order_firstname  . "'>First page</a>..
            <a href='" . $page . "?page_active=" . $pre_page ."&order_last=" . $order_lastname  . "&order_firstname=" . $order_firstname  . "'>&#9664---</a>..";

        if ($page_active-1 > PAGE_AMOUNT_NUMBER) {
            $pre = PAGE_AMOUNT_NUMBER;
        } else {
            $pre = $page_active;
        }

        for ($i = $pre; $i > 0; $i-- ) {                        
            $pre_page = ($page_active > $i)?  $page_active - $i:'';
            echo  "<a href='" . $page . "?page_active=" . $pre_page ."&order_last=" . $order_lastname  . "&order_firstname=" . $order_firstname  . "'>". $pre_page."</a>..";
        }
        
        echo "<span style='font-size:1.5em;'>". $page_active . "</span>..";
        $k = 1;
        
        for ($j = 1; ($j <= PAGE_AMOUNT_NUMBER) and ($j + $page_active <= $last_page) ; $j++ ) {                   
            $next_page = ($page_active < $last_page)? $page_active + $j:'';
            echo  "<a href='" . $page . "?page_active=" . $next_page ."&order_last=" . $order_lastname  . "&order_firstname=" . $order_firstname  . "'>". $next_page."</a>..";
            $k++;
        } 
        
        $next_page = ($page_active < $last_page)? $page_active + 1:'';
        echo "<a href='" . $page . "?page_active=" . $next_page ."&order_last=" . $order_lastname  . "&order_firstname=" . $order_firstname  . "'>---&#9654</a>..
                    <a href='" . $page . "?page_active=" . $last_page ."&order_last=" . $order_lastname  . "&order_firstname=" . $order_firstname  . "'>Last page</a>
            </div>";
    }
    $pagination = ob_get_contents();
    ob_get_clean();
    return $pagination;
}

$sql =  "SELECT id, last_name, first_name, cell_phone, work_phone, home_phone, email, best_phone FROM  contacts, best_phone WHERE best_phone.id_contacts = contacts.id AND contacts.users_id =" .$_SESSION['users_id']. " ORDER BY last_name $order_lastname , first_name $order_firstname  LIMIT $start_from," .  NUM_RECORDS_PER_PAGE;

$DB = new QueriesToDB;
$result = $DB->selectDB($sql);	

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
		
		unset($view_id);
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
			if (isset($cheked)){				
				if  (in_array($row['id'], $cheked)){
					$checked = 'checked';
				
				}				
			}
			$view_id[] = $row['id'];
			
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