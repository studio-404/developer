<?php if(!defined("DIR")){ exit(); }
class check_super extends connection{
	function __construct(){

	}
	public function super($c){
		$idx = $_GET['super'];
		$conn = $this->conn($c);
		$sql = 'SELECT `id` FROM `studio404_pages` WHERE `idx`=:idx AND `menu_type`=:menu_type AND `lang`=:lang AND `status`!=:status';
		$query = $conn->prepare($sql);
		$query->execute(array(
			":idx"=>$idx, 
			":menu_type"=>"super", 
			":lang"=>LANG_ID,
			":status"=>1
		));
		$count = $query->rowCount();
		if(!$count){ return false; }
		return true;
	}
	function __destruct(){
		
	}
}
?>