<?php if(!defined("DIR")){ exit(); }
class cache extends connection{

	public function index($c,$type){
		$cache_file = "_cache/".$type.LANG_ID.".json"; 
		if(file_exists($cache_file)){
			$output = file_get_contents($cache_file); 
		}else{
			$this->recreate_cache($c,$type,$cache_file);
			$output = file_get_contents($cache_file);
		}
		return $output;
	}

	public function recreate_cache($c,$type,$cache_file){
		$conn = $this->conn($c);
		switch($type){
			case "pagegeneralinfo": 
			$get_slug_from_url = new get_slug_from_url();
			$slug = $get_slug_from_url->slug();
			$sql = 'SELECT * FROM `studio404_pages` WHERE `slug`=:slug AND `lang`=:lang AND `visibility`!=:visibility AND `status`!=:status';	
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":slug"=>$slug, 
				":status"=>1, 
				":visibility"=>1, 
				":lang"=>LANG_ID 
			)); 
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC); 
			break;
			case "components":
			$sql = 'SELECT 
			`studio404_components`.`name` AS com_name,  
			`studio404_components_inside`.* 
			FROM 
			`studio404_components`,`studio404_components_inside`
			WHERE 
			`studio404_components`.`status`!=:status AND 
			`studio404_components`.`id`=`studio404_components_inside`.`cid` AND  
			`studio404_components_inside`.`lang`=:lang AND  
			`studio404_components_inside`.`status`!=:status
			';	
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":status"=>1, 
				":lang"=>LANG_ID 
			)); 
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC); 
			break;
			case "languages":
			$sql = 'SELECT * FROM `studio404_language` WHERE `status`=:status AND `variable`=:false';	
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":status"=>1, 
				":false"=>'false' 
			)); 
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC); 
			break;
			case "language_data":
			$sql = 'SELECT * FROM `studio404_language` WHERE `status`!=:status AND `variable`!=:false AND `langs`=:lang';	
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":status"=>1, 
				":false"=>'false', 
				":lang"=>LANG_ID 
			)); 
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC); 
			break;
			case "main_menu": 
			$sql = 'SELECT * FROM `studio404_pages` WHERE `status`!=:status AND `menu_type`!=:super AND `lang`=:lang AND `visibility`!=:visibility AND `cid`=:cid';	
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":status"=>1, 
				":super"=>'super', 
				":lang"=>LANG_ID, 
				":visibility"=>1, 
				":cid"=>2 
			)); 
			$f = $prepare->fetchAll(PDO::FETCH_ASSOC); 
			$fetch = $this->sub_menu($c,$f);
			break;
			case "multimedia": 
			$sql = 'SELECT 
			`studio404_gallery_file`.*, `studio404_gallery_file`.`gallery_idx` as x
			FROM 
			`studio404_pages`,`studio404_media_attachment`,`studio404_media`,`studio404_media_item`,`studio404_gallery_attachment`,`studio404_gallery`,`studio404_gallery_file` 
			WHERE 
			`studio404_pages`.`page_type`=:videogallery AND 
			`studio404_pages`.`lang`=:lang AND 
			`studio404_pages`.`visibility`!=:visibility AND 
			`studio404_pages`.`status`!=:status AND 
			`studio404_pages`.`idx`=`studio404_media_attachment`.`connect_idx` AND 
			`studio404_media_attachment`.`lang`=:lang AND 
			`studio404_media_attachment`.`status`!=:status AND 
			`studio404_media_attachment`.`idx`=`studio404_media`.`idx` AND 
			`studio404_media`.`lang`=:lang AND 
			`studio404_media`.`status`!=:status AND 
			`studio404_media`.`idx`=`studio404_media_item`.`media_idx` AND 
			`studio404_media_item`.`lang`=:lang AND 
			`studio404_media_item`.`visibility`!=:visibility AND 
			`studio404_media_item`.`status`!=:status AND 
			`studio404_media_item`.`idx`=`studio404_gallery_attachment`.`connect_idx` AND 
			`studio404_gallery_attachment`.`pagetype`=:videogallery AND 
			`studio404_gallery_attachment`.`lang`=:lang AND 
			`studio404_gallery_attachment`.`status`!=:status AND 
			`studio404_gallery_attachment`.`idx`=`studio404_gallery`.`idx` AND 
			`studio404_gallery`.`lang`=:lang AND 
			`studio404_gallery`.`status`!=:status AND 
			`studio404_gallery`.`idx`=`studio404_gallery_file`.`gallery_idx` AND 
			`studio404_gallery_file`.`lang`=:lang AND 
			`studio404_gallery_file`.`status`!=:status 
			ORDER BY `studio404_gallery_file`.`position` DESC LIMIT 2
			';	
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":videogallery"=>'videogallerypage', 
				":lang"=>LANG_ID, 
				":visibility"=>1, 
				":status"=>1
			)); 
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC); 
			break;
			case "news":
			$sql = 'SELECT 
			`studio404_module_item`.* 
			FROM 
			`studio404_pages`,`studio404_module_attachment`, `studio404_module`, `studio404_module_item` 
			WHERE 
			`studio404_pages`.`page_type`=:pagetype AND 
			`studio404_pages`.`lang`=:lang AND 
			`studio404_pages`.`status`!=:status AND 
			`studio404_pages`.`idx`=`studio404_module_attachment`.`connect_idx` AND 
			`studio404_module_attachment`.`page_type`=:pagetype AND 
			`studio404_module_attachment`.`lang`=:lang AND 
			`studio404_module_attachment`.`status`!=:status AND 
			`studio404_module_attachment`.`idx`=`studio404_module`.`idx` AND 
			`studio404_module`.`lang`=:lang AND 
			`studio404_module`.`status`!=:status AND 
			`studio404_module`.`idx`=`studio404_module_item`.`module_idx` AND 
			`studio404_module_item`.`lang`=:lang AND 
			`studio404_module_item`.`visibility`!=:visibility AND 
			`studio404_module_item`.`status`!=:status 
			ORDER BY `studio404_module_item`.`date` DESC LIMIT 15 
			';	
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":pagetype"=>'newspage', 
				":lang"=>LANG_ID, 
				":status"=>1, 
				":visibility"=>1, 
			)); 
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC); 
			break;
			case "events":
			$sql = 'SELECT 
			`studio404_module_item`.* 
			FROM 
			`studio404_pages`,`studio404_module_attachment`, `studio404_module`, `studio404_module_item` 
			WHERE 
			`studio404_pages`.`page_type`=:pagetype AND 
			`studio404_pages`.`lang`=:lang AND 
			`studio404_pages`.`status`!=:status AND 
			`studio404_pages`.`idx`=`studio404_module_attachment`.`connect_idx` AND 
			`studio404_module_attachment`.`page_type`=:pagetype AND 
			`studio404_module_attachment`.`lang`=:lang AND 
			`studio404_module_attachment`.`status`!=:status AND 
			`studio404_module_attachment`.`idx`=`studio404_module`.`idx` AND 
			`studio404_module`.`lang`=:lang AND 
			`studio404_module`.`status`!=:status AND 
			`studio404_module`.`idx`=`studio404_module_item`.`module_idx` AND 
			`studio404_module_item`.`lang`=:lang AND 
			`studio404_module_item`.`visibility`!=:visibility AND 
			`studio404_module_item`.`status`!=:status 
			ORDER BY `studio404_module_item`.`date` DESC LIMIT 15 
			';	
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":pagetype"=>'eventpage', 
				":lang"=>LANG_ID, 
				":status"=>1, 
				":visibility"=>1, 
			)); 
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC); 
			break;
		}
		$fh = fopen($cache_file, 'w') or die("Error opening output file");
		fwrite($fh, json_encode($fetch,JSON_UNESCAPED_UNICODE));
		fclose($fh);
	}

	public function sub_menu($c,$fetch){ 
		$conn = $this->conn($c);
		$o = array(); 
		foreach($fetch as $f){ 
			$o["date"][] = $f["date"]; 
			$o["expiredate"][] = $f["expiredate"]; 
			$o["title"][] = $f["title"]; 
			$o["redirectlink"][] = $f["redirectlink"]; 
			$o["slug"][] = $f["slug"]; 

			$sql = 'SELECT * FROM `studio404_pages` WHERE `status`!=:status AND `menu_type`!=:super AND `lang`=:lang AND `visibility`!=:visibility AND `cid`=:cid';	
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array( 
				":status"=>1, 
				":super"=>'super', 
				":lang"=>LANG_ID, 
				":visibility"=>1, 
				":cid"=>$f['cid'] 
			)); 
			$fetch2 = $prepare->fetchAll(PDO::FETCH_ASSOC); 
			if(!$prepare->rowCount()){ 
				break; 
			}else{ 
				$o["sub"][] = $this->sub_menu2($c,$f["idx"]);
			}
		}
		return $o;
	}

	public function sub_menu2($c,$idx){
		$conn = $this->conn($c);
		$o = array();
		$sql = 'SELECT * FROM `studio404_pages` WHERE `status`!=:status AND `menu_type`!=:super AND `lang`=:lang AND `visibility`!=:visibility AND `cid`=:cid';	
		$prepare = $conn->prepare($sql); 
		$prepare->execute(array( 
			":status"=>1, 
			":super"=>'super', 
			":lang"=>LANG_ID, 
			":visibility"=>1, 
			":cid"=>$idx  
		)); 
		$fetch2 = $prepare->fetchAll(PDO::FETCH_ASSOC); 
		if($prepare->rowCount()){
			foreach($fetch2 as $f2){
				$o["date"][] = $f2["date"]; 
				$o["expiredate"][] = $f2["expiredate"]; 
				$o["title"][] = $f2["title"]; 
				$o["redirectlink"][] = $f2["redirectlink"]; 
				$o["slug"][] = $f2["slug"]; 
				$o["sub"][] = $this->sub_menu2($c,$f2['idx']); 	
			}
		}
		return $o;	
	}

}
?>