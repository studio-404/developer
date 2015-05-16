<?php if(!defined("DIR")){ exit(); }
class model_admin_editmediaitem extends connection{
	public $outMessage = 2;
	function __construct(){
		
	}

	public function edit($c){
		$conn = $this->conn($c);
		if(
			isset($_POST['date'],$_POST['expiredate'],$_POST['title'],$_POST['tags'],$_POST['visibility'],$_POST['description']) && 
			$this->noEmpty($_POST['date']) && 
			$this->noEmpty($_POST['expiredate']) && 
			$this->noEmpty($_POST['title']) && 
			$this->noEmpty($_POST['visibility']) 
		){
			$visibility = ($_POST['visibility']=="true") ? 2 : 1;
			echo $visibility;
			// update main columns
			$sql = 'UPDATE `studio404_media_item` SET 
			`title`=:smi_title, 
			`description`=:smi_description, 
			`tags`=:smi_tags 
			WHERE 
			`idx`=:smi_idx AND 
			`lang`=:lang AND 
			`status`!=:status 
			';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":smi_title"=>$_POST['title'], 
				":smi_description"=>$_POST['description'], 
				":smi_tags"=>$_POST['tags'], 
				":lang"=>LANG_ID,
				":status"=>1,
				":smi_idx"=>$_GET['midx']
			));

			//update every language columne
			$date = strtotime($_POST['date']);
			$expiredate = strtotime($_POST['expiredate']);
			
			$sql2 = 'UPDATE `studio404_media_item` SET 
			`date`=:datex, 
			`expiredate`=:expiredate, 
			`visibility`=:visibility
			WHERE 
			`idx`=:smi_idx AND 
			`status`!=:status ';
			$prepare2 = $conn->prepare($sql2);
			$prepare2->execute(array(
				":datex"=>$date, 
				":expiredate"=>$expiredate, 
				":status"=>1,
				":smi_idx"=>$_GET['midx'], 
				":visibility"=>$visibility
			));

			$this->outMessage = 1;
		}
	}

	public function removeMe($c){
		$conn = $this->conn($c);
		$sql = 'UPDATE `studio404_media_item` SET `status`=:status WHERE `idx`=:idx AND `status`!=:status';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":idx"=>$_GET['rmidx'], 
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