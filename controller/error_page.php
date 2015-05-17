<?php
class error_page{
	function __construct(){
		$include = WEB_DIR.'/error_page.php';
		if(file_exists($include)){
			@include($include);
		}else{
			$controller = new error_page(); 
		}
	}

	function __destruct(){
		
	}
}