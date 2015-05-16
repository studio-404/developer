<?php if(!defined("DIR")){ exit(); }

class model_admin_logs extends connection{

	public $outMessage;

	function __construct(){

	}

	public function select_admin_logs($c){
		$out = array();
		if(isset($_GET['search']) && !empty($_GET['search']) ){
			$sql = 'SELECT * FROM `studio404_logs` WHERE `status`!=:status AND `date`>:search_date AND `date`<:future_date';
			$search_date = strtotime($_GET['search']);
			$future_date = $search_date + 86400; // after 1 day time 
			
			$exe_array = array(":status"=>1,":search_date"=>$search_date, ":future_date"=>$future_date);
		}else{
			$sql = 'SELECT * FROM `studio404_logs` WHERE `status`!=:status ORDER BY `date` DESC';
			$exe_array = array(":status"=>1);
		}		
		$path = '?action=log&pn=';
		$itemsPerPage = 10;
		$pager = new pager();
		$pager = $pager->action($c,$sql,$exe_array,$path,$itemsPerPage);		
		$out['table'] = $this->table($c,$pager[0],$exe_array);
		$out['pager'] = $pager[1];
		return $out;
	}

	public function removeMe($c){
		$conn = $this->conn($c);
		$token_get = $_GET["token"];
		$token_session = $_SESSION["token"];
		if(isset($_GET["remove"]) && isset($_GET['id']) && is_numeric($_GET['id']) && $token_get==$token_session){
			$sql = 'UPDATE `studio404_logs` SET `status`=:status WHERE `id`=:id';
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
				$out .= '<span class="cell primary">'.date("d-m-Y H:i:s",$rows['date']).'</span>';
				$out .= '<span class="cell">'.$rows['namelname'].'</span>';
				$out .= '<span class="cell">'.$rows['username'].'</span>';
				$out .= '<span class="cell">'.$rows['browser'].'</span>';
				$out .= '<span class="cell">'.$rows['os'].'</span>';
				$out .= '<span class="cell">'.$rows['ip'].'</span>';
				$out .= '<span class="cell">
						<a href="javascript:;" onclick="deleteComfirm(\'?action=log&id='.$rows['id'].'&remove=true&token='.$_SESSION['token'].'\')" title="Remove log"><i class="fa fa-times"></i></a>
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