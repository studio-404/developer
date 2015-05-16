<?php if(!defined("DIR")){ exit(); }
class pre_slug extends connection{
	function __construct(){

	}

	public function slug($c,$super_idx=true,$sub_id){
		if(is_array($c) && isset($super_idx) && isset($sub_id)){
			if($sub_id){
				$conn = $this->conn($c);
				$sql = 'SELECT `idx`,`subid`,`cid`,`slug` FROM `studio404_pages` WHERE `menu_type`!=:menu_type AND `idx`=:idx AND `lang`=:lang AND `status`!=:status';
				$query = $conn->prepare($sql);
				$query->execute(array(
					":menu_type"=>"super", 
					":idx"=>$sub_id, 
					":lang"=>LANG_ID, 
					":status"=>1
				));

				$rows = $query->fetch(PDO::FETCH_ASSOC);
				if(!empty($rows['slug']) && !empty($rows['idx']) ){
					$slug[] = $rows['slug'];
					// if($this->slug($c,$super_idx,$rows['subid'])){
					// 	$in_slug = $this->slug($c,$super_idx,$rows['subid']);
					// 	foreach($in_slug as $in){
					// 		$slug[] = $in;
					// 	}
					// }
				}
			}
		}
		return $slug;
	}

	function __destruct(){
		
	}
}
?>