<?php if(!defined("DIR")){ exit(); }
class model_admin_menumanagment extends connection{
	public $outMessage;
	function __construct(){

	}

	public function select_menus($c){
		$out = array();		
		if(isset($_GET['search']) && !empty($_GET['search']) ){
			$sql = 'SELECT * FROM `studio404_pages` WHERE `menu_type`=:menu_type AND `status`!=:status AND `title` LIKE :title AND `lang`=:lang';
			$search = '%'.$_GET['search'].'%';
			$exe_array = array(":menu_type"=>"super",":status"=>1,":title"=>$search, ":lang"=>LANG_ID);
		}else{
			$sql = 'SELECT * FROM `studio404_pages` WHERE `menu_type`=:menu_type AND `status`!=:status AND `lang`=:lang';
			$exe_array = array(":menu_type"=>"super", ":status"=>1, ":lang"=>LANG_ID);
		}		
		$path = '?action=menuManagment&pn=';
		$itemsPerPage = 10;
		$pager = new pager();
		$pager = $pager->action($c,$sql,$exe_array,$path,$itemsPerPage);		
		$out['table'] = $this->table($c,$pager[0],$exe_array);
		$out['pager'] = $pager[1];
		return $out;
	}

	public function select_sub($c){
		$out = array();
		$conn = $this->conn($c);
		$sql = 'SELECT * FROM `studio404_pages` WHERE `menu_type`!=:menu_type AND `cid`=:cid AND `status`!=:status AND `lang`=:lang ORDER BY `position` ASC';
		$exe_array = array(":cid"=>$_GET['super'], ":menu_type"=>"super", ":status"=>1, ":lang"=>LANG_ID);
		$out['table'] = $this->table_sub($c,$sql,$exe_array);
		$out['pager'] = '';
		return $out;
	}

	public function add($c){
		$conn = $this->conn($c);
		$token_get = $_GET["token"];
		$token_session = $_SESSION["token"];
		if($this->noEmpty($_POST['title']) && $token_get==$token_session)
		{ 
			//select max idx
			try{
				$sql_max = 'SELECT MAX(`idx`)+1 AS maxid FROM `studio404_pages`';
				$query = $conn->query($sql_max);
				$u_row = $query->fetch(PDO::FETCH_ASSOC);
			}catch(Exception $e){ $maxid = false; }
			$maxid = ($u_row['maxid']) ? $u_row['maxid'] : 1;

			$model_admin_selectLanguage = new model_admin_selectLanguage();
			$lang_query = $model_admin_selectLanguage->select_languages($c);

			foreach($lang_query as $lang_row){				
				$sql = 'INSERT INTO `studio404_pages` SET 
						`idx`=:idx, 
						`cid`=:cid, 
						`date`=:datex, 
						`menu_type`=:menu_type, 
						`page_type`=:page_type, 
						`title`=:title, 
						`text`=:textx, 
						`slug`=:slug, 
						`lang`=:lang, 
						`itemperpage`=:itemperpage, 
						`insert_admin`=:insert_admin, 
						`visibility`=:visibility, 
						`position`=:position, 
						`status`=:status';
				$insert = $conn->prepare($sql);
				$insert->execute(array(
					":idx"=>$maxid,
					":cid"=>"0",
					":datex"=>time(),
					":menu_type"=>"super",
					":page_type"=>"false",
					":title"=>$_POST['title'],
					":textx"=>"false",
					":slug"=>"false",
					":lang"=>$lang_row['id'],
					":itemperpage"=>$_POST['itemperpage'], 
					":insert_admin"=>$_SESSION["user404_id"],
					":visibility"=>1,
					":position"=>1,
					":status"=>0
				));
			}
			$this->outMessage = 1;
		}else{
			$this->outMessage = 2;
		}
		return $this->outMessage;
	}

	private function noEmpty($foo){
		if(empty($foo)){
			return false;
		}
		return true;
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
				$out .= '<span class="cell primary"><a href="?action=sitemap&super='.$rows['idx'].'">'.$rows['title'].'</a></span>';
				$out .= '<span class="cell">'.$rows['itemperpage'].'</span>';
				$out .= '<span class="cell">
						<a href="?action=editMenuManagment&id='.$rows['idx'].'&token='.$_SESSION['token'].'" title="Edit page managment"><i class="fa fa-pencil-square-o"></i></a>
						<a href="javascript:;" onclick="deleteComfirm(\'?action=menuManagment&id='.$rows['idx'].'&remove=true&token='.$_SESSION['token'].'\')" title="Remove page managment"><i class="fa fa-times"></i></a>
				</span>';
				$out .= '</div>';
			}
		}catch(Exception $e){
			
		}
		return $out;
	}

	public function table_sub($c,$sql,$exe_array,$colour=0,$tab=0){
		$out = '';
		$conn = $this->conn($c);
		$query = $conn->prepare($sql);
		$colorFull = array("","#ffffff","#f7f6fc","#edebf3","#e3e2eb","#cccbd3","#bebdc6");
		$tabSpace = array("","<div class=\"tab-1\"></div>","<div class=\"tab-2\"></div>","<div class=\"tab-3\"></div>","<div class=\"tab-4\"></div>","<div class=\"tab-5\"></div>","<div class=\"tab-6\"></div>");
		
		$colour++;
		$tab++;
		try{
			$query->execute($exe_array);
			$token = md5(sha1(time()));
			$_SESSION['token'] = $token;
			
			while($rows = $query->fetch()){
				$out .= '<div class="row lev-'.$rows['cid'].'" style="background-color:'.$colorFull[$colour].'">';
				$visibilityx = ($rows['visibility']==1) ? "red" : "green";
				$link_visibility = "?action=sitemap&super=".$_GET['super']."&sub=".$rows['idx']."&visibilitychnage=true&token=".$_SESSION['token'];
				$out .= '<span class="cell primary"><a href="'.$link_visibility.'" style="color:'.$visibilityx.'" title="Change visibility"><i class="fa fa-dot-circle-o"></i></a></span>';
				
				$out .= '<span class="cell">';
				if($rows['position']>=2){
					$out .= '<a href="?action=sitemap&super='.$_GET['super'].'&up=true&id='.$rows['idx'].'&token='.$_SESSION['token'].'" class="changeposition" title="Move up"><i class="fa fa-arrow-circle-up"></i></a>';
				}
				//$out .= $this->maxpos($c,$rows['cid']);
				if($this->maxpos($c,$rows['cid'])>$rows['position']){
					$out .= '<a href="?action=sitemap&super='.$_GET['super'].'&down=true&id='.$rows['idx'].'&token='.$_SESSION['token'].'" class="changeposition" title="Move down"><i class="fa fa-arrow-circle-down"></i></a>';
				}
				$out .= '</span>';
				
				$out .= '<span class="cell">'.$tabSpace[$tab].'<a href="?action=editSitemap&super='.$_GET['super'].'&id='.$rows['idx'].'&token='.$_SESSION['token'].'">'.$rows['title'].'</a><br /> <a href="'.WEBSITE.LANG."/".$rows['slug'].'" class="slugs" target="_blank">'.WEBSITE.LANG."/".$rows['slug'].'</a></span>';
				$out .= '<span class="cell">'.$rows['page_type'].'</span>';
				$out .= '<span class="cell">'.$rows['idx'].'</span>';

				if($rows['page_type']!="newspage" && $rows['page_type']!="eventpage" && $rows['page_type']!="publicationpage" && $rows['page_type']!="teampage" && $rows['page_type']!="catalogpage" && $rows['page_type']!="photogallerypage" && $rows['page_type']!="videogallerypage"){
					$insert_image_link = '<a href="?action=editSitemap&super='.$_GET['super'].'&id='.$rows['idx'].'&token='.$_SESSION['token'].'#tabs-3" title="Attach pictures"> <i class="fa fa-picture-o"></i></a>';
					$insert_image_link .= '<a href="?action=editSitemap&super='.$_GET['super'].'&id='.$rows['idx'].'&token='.$_SESSION['token'].'#tabs-4" title="Attach files"> <i class="fa fa-file"></i></a>';
				}else if($rows['page_type']=="newspage" || $rows['page_type']=="eventpage"){					
					$insert_image_link = '<a href="?action=newsModule&type='.$rows['page_type'].'&id='.$rows['idx'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'" title="Manage news"> <i class="fa fa-newspaper-o"></i></a>';
				}else if($rows['page_type']=="catalogpage" || $rows['page_type']=="publicationpage" || $rows['page_type']=="teampage"){			
					$insert_image_link = '<a href="?action=catalogModule&type='.$rows['page_type'].'&id='.$rows['idx'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'" title="Manage catalog"> <i class="fa fa-list"></i></a>';
				}else if($rows['page_type']=="photogallerypage"){			
					$insert_image_link = '<a href="?action=gallery&type=photogallerypage&id='.$rows['idx'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'" title="Manage gallery folder"> <i class="fa fa-picture-o"></i></a>';
				}else if($rows['page_type']=="videogallerypage"){			
					$insert_image_link = '<a href="?action=gallery&type=videogallerypage&id='.$rows['idx'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'" title="Manage gallery folder"> <i class="fa fa-file-video-o"></i></a>';
				}else{ $insert_image_link=''; }

				$out .= '<span class="cell">
						<a href="'.WEBSITE.LANG."/".$rows['slug'].'" target="_blank" title="Check page"><i class="fa fa-eye"></i></a>
						<a href="?action=editSitemap&super='.$_GET['super'].'&id='.$rows['idx'].'&token='.$_SESSION['token'].'" title="Edit page"><i class="fa fa-pencil-square-o"></i></a>
						'.$insert_image_link.'
						<a href="?action=addSitemapItem&super='.$_GET['super'].'&sub='.$rows['idx'].'" title="Add sub page"><i class="fa fa-plus"></i></a>
						<a href="javascript:;" onclick="deleteComfirm(\'?action=sitemap&super='.$_GET['super'].'&id='.$rows['idx'].'&remove=true&token='.$_SESSION['token'].'\')" title="Remove page"><i class="fa fa-times"></i></a>
				</span>';
				$out .= '</div>';
				$exe_array2 = array(":cid"=>$rows['idx'], ":menu_type"=>"super", ":status"=>1, ":lang"=>LANG_ID);
				$out .= $this->table_sub($c,$sql,$exe_array2,$colour,$tab);
			}
		}catch(Exception $e){
			
		}
		return $out;
	}

	public function maxpos($c,$cid){
		$conn = $this->conn($c);
		$sql = 'SELECT MAX(`position`) AS max FROM `studio404_pages` WHERE `cid`=:cid AND `status`!=:status';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(":cid"=>$cid,":status"=>1));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		return $fetch['max'];
	}

	function __destruct(){

	}
}
?>