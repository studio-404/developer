<?php if(!defined("DIR")){ exit(); }
class product extends connection{
	function __construct($c){
		$this->template($c);
	}

	public function template($c){
		$conn = $this->conn($c); // connection

		$data["website_title"] = "product page title"; 
		$data["website_text"] = "product page text";

		@include($c["website.directory"]."/product.php"); 
	}
}
?>