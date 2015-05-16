<?php if(!defined("DIR")){ exit(); }
class model_admin_selectLanguage extends connection{
	function __construct(){

	}

	public function select_languages($c){
		$conn = $this->conn($c);
		$sql = 'SELECT `id`,`text`,`langs` FROM `studio404_language` WHERE `languagenames`=:languagenames';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
		 	":languagenames"=>1
		));
		$u_row = $prepare->fetchAll(PDO::FETCH_ASSOC);
		return $u_row;
	}

	public function select_option($c){
		$url_controll = new url_controll();
		$lang = $url_controll->url("segment", 1);
		$query = $this->select_languages($c);
		$out = '<select name="one" class="dropdown-select">'; 
		foreach($query as $rows){
			if($lang==$rows['langs']){ $selected = 'selected="selected"'; }else{ $selected=''; }
			$out .= '<option value="'.$rows['langs'].'" '.$selected.'>'.$rows['text'].'</option>';
		}
		$out .= '</select>';
		return $out;
	}

	function __destruct(){

	}
}
?>