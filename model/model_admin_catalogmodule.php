<?php if(!defined("DIR")){ exit(); }
class model_admin_catalogmodule extends connection{
	function __construct(){

	}

	public function select_list($c){
		$out = array();		
		if(isset($_GET['search']) && !empty($_GET['search']) ){
			$search='%'.$_GET['search'].'%';
			$search_in = ' AND `studio404_module_item`.`title` LIKE :search ';
		}else{ $search='a'; $search_in = ' AND `studio404_module_item`.`id`!=:search ';  }
			//page type
			$get_page_type = new get_page_type();
			$page_type = $get_page_type->type($_SESSION["C"],$_GET['id']);
			$sql = 'SELECT 
			`studio404_module_item`.`idx` AS smi_idx, 
			`studio404_module_item`.`date` AS smi_date, 
			`studio404_module_item`.`title` AS smi_title, 
			`studio404_module_item`.`tags` AS smi_tags,  
			`studio404_module_item`.`slug` AS smi_slug,  
			`studio404_module_item`.`position` AS smi_position,  
			`studio404_module_item`.`visibility` AS smi_visibility  
			FROM 
			`studio404_module_attachment`, `studio404_module`, `studio404_module_item`
			WHERE 
			`studio404_module_attachment`.`connect_idx`=:sma_connect_id AND 
			`studio404_module_attachment`.`page_type`=:sma_page_type AND 
			`studio404_module_attachment`.`lang`=:lang AND 
			`studio404_module_attachment`.`status`!=:status AND 
			`studio404_module_attachment`.`idx`=`studio404_module`.`idx` AND 
			`studio404_module`.`lang`=:lang AND 
			`studio404_module`.`status`!=:status AND 
			`studio404_module`.`idx`=`studio404_module_item`.`module_idx` AND 
			`studio404_module_item`.`lang`=:lang AND 
			`studio404_module_item`.`status`!=:status '.$search_in.'
			ORDER BY 
			`studio404_module_item`.`position` ASC
			';
			$exe_array = array(
				":sma_connect_id"=>$_GET['id'], 
				":sma_page_type"=>$page_type, 
				":status"=>1, 
				":search"=>$search, 
				":lang"=>LANG_ID
			);
		$path = '?action=newsModule&type=catalogpage&id='.$_GET['id'].'&pn=';
		$itemsPerPage = 10;
		$pager = new pager();
		$pager = $pager->action($c,$sql,$exe_array,$path,$itemsPerPage);	
		$out['table'] = $this->table($c,$pager[0],$exe_array);
		$out['pager'] = $pager[1];
		return $out;
	}

	public function getcatalogs($c){
		$conn = $this->conn($c);
		$sql = 'SELECT `idx`, `title` FROM 
		`studio404_pages`
		WHERE 
		`page_type`=:sma_page_type AND 
		`lang`=:lang AND 
		`status`!=:status 
		ORDER BY 
		`title` ASC 
		';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":sma_page_type"=>"catalogpage", 
			":status"=>1,  
			":lang"=>LANG_ID
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
			$maxpos = $this->maxpos($c,$_GET['id']);
			while($rows = $query->fetch()){
				$out .= '<div class="row">';

				$visibilityx = ($rows['smi_visibility']==1) ? "red" : "green";
				$_SESSION['token'] = md5(sha1(time()));
				$link_visibility = "?action=catalogModule&type=catalogpage&id=".$_GET['id']."&catalogidx=".$rows['smi_idx']."&super=".$_GET['super']."&visibilitychnage=true&token=".$_SESSION['token'];
				$out .= '<span class="cell primary"><a href="'.htmlentities($link_visibility).'" style="color:'.$visibilityx.'" title="Change visibility"><i class="fa fa-dot-circle-o"></i></a></span>';
				
				$out .= '<span class="cell">';
				if($rows['smi_position']!=1){
					$out .= '<a href="?action=catalogModule&type=catalogpage&id='.$_GET['id'].'&cidx='.$rows['smi_idx'].'&super='.$_GET['super'].'&up=true&token='.$_SESSION['token'].'" class="changeposition" title="Move up"><i class="fa fa-arrow-circle-up"></i></a>';
				}
				if($rows['smi_position']!=$maxpos){
					$out .= '<a href="?action=catalogModule&type=catalogpage&id='.$_GET['id'].'&cidx='.$rows['smi_idx'].'&super='.$_GET['super'].'&down=true&token='.$_SESSION['token'].'" class="changeposition" title="Move down"><i class="fa fa-arrow-circle-down"></i></a>';
				}
				$out .= '</span>';

				$out .= '<span class="cell"><a href="?action=editCatalogItem&id='.$_GET['id'].'&cidx='.$rows['smi_idx'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'">'.$rows['smi_title'].'</a> <br /> <a href="'.WEBSITE.LANG."/".htmlentities($rows['smi_slug']).'" class="slugs" target="_blank">'.WEBSITE.LANG."/".$rows['smi_slug'].'</a></span>';
			
				$out .= '<span class="cell">'.$rows['smi_idx'].'</span>';
				$insert_image_link = '<a href="?action=editCatalogItem&id='.$_GET['id'].'&cidx='.$rows['smi_idx'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'#tabs-4" title="Attach pictures"> <i class="fa fa-picture-o"></i></a>';
				$insert_image_link .= '<a href="?action=editCatalogItem&id='.$_GET['id'].'&cidx='.$rows['smi_idx'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'#tabs-5" title="Attach files"> <i class="fa fa-file"></i></a>';
				$insert_image_link .= '<a href="?action=editCatalogItem&id='.$_GET['id'].'&cidx='.$rows['smi_idx'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'#tabs-3" title="More info"> <i class="fa fa-info-circle"></i></a>';

				$out .= '<span class="cell" style="width:120px;">
						<a href="'.WEBSITE.LANG."/".htmlentities($rows['smi_slug']).'" target="_blank" title="Check news"><i class="fa fa-eye"></i></a>
						<a href="?action=editCatalogItem&id='.$_GET['id'].'&cidx='.$rows['smi_idx'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'" title="Edit news"><i class="fa fa-pencil-square-o"></i></a>
						'.$insert_image_link.'
						<a href="javascript:;" onclick="deleteComfirm(\'?action=catalogModule&type=catalogpage&id='.$_GET['id'].'&rcidx='.$rows['smi_idx'].'&super='.$_GET['super'].'&remove=true&token='.$_SESSION['token'].'\')" title="Remove catalog item"><i class="fa fa-times"></i></a>
				</span>';
				$out .= '</div>';
			}
		}catch(Exception $e){
			
		}
		return $out;
	}

	public function maxpos($c,$connect_idx){
		$conn = $this->conn($c);
		$sqlp = 'SELECT 
		MAX(`studio404_module_item`.`position`) AS smi_position  
		FROM 
		`studio404_module_attachment`,`studio404_module`,`studio404_module_item`
		WHERE
		`studio404_module_attachment`.`connect_idx`=:connect_idx AND 
		`studio404_module_attachment`.`lang`=:lang AND 
		`studio404_module_attachment`.`status`!=:status AND 
		`studio404_module_attachment`.`idx`=`studio404_module`.`idx` AND 
		`studio404_module`.`lang`=:lang AND 
		`studio404_module`.`status`!=:status AND 
		`studio404_module`.`idx`=`studio404_module_item`.`module_idx` AND 
		`studio404_module_item`.`lang`=:lang AND 
		`studio404_module_item`.`status`!=:status 
		ORDER BY 
		`studio404_module_item`.`position` ASC
		';
		$preparep = $conn->prepare($sqlp);
		$preparep->execute(array(
			":connect_idx"=>$connect_idx, 
			":lang"=>LANG_ID, 
			":status"=>1, 
		));
		$fetch = $preparep->fetch(PDO::FETCH_ASSOC);
		return $fetch['smi_position'];
	}

	function __destruct(){

	}
}
?>