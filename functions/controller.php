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
		//$file = $obj->url("segment",2); 
		$file = $obj->url_last(); 

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
		}else if($file=="session_timeout"){
			$controller_sessiontime = 'controller/session_timeout.php';
			if(file_exists($controller_sessiontime)){
				$controller = new session_timeout();
			}
		}else{
			if($file!="admin"){// load pages
				//select page types
				$get_page_type = new get_page_type();
				$page_type = $get_page_type->type_page($c);
				
				// text pages
				$controller_text = "controller/text.php"; 
				// home page
				$controller_home = "controller/homepage.php";
				// photo gallery page
				$controller_photo_gallery = "controller/photogallery.php"; 
				// video gallery page
				$contoller_video_gallery = "controller/videogallery.php"; 
				// catalog page
				$controller_catalog = "controller/catalog.php";
				// custom page
				$cust = str_replace("-", "", $file);
				$controller_custom = "controller/custom/".$cust.".php";
				//event page
				$controller_event = "controller/events.php"; 
				//eventsinside page 
				$controller_eventsinside = "controller/eventsinside.php"; 
				//news page
				$controller_news = "controller/news.php"; 
				//newsinside page
				$controller_newsinside = "controller/newsinside.php"; 
				//publication page
				$controller_publication = "controller/publication.php";
				// team page
				$controller_team = "controller/team.php";
				// administrator pages
				$controller = "controller/".$file.".php";
				// session timeout
				$controller_sessiontime = "controller/session_timeout.php";
				//product page
				$controller_product = "controller/product.php";
				//gallery folder page 
				$controller_galleryfolder = "controller/galleryfolder.php";
				// error page 
				$controller_errorpage = "controller/error_page.php";
				
				if(empty($page_type) || $page_type=="error_page"){
					if(file_exists($controller_errorpage)){
						$controller = new error_page(); 
					}
				}else{
					switch ($page_type) {
						case 'homepage':
						if(file_exists($controller_home)){
							$controller = new homepage($c);
						}	
						break;
						case 'session_timeout':
						if(file_exists($controller_sessiontime)){
							$controller = new session_timeout();
						}	
						break;
						case 'textpage':
						if(file_exists($controller_text)){
							$controller = new text($c);
						}	
						break;
						case 'photogallerypage':
						if(file_exists($controller_photo_gallery)){
							$controller = new photogallery($c);
						}	
						break;
						case 'videogallerypage':
						if(file_exists($contoller_video_gallery)){
							$controller = new videogallery($c);
						}	
						break;
						case 'catalogpage':
						if(file_exists($controller_catalog)){
							$controller = new catalog($c);
						}	
						break;
						case 'custompage':
						if(file_exists($controller_custom)){
							$controller = new $cust($c); 
						}	
						break;
						case 'eventpage':
						if(file_exists($controller_event)){
							$controller = new events($c);
						}	
						break;
						case 'eventsinside':
						if(file_exists($controller_eventsinside)){
							$controller = new eventsinside($c);
						}	
						break;
						case 'newspage':
						if(file_exists($controller_news)){
							$controller = new news($c);
						}	
						break;
						case 'newsinside':
						if(file_exists($controller_newsinside)){
							$controller = new newsinside($c);
						}	
						break;
						case 'publicationpage':
						if(file_exists($controller_publication)){
							$controller = new publication($c);
						}	
						break;
						case 'teampage':
						if(file_exists($controller_team)){
							$controller = new team($c);
						}	
						break;
						case 'product':
						if(file_exists($controller_product)){
							$controller = new product($c);
						}	
						break;
						case 'galleryfolder':
						if(file_exists($controller_galleryfolder)){
							$controller = new galleryfolder($c);
						}	
						break;
						case 'error_page':
						if(file_exists($controller_errorpage)){
							$controller = new error_page();
						}	
						break;
						default:
						if(file_exists($controller)){
							$controller = new $file($obj,$c); 
						}
						break;
					}
				}
			}else{
				$controller = new error_page(); 
			}
		}
				
	}

	function __destruct(){
		
	}
}