<?php if(!defined("DIR")){ exit(); }
class session_timeout{
	function __construct(){
		global $c;
        $this->c =& $c;		
		echo $c['session.expire.time'];
	}
	
	function __destruct(){

	}
}
?>