<?php if(!defined("DIR")){ exit(); }
class model_admin_newsmodule extends connection{
	public $outMessage;
	function __construct(){

	}

	public function select_list($c){
		$out = array();		
		if(isset($_GET['search']) && !empty($_GET['search']) ){
			$search='%'.$_GET['search'].'%';
			$search_in = ' AND `studio404_module_item`.`title` LIKE :search ';
		}else{ $search='a'; $search_in = ' AND `studio404_module_item`.`id`!=:search ';  }
			$sql = 'SELECT 
			`studio404_module_item`.`idx` AS smi_idx, 
			`studio404_module_item`.`date` AS smi_date, 
			`studio404_module_item`.`title` AS smi_title, 
			`studio404_module_item`.`tags` AS smi_tags,  
			`studio404_module_item`.`slug` AS smi_slug,  
			`studio404_module_item`.`visibility` AS smi_visibility  
			FROM 
			`studio404_module_attachment`, `studio404_module`, `studio404_module_item`
			WHERE 
			`studio404_module_attachment`.`connect_idx`=:sma_connect_id AND 
			(`studio404_module_attachment`.`page_type`=:sma_page_type || `studio404_module_attachment`.`page_type`=:sma_page_type2) AND 
			`studio404_module_attachment`.`lang`=:lang AND 
			`studio404_module_attachment`.`status`!=:status AND 
			`studio404_module_attachment`.`idx`=`studio404_module`.`idx` AND 
			`studio404_module`.`lang`=:lang AND 
			`studio404_module`.`status`!=:status AND 
			`studio404_module`.`idx`=`studio404_module_item`.`module_idx` AND 
			`studio404_module_item`.`lang`=:lang AND 
			`studio404_module_item`.`status`!=:status '.$search_in.'
			ORDER BY 
			`studio404_module_item`.`date` DESC
			';
			$exe_array = array(
				":sma_connect_id"=>$_GET['id'], 
				":sma_page_type"=>"newspage", 
				":sma_page_type2"=>"eventpage", 
				":status"=>1, 
				":search"=>$search, 
				":lang"=>LANG_ID
			);
		$path = '?action=newsModule&type=newspage&id='.$_GET['id'].'&pn=';
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

				$visibilityx = ($rows['smi_visibility']==1) ? "red" : "green";
				$link_visibility = "?action=newsModule&type=".$_GET['type']."&id=".$_GET['id']."&newsidx=".$rows['smi_idx']."&super=".$_GET['super']."&visibilitychnage=true&token=".$_SESSION['token'];
				$out .= '<span class="cell primary"><a href="'.htmlentities($link_visibility).'" style="color:'.$visibilityx.'" title="Change visibility"><i class="fa fa-dot-circle-o"></i></a></span>';
				$out .= '<span class="cell">'.$rows['smi_idx'].'</span>';
				$out .= '<span class="cell" style="width:100px">'.date("d-m-Y",$rows['smi_date']).'</span>';
				$out .= '<span class="cell"><a href="?action=editNewsItem&id='.$_GET['id'].'&newsidx='.$rows['smi_idx'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'">'.$rows['smi_title'].'</a> <br /> <a href="'.WEBSITE.LANG."/".htmlentities($rows['smi_slug']).'" class="slugs" target="_blank">'.WEBSITE.LANG."/".$rows['smi_slug'].'</a></span>';
				$out .= '<span class="cell">'.$rows['smi_tags'].'</span>';

				$insert_image_link = '<a href="?action=editNewsItem&id='.$_GET['id'].'&newsidx='.$rows['smi_idx'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'#tabs-3" title="Attach pictures"> <i class="fa fa-picture-o"></i></a>';
				$insert_image_link .= '<a href="?action=editNewsItem&id='.$_GET['id'].'&newsidx='.$rows['smi_idx'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'#tabs-4" title="Attach files"> <i class="fa fa-file"></i></a>';

				$out .= '<span class="cell">
						<a href="'.WEBSITE.LANG."/".htmlentities($rows['smi_slug']).'" target="_blank" title="Check news"><i class="fa fa-eye"></i></a>
						<a href="?action=editNewsItem&id='.$_GET['id'].'&newsidx='.$rows['smi_idx'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'" title="Edit news"><i class="fa fa-pencil-square-o"></i></a>
						'.$insert_image_link.'
						<a href="javascript:;" onclick="deleteComfirm(\'?action=newsModule&type='.$_GET['type'].'&id='.$_GET['id'].'&nidx='.$rows['smi_idx'].'&super='.$_GET['super'].'&remove=true&token='.$_SESSION['token'].'\')" title="Remove news"><i class="fa fa-times"></i></a>
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