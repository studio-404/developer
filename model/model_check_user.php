<?php if(!defined("DIR")){ exit(); }

class model_check_user extends connection{
	public $out;
	public function user($c)
	{
		if(isset($_POST['username'],$_POST['password'],$_POST["captcha"]) && !empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["captcha"]) && ($_POST["captcha"]==$_SESSION['encoded']))
		{
			$user = strip_tags($_POST['username']);
			$pass = md5($_POST['password']);
			$conn = $this->conn($c); // PDO connection
			
			$sql = "SELECT `id`,`namelname`,`user_type`,`logtime`,`log` FROM `studio404_users` WHERE `username`=:username AND `password`=:password AND `status`!=:status AND (`user_type`=:administrator OR `user_type`=:subadmin)";
			$query = $conn->prepare($sql);
			$query->execute(array(
				":username" => $user, 
				":password" => $pass, 
				":administrator" => "administrator", 
				":subadmin" => "sub admin", 
				":status" => 1
			));
			$u_row = $query->fetch(PDO::FETCH_ASSOC);
			
			if($u_row["user_type"]){//user exists
				$_SESSION["user404_id"] = $u_row["id"];
				$_SESSION["user404"] = $user;
				$_SESSION["expired_sessioned_time"] = (time() + $c['session.expire.time']);
				$_SESSION["user_type"] = $u_row["user_type"];
				$_SESSION["logtime"] = $u_row["logtime"];
				$_SESSION["log"] = $u_row["log"]+1;
				$_SESSION['C'] = $c;
				$sql_update = "UPDATE `studio404_users` SET `logtime`=:logtime, `log`=:log WHERE `username`=:username AND `password`=:password AND `status`!=:status ";
				$query_update = $conn->prepare($sql_update);
				$query_update->execute(array(
					":logtime" => time(),
					":log" => $_SESSION["log"], 
					":username" => $user,
					":password" => $pass, 
					":status" => 1
				));
				// insert log
				$this->insert_log_info($c,$user,$u_row["namelname"]);				
				$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$redirect = new redirect();
				$redirect->go($actual_link);
			}else{
				$this->out = true;
			}
		}else{
			$this->out = true;
		}
		return $this->out;
	}

	public function insert_log_info($c,$username,$namelname){
		$conn = $this->conn($c);
		$sql_insert_log = "INSERT INTO `studio404_logs` SET `date`=:datex, `namelname`=:namelname, `username`=:username, `browser`=:browser, `os`=:os, `ip`=:ip, `status`=:status"; 
		$datex = time();
		$userData = new userData();	
		$browser = $userData->getBrowser();		
		$os = $userData->getOS();
		$ip = $userData->getUserIP();
		
		$insert_prepare = $conn->prepare($sql_insert_log);
		$insert_prepare->execute(array(
			':datex'=>$datex, 
			':namelname' => $namelname, 
			':username' => $username, 
			':browser'=>$browser, 
			':os'=>$os, 
			':ip'=>$ip, 
			':status'=>0
		));
	}
}