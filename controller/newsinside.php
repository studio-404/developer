<?php if(!defined("DIR")){ exit(); }
class newsinside extends connection{
	function __construct($c){
		$this->template($c);
	}

	public function template($c){
		$conn = $this->conn($c); // connection

		$data["website_title"] = "newsinside page title"; 
		$data["website_text"] = "newsinside page text";

		@include($c["website.directory"]."/newsinside.php"); 
	}
}
?>