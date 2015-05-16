<?php if(!defined("DIR")){ exit(); }
class slug_generation{
	public $english = array('a','b','g','d','e','v','z','T','i','k','l','m','n','o','p','J','r','s','t','u','f','q','R','y','S','C','c','Z','w','W','x','j','h');
	public $georgin = array('ა','ბ','გ','დ','ე','ვ','ზ','თ','ი','კ','ლ','მ','ნ','ო','პ','ჟ','რ','ს','ტ','უ','ფ','ქ','ღ','ყ','შ','ჩ','ც','ძ','წ','ჭ','ხ','ჯ','ჰ');

	public function generate($str){
		$out = str_replace(" ", "-", $str); 
		$out = str_replace($this->georgin, $this->english, $out);

		$out = strlen($out) > 500 ? substr($out,0,500)."..." : $out;
//		$out = str_replace(array('`','~','!','@','#','$','%','^','&','*','(',')','_','{','}','/','?','>','<',';','"',"'",':',']','[','|',',','.'), '-', $out);
		return $out;
	}
}
?>