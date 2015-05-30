<?php if(!defined("DIR")){ exit(); }
class model_admin_emaillist extends connection{
	public $outMessage = 2; 
	function __construct(){

	}

	public function removeMe($c){
		$conn = $this->conn($c);
		if($this->noEmpty($_GET['eid']) && is_numeric($_GET['eid']) && $_SESSION['token']==$_GET['token'])
		{ 			
			$sql = 'UPDATE `studio404_newsletter_emails` SET 
					`status`=:status
					WHERE 
					`id`=:id AND 
					`type`=:type';
			$insert = $conn->prepare($sql);
			$insert->execute(array(
				":type"=>'email', 
				":id"=>$_GET['eid'], 
				":status"=>1
			));
			$this->outMessage = 1;
		}
	}

	public function outbox($c){
		$out = array();		
		if(isset($_GET['search']) && !empty($_GET['search']) ){
			$search='%'.$_GET['search'].'%';
			$search_in = ' AND `subject` LIKE :search ';
		}else{ $search='a'; $search_in = ' AND `id`!=:search ';  }
			$sql = 'SELECT * FROM 
			`studio404_newsletter`
			WHERE 
			`type`=:type '.$search_in.'
			ORDER BY 
			`date` ASC
			';
			$exe_array = array(
				":type"=>'send',
				":search"=>$search
			);
		$path = '?action=outbox&token='.$_SESION['token'].'&pn=';
		$itemsPerPage = 10;
		$pager = new pager();
		$pager = $pager->action($c,$sql,$exe_array,$path,$itemsPerPage);	
		$out['table'] = $this->table_outbox($c,$pager[0],$exe_array);
		$out['pager'] = $pager[1];
		return $out;
	}

	public function table_outbox($c,$sql,$exe_array){
		$out = '';
		$conn = $this->conn($c);
		$query = $conn->prepare($sql);
		
		try{ 
			$query->execute($exe_array);
			$token = md5(sha1(time()));
			$_SESSION['token'] = $token;
			while($rows = $query->fetch()){
				$out .= '<div class="row">';

				$out .= '<span class="cell">'.date( "d-m-Y H:i:s", $rows['date']).'</span>';
				$out .= '<span class="cell">'.$rows['sendtype'].'</span>';
				$out .= '<span class="cell"><a href="?action=showemails&id='.$rows['group_id'].'">'.$this->getEmailGroupNameById($c,$rows['group_id']).'</a></span>'; 
				$out .= '<span class="cell">'.$rows['subject'].'</span>';				
				$out .= '<span class="cell">'.$rows['send_status'].'</span>'; 		
				$out .= '<span class="cell">
						<a href="/_plugins/newsletter/index.php?u='.$rows['uid'].'" target="_blank" title="View"><i class="fa fa-eye"></i></a>
				</span>';
				$out .= '</div>';
			}
		}catch(Exception $e){
			
		}
		return $out;
	}

	public function getEmailGroupNameById($c,$id){
		$conn = $this->conn($c);
		$sql = 'SELECT `name` FROM `studio404_newsletter_emails` WHERE `id`=:id AND `type`=:type AND `status`!=:status';
		$prepare = $conn->prepare($sql); 
		$prepare->execute(array(
			":type"=>'group', 
			":id"=>$id, 
			":status"=>1
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		return $fetch['name'];
	}

	public function select($c){
		$out = array();		
		if(isset($_GET['search']) && !empty($_GET['search']) ){
			$search='%'.$_GET['search'].'%';
			$search_in = ' AND (`name` LIKE :search OR `email` LIKE :search) ';
		}else{ $search='a'; $search_in = ' AND `id`!=:search ';  }
			$sql = 'SELECT * FROM 
			`studio404_newsletter_emails`
			WHERE 
			`type`=:type AND 		
			`group_id`=:group_id AND 		
			`status`!=:status '.$search_in.'
			ORDER BY 
			`name` ASC
			';
			$exe_array = array(
				":group_id"=>$_GET['id'],
				":type"=>'email',
				":status"=>1, 
				":search"=>$search
			);
		$path = '?action=showemails&id='.$_GET['id'].'&token='.$_SESION['token'].'&pn=';
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
				$out .= '<div class="row">';

				$out .= '<span class="cell">'.$rows['id'].'</span>';
				$out .= '<span class="cell"><a href="?action=editEmail&id='.$_GET['id'].'&eid='.$rows['id'].'&token='.$_SESSION['token'].'" title="">'.$rows['name'].'</a></span>';
				$out .= '<span class="cell">'.$rows['email'].'</span>';				
				$out .= '<span class="cell">
						<a href="?action=editEmail&id='.$_GET['id'].'&eid='.$rows['id'].'&token='.$_SESSION['token'].'" title="Edit email"><i class="fa fa-pencil-square-o"></i></a>
						<a href="javascript:;" onclick="deleteComfirm(\'?action=showemails&id='.$_GET['id'].'&eid='.$rows['id'].'&remove=true&token='.$_SESSION['token'].'\')" title="Remove email"><i class="fa fa-times"></i></a>
				</span>';
				$out .= '</div>';
			}
		}catch(Exception $e){
			
		}
		return $out;
	}

	public function add($c){
		$conn = $this->conn($c);
		if($this->noEmpty($_POST['name']) && $this->noEmpty($_POST['email']) && $this->noEmpty($_GET['id']) && is_numeric($_GET['id']))
		{ 			
			$unsubscribe = sha1(md5($_POST['email']."Studio404"));
			$sql = 'INSERT INTO `studio404_newsletter_emails` SET 
					`name`=:name, 
					`email`=:email, 
					`type`=:type, 
					`unsubscribe`=:unsubscribe, 
					`group_id`=:group_id 
					';
			$insert = $conn->prepare($sql);
			$insert->execute(array(
				":name"=>$_POST['name'], 
				":email"=>$_POST['email'], 
				":type"=>'email', 
				":unsubscribe"=>$unsubscribe, 
				":group_id"=>$_GET['id'] 
			));
			$this->outMessage = 1;
		}
	}

	public function edit($c){
		$conn = $this->conn($c);
		if($this->noEmpty($_POST['name']) && $this->noEmpty($_GET['eid']) && is_numeric($_GET['eid']) && $_SESSION['token']==$_GET['token'])
		{ 			
			$sql = 'UPDATE `studio404_newsletter_emails` SET 
					`name`=:name, 
					`email`=:email 
					WHERE 
					`id`=:id AND 
					`type`=:type';
			$insert = $conn->prepare($sql);
			$insert->execute(array(
				":name"=>$_POST['name'], 
				":email"=>$_POST['email'], 
				":type"=>'email', 
				":id"=>$_GET['eid']
			));
			$this->outMessage = 1;
		}
	}

	public function select_one($c){
		$conn = $this->conn($c);
		$sql = 'SELECT `name`,`email` FROM `studio404_newsletter_emails` WHERE `id`=:id AND `type`=:type AND `status`!=:status';
		$prepare = $conn->prepare($sql); 
		$prepare->execute(array(
			":type"=>'email', 
			":id"=>$_GET['eid'], 
			":status"=>1
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		return $fetch;
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