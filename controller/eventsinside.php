<?php if(!defined("DIR")){ exit(); }
class eventsinside extends connection{
	function __construct($c){
		$this->template($c);
	}

	public function template($c){
		$conn = $this->conn($c); // connection

		$data["website_title"] = "eventsinside page title"; 
		$data["website_text"] = "eventsinside page text";

		@include($c["website.directory"]."/eventsinside.php"); 
	}
}
?>