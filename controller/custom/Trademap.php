<?php if(!defined("DIR")){ exit(); }
			class Trademap{
				function __construct($c){
					$this->template($c,"Trademap");
				}
				
				public function template($c,$page){
					$include = WEB_DIR."/Trademap.php";
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