<?php if(!defined("DIR")){ exit(); }
class model_admin_selectManagedMenu extends connection{
	function __construct(){

	}

	public function select($c,$home=false){		
		$conn = $this->conn($c);
		$sql = 'SELECT `idx`,`title` FROM `studio404_pages` WHERE `menu_type`=:menu_type AND `lang`=:lang AND `status`!=:status';
		$query = $conn->prepare($sql);
		$query->execute(array(
			":menu_type"=>"super", 
			":lang"=>LANG_ID, 
			":status"=>1
		));	
		$rows = $query->fetchAll();
		$out = '';
		foreach($rows as $row){
			if(!$home){
				$out .= '<li>'; 
				$out .= '<a href="?action=sitemap&amp;super='.$row['idx'].'">'.$row['title'].'</a>';
				$out .= '</li>';
			}else{
				$out .= '<div class="row">'; 
				$out .= '<span class="cell primary" data-label="Vehicle">'.$row['title'].'</span>'; 
				$out .= '<span class="cell" data-label="Action">'; 
				$out .= '<a href="?action=sitemap&amp;super='.$row['idx'].'"><i class="fa fa-pencil-square-o"></i></a>'; 
				$out .= '</span>';
				$out .= '</div>';
			}
		}
		return $out;
	}

	function __destruct(){

	}
}
?>