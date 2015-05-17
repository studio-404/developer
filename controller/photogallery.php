<?php if(!defined("DIR")){ exit(); }
class photogallery extends connection{
	function __construct($c){
		$this->template($c);
	}

	public function template($c){
		$conn = $this->conn($c); // connection

		$data["website_title"] = "Photo gallery page title"; 
		$data["website_text"] = "Photo gallery page text";

		@include($c["website.directory"]."/photogallery.php"); 
	}
}
?>