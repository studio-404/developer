<?php if(!defined("DIR")){ exit(); }
class model_admin_components extends connection{
	public $outMessage = 2;
	function __construct(){

	}

	public function select($c){
		$out = array();		
		if(isset($_GET['search']) && !empty($_GET['search']) ){
			$search='%'.$_GET['search'].'%';
			$search_in = ' AND `name` LIKE :search ';
		}else{ $search='a'; $search_in = ' AND `id`!=:search ';  }
		$sql = 'SELECT `id`,`name` FROM `studio404_components` WHERE `status`!=:status '.$search_in.' ORDER BY `name` ASC';
		$exe_array = array(
			":status"=>1, 
			":search"=>$search, 
		);
		$path = '?action=components&pn=';
		$itemsPerPage = 10;
		$pager = new pager();
		$pager = $pager->action($c,$sql,$exe_array,$path,$itemsPerPage);	
		$out['table'] = $this->table($c,$pager[0],$exe_array);
		$out['pager'] = $pager[1];
		return $out;
	}

	public function select_components_menu($c){
		$conn = $this->conn($c); 
		$sql = 'SELECT `id`,`name` FROM `studio404_components` WHERE `status`!=:status ORDER BY `name` ASC';
		$prepare = $conn->prepare($sql); 
		$prepare->execute(array(
			":status"=>1
		));
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
			$_SESSION['token'] = md5(sha1(time()));

			while($rows = $query->fetch()){
				$out .= '<div class="row">';				
				$out .= '<span class="cell">'.$rows['id'].'</span>';
				$out .= '<span class="cell"><a href="?action=editComponents&id='.$rows['id'].'&token='.$_SESSION['token'].'">'.$rows['name'].'</a></span>';			
				$out .= '<span class="cell" style="width:120px;">
						<a href="?action=editComponents&id='.$rows['id'].'&token='.$_SESSION['token'].'" title="Edit components"><i class="fa fa-pencil-square-o"></i></a>
						<a href="?action=componentModule&id='.$rows['id'].'&token='.$_SESSION['token'].'" title="Manage components"><i class="fa fa-list-ol"></i></a>
						<a href="javascript:;" onclick="deleteComfirm(\'?action=components&comid='.$rows['id'].'&remove=true&token='.$_SESSION['token'].'\')" title="Remove components"><i class="fa fa-times"></i></a>
						</span>';

				$out .= '</div>';
			}
		}catch(Exception $e){
			
		}
		return $out;
	}

	public function add($c){
		$conn = $this->conn($c);
		$sql = 'INSERT INTO `studio404_components` SET `name`=:name, `insert_admin`=:insert_admin, `status`=:status';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":name"=>$_POST['name'], 
			":insert_admin"=>$_SESSION["user404_id"], 
			":status"=>0
		));
		$this->outMessage = 1;
	}

	public function edit($c){
		$conn = $this->conn($c);
		$sql = 'UPDATE `studio404_components` SET `name`=:name WHERE `id`=:id';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":name"=>$_POST['name'], 
			":id"=>$_GET['id']
		));
		$this->outMessage = 1;
	}

	public function removeMe($c){
		$conn = $this->conn($c);
		$sql = 'UPDATE `studio404_components` SET `status`=:status WHERE `id`=:comid';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":status"=>1, 
			":comid"=>$_GET['comid'] 
		));
		$this->outMessage = 1;
	}

	function __destruct(){

	}
}
?>