<?php if(!defined("DIR")){ exit(); }
class model_admin_editprofile extends connection{
	
	public $outMessage;

	function __construct(){

	}

	public function select_profile($c){
		$conn = $this->conn($c);
		$out = array();
		$token_get = $_GET["token"];
		$token_session = $_SESSION["token"];
		$edit_id = $_GET["id"];
		if($token_get==$token_session){
			$sql = 'SELECT * FROM `studio404_users` WHERE `id`=:id AND `status`!=:status';
			$exe_array = array("id"=>$edit_id, ":status"=>1);
			$query = $conn->prepare($sql);
			$query->execute($exe_array);
			$fetch = $query->fetch(PDO::FETCH_ASSOC);
			return $fetch;
		}		
		return $out;
	}

	public function removeMe($c){
		$conn = $this->conn($c);
		$token_get = $_GET["token"];
		$token_session = $_SESSION["token"];
		if(isset($_GET["remove"]) && isset($_GET['id']) && is_numeric($_GET['id']) && $token_get==$token_session){
			$sql = 'UPDATE `studio404_users` SET `status`=:status WHERE `id`=:id';
			$query = $conn->prepare($sql);
			$query->execute(array(
				":status"=>1,
				":id"=>$_GET['id']
			));
			$this->outMessage = 1;
		}else{
			$this->outMessage = 2;
		}
	}

	public function edit($c){
		$conn = $this->conn($c);
		$namelname = strip_tags($_POST['namelname']);
		$ucode = strip_tags($_POST['ucode']);
		$email = strip_tags($_POST['email']);
		$phone = strip_tags($_POST['phone']);
		$mobile = strip_tags($_POST['mobile']);
		$user_type = strip_tags($_POST['usertype']);
		$token = $_GET['token'];
		$token_get = $_GET["token"];
		$token_session = $_SESSION["token"];
		
		if( $this->noEmpty($namelname) && $this->noEmpty($user_type) && $this->noEmpty($ucode) && isset($_GET['id']) && $this->noEmpty($_GET['id']) && is_numeric($_GET['id']) && $token_get==$token_session){
			$sql = 'UPDATE `studio404_users` SET `namelname`=:namelname, `ucode`=:ucode, `email`=:email, `phone`=:phone, `mobile`=:mobile, `user_type`=:user_type WHERE `id`=:id AND `status`!=:status';
			$query = $conn->prepare($sql);
			$query->execute(array(
			":namelname"=>$namelname,
			":ucode"=>$ucode,
			":email"=>$email,
			":phone"=>$phone,
			":mobile"=>$mobile, 
			":user_type"=>$user_type, 
			":id"=>$_GET['id'], 
			":status"=>1 
			));
			$this->outMessage = 1;	
		}else{
			$this->outMessage = 2;
		}
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