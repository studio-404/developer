<?php if(!defined("DIR")){ exit(); }
			class Exportcatalog{
				function __construct($c){
					$this->template($c,"Exportcatalog");
				}
				
				public function template($c,$page){
					$include = WEB_DIR."/Exportcatalog.php";
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