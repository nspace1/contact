<?php

require_once 'app/auth/Auth.php';
$auth = new Auth;
$auth->session_security();

require_once 'php_script\validation.php';
require_once 'app/event/Event.php';
$event = new Event;

if (isset($_POST['send'])){
    $event = new Event;
    $event->send($_POST['to']);
}

//insert not exist email
if(isset($_POST['add_ev_msg'])) {
    $event->insertNotExistEmail($_POST);
}
 //header
require 'pages\header.php';
?>
    <main>
        <div class="container">
            <div id='content_view_ev'>
            <?php
                if ($event->msg_add_mail !== "") {
                    echo
                    "<div class='msg'>
                        <small>This address is not in your contact mananger</small><br><br>
                        <form action='event.php' method='post' id='msg_form'>";							
                            $i = 1;
                            foreach ($event->msg_add_mail as $value ) {
                                echo "<input type='checkbox' name=". $i ."  value=". $value .">" . $value . "<br>";
                                ++$i;
                            }
                            ?>
                            <input type='hidden' name='add_ev_msg' value='add_ev_msg'><br>
                            <input  type="submit" name="add_email"  id="add_email" value='Add to contact mananger' class='button_to_link'><br> 
                            <a href="event.php" >Go to My Albums/Events</a>
                        </form>
                    </div>
                <?php	
                }
                ?>
                <span style='text-align: right'><h3>EVENT</h3></span>
                <form name="event_form" action="event.php" method="post">
                    <table>
                        <tr>
                            <td>
                                <a href="add_contact_from_list.php">To:</a>
                            </td>
                            <td>
                                <input  type="email" multiple name="to" cols="100" value="<?= isset($_GET['to']) ? $_GET['to'] : '' ?>" style="width:100%">
                            </td> 
                        </tr>
                        <tr>
                            <td>
                                Subject:
                            </td>
                            <td>
                                <input type="text" name="subject" maxlength="59"  value="" style="width:100%">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Event:
                            </td>
                            <td>
                                <textarea name="event" rows="8" cols="70"style="resize: none;" ></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="hidden" name="date_event" value="<?php  echo date("Y-m-d H:i:s");?>">
                                <input type="submit" name="send" value="Send">
                            </td><td></td>
                        </tr>		
                    </table>
            </form>			
        </div>			
    </div>	
</main>
</body>
</html>



