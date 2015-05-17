<?php if(!defined("DIR")){ exit(); }
			class registeruser{ 
				function __construct($c){
					$this->template($c,"registeruser");
				} 

				public function template($c,$page){ 
					$include = WEB_DIR."/registeruser.php";
					if(file_exists($include)){ 
						/* 
						** Here goes any code developer wants to \n
						*/ 
						@include($include); 
					}else{
						$controller = new error_page(); 
					} 
				} 
			}
			?>