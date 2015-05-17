<?php if(!defined("DIR")){ exit(); }
class model_admin_addpage extends connection{
	public $outMessage = 2;
	function __construct(){

	}

	public function add($c){
		$conn = $this->conn($c);
		$slug_generation = new slug_generation();
		if($_POST['slug']){
			$slug = $_POST['slug']."/".$slug_generation->generate($_POST['friendlyurl']);	
		}else{
			$slug = $slug_generation->generate($_POST['friendlyurl']);
		}
		if(
			isset($_POST['date']) && 
			isset($_POST['expiredate']) && 
			isset($_POST['title']) && 
			isset($_POST['shorttitle']) && 
			isset($_POST['friendlyurl']) && 
			isset($_POST['page_type']) && 
			isset($_POST['description']) && 
			isset($_POST['pagecontent']) && 
			isset($_POST['redirectLink']) && 
			isset($_POST['keywords']) && 
			isset($_POST['videourl']) && 
			isset($_POST['visibility']) && 
			$this->check_friendly_url($c,$slug)
		){
			// check if super exists
			$check_super = new check_super();
			$super = $check_super->super($c);
			if(
				$this->noEmpty($_POST['date']) && 
				$this->noEmpty($_POST['expiredate']) && 
				$this->noEmpty($_POST['title']) && 
				$this->noEmpty($_POST['shorttitle']) && 
				$this->noEmpty($_POST['friendlyurl']) && 
				$this->noEmpty($_POST['page_type']) && 
				$this->noEmpty($_POST['visibility']) && 
				$super 
			){
				//select max idx
				$sql_max = 'SELECT MAX(`idx`)+1 AS maxid FROM `studio404_pages`';
				$query = $conn->query($sql_max);
				$u_row = $query->fetch(PDO::FETCH_ASSOC);
				$maxid = ($u_row['maxid']) ? $u_row['maxid'] : 1;

				$sql_max_pos = 'SELECT MAX(`position`)+1 AS maxpos FROM `studio404_pages` WHERE `cid`=:cid AND `status`!=:status';
				$prepare = $conn->prepare($sql_max_pos);
				$subid = (isset($_GET['sub']) && is_numeric($_GET['sub'])) ? $_GET['sub'] : '0';
				if(!isset($_GET['sub'])){ $subid = $_GET['super']; }
				$prepare->execute(array( 
					":cid"=>$subid, 
					":status"=>1 
				)); 
				$u_row2 = $prepare->fetch(PDO::FETCH_ASSOC);
				$maxpos = ($u_row2['maxpos']) ? $u_row2['maxpos'] : 1;

				$visibility = ($_POST['visibility']=="true") ? "2" : "1";
				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$lang_query = $model_admin_selectLanguage->select_languages($c);
				$cid = (isset($_GET['sub'])) ? $_GET['sub'] : $_GET['super'];
				if(!$cid){ $cid = 0; }
				if(isset($_POST['date'])){ $datex = strtotime($_POST['date']); }
				else{ $datex=time(); }
				if(isset($_POST['expiredate'])){ $expiredate = strtotime($_POST['expiredate']); }
				else{ $expiredate=time(); }
				
				$background = '';
				if(isset($_POST['background'])){
					$expl = explode("/",$_POST['background']);				
					$from = DIR.$expl[1]."/".end($expl);
					$To = DIR.'files/background/'.end($expl);
					if(file_exists($from)){	
						if(@copy($from,$To)){
							@unlink($from);
							$background = explode("/home/geoweb/developer.404.ge",$To);
							$background = $background[1];
						}
					}				
				}
				/*
				** media maxidx and max position
				*/
				//select max idx
				$sqlm = 'SELECT MAX(`idx`)+1 AS maxid FROM `studio404_gallery`';
				$querym = $conn->query($sqlm);
				$rowm = $querym->fetch(PDO::FETCH_ASSOC);
				$maxidm = ($rowm['maxid']) ? $rowm['maxid'] : 1;

				$sql_max_posm = 'SELECT MAX(`position`)+1 AS maxpos FROM `studio404_gallery` WHERE `status`!=:status';
				$preparem = $conn->prepare($sql_max_posm);
				$preparem->execute(array( 
					":status"=>1 
				));
				$row2m = $preparem->fetch(PDO::FETCH_ASSOC);
				$maxposm = ($row2m['maxpos']) ? $row2m['maxpos'] : 1;	

				foreach($lang_query as $lang_row){
					$redirectlink = ($_POST['redirectLink']) ? $_POST['redirectLink'] : "false";
					$sql = 'INSERT INTO `studio404_pages` SET 
							`idx`=:idx,
							`cid`=:cid, 
							`subid`=:subid, 
							`date`=:datex,
							`expiredate`=:expiredate,
							`menu_type`=:menu_type, 
							`page_type`=:page_type, 
							`title`=:title, 
							`shorttitle`=:shorttitle, 
							`description`=:description, 
							`text`=:textx,
							`redirectlink`=:redirectlink, 
							`keywords`=:keywords,
							`background`=:background, 
							`videourl`=:videourl, 
							`slug`=:slug, 
							`insert_admin`=:insert_admin, 
							`lang`=:lang, 
							`itemperpage`=:itemperpage, 
							`visibility`=:visibility, 
							`position`=:position, 
							`status`=:status
					';
					$insert = $conn->prepare($sql);
					
					
					$insert->execute(array(
						":idx"=>$maxid,
						":cid"=>$cid,
						":subid"=>$subid, 
						":datex"=>$datex,
						":expiredate"=>$expiredate,
						":menu_type"=>"sub",
						":page_type"=>$_POST['page_type'],
						":title"=>$_POST['title'],
						":shorttitle"=>$_POST['shorttitle'],
						":description"=>$_POST['description'],
						":textx"=>$_POST['pagecontent'],
						":redirectlink"=>$redirectlink,
						":keywords"=>$_POST['keywords'],
						":background"=>$background,
						":videourl"=>$_POST['videourl'],
						":slug"=>$slug,
						":insert_admin"=>$_SESSION["user404_id"], 
						":lang"=>$lang_row['id'],
						":itemperpage"=>0, 
						":visibility"=>$visibility,
						":position"=>$maxpos,
						":status"=>0
					));

					//insert media
					$this->insertmedia($c,$maxid,$lang_row['id'],$maxidm,$maxposm);
					if($_POST['page_type']=="newspage" || $_POST['page_type']=="catalogpage" || $_POST['page_type']=="eventpage" || $_POST["page_type"]=="publicationpage" || $_POST["page_type"]=="teampage"){
						$this->insertmodule($c,$maxid,$lang_row['id'],$_POST['page_type']);
					}

					if($_POST['page_type']=="photogallerypage" || $_POST['page_type']=="videogallerypage"){
						$this->insertmediamodule($c,$maxid,$lang_row['id'],$_POST['page_type']);
					}

					if($_POST['page_type']=="custompage"){
						$this->create_custom_page($c,$slug);
					}

				}
				$this->outMessage = 1;
			}
		}
		return $this->outMessage;
	}


	public function create_custom_page($c,$s){
		$custom_dir = "controller/custom/";
		$s = str_replace("-", "", $s);
		$custom_file = $custom_dir.$s.".php";
		$custom_file_website = $c["website.directory"]."/".$s.".php";
		if(!file_exists($custom_file) && !file_exists($custom_file_website)){
			$controller_write = '<?php if(!defined("DIR")){ exit(); }
			class '.$s.'{
				function __construct($c){
					$this->template($c,"'.$s.'");
				}
				
				public function template($c,$page){
					$include = WEB_DIR."/'.$s.'.php";
					if(file_exists($include)){
					/* 
					** Here goes any code developer wants to 
					*/
					@include($include);
					}else{
						$controller = new error_page(); 
					}
				}
			}
			?>';
			$view_write = 'Template page ... ';
			$file = fopen($custom_file,"w");
			fwrite($file,$controller_write);
			fclose($file);

			$file2 = fopen($custom_file_website,"w");
			fwrite($file2,$view_write);
			fclose($file2);
		}
	}


	public function insertmedia($c,$connect_idx,$lang,$maxid,$maxpos){
		if($_POST['page_type']!="newspage" && $_POST['page_type']!="catalogpage") :
			$conn = $this->conn($c);		
			// insert gallery
			$sql_media = 'INSERT INTO `studio404_gallery` SET 
			`idx`=:idx, 
			`date`=:datex,
			`title`=:title,
			`position`=:position, 
			`lang`=:lang, 
			`status`=:status 
			';
			$prepare_media = $conn->prepare($sql_media);
			$prepare_media->execute(array(
				":idx"=>$maxid, 
				":datex"=>time(),
				":title"=>$_POST['title'], 
				":position"=>$maxpos, 
				":lang"=>$lang, 
				":status"=>0
			));
			// insert gallery attachment
			$sql_media2 = 'INSERT INTO `studio404_gallery_attachment` SET 
			`idx`=:idx, 
			`connect_idx`=:connect_idx, 
			`pagetype`=:pagetype, 
			`lang`=:lang, 
			`status`=:status
			'; 
			$prepare_media2 = $conn->prepare($sql_media2); 
			$prepare_media2->execute(array(
				":idx"=>$maxid, 
				":connect_idx"=>$connect_idx,
				":pagetype"=>$_POST['page_type'], 
				":lang"=>$lang, 
				":status"=>0
			));
		endif;
	}

	public function insertmodule($c,$connect_idx,$lang,$page_type){
			$conn = $this->conn($c);
			try{
				//select max module idx		
				$sqlm = 'SELECT MAX(`idx`) AS maxid FROM `studio404_module` WHERE `lang`=:lang';
				$preparem = $conn->prepare($sqlm);
				$preparem->execute(array(
					":lang"=>$lang
				));
				$fetchm = $preparem->fetch(PDO::FETCH_ASSOC);
			}catch(Exeption $e){

			}
			$maxid = ($fetchm['maxid']) ? ($fetchm['maxid'] + 1) : 1;
			// insert module
			$sql_media = 'INSERT INTO `studio404_module` SET 
			`idx`=:idx, 
			`date`=:datex,
			`title`=:title,
			`lang`=:lang, 
			`status`=:status 
			';
			$prepare_media = $conn->prepare($sql_media);
			$prepare_media->execute(array(
				":idx"=>$maxid, 
				":datex"=>time(),
				":title"=>$_POST['title'], 
				":lang"=>$lang, 
				":status"=>0
			));
			// insert module attachment
			$sql_media2 = 'INSERT INTO `studio404_module_attachment` SET 
			`idx`=:idx, 
			`connect_idx`=:connect_idx, 
			`page_type`=:page_type, 
			`lang`=:lang, 
			`status`=:status
			'; 
			$prepare_media2 = $conn->prepare($sql_media2); 
			$prepare_media2->execute(array(
				":idx"=>$maxid, 
				":connect_idx"=>$connect_idx,
				":page_type"=>$page_type, 
				":lang"=>$lang, 
				":status"=>0
			));
	}

	public function insertmediamodule($c,$connect_idx,$lang,$page_type){
			$conn = $this->conn($c);
			try{
				//select max module idx		
				$sqlm = 'SELECT MAX(`idx`) AS maxid FROM `studio404_media` WHERE `lang`=:lang';
				$preparem = $conn->prepare($sqlm);
				$preparem->execute(array(
					":lang"=>$lang
				));
				$fetchm = $preparem->fetch(PDO::FETCH_ASSOC);
			}catch(Exeption $e){

			}
			$maxid = ($fetchm['maxid']) ? ($fetchm['maxid'] + 1) : 1;
			// insert module
			$sql_media = 'INSERT INTO `studio404_media` SET 
			`idx`=:idx, 
			`date`=:datex,
			`title`=:title,
			`lang`=:lang, 
			`status`=:status 
			';
			$prepare_media = $conn->prepare($sql_media);
			$prepare_media->execute(array(
				":idx"=>$maxid, 
				":datex"=>time(),
				":title"=>$_POST['title'], 
				":lang"=>$lang, 
				":status"=>0
			));
			// insert module attachment
			$sql_media2 = 'INSERT INTO `studio404_media_attachment` SET 
			`idx`=:idx, 
			`connect_idx`=:connect_idx, 
			`page_type`=:page_type, 
			`lang`=:lang, 
			`status`=:status
			'; 
			$prepare_media2 = $conn->prepare($sql_media2); 
			$prepare_media2->execute(array(
				":idx"=>$maxid, 
				":connect_idx"=>$connect_idx,
				":page_type"=>$page_type, 
				":lang"=>$lang, 
				":status"=>0
			));
	}

	public function check_friendly_url($c,$ufu_slug){
		switch($ufu_slug){
			case $c['admin.slug']:
				$out = false;
			break;
			case $c["product.view.pre.slug"]:
				$out = false;
			break;
			case $c["gallery.view.pre.slug"]:
				$out = false;
			break;
			case $c["website.directory"]:
				$out = false;
			break;
			case "admin":
				$out = false;
			break;
			case "_ajax":
				$out = false;
			break;
			case "_plugins":
				$out = false;
			break;
			case "backup":
				$out = false;
			break;
			case "controller":
				$out = false;
			break;
			case "files":
				$out = false;
			break;
			case "files_pre":
				$out = false;
			break;
			case "flash":
				$out = false;
			break;
			case "functions":
				$out = false;
			break;
			case "images":
				$out = false;
			break;
			case "model":
				$out = false;
			break;
			case "paypal":
				$out = false;
			break;
			case "scripts":
				$out = false;
			break;
			case "styles":
				$out = false;
			break;
			case "thumbs":
				$out = false;
			break;
			case "view":
				$out = false;
			break;
			case "ajaxmoveimage":
				$out = false;
			break;
			case "ajaxupload":
				$out = false;
			break;
			case "error_page":
				$out = false;
			break;
			case "invoices":
				$out = false;
			break;
			case "session_timeout":
				$out = false;
			break;
			case "under":
				$out = false;
			break;
			default:
				$out = true;
			break;
		}
		return $out;
	}

	public function noEmpty($str){
		if(empty($str)){
			return false;
		}
		return true;
	}

	function __destruct(){

	}
}
?>