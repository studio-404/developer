<?php if(!defined("DIR")){ exit(); }
class model_admin_menageemails extends connection{
	public $outMessage = 2; 
	function __construct(){

	}

	public function removeMe($c){
		$conn = $this->conn($c);
		if($this->noEmpty($_GET['id']) && is_numeric($_GET['id']) && $_SESSION['token']==$_GET['token'])
		{ 			
			$sql = 'UPDATE `studio404_newsletter_emails` SET 
					`status`=:status
					WHERE 
					`id`=:id AND 
					`type`=:type';
			$insert = $conn->prepare($sql);
			$insert->execute(array(
				":type"=>'group', 
				":id"=>$_GET['id'], 
				":status"=>1
			));
			$this->outMessage = 1;
		}
	}

	public function addSendEmail($c){
		$conn = $this->conn($c); 
		$uid = new uid();
		$u = $uid->generate(6);
		if(isset($_POST['sendtype'],$_POST['subject'],$_POST['message']) && $_POST['sendtype']=="groups" && is_numeric($_POST['groups']) && !empty($_POST['subject']) ){
			$sql = 'INSERT INTO `studio404_newsletter` SET `uid`=:uid, `date`=:datex, `type`=:type, `sendtype`=:sendtype, `group_id`=:group_id, `individualemail`=:individualemail, `subject`=:subject, `message`=:message ';
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":uid"=>$u, 
				":datex"=>time(), 
				":type"=>'send', 
				":sendtype"=>'group', 
				":group_id"=>$_POST['groups'], 
				":individualemail"=>'', 
				":subject"=>$_POST['subject'], 
				":message"=>$_POST['message'] 
			));
			$this->outMessage = 1;
		}else if(isset($_POST['sendtype'],$_POST['subject'],$_POST['message']) && $_POST['sendtype']=="individual" && !empty($_POST['subject']) && !empty($_POST['email'])){
			$sql = 'INSERT INTO `studio404_newsletter` SET `uid`=:uid, `date`=:datex, `type`=:type, `sendtype`=:sendtype, `group_id`=:group_id, `individualemail`=:individualemail, `subject`=:subject, `message`=:message ';
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":uid"=>$u, 
				":datex"=>time(), 
				":type"=>'send', 
				":sendtype"=>'individual', 
				":group_id"=>0, 
				":individualemail"=>$_POST['email'], 
				":subject"=>$_POST['subject'], 
				":message"=>$_POST['message'] 
			));
			$this->outMessage = 1;
		}
	}

	public function select($c){
		$out = array();		
		if(isset($_GET['search']) && !empty($_GET['search']) ){
			$search='%'.$_GET['search'].'%';
			$search_in = ' AND `name` LIKE :search ';
		}else{ $search='a'; $search_in = ' AND `id`!=:search ';  }
			$sql = 'SELECT 
			*
			FROM 
			`studio404_newsletter_emails`
			WHERE 
			`type`=:type AND 			
			`status`!=:status '.$search_in.'
			ORDER BY 
			`name` ASC
			';
			$exe_array = array(
				":type"=>'group',
				":status"=>1, 
				":search"=>$search
			);
		$path = '?action=managedemails&token='.$_SESION['token'].'&pn=';
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
				$out .= '<span class="cell"><a href="?action=showemails&id='.$rows['id'].'" title="Check emails list">'.$rows['name'].'</a></span>';
				$out .= '<span class="cell">'.$this->countinsideemails($c,$rows['id']).'</span>';
				
				$out .= '<span class="cell">
						<a href="?action=showemails&id='.$rows['id'].'" title="Check emails list"><i class="fa fa-eye"></i></a>
						<a href="?action=editEmailGroup&id='.$rows['id'].'&token='.$_SESSION['token'].'" title="Edit email group name"><i class="fa fa-pencil-square-o"></i></a>
						<a href="javascript:;" onclick="deleteComfirm(\'?action=managedemails&id='.$rows['id'].'&remove=true&token='.$_SESSION['token'].'\')" title="Remove email group"><i class="fa fa-times"></i></a>
				</span>';
				$out .= '</div>';
			}
		}catch(Exception $e){
			
		}
		return $out;
	}

	public function countinsideemails($c,$id){
		$conn = $this->conn($c);
		$sql = 'SELECT COUNT(`id`) AS cc FROM `studio404_newsletter_emails` WHERE `group_id`=:group_id AND `status`!=:status';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":group_id"=>$id, 
			":status"=>1
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC); 
		return $fetch["cc"]; 
	}

	public function add($c){
		$conn = $this->conn($c);
		if($this->noEmpty($_POST['groupname']))
		{ 			
			$sql = 'INSERT INTO `studio404_newsletter_emails` SET 
					`name`=:groupname, 
					`type`=:type';
			$insert = $conn->prepare($sql);
			$insert->execute(array(
				":groupname"=>$_POST['groupname'], 
				":type"=>'group'
			));
			$this->outMessage = 1;
		}
	}

	public function edit($c){
		$conn = $this->conn($c);
		if($this->noEmpty($_POST['groupname']) && $this->noEmpty($_GET['id']) && is_numeric($_GET['id']) && $_SESSION['token']==$_GET['token'])
		{ 			
			$sql = 'UPDATE `studio404_newsletter_emails` SET 
					`name`=:groupname
					WHERE 
					`id`=:id AND 
					`type`=:type';
			$insert = $conn->prepare($sql);
			$insert->execute(array(
				":groupname"=>$_POST['groupname'], 
				":type"=>'group', 
				":id"=>$_GET['id']
			));
			$this->outMessage = 1;
		}
	}

	public function select_one($c){
		$conn = $this->conn($c);
		$sql = 'SELECT `name` FROM `studio404_newsletter_emails` WHERE `id`=:id AND `type`=:type AND `status`!=:status';
		$prepare = $conn->prepare($sql); 
		$prepare->execute(array(
			":type"=>'group', 
			":id"=>$_GET['id'], 
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