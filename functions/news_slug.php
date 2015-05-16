<?php if(!defined("DIR")){ exit(); }
class news_slug extends connection{
	function __construct(){

	}

	public function slug($c){
		$conn = $this->conn($c);
		$idx = (isset($_GET['newsidx'])) ? $_GET['newsidx'] : $_GET['catalogidx']; 
		$idx = (isset($_GET["mediaidx"])) ? $_GET["mediaidx"] : $idx;
		$sql = 'SELECT `slug` FROM `studio404_pages` WHERE `idx`=:idx AND `lang`=:lang AND `status`!=:status';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":idx"=>$idx,
			":lang"=>LANG_ID, 
			":status"=>1
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		return $fetch['slug'];
	}

	function __destruct(){

	}
}
?>