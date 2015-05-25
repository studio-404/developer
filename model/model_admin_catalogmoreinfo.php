<?php if(!defined("DIR")){ exit(); }
class model_admin_catalogmoreinfo extends connection{
	public $outMessage = 2;
	function __construct(){

	}

	public function select_one($c,$idx){
		$sql = 'SELECT `module_item_id`,`name` FROM `studio404_catalog_info` WHERE `idx`=:idx AND `lang`=:lang AND `status`!=:status';
		$conn = $this->conn($c);
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":idx"=>$idx, 
			":lang"=>LANG_ID, 
			":status"=>1
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		return $fetch;
	}

	public function updateMe($c){
		$sql = 'UPDATE `studio404_catalog_info` SET `name`=:name WHERE `idx`=:idx AND `lang`=:lang AND `status`!=:status';
		$conn = $this->conn($c);
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":idx"=>$_GET['id'], 
			":name"=>$_POST['name'], 
			":lang"=>LANG_ID, 
			":status"=>1
		));
		$this->outMessage = 1;
	}

	public function select_list_all($c){
		$out = array();		
		if(isset($_GET['search']) && !empty($_GET['search']) ){
			$search='%'.$_GET['search'].'%';
			$search_in = ' AND `studio404_catalog_info`.`name` LIKE :search ';
		}else{ $search='a'; $search_in = ' AND `studio404_catalog_info`.`id`!=:search ';  }
			$sql = 'SELECT 
			`studio404_catalog_info`.*,
			`studio404_pages`.`title` AS sp_title 
			FROM 
			`studio404_catalog_info`,`studio404_pages` 
			WHERE 
			`studio404_catalog_info`.`lang`=:lang AND 
			`studio404_catalog_info`.`status`!=:status AND 
			`studio404_catalog_info`.`module_item_id`=`studio404_pages`.`idx` AND 
			`studio404_pages`.`lang`=:lang AND 
			`studio404_pages`.`status`!=:status  
			'.$search_in.' 
			ORDER BY `name` ASC';
			
			$exe_array = array(
				":status"=>1, 
				":lang"=>LANG_ID, 
				":search"=>$search
			);
		$path = '?action=catalogMoreInfo&pn=';
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
			
				$out .= '<span class="cell" style="width:60px">'.$rows['idx'].'</span>';
				$out .= '<span class="cell">'.$rows['sp_title'].'</span>';
				$out .= '<span class="cell primary"><a href="?action=editCatalogMoreInfo&id='.$rows['idx'].'">'.$rows['name'].'</a></span>';
				
				$out .= '<span class="cell" style="width:120px;">
							<a href="?action=editCatalogMoreInfo&id='.$rows['idx'].'" title="Edit catalog more info"><i class="fa fa-pencil-square-o"></i></a>
							<a href="javascript:;" onclick="deleteComfirm(\'?action=catalogMoreInfo&cridxremove='.$rows['idx'].'&remove=true&token='.$_SESSION['token'].'\')" title="Remove catalog more item"><i class="fa fa-times"></i></a>
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