<?php if(!defined("DIR")){ exit(); }
class events extends connection{
	function __construct($c){
		$this->template($c);
	}

	public function template($c){
		$conn = $this->conn($c); // connection
		
		$data["website_title"] = "events page title"; 
		$data["website_text"] = "events page text";

		include($c["website.directory"]."/events.php"); 
	}
}
?>