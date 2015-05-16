<?php if(!defined("DIR")){ exit(); }
class get_page_type extends connection{
	public function type($c,$idx){
		$conn = $this->conn($c);
		$sql = 'SELECT `page_type` FROM `studio404_pages` WHERE `idx`=:idx AND `status`!=:status';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":idx"=>$idx, 
			":status"=>1
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		$out = $fetch['page_type'];
		return $out;
	}
}
?>