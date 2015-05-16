<?php if(!defined("DIR")){ exit(); }
class get_lang_id extends connection{
	function __construct(){
		
	}

	public function id($c,$lang){
		$conn = $this->conn($c);
		$sql = 'SELECT `id` FROM `studio404_language` WHERE `languagenames`=:languagenames AND `langs`=:langs AND `status`=:status';
		$query = $conn->prepare($sql);
		$query->execute(array(
			":languagenames"=>1,
			":langs"=>$lang,
			":status"=>1
		));
		$u_row = $query->fetch(PDO::FETCH_ASSOC);
		$id = $u_row['id'];
		return $id;
	}
}
?>