<?php if(!defined("DIR")){ exit(); }
class model_admin_adduser extends connection{
	
	function __construct(){

	}

	public function add($c){
		$conn = $this->conn($c);
		if($this->noEmpty($_POST['username']) && $this->noEmpty($_POST['password']) && $this->noEmpty($_POST['namelname']) && $this->noEmpty($_POST['ucode']) && $this->noEmpty($_POST['usertype']))
		{ 
			$sql = 'INSERT INTO `studio404_users` SET `username`=:username, `password`=:password, `namelname`=:namelname, `ucode`=:ucode, `email`=:email, `phone`=:phone, `mobile`=:mobile, `user_type`=:user_type, `log`=:log, `logtime`=:logtime, `status`=:status';
			$insert = $conn->prepare($sql);
			$insert->execute(array(
				":username"=>$_POST['username'],
				":password"=>md5($_POST['password']),
				":namelname"=>$_POST['namelname'],
				":ucode"=>$_POST['ucode'],
				":email"=>$_POST['email'],
				":phone"=>$_POST['phone'],
				":mobile"=>$_POST['mobile'],
				":user_type"=>$_POST['usertype'],
				":logtime"=>time(),
				":log"=>0,
				":status"=>0,
			));
			return 1;
		}else{
			return 2;
		}
	}

	private function noEmpty($foo){
		if(empty($foo)){
			return false;
		}
		return true;
	}

	function __destruct(){

	}
}

?>