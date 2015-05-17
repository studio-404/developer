<?php if(!defined("DIR")){ exit(); }
class model_admin_editMenuManagment extends connection{
	public $outMessage;

	function __construct(){

	}

	public function select_editMenuManagment($c){
		$conn = $this->conn($c);
		$out = array();
		$token_get = $_GET["token"];
		$token_session = $_SESSION["token"];
		$edit_id = $_GET["id"];
		if($token_get==$token_session){
			$sql = 'SELECT * FROM `studio404_pages` WHERE `idx`=:idx AND `lang`=:lang_id AND `status`!=:status';
			$exe_array = array(":idx"=>$edit_id,":lang_id"=>LANG_ID, ":status"=>1);
			$query = $conn->prepare($sql);
			$query->execute($exe_array);
			$fetch = $query->fetch(PDO::FETCH_ASSOC);
			return $fetch;
		}		
		return $out;
	}

	public function removeMe($c){
		$conn = $this->conn($c);
		$token_get = $_GET["token"];
		$token_session = $_SESSION["token"];
		if(isset($_GET["remove"]) && isset($_GET['id']) && is_numeric($_GET['id']) && $token_get==$token_session){
			$sql = 'UPDATE `studio404_pages` SET `status`=:status WHERE `idx`=:id';
			$query = $conn->prepare($sql);
			$query->execute(array(
				":status"=>1,
				":id"=>$_GET['id']
			));

			// select current item's position
			$sqlp = 'SELECT `cid`,`position` FROM `studio404_pages` WHERE `idx`=:idx AND `lang`=:lang';
			$preparep = $conn->prepare($sqlp);
			$preparep->execute(array(
				":idx"=>$_GET['id'], 
				":lang"=>LANG_ID
			));
			$fetchp = $preparep->fetch(PDO::FETCH_ASSOC);
			$current_position = $fetchp['position'];
			$current_cid = $fetchp['cid'];

			// minus one position in every item which is greater then current position
			$sqlm = 'UPDATE `studio404_pages` SET `position`=`position`-1 WHERE `cid`=:cid AND `position`>:current_position AND `status`!=:status';
			$preparem = $conn->prepare($sqlm);
			$preparem->execute(array(
				":cid"=>$current_cid, 
				":current_position"=>$current_position, 
				":status"=>1
			));

			$this->outMessage = 1;

		}else{
			$this->outMessage = 2;
		}
	}

	public function edit($c){
		$conn = $this->conn($c);
		$title = $_POST['title'];
		$itemperpage = $_POST['itemperpage'];
		$token = $_GET['token'];
		$token_get = $_GET["token"];
		$token_session = $_SESSION["token"];
		if( $this->noEmpty($title) && isset($_GET['id']) && $this->noEmpty($_GET['id']) && is_numeric($_GET['id']) && $token_get==$token_session){
			
			$sql = 'UPDATE `studio404_pages` SET `title`=:titlex, `itemperpage`=:itemperpage WHERE `idx`=:idx AND `lang`=:lang AND `status`!=:status';
			$query = $conn->prepare($sql);
			$query->execute(array(
			":titlex"=>$title,
			":itemperpage"=>$itemperpage,
			":idx"=>$_GET['id'], 
			":lang"=> LANG_ID,
			":status"=>1 
			));
			$this->outMessage = 1;	
		}else{
			$this->outMessage = 2;
		}
	}

	public function editPage($c){
		$conn = $this->conn($c);
		if(
			isset($_POST['date']) && 
			isset($_POST['expiredate']) && 
			isset($_POST['title']) && 
			isset($_POST['shorttitle']) && 
			isset($_POST['description']) && 
			isset($_POST['pagecontent']) && 
			isset($_POST['redirectLink']) && 
			isset($_POST['keywords']) && 
			isset($_POST['videourl']) && 
			isset($_POST['visibility']) 
		){
			// check if super exists
			$check_super = new check_super();
			$super = $check_super->super($c);
			if(
				$this->noEmpty($_POST['date']) && 
				$this->noEmpty($_POST['expiredate']) && 
				$this->noEmpty($_POST['title']) && 
				$this->noEmpty($_POST['shorttitle']) && 
				$this->noEmpty($_POST['visibility']) && 
				$super 
			){
				$visibility = ($_POST['visibility']=="true") ? "2" : "1";
				
				if(isset($_POST['date'])){ $datex = strtotime($_POST['date']); }
				else{ $datex=time(); } 
				if(isset($_POST['expiredate'])){ $expiredate = strtotime($_POST['expiredate']); }
				else{ $expiredate=time(); } 
				//
				$redirectlink = ($_POST['redirectLink']) ? $_POST['redirectLink'] : "false";
				////////////////////////////////// background start ////////////////////////////
				if(isset($_POST['background']) && !empty($_POST['background'])){
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
				}else{
					$get_background = new get_background();
					$background = $get_background->backgr($_GET['id'],$c);
				}
				$sql_bg = 'UPDATE `studio404_pages` SET 
						`background`=:background 
						WHERE 
						`idx`=:idx AND 
						`status`!=:status
					';
				$update_bg = $conn->prepare($sql_bg);
				$update_bg->execute(array(
						":background"=>$background, 
						":idx"=>$_GET['id'], 
						":status"=>1
				));
				////////////////////////////////// background end ////////////////////////////
				$sql = 'UPDATE `studio404_pages` SET 
						`date`=:datex,
						`expiredate`=:expiredate,
						`title`=:title, 
						`shorttitle`=:shorttitle, 
						`description`=:description, 
						`text`=:textx,
						`redirectlink`=:redirectlink, 
						`keywords`=:keywords,
						`videourl`=:videourl,  
						`visibility`=:visibility 
						WHERE 
						`idx`=:idx AND 
						`lang`=:lang AND 
						`status`!=:status
					';
				$update = $conn->prepare($sql);
				$update->execute(array(
						":datex"=>$datex,
						":expiredate"=>$expiredate,
						":title"=>$_POST['title'],
						":shorttitle"=>$_POST['shorttitle'],
						":description"=>$_POST['description'],
						":textx"=>$_POST['pagecontent'],
						":redirectlink"=>$redirectlink,
						":keywords"=>$_POST['keywords'],
						":videourl"=>$_POST['videourl'], 
						":visibility"=>$visibility, 
						":idx"=>$_GET['id'], 
						":lang"=>LANG_ID, 
						":status"=>1
				));
				$this->outMessage = 1;
			}else{
				$this->outMessage = 2;
			}
		}else{
			$this->outMessage = 2;
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