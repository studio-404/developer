<?php if(!defined("DIR")){ exit(); } 
class model_admin_newslettermain extends connection{
	public $outMessage = 2;
	function __construct(){

	}

	public function select_main($c){
		$conn = $this->conn($c);
		$sql = 'SELECT * FROM `studio404_newsletter` WHERE `id`=:id';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":id"=>1
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC); 
		return $fetch;
	}

	public function edit_main($c){
		$conn = $this->conn($c);
		$sql = 'UPDATE `studio404_newsletter` SET `host`=:hostx, `user`=:userx, `pass`=:passx, `from`=:fromx, `fromname`=:fromname WHERE `id`=:id';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			':hostx'=>$_POST['host'], 
			':userx'=>$_POST['user'], 
			':passx'=>$_POST['pass'], 
			':fromx'=>$_POST['from'], 
			':fromname'=>$_POST['fromname'], 
			':id'=>1
		));
		$this->outMessage = 1;
	}

	function __destruct(){

	}
}
?>