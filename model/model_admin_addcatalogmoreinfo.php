<?php if(!defined("DIR")){ exit(); }
class model_admin_addcatalogmoreinfo extends connection{
	public $outMessage = 2;

	function __construct(){

	}

	public function add($c){
		$conn = $this->conn($c);

		//select max idx
		$sqlm = 'SELECT MAX(`idx`)+1 AS maxid FROM `studio404_catalog_info`';
		$querym = $conn->query($sqlm);
		$rowm = $querym->fetch(PDO::FETCH_ASSOC);
		$maxidm = ($rowm['maxid']) ? $rowm['maxid'] : 1;

		// select languages
		$model_admin_selectLanguage = new model_admin_selectLanguage();
		$lang_query = $model_admin_selectLanguage->select_languages($c);
		
		foreach($lang_query as $lang_row){
			$sql = 'INSERT INTO `studio404_catalog_info` SET `idx`=:idx, `name`=:name, `module_item_id`=:module_item_id, `type`=:type, `insert_admin`=:insert_admin, `lang`=:lang';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":idx"=>$maxidm, 
				":name"=>$_POST['name'], 
				":module_item_id"=>$_POST['module_item_id'], 
				":type"=>"catalogpage", 
				":insert_admin"=>$_SESSION['user404_id'], 
				":lang"=>$lang_row['id']
			));
		}
		$this->outMessage = 1;

		return $this->outMessage;
	}

	public function removeMe($c){
		$conn = $this->conn($c);
		if(isset($_GET['cridxremove']) && is_numeric($_GET['cridxremove']) && $_GET['token']==$_SESSION['token']){
			$sql = 'UPDATE `studio404_catalog_info` SET `status`=:status WHERE `idx`=:idx';
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":idx"=>$_GET['cridxremove'], 
				":status"=>1
			));
			$this->outMessage = 1;
		}		
	}

	function __destruct(){

	}
}
?>