<?php if(!defined("DIR")){ exit(); }
class homepage extends connection{
	function __construct($c){
		$this->template($c);
	}

	public function template($c){
		$conn = $this->conn($c); // connection

		$cache = new cache();
		$data["pagegeneralinfo"] = $cache->index($c,"pagegeneralinfo");
		$data["components"] = $cache->index($c,"components");
		$data["languages"] = $cache->index($c,"languages");
		$data["language_data"] = $cache->index($c,"language_data");
		$data["main_menu"] = $cache->index($c,"main_menu");
		$data["multimedia"] = $cache->index($c,"multimedia");
		$data["news"] = $cache->index($c,"news");
		$data["events"] = $cache->index($c,"events");
		

		@include($c["website.directory"]."/homepage.php"); 
	}
}
?>