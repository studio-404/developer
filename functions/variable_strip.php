<?php if(!defined("DIR")){ exit(); }
class variable_strip{
	public function rstr($str){
		$str = strip_tags($str);
		$find = array('`','~','!','@','#','$','%','^','&','*','(',')','_','{','}','/','?','>','<',';','"',"'",':',']','[','|',',','.',' ');
		$replace = array(''); 
		$out = str_replace($find, $replace, $str);
		return $out;
	}
}
?>