<?php if(!defined("DIR")){ exit(); }
class text extends connection{
	function __construct($c){
		$this->template($c);
	}

	public function template($c){
		$conn = $this->conn($c); // connection

		$data["website_title"] = "Text page title"; 
		$data["website_text"] = "Text page text";

		@include($c["website.directory"]."/text.php"); 
	}
}
?>