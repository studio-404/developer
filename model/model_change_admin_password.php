<?php if(!defined("DIR")){ exit(); }
/*
** make all neccessery modules
*/
class model_change_admin_password extends connection{

	function __construct(){		
	}

	public function change($c){
		$oldpass = $_POST["oldpass"];
		$newpass = $_POST["newpass"];
		$newpass2 = $_POST["newpass2"];
		if($this->check_old_pass($oldpass,$c) && $this->emptyornot($oldpass) && $this->emptyornot($newpass) && $this->check($newpass,$newpass2)){
			$conn = $this->conn($c);
			$change_sql = 'UPDATE `studio404_users` SET `password`=:password WHERE `username`=:username AND `status`!=:status';
			$query = $conn->prepare($change_sql);
			$query->execute(array(
				":username" => $_SESSION["user404"], 
				":password" => md5($newpass), 
				":status" => 1
			));
			return 1;
		}else{
			return 2;
		}
	}

	public function check_old_pass($oldpass,$c){
		$conn = $this->conn($c);
		$sql = 'SELECT `id` FROM `studio404_users` WHERE `username`=:username AND `password`=:password AND `status`!=:status';
		$query = $conn->prepare($sql);
		$query->execute(array(
				":username" => $_SESSION["user404"], 
				":password" => md5($oldpass), 
				":status" => 1
		));
		$u_row = $query->fetch(PDO::FETCH_ASSOC);
		if($u_row['id']){
			return true;
		}
		return false;
	}

	public function emptyornot($checkme){
		if(!empty($checkme)){
			return true;
		}
		return false;
	}

	public function check($password1,$password2){
		
		if($password1==$password2){
			return true;
		}
		return false;

	}

	function __destruct(){
		
	}

}
