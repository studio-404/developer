<?php if(!defined("DIR")){ exit(); }
class send_email{
	public $outMessage = 2; 
	function __construct(){

	}

	public function send($host,$user,$pass,$from,$fromname,$where_to_send,$subject,$message){
		$message = html_entity_decode($message);
		require_once("_plugins/mailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->IsSMTP(); // set mailer to use SMTP
		$mail->Host = $host; // specify main and backup server / mail.batumibooking.net
		$mail->SMTPAuth = true; // turn on SMTP authentication
		$mail->Username = $user; // SMTP username / info@batumibooking.net
		$mail->Password = $pass; // SMTP password / batumi2011booking
		$mail->From = $from; // info@batumibooking.net
		$mail->FromName = $fromname; //BatumiBooking
		// Add Mail Address
		if(is_array($where_to_send)){
			foreach($where_to_send as $e){
				$mail->AddAddress($e);
			}
		}else{
			$mail->AddAddress($where_to_send);

		}
		// etc.
		$mail->WordWrap = 80;
		$mail->IsHTML(true);
		$mail->Subject = "=?UTF-8?B?" . base64_encode(html_entity_decode($subject, ENT_COMPAT, 'UTF-8')) . "?=";
		$mail->Body = $message;
		$mail->AltBody = '';
		$mail->Send();
		$this->outMessage = 1;
		unset($mail);
	}

	function __destruct(){

	}
}
?>