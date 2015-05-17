<?php if(!defined("DIR")){ exit(); }
class url_controll{
	function __construct(){
		
	}

	public function slugs(){ 
		$actual_link = "$_SERVER[REQUEST_URI]";
		$s = @explode("?",$actual_link);
		$x = @explode("/",$s[0]); 
		$count = 0;
		$o = '';
		if(is_array($x)){
			foreach($x as $cc){
				if($count!=0 && $count!=1){ 
					$o .= $cc."/";
				}			
				$count++;
			}
			$o = @rtrim($o, "/");
		}
		return $o;
	}

	public function url($type, $segment = 0){
		$actual_link = "$_SERVER[REQUEST_URI]";
		if($type=="segment"){
			try{
				$s = @explode("?",$actual_link);
				$s = @explode("/", $s[0]);
				if(is_array($s)){
					return $s[$segment];
				}
				
			}catch(Exeption $e){
				echo 'Message: ' .$e->getMessage();
			}			
		}else if($type=="get"){
			try{
				$s = array();
				foreach($_GET as $k => $v){
					$s[$k] = $v;
				}			
				return $s;
			}catch(Exeption $e){
				echo 'Message: ' .$e->getMessage();
			}
		}else if($type=="post"){
			try{
				$s = array();
				foreach($_POST as $k => $v){
					$s[$k] = $v;
				}			
				return $s;
			}catch(Exeption $e){
				echo 'Message: ' .$e->getMessage();
			}
		}

	}

	function __destruct(){
		
	}
}
?>