<?php if(!defined("DIR")){ exit(); }
class model_admin_vectormap extends connection{
	public $outMessage = 2;
	function __construct(){

	}

	public function select($c){
		$out = array();		
		if(isset($_GET['search']) && !empty($_GET['search']) ){
			$search='%'.$_GET['search'].'%';
			$search_in = ' AND (`title` LIKE :search OR `code` LIKE :search)';
		}else{ $search='a'; $search_in = ' AND `id`!=:search ';  }
			//page type
			$get_page_type = new get_page_type();
			$page_type = $get_page_type->type($_SESSION["C"],$_GET['id']);
			$sql = 'SELECT `idx`,`title`, `code` FROM `studio404_vectormap` WHERE `lang`=:lang '.$search_in.' ORDER BY `title` ASC';

			$exe_array = array(
				":search"=>$search, 
				":lang"=>LANG_ID
			);
		$path = '?action=vectormap&pn=';
		$itemsPerPage = 20;
		$pager = new pager();
		$pager = $pager->action($c,$sql,$exe_array,$path,$itemsPerPage);	
		$out['table'] = $this->table($c,$pager[0],$exe_array);
		$out['pager'] = $pager[1];
		return $out;
	}

	public function select_one($c){
		$conn = $this->conn($c);
		$sql = 'SELECT * FROM `studio404_vectormap` WHERE `idx`=:idx AND `lang`=:lang';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":idx"=>$_GET['id'], 
			":lang"=>LANG_ID
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
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
				$out .= '<div class="row">';

				$out .= '<span class="cell">'.$rows['code'].'</span>';
				$out .= '<span class="cell primery"><a href="?action=editVectorMap&id='.$rows['idx'].'&token='.$_SESSION['token'].'">'.$rows['title'].'</a> </span>';
			
				
				$out .= '<span class="cell" style="width:120px;">
							<a href="?action=editVectorMap&id='.$rows['idx'].'&token='.$_SESSION['token'].'" title="Edit country"><i class="fa fa-pencil-square-o"></i></a>
						</span>';
				$out .= '</div>';
			}
		}catch(Exception $e){
			
		}
		return $out;
	}

	public function edit($c){
		$conn = $this->conn($c); 
		if(
			isset($_POST['title'],$_POST['edit_vectormap']) &&
			$this->noEmpty($_POST['title'])
		){
			// update main columns
			$sql = 'UPDATE `studio404_vectormap` SET 
			`title`=:title, 
			`export`=:export, 
			`import`=:import,  
			`trade_regime`=:trade_regime,  
			`countrygroups`=:countrygroups 
			WHERE 
			`idx`=:idx AND 
			`lang`=:lang  
			';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":title"=>$_POST['title'], 
				":export"=>$_POST['export'], 
				":import"=>$_POST['import'], 
				":trade_regime"=>$_POST['traderegime'], 
				":countrygroups"=>$_POST['countrygroups'], 
				":lang"=>LANG_ID,
				":idx"=>$_GET['id']
			));

			$this->outMessage = 1;
		}
	}

	private function noEmpty($foo){
		if(!empty($foo)){
			return true;
		}
		return false;
	}

	function __destruct(){

	}
}
?>