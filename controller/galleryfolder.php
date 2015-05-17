<?php if(!defined("DIR")){ exit(); }
class galleryfolder extends connection{
	function __construct($c){
		$this->template($c);
	}

	public function template($c){
		$conn = $this->conn($c); // connection

		$data["website_title"] = "galleryfolder page title"; 
		$data["website_text"] = "galleryfolder page text";

		@include($c["website.directory"]."/galleryfolder.php"); 
	}
}
?>