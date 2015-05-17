<?php if(!defined("DIR")){ exit(); }
class videogallery extends connection{
	function __construct($c){
		$this->template($c);
	}

	public function template($c){
		$conn = $this->conn($c); // connection

		$data["website_title"] = "Video gallery page title"; 
		$data["website_text"] = "Video gallery page text";

		@include($c["website.directory"]."/videogallery.php"); 
	}
}
?>