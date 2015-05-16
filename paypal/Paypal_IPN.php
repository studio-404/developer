<?php
class Paypal_IPN{
	/*
	* @var string $_url the paypal url 
	*/
	public $_url;
	/*
	* @param string $mode 'live' or 'sandbox'
	*/
	public function __construct($mode = 'live')
	{
		if($mode=="live"){
			$this->_url = 'https://www.paypal.com/cgi-bin/webscr';
		}else{
			$this->_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		}
		// setup an option maybe
	}

	public function run()
	{
		$postFields = 'cmd=_notify-validate';
		foreach($_POST as $key => $values){
			$postFields .= "&".$key."=".urlencode($value);
		}

		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $this->_url, 
			CURLOPT_RETURNTRANSFER => true, 
			CURLOPT_SSL_VERIFYPEER => false, 
			CURLOPT_POST => true, 
			CURLOPT_POSTFIELDS => $postFields
		));
		$result = curl_exec($ch);
		$error = curl_error($ch);
		curl_close($ch);


		$fh = fopen("result_".time().".txt",'w');
		fwrite($fh, $result. ' -- '.$postFields);
		fclose($fh);

		if($result=="VERIFIED"){
			//insert into database 
		}
	}
}
?>