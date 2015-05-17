<?php if(!defined("DIR")){ exit(); }
class model_admin_gallery extends connection{
	function __construct(){

	}

	public function select($c){
		$out = array();		
		if(isset($_GET['search']) && !empty($_GET['search']) ){
			$search='%'.$_GET['search'].'%';
			$search_in = ' AND `studio404_media_item`.`title` LIKE :search ';
		}else{ $search='a'; $search_in = ' AND `studio404_media_item`.`id`!=:search ';  }
			//page type
			$get_page_type = new get_page_type();
			$page_type = $get_page_type->type($_SESSION["C"],$_GET['id']);
			$sql = 'SELECT 
			`studio404_media_item`.`idx` AS smi_idx, 
			`studio404_media_item`.`date` AS smi_date, 
			`studio404_media_item`.`title` AS smi_title, 
			`studio404_media_item`.`tags` AS smi_tags,  
			`studio404_media_item`.`slug` AS smi_slug,  
			`studio404_media_item`.`position` AS smi_position,  
			`studio404_media_item`.`visibility` AS smi_visibility  
			FROM 
			`studio404_media_attachment`, `studio404_media`, `studio404_media_item`
			WHERE 
			`studio404_media_attachment`.`connect_idx`=:sma_connect_id AND 
			`studio404_media_attachment`.`page_type`=:sma_page_type AND 
			`studio404_media_attachment`.`lang`=:lang AND 
			`studio404_media_attachment`.`status`!=:status AND 
			`studio404_media_attachment`.`idx`=`studio404_media`.`idx` AND 
			`studio404_media`.`lang`=:lang AND 
			`studio404_media`.`status`!=:status AND 
			`studio404_media`.`idx`=`studio404_media_item`.`media_idx` AND 
			`studio404_media_item`.`lang`=:lang AND 
			`studio404_media_item`.`status`!=:status '.$search_in.'
			ORDER BY 
			`studio404_media_item`.`position` ASC
			';
			$exe_array = array(
				":sma_connect_id"=>$_GET['id'], 
				":sma_page_type"=>$page_type, 
				":status"=>1, 
				":search"=>$search, 
				":lang"=>LANG_ID
			);
		$path = '?action=gallery&type=photogallerypage&id='.$_GET['id'].'&pn=';
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
			$maxpos = $this->maxpos($c,$_GET['id']);
			while($rows = $query->fetch()){
				$out .= '<div class="row">';

				$visibilityx = ($rows['smi_visibility']==1) ? "red" : "green";
				$_SESSION['token'] = md5(sha1(time()));
				$link_visibility = "?action=gallery&type=photogallerypage&id=".$_GET['id']."&mediaidx=".$rows['smi_idx']."&super=".$_GET['super']."&visibilitychnage=true&token=".$_SESSION['token'];
				$out .= '<span class="cell primary"><a href="'.htmlentities($link_visibility).'" style="color:'.$visibilityx.'" title="Change visibility"><i class="fa fa-dot-circle-o"></i></a></span>';
				
				$out .= '<span class="cell">';
				if($rows['smi_position']!=1){
					$out .= '<a href="?action=gallery&type=photogallerypage&id='.$_GET['id'].'&midx='.$rows['smi_idx'].'&super='.$_GET['super'].'&up=true&token='.$_SESSION['token'].'" class="changeposition" title="Move up"><i class="fa fa-arrow-circle-up"></i></a>';
				}
				if($rows['smi_position']!=$maxpos){
					$out .= '<a href="?action=gallery&type=photogallerypage&id='.$_GET['id'].'&midx='.$rows['smi_idx'].'&super='.$_GET['super'].'&down=true&token='.$_SESSION['token'].'" class="changeposition" title="Move down"><i class="fa fa-arrow-circle-down"></i></a>';
				}
				$out .= '</span>';

				$out .= '<span class="cell"><a href="?action=editMediaItem&id='.$_GET['id'].'&midx='.$rows['smi_idx'].'&super='.$_GET['super'].'&type='.$_GET["type"].'&token='.$_SESSION['token'].'">'.$rows['smi_title'].'</a> <br /> <a href="'.WEBSITE.LANG."/".htmlentities($rows['smi_slug']).'" class="slugs" target="_blank">'.WEBSITE.LANG."/".$rows['smi_slug'].'</a></span>';
			
				$out .= '<span class="cell">'.$rows['smi_idx'].'</span>';
				$insert_image_link = '<a href="?action=editMediaItem&id='.$_GET['id'].'&midx='.$rows['smi_idx'].'&super='.$_GET['super'].'&type='.$_GET["type"].'&token='.$_SESSION['token'].'#tabs-2" title="Attach pictures/videos"> <i class="fa fa-picture-o"></i></a>';

				$out .= '<span class="cell" style="width:120px;">
						<a href="'.WEBSITE.LANG."/".htmlentities($rows['smi_slug']).'" target="_blank" title="Check gallery"><i class="fa fa-eye"></i></a>
						<a href="?action=editMediaItem&id='.$_GET['id'].'&midx='.$rows['smi_idx'].'&super='.$_GET['super'].'&typ='.$_GET["type"].'&token='.$_SESSION['token'].'" title="Edit gallery"><i class="fa fa-pencil-square-o"></i></a>
						'.$insert_image_link.'
						<a href="javascript:;" onclick="deleteComfirm(\'?action=gallery&type=photogallerypage&id='.$_GET['id'].'&rmidx='.$rows['smi_idx'].'&super='.$_GET['super'].'&remove=true&token='.$_SESSION['token'].'\')" title="Remove gallery item"><i class="fa fa-times"></i></a>
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
		MAX(`studio404_media_item`.`position`) AS smi_position  
		FROM 
		`studio404_media_attachment`,`studio404_media`,`studio404_media_item`
		WHERE
		`studio404_media_attachment`.`connect_idx`=:connect_idx AND 
		`studio404_media_attachment`.`lang`=:lang AND 
		`studio404_media_attachment`.`status`!=:status AND 
		`studio404_media_attachment`.`idx`=`studio404_media`.`idx` AND 
		`studio404_media`.`lang`=:lang AND 
		`studio404_media`.`status`!=:status AND 
		`studio404_media`.`idx`=`studio404_media_item`.`media_idx` AND 
		`studio404_media_item`.`lang`=:lang AND 
		`studio404_media_item`.`status`!=:status 
		ORDER BY 
		`studio404_media_item`.`position` ASC
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