<?php if(!defined("DIR")){ exit(); }
class get_background extends connection{
	public function backgr($idx,$c){
		$conn = $this->conn($c); 
		try{
			$sql = 'SELECT `background` FROM `studio404_pages` WHERE `idx`=:idx AND `status`!=:status'; 
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":idx"=>$idx,
				":status"=>1 
			)); 
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
			return $fetch['background'];
		}catch(Exception $e){
			return "";
		}
	}
}
?>