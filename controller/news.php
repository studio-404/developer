<?php if(!defined("DIR")){ exit(); }
class news extends connection{
	function __construct($c){
		$this->template($c);
	}

	public function template($c){
		$conn = $this->conn($c); // connection

		$data["website_title"] = "news page title"; 
		$data["website_text"] = "news page text";

		@include($c["website.directory"]."/news.php"); 
	}
}
?>