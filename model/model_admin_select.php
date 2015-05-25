<?php if(!defined("DIR")){ exit(); }

class model_admin_select extends connection{
	function __construct(){
		
	}

	public function select_admins($c){
		$out = array();
		if(isset($_GET['search']) && !empty($_GET['search']) ){
			$sql = 'SELECT * FROM `studio404_users` WHERE (`user_type`=:administrator OR `user_type`=:subadmin) AND status`!=:status AND (`namelname` LIKE :namelname OR `username` LIKE :namelname OR `ucode` LIKE :namelname) ORDER BY `id` DESC';
			$search = '%'.$_GET['search'].'%';
			$exe_array = array(":administrator"=>"administrator", ":subadmin"=>"sub admin", ":status"=>1,":namelname"=>$search);
		}else{
			$sql = 'SELECT * FROM `studio404_users` WHERE (`user_type`=:administrator OR `user_type`=:subadmin) AND `status`!=:status ORDER BY `id` DESC';
			$exe_array = array(":administrator"=>"administrator", ":subadmin"=>"sub admin",":status"=>1);
		}		
		$path = '?action=userList&pn=';
		$itemsPerPage = 20;
		$pager = new pager();
		$pager = $pager->action($c,$sql,$exe_array,$path,$itemsPerPage);		
		$out['table'] = $this->table($c,$pager[0],$exe_array);
		$out['pager'] = $pager[1];
		return $out;
	}

	public function select_websiteusers($c){
		$out = array();
		if(isset($_GET['search']) && !empty($_GET['search']) ){
			$sql = 'SELECT * FROM `studio404_users` WHERE `user_type`=:wuser AND status`!=:status AND (`namelname` LIKE :namelname OR `username` LIKE :namelname OR `ucode` LIKE :namelname) ORDER BY `id` DESC';
			$search = '%'.$_GET['search'].'%';
			$exe_array = array(":wuser"=>"website", ":status"=>1,":namelname"=>$search);
		}else{
			$sql = 'SELECT * FROM `studio404_users` WHERE `user_type`=:wuser AND `status`!=:status ORDER BY `id` DESC';
			$exe_array = array(":wuser"=>"website", ":status"=>1);
		}		
		$path = '?action=wuserList&pn=';
		$itemsPerPage = 20;
		$pager = new pager();
		$pager = $pager->action($c,$sql,$exe_array,$path,$itemsPerPage);		
		$out['table'] = $this->wtable($c,$pager[0],$exe_array);
		$out['pager'] = $pager[1];
		return $out;
	}

	public function select_admin_names_for_invoice($c){
		$conn = $this->conn($c);
		$sql = 'SELECT `id`,`username`,`namelname` FROM `studio404_users` WHERE `status`!=:status ORDER BY `id` DESC';
		$prepare = $conn->prepare($sql); 
		$prepare->execute(array(":status"=>1)); 
		$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		return $fetch;
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
				$out .= '<span class="cell primary"><a href="?action=editprofile&id='.$rows['id'].'&token='.$_SESSION['token'].'" title="Edit user info">'.$rows['namelname'].'</a></span>';
				$out .= '<span class="cell">'.$rows['username'].'</span>';
				$out .= '<span class="cell">'.$rows['ucode'].'</span>';
				$out .= '<span class="cell">'.$rows['user_type'].'</span>';
				$out .= '<span class="cell">'.$logtime.'</span>';
				$out .= '<span class="cell">
						<a href="?action=editprofile&id='.$rows['id'].'&token='.$_SESSION['token'].'" title="Edit user info"><i class="fa fa-pencil-square-o"></i></a>
						<a href="javascript:;" onclick="deleteComfirm(\'?action=userList&id='.$rows['id'].'&remove=true&token='.$_SESSION['token'].'\')" title="Remove user"><i class="fa fa-times"></i></a>
				</span>';
				$out .= '</div>';
			}
		}catch(Exception $e){
			
		}
		return $out;
	}

	public function wtable($c,$sql,$exe_array){
		$out = '';
		$conn = $this->conn($c);
		$query = $conn->prepare($sql);
		try{
			$query->execute($exe_array);
			$token = md5(sha1(time()));
			$_SESSION['token'] = $token;
			while($rows = $query->fetch()){
				$logtime = ($rows['logtime']) ? date("d/m/Y H:s",$rows['logtime']) : "Not logged";
				$visibilityx = ($rows['allow']==1) ? "red" : "green";
				
				$link_visibility = "?action=wuserList&wuserid=".$rows['id']."&visibilitychnage=true&token=".$_SESSION['token'];
				
				$out .= '<div class="row">';
				$out .= '<span class="cell primary"><a href="'.htmlentities($link_visibility).'" style="color:'.$visibilityx.'" title="Change visibility"><i class="fa fa-dot-circle-o"></i></a></span>';
				$out .= '<span class="cell primary"><a href="?action=weditprofile&id='.$rows['id'].'&token='.$_SESSION['token'].'" title="Edit user info">'.$rows['namelname'].'</a></span>';
				$out .= '<span class="cell">'.$rows['username'].'</span>';
				$out .= '<span class="cell">'.$rows['ucode'].'</span>';
				$out .= '<span class="cell">'.$rows['company_type'].'</span>';
				$out .= '<span class="cell">'.$logtime.'</span>';
				$out .= '<span class="cell">
						<a href="?action=weditprofile&id='.$rows['id'].'&token='.$_SESSION['token'].'" title="Edit user info"><i class="fa fa-pencil-square-o"></i></a>
						<a href="javascript:;" onclick="deleteComfirm(\'?action=wuserList&id='.$rows['id'].'&remove=true&token='.$_SESSION['token'].'\')" title="Remove user"><i class="fa fa-times"></i></a>
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