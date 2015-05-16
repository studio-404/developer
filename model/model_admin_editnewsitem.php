<?php if(!defined("DIR")){ exit(); }
class model_admin_editnewsitem extends connection{
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
				":smi_idx"=>$_GET['newsidx']
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
				":smi_idx"=>$_GET['newsidx']
			));
			$this->outMessage = 1;
		}
	}

	public function removeMe($c){
		$conn = $this->conn($c);
		$sql = 'UPDATE `studio404_module_item` SET `status`=:status WHERE `idx`=:idx AND `status`!=:status';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":idx"=>$_GET['nidx'], 
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