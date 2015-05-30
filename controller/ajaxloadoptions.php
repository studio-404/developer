<?php if(!defined("DIR")){ exit(); }
class ajaxloadoptions extends connection{
	protected $c;
	function __construct(){
		global $c;
        $this->c =& $c;
 		$out = '<option value="">Choose</option>';
		if(isset($_GET['sector']))
		{
			try{
				$conn = $this->conn($this->c);
				$sql = 'SELECT `idx`,`title` FROM `studio404_pages` WHERE `cid`=:cid AND `lang`=:lang AND `status`!=:status AND `visibility`=:visibility ORDER BY `position` ASC';
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
					":cid"=>27, 
					":visibility"=>2,
					":lang"=>LANG_ID, 
					":status"=>1
				));
				$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
				foreach($fetch as $f){
					$out .= '<option value="'.(int)$f['idx'].'">'.htmlentities($f['title']).'</option>'; 	
				}
			}catch(Exception $e){
				$out = "Error loading sector !";
			}
		}else if(isset($_GET['sub_sector'],$_GET['sub_idx']) && is_numeric($_GET['sub_idx'])){
			try{
				$conn = $this->conn($this->c);
				$sql = 'SELECT `idx`,`title` FROM `studio404_pages` WHERE `cid`=:cid AND `lang`=:lang AND `status`!=:status AND `visibility`=:visibility ORDER BY `position` ASC';
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
					":cid"=>$_GET['sub_idx'], 
					":visibility"=>2,
					":lang"=>LANG_ID, 
					":status"=>1
				));
				$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
				foreach($fetch as $f){
					$out .= '<option value="'.(int)$f['idx'].'">'.htmlentities($f['title']).'</option>'; 	
				}
			}catch(Exception $e){
				$out = "Error loading sub sector !";
			}
		}else if(isset($_GET['sme'])){
			try{
				$conn = $this->conn($this->c);
				$sql = 'SELECT `idx`,`title` FROM `studio404_pages` WHERE `cid`=:cid AND `lang`=:lang AND `status`!=:status AND `visibility`=:visibility ORDER BY `position` ASC';
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
					":cid"=>33, 
					":visibility"=>2,
					":lang"=>LANG_ID, 
					":status"=>1
				));
				$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
				foreach($fetch as $f){
					$out .= '<option value="'.(int)$f['idx'].'">'.htmlentities($f['title']).'</option>'; 	
				}
			}catch(Exception $e){
				$out = "Error loading sub sector !";
			}
		}else if(isset($_GET['export_markets'])){
			try{
				$conn = $this->conn($this->c);
				$sql = 'SELECT `idx`,`title` FROM `studio404_pages` WHERE `cid`=:cid AND `lang`=:lang AND `status`!=:status AND `visibility`=:visibility ORDER BY `position` ASC';
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
					":cid"=>37, 
					":visibility"=>2,
					":lang"=>LANG_ID, 
					":status"=>1
				));
				$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
				foreach($fetch as $f){
					$out .= '<option value="'.(int)$f['idx'].'">'.htmlentities($f['title']).'</option>'; 	
				}
			}catch(Exception $e){
				$out = "Error loading export markets !";
			}
		}else if(isset($_GET['newsletterGroups'])){
			try{
				$conn = $this->conn($this->c);
				$sql = 'SELECT `id`,`name` FROM `studio404_newsletter_emails` WHERE `type`=:type AND `group_id`=:group_id AND `status`!=:status ORDER BY `name` ASC';
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
					":type"=>'group', 
					":group_id"=>0,
					":status"=>1
				));
				$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);

				$model_admin_menageemails = new model_admin_menageemails();

				foreach($fetch as $f){
					$num = $model_admin_menageemails->countinsideemails($this->c,$f['id']);
					$out .= '<option value="'.(int)$f['id'].'">'.htmlentities($f['name']).' ( '.$num.' )</option>'; 	
				}
			}catch(Exception $e){
				$out = "Error loading newsletter groups !";
			}
		}
		echo $out;
	}
	
	function __destruct(){

	}

}
?>