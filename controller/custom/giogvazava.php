<?php if(!defined("DIR")){ exit(); }
			class giogvazava{
				function __construct($c){
					$this->template($c,"giogvazava");
				}
				
				public function template($c,$page){
					$include = WEB_DIR."/giogvazava.php";
					if(file_exists($include)){
					/* 
					** Here goes any code developer wants to 
					*/
					@include($include);
					}else{
						$controller = new error_page(); 
					}
				}
			}
			?>