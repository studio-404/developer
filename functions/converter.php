<?php if(!defined("DIR")){ exit(); }
class converter{
	
	public $english = array('a','b','g','d','e','v','z','T','i','k','l','m','n','o','p','J','r','s','t','u','f','q','R','y','S','C','c','Z','w','W','x','j','h');
	public $georgin = array('ა','ბ','გ','დ','ე','ვ','ზ','თ','ი','კ','ლ','მ','ნ','ო','პ','ჟ','რ','ს','ტ','უ','ფ','ქ','ღ','ყ','შ','ჩ','ც','ძ','წ','ჭ','ხ','ჯ','ჰ');


	function __construct(){

	}

	public function englishToGeorgian($input){
		$output = str_replace($this->english, $this->georgin, $input);
		return $output;
	}

	public function removeTags($input){
		$output = strip_tags($input);
		return $output;
	}

	public function compress($input){
	    $output = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $input);
	    $output = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $output);
		return $output;
	}

	function __destruct(){

	}
}
?>