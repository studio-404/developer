<?php
	require("class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->IsSMTP();                                    // set mailer to use SMTP
	$mail->Host = "mail.server"; 		 				// specify main and backup server
	$mail->SMTPAuth = true; 							// turn on SMTP authentication
	$mail->Username = "un";				 				// SMTP username
	$mail->Password = "pass";		 					// SMTP password
	$mail->From = "from@address";
	$mail->FromName = "from_name";

// Add Mail Address
	$mail->AddAddress($where_to_send);
// etc.

	$mail->WordWrap = 80;
	$mail->IsHTML(true);
	$mail->Subject = $_POST["subject"];
	$mail->Body    = $_POST["message"];
	$mail->AltBody = $_POST["message"];
	$mail->Send();
?>