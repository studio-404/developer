<?php if(!defined("DIR")){ exit(); }
class model_admin_languageData extends connection{
	public $outMessage = 2;
	function __construct(){

	}

	public function select($c){
		$out = array();		
		if(isset($_GET["search"]) && !empty($_GET["search"])){
			$where = ' AND `variable` LIKE :search '; 
			$search = '%'.$_GET["search"].'%';
			$exe_array = array(
			":search"=>$search, 
			":lang"=>LANG_ID,
			":status"=>1
			);
		}else{
			$where = ''; 
			$exe_array = array(
			":lang"=>LANG_ID,
			":status"=>1
			);
		}
		$sql = 'SELECT `id`,`idx`, `variable`,`text` FROM `studio404_language` WHERE `langs`=:lang AND `languagenames`!=:status AND `status`!=:status'.$where.' ORDER BY `id` DESC';
		
		$path = '?action=languageData&pn=';
		$itemsPerPage = 10;
		$pager = new pager();
		$pager = $pager->action($c,$sql,$exe_array,$path,$itemsPerPage);	
		$out['table'] = $this->table($c,$pager[0],$exe_array);
		$out['pager'] = $pager[1];
		return $out;
	}

	public function add($c){
		if(isset($_POST["add_language_data"],$_POST["variable"],$_POST["text"])){
			$conn = $this->conn($c); 
			$variable = $_POST["variable"]; 
			$text = $_POST["text"]; 
			
			$variable_strip = new variable_strip();
			$variable = $variable_strip->rstr($variable);

			$model_admin_selectLanguage = new model_admin_selectLanguage();
			$lang_query = $model_admin_selectLanguage->select_languages($c);

			$sqlm = 'SELECT MAX(`idx`)+1 AS maxidx FROM `studio404_language`';
			$preparem = $conn->prepare($sqlm);
			$preparem->execute();
			$fetchm = $preparem->fetch(PDO::FETCH_ASSOC);
			$maxidx = ($fetchm["maxidx"]) ? $fetchm["maxidx"] : 1;

			foreach($lang_query as $lang_row){
				$sql = 'INSERT INTO `studio404_language` SET `idx`=:maxidx, `variable`=:variable, `text`=:textx, `languagenames`=:zero, `lang_img`=:false, `insert_admin`=:insert_admin, `langs`=:langs, `status`=:zero';
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
					":maxidx"=>$maxidx, 
					":variable"=>$variable, 
					":textx"=>$text, 
					":zero"=>0, 
					":false"=>"false", 
					":insert_admin"=>$_SESSION["user404_id"], 
					":langs"=>$lang_row["id"] 
				));
			}
			$this->outMessage = 1;
			unset($_SESSION["variables"]);
			return $this->outMessage;
		}
	}

	public function edit($c){
		$conn = $this->conn($c); 
		$text = $_POST["text"]; 
		$sql = 'UPDATE `studio404_language` SET `text`=:textx WHERE `idx`=:id AND `langs`=:lang AND `status`!=:status';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":textx"=>$text, 
			":id"=>$_GET["id"], 
			":lang"=>LANG_ID, 
			":status"=>1
		));
		$this->outMessage = 1;
		return $this->outMessage;
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
				$out .= '<span class="cell">'.$rows['idx'].'</span>';
				$out .= '<span class="cell"><a href="?action=editLanguageData&id='.$rows['idx'].'&token='.$_SESSION['token'].'">'.$rows['variable'].'</a></span>';			
				$out .= '<span class="cell">'.$rows['text'].'</span>';			
				$out .= '<span class="cell" style="width:120px;"><a href="?action=editLanguageData&id='.$rows['idx'].'&token='.$_SESSION['token'].'" title="Edit language data"><i class="fa fa-pencil-square-o"></i></a>'; 
				$out .= '<a href="javascript:;" onclick="deleteComfirm(\'?action=languageData&langdataid='.$rows['idx'].'&remove=true&token='.$_SESSION['token'].'\')" title="Remove language data"><i class="fa fa-times"></i></a>';
				$out .= '</span>';
				$out .= '</div>';
			}
		}catch(Exception $e){
			
		}
		return $out;
	}

	public function select_one($c){
		$conn = $this->conn($c); 
		$sql = 'SELECT `variable`,`text` FROM `studio404_language` WHERE `languagenames`=:zero AND `status`!=:status AND `idx`=:id AND `langs`=:lang';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":zero"=>0, 
			":status"=>1, 
			":id"=>$_GET['id'], 
			":lang"=>LANG_ID
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		return $fetch;
	}

	public function l($variable){
		if(!isset($_SESSION["language_variable"]["l".LANG_ID])){
			$conn = $this->conn($_SESSION["C"]);
			$sql = 'SELECT `variable`,`text` FROM `studio404_language` WHERE `status`!=:status AND `langs`=:lang';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":status"=>1, 
				":lang"=>LANG_ID
			));
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
			
			foreach($fetch as $f){
				$_SESSION["language_variable"]["l".LANG_ID][$f["variable"]] = $f["text"];
			}
		}
		return $_SESSION["language_variable"]["l".LANG_ID][$variable];
	}

	public function removeMe($c){
		$conn = $this->conn($c); 
		$idx = $_GET["langdataid"]; 
		$sql = 'UPDATE `studio404_language` SET `status`=:one WHERE `idx`=:idx';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":one"=>1, 
			":idx"=>$idx
		));
		$this->outMessage = 1;
		return $this->outMessage;
	}

	function __destruct(){

	}
}
?>