<?php if(!defined("DIR")){ exit(); }
class controller
{//constractor
	function __construct($c){
		if(isset($_SESSION["expired_sessioned_time"]) && !empty($_SESSION["expired_sessioned_time"])){
			$time = time();
			$new_expire = $time + $c['session.expire.time'];
			if($_SESSION["expired_sessioned_time"]<$time){
		 		unset($_SESSION["expired_sessioned_time"]);
		 		session_destroy();
		 		$redirect = new redirect();
		 		$redirect->go();
			}else{
				$_SESSION["expired_sessioned_time"] = $new_expire;
			}			
		}
	}

	public function loadpage($obj,$c)
	{// load constructor
		$file = $obj->url("segment",2); 
		// select page types
		$type_obj = new page_type();
		$page_type = $type_obj->get_page_type($c);
		echo $page_type;

		// if go to admin
		if($file==$c['admin.slug']){
			$controller = "controller/admin.php";
			if(file_exists($controller)){
				$controller = new admin($obj,$c); 
			}else{
				$controller = new error_page(); 
			}
		}else if(1==2){
			// check file types
		}else{
			$controller = "controller/".$file.".php";
			if(file_exists($controller)){
				$controller = new $file($obj,$c); 
			}else{
				$controller = new error_page(); 
			}			
		}
		

				
	}

	function __destruct(){
		
	}
}