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

	public function type_page($c){
		$conn = $this->conn($c);
		//get slug
		$url_controll = new url_controll();
		$slug = $url_controll->slugs();

		try{
			$sql = 'SELECT `page_type` FROM `studio404_pages` WHERE `slug`=:slug AND `status`!=:status';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":slug"=>$slug, 
				":status"=>1
			));
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
			$out = $fetch['page_type'];
		}catch(Exception $e){ $out = ""; }
		
		if(empty($out)){
			$explode = explode("/", $slug);
			if(is_array($explode)){
				switch($explode[0]){
					case $c["product.view.pre.slug"]:
					$out = "product";
					break;
					case $c["gallery.view.pre.slug"]:
					$out = "galleryfolder";
					break;
					case "events": 
					$out = "eventsinside";
					break;
					case "news": 
					$out = "newsinside";
					break;
					default:
					$out = "error_page";
					break;
				}
			}else{
				$out = "error_page";
			}
		}

		return $out;
	}
}
?>