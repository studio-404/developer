<?php if(!defined("DIR")){ exit(); }
class model_admin_select_admintypes extends connection{
	function __construct(){

	}

	public function select($c){
		$conn = $this->conn($c); 
		$sql = 'SELECT `name` FROM `studio404_user_right` WHERE `status`!=:status ORDER BY `name` ASC';
		$prepare = $conn->prepare($sql); 
		$prepare->execute(array(
			":status"=>1
		)); 
		$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC); 
		return $fetch;
	}

	function __destruct(){

	}
}
?>