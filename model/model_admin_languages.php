<?php if(!defined("DIR")){ exit(); }
class model_admin_languages extends connection{
	public $outMessage = 2;
	function __construct(){

	}

	public function select($c){
		$out = array();		
		
		$sql = 'SELECT `id`,`text`,`langs` FROM `studio404_language` WHERE `languagenames`=:status AND `status`=:status ORDER BY `text` ASC';
		$exe_array = array(
			":status"=>1
		);
		$path = '?action=languages&pn=';
		$itemsPerPage = 10;
		$pager = new pager();
		$pager = $pager->action($c,$sql,$exe_array,$path,$itemsPerPage);	
		$out['table'] = $this->table($c,$pager[0],$exe_array);
		$out['pager'] = $pager[1];
		return $out;
	}

	public function select_one($c){
		$conn = $this->conn($c); 
		$sql = 'SELECT `text`,`lang_img`,`langs` FROM `studio404_language` WHERE `languagenames`=:status AND `status`=:status AND `id`=:id';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":status"=>1, 
			":id"=>$_GET['id']
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		return $fetch;
	}

	public function table($c,$sql,$exe_array){
		$out = '';
		$conn = $this->conn($c);
		$query = $conn->prepare($sql);
		
		try{ 
			$query->execute($exe_array);
			$token = md5(sha1(time()));
			$_SESSION['token'] = $token;
			$_SESSION['token'] = md5(sha1(time()));

			while($rows = $query->fetch()){
				$out .= '<div class="row">';				
				$out .= '<span class="cell">'.$rows['id'].'</span>';
				$out .= '<span class="cell"><a href="?action=editLanguage&id='.$rows['id'].'&token='.$_SESSION['token'].'">'.$rows['text'].'</a></span>';			
				$out .= '<span class="cell">'.$rows['langs'].'</span>';			
				$out .= '<span class="cell" style="width:120px;"><a href="?action=editLanguage&id='.$rows['id'].'&token='.$_SESSION['token'].'" title="Edit language"><i class="fa fa-pencil-square-o"></i></a>'; 
				if($rows['langs']!=$c['main.language']){
					$out .= '<a href="javascript:;" onclick="deleteComfirm(\'?action=languages&langid='.$rows['id'].'&remove=true&token='.$_SESSION['token'].'\')" title="Remove language"><i class="fa fa-times"></i></a>';
				}
				$out .= '</span>';

				$out .= '</div>';
			}
		}catch(Exception $e){
			
		}
		return $out;
	}


	public function add($c){
		if(isset($_POST["name"],$_POST["slug"],$_POST["background"])){
			$conn = $this->conn($c); 
			$name = $_POST["name"]; 
			$slug = $_POST["slug"]; 

			$background = 'false';
			if(isset($_POST['background'])){
				$expl = explode("/",$_POST['background']);				
				$from = DIR.$expl[1]."/".end($expl);
				$To = DIR.'files/background/'.end($expl);
				if(file_exists($from)){	
					if(@copy($from,$To)){
						@unlink($from);
						$background = explode("/home/geoweb/developer.404.ge",$To);
						$background = $background[1];
					}
				}				
			}

			$sql = 'INSERT INTO `studio404_language` SET `variable`=:false, `text`=:name, `languagenames`=:one, `insert_admin`=:insert_admin,w `lang_img`=:lang_img, `langs`=:slug, `status`=:one';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":false"=>"false", 
				":name"=>$name, 
				":one"=>1, 
				":insert_admin"=>$_SESSION["user404_id"], 
				":lang_img"=>$background, 
				":slug"=>$slug
			));
			$insert_id = $conn->lastInsertId();
			$this->insertLanguageInEveryTable($c,$insert_id,"studio404_pages");
			$this->insertLanguageInEveryTable($c,$insert_id,"studio404_module_item");
			$this->insertLanguageInEveryTable($c,$insert_id,"studio404_module_attachment");
			$this->insertLanguageInEveryTable($c,$insert_id,"studio404_module");
			$this->insertLanguageInEveryTable($c,$insert_id,"studio404_gallery_file");
			$this->insertLanguageInEveryTable($c,$insert_id,"studio404_gallery_attachment");
			$this->insertLanguageInEveryTable($c,$insert_id,"studio404_gallery");
			$this->insertLanguageInEveryTable($c,$insert_id,"studio404_components_inside");
			$this->insertLanguageInEveryTable($c,$insert_id,"studio404_catalog_info");

			$this->outMessage = 1;
			return $this->outMessage;
		}
	}


	public function edit($c){
		if(isset($_POST["name"],$_GET["id"],$_POST["background"])){
			$conn = $this->conn($c); 
			$name = $_POST["name"]; 
			$id = $_GET["id"]; 

			if(isset($_POST['background']) && !empty($_POST['background'])){
				$expl = explode("/",$_POST['background']);				
				$from = DIR.$expl[1]."/".end($expl);
				$To = DIR.'files/background/'.end($expl);
				if(file_exists($from)){	
					if(@copy($from,$To)){
						@unlink($from);
						$background = explode(DIR,$To);
						$background = $background[1];
					}
				}
				$sqlb = 'UPDATE `studio404_language` SET `lang_img`=:image WHERE `id`=:id';
				$prepareb = $conn->prepare($sqlb);
				$prepareb->execute(array(
					":image"=>$background, 
					":id"=>$id
				));					
			}

			$sql = 'UPDATE `studio404_language` SET `text`=:name WHERE `id`=:id';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":name"=>$name, 
				":id"=>$id
			));

			$this->outMessage = 1;
		}
	}


	private function insertLanguageInEveryTable($c,$insert_id,$table){
		$conn = $this->conn($c); 
		// select columns in current table / $table
		$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA=:dbusername AND TABLE_NAME=:tablename";
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":dbusername"=>$c['database.username'], 
			":tablename"=>$table
		));
		$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);	

		// select current table / $table
		$idx = "idx";
		$sql2 = 'SELECT * FROM `'.$table.'` WHERE `status`!=:status GROUP BY `'.$idx.'`';
		$prepare2 = $conn->prepare($sql2); 
		$prepare2->execute(array(
			":status"=>1
		));
		$fetch2 = $prepare2->fetchAll(PDO::FETCH_ASSOC);
		$set = '';
		$insert_array = array();

		// foreach current table
		foreach ($fetch2 as $v) {
			$general_idx = $v[$idx]; 
			// foreach current table's columns
			foreach ($fetch as $cols) { // cake some variables
				if($cols["COLUMN_NAME"]=="lang" || $cols["COLUMN_NAME"] == "id"){ continue; }
				$set .= '`'.$cols["COLUMN_NAME"].'`=:'.$cols["COLUMN_NAME"].', ';
				$insert_array[":".$cols["COLUMN_NAME"]] = $v[$cols["COLUMN_NAME"]]; 
			}
			$insert_array[":lang"] = $insert_id; 
			$set .= '`lang`=:lang ';
			// generated sql code
			$sql_insert = 'INSERT INTO `'.$table.'` SET '.$set;
			$prepare_insert = $conn->prepare($sql_insert); 
			$prepare_insert->execute($insert_array);

			//clear caked variables
			$set = "";
			$sql_insert = "";
			$insert_array = array();
		}		
		
	}

	public function removeMe($c){
		$conn = $this->conn($c); 
		$langid= $_GET['langid'];
		$sql = 'DELETE FROM `studio404_language` WHERE `id`=:id';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":id"=>$langid
		));

		
		$this->removeOtherTables($c,$langid,"studio404_pages");
		$this->removeOtherTables($c,$langid,"studio404_module_item");
		$this->removeOtherTables($c,$langid,"studio404_module_attachment");
		$this->removeOtherTables($c,$langid,"studio404_module");
		$this->removeOtherTables($c,$langid,"studio404_gallery_file");
		$this->removeOtherTables($c,$langid,"studio404_gallery_attachment");
		$this->removeOtherTables($c,$langid,"studio404_gallery");
		$this->removeOtherTables($c,$langid,"studio404_components_inside");
		$this->removeOtherTables($c,$langid,"studio404_catalog_info");

		$this->outMessage = 1;
	}

	private function removeOtherTables($c,$lang_id,$table){
		$conn = $this->conn($c);
		$sql = 'DELETE FROM `'.$table.'` WHERE `lang`=:lang_id';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":lang_id"=>$lang_id
		));
	}

	function __destruct(){

	}
}
?>