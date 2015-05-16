<?php if(!defined("DIR")){ exit(); }
class model_admin_editcatalogsitem extends connection{
	public $outMessage = 2;
	function __construct(){
		
	}

	public function edit($c){
		$conn = $this->conn($c);
		if(
			isset($_POST['date'],$_POST['expiredate'],$_POST['title'],$_POST['videourl'],$_POST['tags'],$_POST['visibility'],$_POST['short_description'],$_POST['long_description']) && 
			$this->noEmpty($_POST['date']) && 
			$this->noEmpty($_POST['expiredate']) && 
			$this->noEmpty($_POST['title']) && 
			$this->noEmpty($_POST['visibility']) 
		){
			// update main columns
			$sql = 'UPDATE `studio404_module_item` SET 
			`title`=:smi_title, 
			`videourl`=:smi_videourl, 
			`short_description`=:smi_short_description, 
			`long_description`=:smi_long_description, 
			`tags`=:smi_tags 
			WHERE 
			`idx`=:smi_idx AND 
			`lang`=:lang AND 
			`status`!=:status 
			';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":smi_title"=>$_POST['title'], 
				":smi_videourl"=>$_POST['videourl'], 
				":smi_short_description"=>$_POST['short_description'], 
				":smi_long_description"=>$_POST['long_description'], 
				":smi_tags"=>$_POST['tags'], 
				":lang"=>LANG_ID,
				":status"=>1,
				":smi_idx"=>$_GET['cidx']
			));

			//update every language columne
			$date = strtotime($_POST['date']);
			$expiredate = strtotime($_POST['expiredate']);
			
			$sql2 = 'UPDATE `studio404_module_item` SET 
			`date`=:datex, 
			`expiredate`=:expiredate 
			WHERE 
			`idx`=:smi_idx AND 
			`status`!=:status ';
			$prepare2 = $conn->prepare($sql2);
			$prepare2->execute(array(
				":datex"=>$date, 
				":expiredate"=>$expiredate, 
				":status"=>1,
				":smi_idx"=>$_GET['cidx']
			));
			
			//insert new catalog more info
			$count = count($_POST['infoname_id']);
			if($count) : 
				try{
					// delete old catalog more info
					$sql_delete = 'DELETE FROM `studio404_catalog_info_values` WHERE `cidx`=:cidx AND `item_idx`=:item_idx AND `lang`=:lang';
					$prepareDelete = $conn->prepare($sql_delete);
					$prepareDelete->execute(array(
						":cidx"=>$_GET['cidx'], 
						":item_idx"=>$_GET['id'], 
						":lang"=>LANG_ID
					));
				}catch(Exception $e){  }
				
				$x = 0;				
				foreach($_POST['infoname_id'] as $val){
					$sci_idx = $_POST['infoname_id'][$x]; 
					$value = $_POST['infoname'][$x]; 
					$infovalue = $_POST['infovalue'][$x]; 
					
					$sqli = 'INSERT INTO `studio404_catalog_info_values` SET `cidx`=:cidx, `item_idx`=:item_idx, `sci_idx`=:sci_idx, `value`=:value, `insert_admin`=:insert_admin, `lang`=:lang, `position`=:position';
					$preparei = $conn->prepare($sqli);
					$preparei->execute(array(
						":cidx"=>$_GET['cidx'], 
						":item_idx"=>$_GET['id'], 
						":sci_idx"=>$sci_idx, 
						":value"=>$infovalue, 
						":insert_admin"=>$_SESSION["user404_id"], 
						":lang"=>LANG_ID, 
						":position"=>($x+1)
					));	
					$x++;					
				}
			endif;
			


			$this->outMessage = 1;
		}
	}

	public function removeMe($c){
		$conn = $this->conn($c);
		$sql = 'UPDATE `studio404_module_item` SET `status`=:status WHERE `idx`=:idx AND `status`!=:status';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":idx"=>$_GET['rcidx'], 
			":status"=>1
		));
		$this->outMessage = 1;
	}

	private function noEmpty($foo){
		if(!empty($foo)){
			return true;
		}
		return false;
	}

	function __destruct(){

	}
}
?>