<?php if(!defined("DIR")){ exit(); }
class page_type extends connection{
	function __construct(){

	}

	public function get_page_type($c){
		$conn = $this->conn($c);
		$out = '';
		$url_controll = new url_controll();
		$slugs = $url_controll->slugs();
		//select mane pages
		$sql = 'SELECT `page_type` FROM `studio404_pages` WHERE `slug`=:slug AND `lang`=:lang AND `status`!=:status'; 
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":slug"=>$slugs, 
			":lang"=>LANG_ID, 
			":status"=>1
		));
		$nums = $prepare->rowCount();
		if($nums){
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
			$out = $fetch["page_type"];
		}else{
			//select news
			$sql_module = 'SELECT 
			`studio404_module_attachment`.`page_type` AS module_pagetype
			FROM 
			`studio404_module_item`, `studio404_module`, `studio404_module_attachment`, `studio404_pages` 
			WHERE 
			`studio404_module_item`.`slug`=:slug AND 
			`studio404_module_item`.`lang`=:lang AND 
			`studio404_module_item`.`status`!=:status AND 
			`studio404_module_item`.`module_idx`=`studio404_module`.`idx` AND 
			`studio404_module`.`lang`=:lang AND 
			`studio404_module`.`status`!=:status AND 
			`studio404_module`.`idx`=`studio404_module_attachment`.`idx` AND 
			`studio404_module_attachment`.`lang`=:lang AND 
			`studio404_module_attachment`.`status`!=:status AND 
			`studio404_module_attachment`.`connect_idx`=`studio404_pages`.`idx` AND 
			`studio404_pages`.`lang`=:lang AND 
			`studio404_pages`.`status`!=:status
			';
			$prepare_module = $conn->prepare($sql_module);
			$prepare_module->execute(array(
				":slug"=>$slugs, 
				":lang"=>LANG_ID, 
				":status"=>1

			));
			$nums_module = $prepare_module->rowCount();
			if($nums_module){
				$fetch_module = $prepare_module->fetch(PDO::FETCH_ASSOC);
				$out = $fetch_module["page_type"];
			}
		}
		return $out;
	}

	function __destruct(){

	}
}
?>