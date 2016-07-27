
<?php	

error_reporting(E_ALL); ini_set('display_errors', 1);

require_once 'app/auth/Auth.php';
$auth = new Auth;
$auth->session_security();

require_once 'php_script\validation.php';	
		
//Delete contact
$form_ask_delete ='';
    
if (isset($_POST['delete'])) {
        require_once 'php_script\delete_contacts.php';
        $form_ask_delete=delete_contacts($conn);		
}

require 'php_script\view_contacts_list.php';



//header
require 'pages\header.php';
?>
    <main class="main">       
        <div class='content_view'>
            <div class="msg" style="<?php echo ($form_ask_delete !== '') ? 'visibility: visible':'visibility: hidden'; ?>">					
                <p>Are you want to delete this contact?
                <p> <?php echo $_POST['email'] ?>
                <form action="index.php" method="post" >
                    <input type='hidden' name="ask" value="ok">
                    <input type='hidden' name="id" value="<?php echo $_POST['id']; ?>">
                    <input style = 'float:left;' type='submit' name="delete" value="Delete">
                    <input style = 'float:right;' type='submit' name="cancel" value= 'CANCEL' >								
                </form>
            </div>
            <span style='text-align: right'><h3>MANAGEMENT MAIN PAGE</h3></span>
            <table>
                <form action='edit_view.php'>
                <input type='submit' value= 'ADD'>		
                </form>
                <form  method='get' action='index.php'>
                    <thead>
                        <tr>
                            <th>
                                <input  type="submit" name="last"   value='Last' class='button_to_link'> <?= (isset($order_firstname)) ? ($order_lastname == 'DESC') ? '&#9650' : '&#9660': '' ?>
                                <input type='hidden' name='order_lastname' value ="<?= $order_lastname ?>">
                            </th>
                            <th>
                                <input  type="submit" name="first"   value='First' class='button_to_link'> <?= (isset($order_firstname)) ? ($order_firstname == 'DESC') ? '&#9650' : '&#9660' : '' ?>			
                                <input type='hidden' name='order_firstname' value ="<?= $order_firstname ?>">
                            </th>
                            <th>Email</th>
                            <th>Best Phone</th>
                        </tr>
                    </thead>
                    <input type='hidden' name='page_active' value ="<?= $page_active ?>">
                </form>
                <tbody>
                    <?php	
                        if (!empty($result)){
                            //php_script\view_contacts_list.php
                            view_contacts_list_index_php($result, $res);	
                        }
                    ?>					
                </tbody>
            </table> 
            <form action='edit_view.php'>			
            <input type='submit' value= 'ADD'>				
            </form>				
            <?= $pagination?>
            </div>
        </div>	
    </main>	
</body>
</html>


