<?php if(!defined("DIR")){ exit(); }
class publication extends connection{
	function __construct($c){
		$this->template($c);
	}

	public function template($c){
		$conn = $this->conn($c); // connection

		$data["website_title"] = "publication page title"; 
		$data["website_text"] = "publication page text";

		@include($c["website.directory"]."/publication.php"); 
	}
}
?>