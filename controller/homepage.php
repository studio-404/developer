<?php if(!defined("DIR")){ exit(); }
class homepage extends connection{
	function __construct($c){
		$this->template($c);
	}

	public function template($c){
		$conn = $this->conn($c); // connection

		$data["website_title"] = "Home page title"; 
		$data["website_text"] = "Home page text";

		@include($c["website.directory"]."/homepage.php"); 
	}
}
?>