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
		$get_ip = new get_ip();
		$ip = $get_ip->ip;

		
		if($c['website.mode']=="UnderDeveloper" && !in_array($ip, $c['allowes.ips'])){
			// if under developer
			$controller = "controller/under.php";
			if(file_exists($controller)){
				$controller = new under($c); 
			}else{
				$controller = new error_page(); 
			}
		}else if($file==$c['admin.slug']){
			// administrator page
			$controller = "controller/admin.php";
			if(file_exists($controller)){
				$controller = new admin($obj,$c); 
			}else{
				$controller = new error_page(); 
			}
		}else{
			if($file!="admin"){// load custom pages
				$controller = "controller/".$file.".php";
				$cust = str_replace("-", "", $file);
				$controller_custom = "controller/custom/".$cust.".php";

				if(file_exists($controller)){
					$controller = new $file($obj,$c); 
				}else if(file_exists($controller_custom)){
					$controller = new $cust($c); 
				}else{
					$controller = new error_page(); 
				}
			}else{
					$controller = new error_page(); 
			}
		}
		

				
	}

	function __destruct(){
		
	}
}