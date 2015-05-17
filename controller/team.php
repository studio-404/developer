<?php if(!defined("DIR")){ exit(); }
class team extends connection{
	function __construct($c){
		$this->template($c);
	}

	public function template($c){
		$conn = $this->conn($c); // connection

		$data["website_title"] = "team page title"; 
		$data["website_text"] = "team page text";

		@include($c["website.directory"]."/team.php"); 
	}
}
?>