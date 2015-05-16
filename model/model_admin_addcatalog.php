<?php if(!defined("DIR")){ exit(); }
class model_admin_addcatalog extends connection{
	public $outMessage;
	function __construct(){

	}

	public function add($c){
		$conn = $this->conn($c);
		if(isset($_POST['date'],$_POST['expiredate'],$_POST['title'],$_POST['slug'],$_POST['friendlyurl'],$_POST['short_description'],$_POST['long_description'],$_POST['tags'])){
			if(
				$this->noEmpty($_POST['date']) &&  
				$this->noEmpty($_POST['expiredate']) &&  
				$this->noEmpty($_POST['title']) &&  
				$this->noEmpty($_POST['friendlyurl']) 
			){
				//select max idx
				$sqlm = 'SELECT MAX(`idx`)+1 AS maxid FROM `studio404_module_item`';
				$querym = $conn->query($sqlm);
				$rowm = $querym->fetch(PDO::FETCH_ASSOC);
				$maxidm = ($rowm['maxid']) ? $rowm['maxid'] : 1;

				//select max catalog position
				try{
					$sqlp = 'SELECT 
					`studio404_module_item`.`idx` AS smi_idx,  
					`studio404_module_item`.`position` AS smi_position  
					FROM 
					`studio404_module_attachment`,`studio404_module`,`studio404_module_item`
					WHERE
					`studio404_module_attachment`.`connect_idx`=:connect_idx AND 
					`studio404_module_attachment`.`lang`=:lang AND 
					`studio404_module_attachment`.`status`!=:status AND 
					`studio404_module_attachment`.`idx`=`studio404_module`.`idx` AND 
					`studio404_module`.`lang`=:lang AND 
					`studio404_module`.`status`!=:status AND 
					`studio404_module`.`idx`=`studio404_module_item`.`module_idx` AND 
					`studio404_module_item`.`lang`=:lang AND 
					`studio404_module_item`.`status`!=:status 
					ORDER BY 
					`studio404_module_item`.`position` ASC
					';
					$preparep = $conn->prepare($sqlp);
					$preparep->execute(array(
						":connect_idx"=>$_GET['catalogidx'], 
						":lang"=>LANG_ID, 
						":status"=>1, 
					));
					
					while($fetchp = $preparep->fetch()){
						$position = $fetchp['smi_position'] + 1; 
						$idx = $fetchp['smi_idx']; 

						$sqlu = 'UPDATE 
						`studio404_module_item`
						SET 
						`position`=:position
						WHERE 
						`idx`=:idx AND 
						`status`!=:status';
						$prepareu = $conn->prepare($sqlu);
						$prepareu->execute(array(
							":position"=>$position, 
							":idx"=>$idx, 
							":status"=>1
						));
					}
				}catch(PDOException $e){
					echo $e;
					exit();
				}
				$smi_maxposition = ($fetchp['smi_maxposition']) ? $fetchp['smi_maxposition'] : 1;
				
				// get page type
				$get_page_type = new get_page_type();
				$page_type = $get_page_type->type($_SESSION["C"],$_GET['catalogidx']);
				$datex = strtotime($_POST['date']);
				$expiredate = strtotime($_POST['expiredate']);
				try{
					// select connect id 
					$sqlc = 'SELECT 
					`studio404_module`.`idx` AS sm_idx
					FROM 
					`studio404_module_attachment`, `studio404_module` 
					WHERE 
					`studio404_module_attachment`.`connect_idx`=:connect_idx AND 
					`studio404_module_attachment`.`page_type`=:page_type AND 
					`studio404_module_attachment`.`lang`=:lang AND 
					`studio404_module_attachment`.`status`!=:status AND 
					`studio404_module_attachment`.`idx`=`studio404_module`.`idx` AND 
					`studio404_module`.`lang`=:lang AND 
					`studio404_module`.`status`!=:status 
					';
					$preparec = $conn->prepare($sqlc);
					$preparec->execute(array(
						":connect_idx"=>$_GET['catalogidx'], 
						":page_type"=>$page_type, 
						":lang"=>LANG_ID, 
						":status"=>1, 
					));
					$fetchc = $preparec->fetch(PDO::FETCH_ASSOC);
				}catch(Exeption $e){
				}
				
				$slug_generation = new slug_generation();
				$uid = new uid();
				$u = $uid->generate();
				$slug = PRE_VIEW."/".$u."/".$slug_generation->generate($_POST['friendlyurl']);
				
				// select languages
				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$lang_query = $model_admin_selectLanguage->select_languages($c);
				
				foreach($lang_query as $lang_row){
					$sql = 'INSERT INTO `studio404_module_item` SET 
					`idx`=:idx, 
					`uid`=:uid, 
					`date`=:datex, 
					`expiredate`=:expiredate, 
					`module_idx`=:module_idx, 
					`title`=:title, 
					`videourl`=:videourl, 
					`short_description`=:short_description, 
					`long_description`=:long_description, 
					`tags`=:tags, 
					`slug`=:slug, 
					`insert_admin`=:insert_admin, 
					`position`=:position, 
					`lang`=:lang, 
					`visibility`=:visibility, 
					`status`=:status';
					$prepare = $conn->prepare($sql);
					$prepare->execute(array(
						":idx"=>$maxidm, 
						":uid"=>$u, 
						":datex"=>$datex, 
						":expiredate"=>$expiredate, 
						":module_idx"=>$fetchc['sm_idx'], 
						":title"=>$_POST['title'], 
						":videourl"=>$_POST['videourl'], 
						":short_description"=>$_POST['short_description'], 
						":long_description"=>$_POST['long_description'], 
						":tags"=>$_POST['tags'], 
						":slug"=>$slug, 
						":insert_admin"=>$_SESSION["user404_id"], 
						":position"=>$smi_maxposition, 
						":lang"=>$lang_row['id'], 
						":visibility"=>1, 
						":status"=>0 
					));
					//insert media
					$this->insertmedia($c,$maxidm,$lang_row['id']);
				}
				$this->outMessage = 1;
			}else{
				$this->outMessage = 2;
			}			
		}
		return $this->outMessage;
	}

	public function insertmedia($c,$connect_idx,$lang){
		$conn = $this->conn($c); 

		//select gallery max idx
		$sqlg = 'SELECT MAX(`idx`) AS maxid FROM `studio404_gallery` WHERE `lang`=:lang';
		$prepareg = $conn->prepare($sqlg);
		$prepareg->execute(array(
			":lang"=>$lang
		));
		$fetchg = $prepareg->fetch(PDO::FETCH_ASSOC);
		$maxid = ($fetchg['maxid']) ? ($fetchg['maxid'] + 1) : 1; 
		// page type
		$get_page_type = new get_page_type();
		$page_type = $get_page_type->type($_SESSION["C"],$_GET['catalogidx']);
		// insert gallery
		$sql_media = 'INSERT INTO `studio404_gallery` SET 
		`idx`=:idx, 
		`date`=:datex,
		`title`=:title, 
		`lang`=:lang, 
		`status`=:status 
		';
		$prepare_media = $conn->prepare($sql_media);
		$prepare_media->execute(array(
			":idx"=>$maxid, 
			":datex"=>time(),
			":title"=>$_POST['title'], 
			":lang"=>$lang, 
			":status"=>0
		));
		// insert gallery attachment
		$sql_media2 = 'INSERT INTO `studio404_gallery_attachment` SET 
		`idx`=:idx, 
		`connect_idx`=:connect_idx, 
		`pagetype`=:pagetype, 
		`lang`=:lang, 
		`status`=:status
		'; 
		$prepare_media2 = $conn->prepare($sql_media2); 
		$prepare_media2->execute(array(
			":idx"=>$maxid, 
			":connect_idx"=>$connect_idx,
			":pagetype"=>$page_type, 
			":lang"=>$lang, 
			":status"=>0
		));
	}

	public function noEmpty($str){
		if(empty($str)){
			return false;
		}
		return true;
	}

	function __destruct(){

	}
}
?>