<?php if(!defined("DIR")){ exit(); }
class catalog extends connection{
	function __construct($c){
		$this->template($c);
	}

	public function template($c){
		$conn = $this->conn($c); // connection

		$data["website_title"] = "catalog page title"; 
		$data["website_text"] = "catalog page text";

		@include($c["website.directory"]."/catalog.php"); 
	}
}
?>