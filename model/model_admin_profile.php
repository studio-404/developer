<?php if(!defined("DIR")){ exit(); }
class model_admin_profile extends connection{
	public $outMessage;
	function __construct(){
		
	}

	public function selectAdminProfile($c){
		$conn = $this->conn($c);
		$sql = 'SELECT `namelname`,`email`, `phone`, `mobile` FROM `studio404_users` WHERE `username`=:username AND `status`!=:status';
		$query = $conn->prepare($sql);
		if (!$query) {
			print_r($dbh->errorInfo());
		}
		$query->execute(array(
			":username"=>$_SESSION["user404"], 
			":status"=>1
		));
		$u_row = $query->fetch(PDO::FETCH_ASSOC);
		return $u_row;
	}

	public function updateMe($c){
		if(isset($_POST['admin_change_profile'])){

			$conn = $this->conn($c);
			$email = strip_tags($_POST['email']);
			$phone = strip_tags($_POST['phone']);
			$mobile = strip_tags($_POST['mobile']);
			$namelname = strip_tags($_POST['namelname']);
			
			$sql = 'UPDATE `studio404_users` SET `namelname`=:namelname, `email`=:email, `phone`=:phone, `mobile`=:mobile WHERE `username`=:username AND `status`!=:status';
			$query = $conn->prepare($sql);
			$query->execute(array(
				":username"=>$_SESSION["user404"], 
				":status"=>1, 
				":namelname"=>$namelname,
				":email"=>$email,
				":phone"=>$phone,
				":mobile"=>$mobile
			));
			$this->outMessage = 1;

		}
	}

	function __destruct(){
		
	}



}
?>