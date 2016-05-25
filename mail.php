<?php
//$address[]="naaa@ukr.net"; 
//$address[]="naaa.nazar@gmail.com";
//$address[]="naaa11@ukr.net";

//$subject="2222222222";
//$body="11111111222222223333333333";

//send_mail($address, $subject, $body);

function send_mail($address, $subject, $body){

require_once('phpmailer\class.phpmailer.php');
include_once 'phpmailer\class.smtp.php';

$mail             = new PHPMailer();

$mail->IsSMTP(); 
$mail->Host       = "smtp.ukr.net"; 
//$mail->SMTPDebug  = 2; 
$mail->SMTPAuth   = true;                
$mail->SMTPSecure = "ssl";
$mail->Port       = 465; 
$mail->CharSet    = 'UTF-8';

$mail->Username   = "contact_mananger@ukr.net";
$mail->Password   = "Con_Man9596St";      

//$body             = "sdfsdfsdfsdf";
$mail->SetFrom('contact_mananger@ukr.net', 'Contact Mananger');
$mail->Subject    = $subject;
$mail->MsgHTML($body);
//$address = "naaa@ukr.net";

foreach ($address as $value) {
	$mail->AddAddress($value);
}
//$mail->AddAddress($address);



if(!$mail->Send()) {
	$mail_log;
//echo "Mailer Error: " . $mail->ErrorInfo;
$mail_log='Error message not sent!';
return	$mail_log;
} else {
//echo "Message sent!";

$mail_log='Message sent!';
return	$mail_log;
}
}
    
?>