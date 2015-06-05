<?php if(!defined("DIR")){ exit(); }
class model_admin_componentsmodele extends connection{
	public $outMessage = 2;
	function __construct(){

	} 

	public function select_one($c){
		$conn = $this->conn($c);
		$fetch = array();
		try{
			$sql = 'SELECT `title`, `desc`, `url`, `image` FROM `studio404_components_inside` WHERE `idx`=:idx AND `lang`=:lang AND `status`!=:status';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":idx"=>$_GET['id'], 
				":lang"=>LANG_ID, 
				":status"=>1
			));
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		}catch(Exception $e){ }
		return $fetch;
	}

	public function select($c){
		$out = array();		
		if(isset($_GET['search']) && !empty($_GET['search']) ){
			$search='%'.$_GET['search'].'%';
			$search_in = ' AND `title` LIKE :search ';
		}else{ $search='a'; $search_in = ' AND `id`!=:search ';  }

		$sql = 'SELECT `idx`, `title`, `desc`, `url`, `position` FROM `studio404_components_inside` WHERE `cid`=:cid AND `lang`=:lang AND `status`!=:status '.$search_in.' ORDER BY `position` ASC';
		$exe_array = array(
			":cid"=>$_GET['id'], 
			":lang"=>LANG_ID, 
			":status"=>1, 
			":search"=>$search 
		);
		$path = '?action=componentModule&id='.$_GET['id'].'&pn=';
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
			$cname = $this->componentname($c); 
			while($rows = $query->fetch()){
				$out .= '<div class="row">';
				$out .= '<span class="cell">'.$rows['idx'].'</span>';

				$out .= '<span class="cell">';
				if($rows['position']>=2){
					$out .= '<a href="?action=componentModule&id='.$_GET['id'].'&up=true&cidx='.$rows['idx'].'&token='.$_SESSION['token'].'" class="changeposition" title="Move up"><i class="fa fa-arrow-circle-up"></i></a>';
				}
				if($this->maxpos($c)>$rows['position']){
					$out .= '<a href="?action=componentModule&id='.$_GET['id'].'&down=true&cidx='.$rows['idx'].'&token='.$_SESSION['token'].'" class="changeposition" title="Move down"><i class="fa fa-arrow-circle-down"></i></a>';
				}
				$out .= '</span>';
				$out .= '<span class="cell"><a href="?action=editComponentsModule&id='.$rows['idx'].'&token='.$_SESSION['token'].'">'.$rows['title'].'</a></span>';			
				$out .= '<span class="cell">'.$cname.'</span>';
				$out .= '<span class="cell"><a href="'.htmlentities($rows['url']).'" target="_blank">'.htmlentities($rows['url']).'</a></span>';

				$out .= '<span class="cell" style="width:120px;">
						<a href="?action=editComponentsModule&id='.$rows['idx'].'&token='.$_SESSION['token'].'" title="Edit components"><i class="fa fa-pencil-square-o"></i></a>
						<a href="javascript:;" onclick="deleteComfirm(\'?action=componentModule&id='.$_GET['id'].'&commodelid='.$rows['idx'].'&remove=true&token='.$_SESSION['token'].'\')" title="Remove components"><i class="fa fa-times"></i></a>
						</span>';

				$out .= '</div>';
			}
		}catch(Exception $e){
			
		}
		return $out;
	}

	public function componentname($c){
		$conn = $this->conn($c); 
		$sql = 'SELECT `name` FROM `studio404_components` WHERE `id`=:id';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":id"=>$_GET['id']
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC); 
		return $fetch["name"];
	}

	public function add($c){
		$conn = $this->conn($c); 

		//select max idx
		$sqlm = 'SELECT MAX(`idx`)+1 AS maxid FROM `studio404_components_inside`';
		$querym = $conn->query($sqlm);
		$rowm = $querym->fetch(PDO::FETCH_ASSOC);
		$maxidm = ($rowm['maxid']) ? $rowm['maxid'] : 1;
		$cid = $_GET['id']; 

		//select max position
		$sqlp = 'SELECT MAX(`position`)+1 AS maxpos FROM `studio404_components_inside` WHERE `cid`=:cid AND `status`!=:status';
		$preparep = $conn->prepare($sqlp);
		$preparep->execute(array(
			":cid"=>$cid, 
			":status"=>1
		));
		$fetchp = $preparep->fetch(PDO::FETCH_ASSOC);
		$maxpos = ($fetchp['maxpos']) ? $fetchp['maxpos'] : 1;

		$background = '';
		if(isset($_POST['background'])){
			$expl = explode("/",$_POST['background']);				
			$from = DIR.$expl[1]."/".end($expl);
			$To = DIR.'files/background/'.end($expl);
			if(file_exists($from)){	
				if(@copy($from,$To)){
					@unlink($from);
					$background = explode(DIR,$To);
					$background = "/".$background[1];

				}
			}				
		}

		// select languages
		$model_admin_selectLanguage = new model_admin_selectLanguage();
		$lang_query = $model_admin_selectLanguage->select_languages($c);
	
		foreach($lang_query as $lang_row){
			$sql = 'INSERT INTO `studio404_components_inside` SET `idx`=:idx, `cid`=:cid, `title`=:title, `desc`=:description, `image`=:image, `url`=:url, `insert_admin`=:insert_admin, `lang`=:lang, `position`=:position';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":idx"=>$maxidm, 
				":cid"=>$cid, 
				":title"=>$_POST['title'], 
				":description"=>$_POST['shortdesc'], 
				":image"=>$background, 
				":url"=>$_POST['url'], 
				":insert_admin"=>$_SESSION["user404_id"], 
				":lang"=>$lang_row['id'], 
				":position"=>$maxpos 
			)); 
		}
		$this->outMessage = 1;
	}

	public function edit($c){
		$conn = $this->conn($c); 

		if(isset($_POST['background']) && !empty($_POST['background'])){
			$expl = explode("/",$_POST['background']);				
			$from = DIR.$expl[1]."/".end($expl);
			$To = DIR.'files/background/'.end($expl);
			if(file_exists($from)){	
				if(@copy($from,$To)){
					@unlink($from);
					$background = explode(DIR,$To);
					$background = "/".$background[1];
				}
			}
			$sqlb = 'UPDATE `studio404_components_inside` SET `image`=:image WHERE `idx`=:idx AND `lang`=:lang AND `status`!=:status';
			$prepareb = $conn->prepare($sqlb);
			$prepareb->execute(array(
				":image"=>$background, 
				":idx"=>$_GET['id'], 
				":lang"=>LANG_ID, 
				":status"=>1
			));					
		}

		$sql = 'UPDATE `studio404_components_inside` SET `title`=:title, `desc`=:description, `url`=:url WHERE `idx`=:idx AND `lang`=:lang AND `status`!=:status';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":title"=>$_POST['title'], 
			":description"=>$_POST['shortdesc'], 
			":url"=>$_POST['url'], 
			":idx"=>$_GET['id'], 
			":lang"=>LANG_ID, 
			":status"=>1
		)); 

		$this->outMessage = 1;
	}

	public function removeMe($c){
		$conn = $this->conn($c);
		$componentID = $_GET['commodelid'];
		// select current item position
		$sqlp = 'SELECT `position` FROM `studio404_components_inside` WHERE `idx`=:idx AND `lang`=:lang AND `status`!=:status'; 
		$preparep = $conn->prepare($sqlp);
		$preparep->execute(array(
			":idx"=>$componentID, 
			":lang"=>LANG_ID, 
			":status"=>1
		));
		$fetch = $preparep->fetch(PDO::FETCH_ASSOC);
		$position = $fetch["position"];

		// minus one position in every item which is greater then current position
		$sqlm = 'UPDATE `studio404_components_inside` SET `position`=`position`-1 WHERE `cid`=:cid AND `position`>:current_position AND `status`!=:status';
		$preparem = $conn->prepare($sqlm);
		$preparem->execute(array(
			":cid"=>$_GET['id'], 
			":current_position"=>$position, 
			":status"=>1
		));

		$sql = 'UPDATE `studio404_components_inside` SET `status`=:status WHERE `idx`=:comid AND `status`!=:status';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":status"=>1, 
			":comid"=>$componentID
		));

		$this->outMessage = 1;
	}

	public function maxpos($c){
		$conn = $this->conn($c);
		$sql = 'SELECT MAX(`position`) AS max FROM `studio404_components_inside` WHERE `cid`=:cid AND `status`!=:status';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(":cid"=>$_GET['id'],":status"=>1));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		return $fetch['max'];
	}

	function __destruct(){

	}
}
?>