<?php if(!defined("DIR")){ exit(); }
class language extends connection{
	public $out = array();

	function __construct($langs, $c){
		//connection
		$conn = $this->conn($c);
		// type all languages condition here
		if($langs!='en'){ 
			$langs = $c['main.language']; 
		}

		$select_destroy = $conn->query('SELECT `value` FROM `studio404_settings` WHERE `var`="languageCachedClear" ');
		$sd_row = $select_destroy->fetch();
		if($sd_row["value"]=="1"){//destroy session
			session_destroy();
		}	
		
		if(!isset($_SESSION["variables"])){
			$query = $conn->query("SELECT `variable`,`text` FROM `studio404_language` WHERE `langs`='".$langs."' AND `status`!=1 ");
			while($r = $query->fetch()){
				$this->out[$r["variable"]] = $r["text"];				
			}
			$_SESSION["variables"]= $this->out;
			return $_SESSION["variables"];
		}else{
			return 1;
		}
		
	}

	function __destruct(){
		
	}

}