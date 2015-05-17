<?php if(!defined("DIR")){ exit(); }
class under{

	function __construct($c){
		$this->template($c,"under");
	}

	public function template($c,$page){
		$include = WEB_DIR.'/website_under_constructor.php';
		if(file_exists($include)){
			$data["dm"] = $c['developer.message'];
			@include($include);
		}else{
			$controller = new error_page(); 
		}
	}
}
?>