<?php if(!defined("DIR")){ exit(); }
class model_admin_userrights extends connection{
	public $outMessage=2;

	function __construct(){
		
	}

	public function check_if_permition($c){
		$conn = $this->conn($c);
	}

	public function select_userright($c){
		$conn = $this->conn($c);
		$out = array();
		$token_get = $_GET["token"];
		$token_session = $_SESSION["token"];
		$edit_id = $_GET["id"];
		if($token_get==$token_session){
			$sql = 'SELECT * FROM `studio404_user_right` WHERE `id`=:id AND `status`!=:status';
			$exe_array = array("id"=>$edit_id, ":status"=>1);
			$query = $conn->prepare($sql);
			$query->execute($exe_array);
			$fetch = $query->fetch(PDO::FETCH_ASSOC);
			return $fetch;
		}		
		return $out;
	}

	public function edit($c){
		$conn = $this->conn($c);
		$usergroup = strip_tags($_POST['usergroup']);
		$menumanagment = (int)strip_tags($_POST['menumanagment']);
		$modules = (int)strip_tags($_POST['modules']);
		$users = (int)strip_tags($_POST['users']);
		$tools = (int)strip_tags($_POST['tools']);
		$settings = (int)strip_tags($_POST['settings']);
		$token_get = $_GET["token"];
		$token_session = $_SESSION["token"];
		
		if( $this->noEmpty($usergroup) && $token_get==$token_session){
			$sql = 'UPDATE `studio404_user_right` SET `name`=:name, `menu_managment`=:menu_managment, `modules`=:modules, `users`=:users, `tools`=:tools, `settings`=:settings WHERE `id`=:id AND `status`!=:status';
			$query = $conn->prepare($sql);
			$query->execute(array(
			":name"=>$usergroup,
			":menu_managment"=>$menumanagment,
			":modules"=>$modules,
			":users"=>$users, 
			":tools"=>$tools, 
			":settings"=>$settings, 
			":id"=>$_GET['id'], 
			":status"=>1 
			));
			$this->outMessage = 1;	
		}else{
			$this->outMessage = 2;
		}
	}

	public function removeMe($c){
		$conn = $this->conn($c);
		$token_get = $_GET["token"];
		$token_session = $_SESSION["token"];
		if(isset($_GET["remove"]) && isset($_GET['id']) && is_numeric($_GET['id']) && $token_get==$token_session){
			$sql = 'UPDATE `studio404_user_right` SET `status`=:status WHERE `id`=:id';
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

	public function update_admin_right($c){
		if($this->noEmpty($_POST['usergroup'])){
			$usergroup = $_POST['usergroup'];
			$menumanagment = (int)$_POST['menumanagment'];
			$modules = (int)$_POST['modules'];
			$users = (int)$_POST['users'];
			$tools = (int)$_POST['tools'];
			$settings = (int)$_POST['settings'];

			$conn = $this->conn($c);
			$sql = 'INSERT INTO `studio404_user_right` SET `name`=:name, `menu_managment`=:menu_managment, `modules`=:modules, `users`=:users, `tools`=:tools, `settings`=:settings, `status`=:status ';
			try{
				$query = $conn->prepare($sql);
				$query->execute(array(
					":name"=>$usergroup,
					":menu_managment"=>$menumanagment, 
					":modules"=>$modules, 
					":users"=>$users, 
					":tools"=>$tools, 
					":settings"=>$settings, 
					":status"=>0
				));
				$this->outMessage = 1;
			}catch(Exception $e){
				$this->outMessage = 2;
			}
		}
	}

	public function noEmpty($foo){
		if(empty($foo)){
			return false;
		}
		return true;
	}

	public function select_admins_rightgroups($c){
		$out = array();
		$sql = 'SELECT * FROM `studio404_user_right` WHERE `status`!=:status';
		$exe_array = array(":status"=>1);
				
		$path = '?action=userRights&pn=';
		$itemsPerPage = 10;
		$pager = new pager();
		$pager = $pager->action($c,$sql,$exe_array,$path,$itemsPerPage);		
		$out['table'] = $this->table($c,$pager[0],$exe_array);
		$out['pager'] = $pager[1];
		return $out;
	}

	public function table($c,$sql,$exe_array){
		$out = '';
		$conn = $this->conn($c);
		$query = $conn->prepare($sql);
		try{
			$query->execute($exe_array);
			$token = md5(sha1(time()));
			$_SESSION['token'] = $token;
			while($rows = $query->fetch()){
				$logtime = ($rows['logtime']) ? date("d/m/Y H:s",$rows['logtime']) : "Not logged";
				$out .= '<div class="row">';
				$out .= '<span class="cell primary">'.$rows['name'].'</span>';
				$out .= '<span class="cell">
						<a href="?action=editAdminRights&id='.$rows['id'].'&token='.$_SESSION['token'].'" title="Edit user right groupe"><i class="fa fa-pencil-square-o"></i></a>
						<a href="javascript:;" onclick="deleteComfirm(\'?action=userRights&id='.$rows['id'].'&remove=true&token='.$_SESSION['token'].'\')" title="Remove user right group"><i class="fa fa-times"></i></a>
				</span>';
				$out .= '</div>';
			}
		}catch(Exception $e){
			
		}
		return $out;
	}

	function __destruct(){
		
	}
}
?>