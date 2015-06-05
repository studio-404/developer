<?php if(!defined("DIR")){ exit(); }
class generate_cache_file_name {
	public function filename(){
		$actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		// fist explode ? 
		$explode = explode("?",$actual_link);
		$before_question = $explode[0]; 
		$after_question = $explode[1];

		$removeSymbols = $this->removeSymbols($before_question);
		$removeSymbols2 = $this->removeSymbols($after_question);
		echo "Filename: ".$removeSymbols.$removeSymbols2.".php";
	}

	public function removeSymbols($str){
		$search = array("http://","www",".",",","~","`","!","@","#","$","%","^","&","*","(",")","-","=","{","}","'",'"',"|","<",">");
		$replace = "_";
		$out = str_replace($search, $replace, $str);
		return $out;
	}
}
?>