<?php if(!defined("DIR")){ exit(); }
class model_admin_breadcrups extends connection{
	public $breadcrups="";
	function __construct(){
		
	}

	public function get($c){
		if(isset($_GET['action']) && !empty($_GET['action'])){
			$this->breadcrups = '<div class="breadcrumb flat">';
			$this->breadcrups .= '<a href="?action=welcome">Home <i class="fa fa-caret-right"></i></a>';
			switch($_GET['action'])
			{
				case "menuManagment":
				$this->breadcrups .= '<a href="?action=menuManagment">Page managment <i class="fa fa-caret-right"></i></a>';
				break;
				case "addPageManagment":
				$this->breadcrups .= '<a href="?action=menuManagment">Page managment <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=addPageManagment&token='.$_GET['token'].'">Add page <i class="fa fa-caret-right"></i></a>';
				break;
				case "editMenuManagment":
				$this->breadcrups .= '<a href="?action=menuManagment">Page managment <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=editMenuManagment&id='.$_GET['id'].'&token='.$_GET['token'].'">Edit page <i class="fa fa-caret-right"></i></a>';
				break;
				case "sitemap":
				$this->breadcrups .= '<a href="?action=menuManagment">Page managment <i class="fa fa-caret-right"></i></a>';
				$getsupername = $this->getsupername($c);
				$this->breadcrups .= '<a href="?action=sitemap&super='.$_GET['super'].'">'.$getsupername.' <i class="fa fa-caret-right"></i></a>';
				break;
				case "addSitemapItem":
				$this->breadcrups .= '<a href="?action=menuManagment">Page managment <i class="fa fa-caret-right"></i></a>';
				$getsupername = $this->getsupername($c);
				$this->breadcrups .= '<a href="?action=sitemap&super='.$_GET['super'].'">'.$getsupername.' <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=addSitemapItem&super='.$_GET['super'].'">Add page <i class="fa fa-caret-right"></i></a>';
				break;
				case "editSitemap":
				$this->breadcrups .= '<a href="?action=menuManagment">Page managment <i class="fa fa-caret-right"></i></a>';
				$getsupername = $this->getsupername($c);
				$this->breadcrups .= '<a href="?action=sitemap&super='.$_GET['super'].'">'.$getsupername.' <i class="fa fa-caret-right"></i></a>';
				$getpagetitle = $this->getpagetitle($c);
				$this->breadcrups .= '<a href="?action=editSitemap&super='.$_GET['super'].'&id='.$_GET['id'].'&token='.$_SESSION['token'].'">'.$getpagetitle.' <i class="fa fa-caret-right"></i></a>';
				break;
				case "newsModule":
				$this->breadcrups .= '<a href="?action=menuManagment">Page managment <i class="fa fa-caret-right"></i></a>';
				$getsupername = $this->getsupername($c);
				$this->breadcrups .= '<a href="?action=sitemap&super='.$_GET['super'].'">'.$getsupername.' <i class="fa fa-caret-right"></i></a>';
				$getpagetitle = $this->getpagetitle($c);
				$this->breadcrups .= '<a href="?action=editSitemap&super='.$_GET['super'].'&id='.$_GET['id'].'&token='.$_SESSION['token'].'">'.$getpagetitle.' <i class="fa fa-caret-right"></i></a>';	
				$this->breadcrups .= '<a href="?action=newsModule&type=newspage&id='.$_GET['id'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'">Manage <i class="fa fa-caret-right"></i></a>';
				break;
				case "addNews":
				$this->breadcrups .= '<a href="?action=menuManagment">Page managment <i class="fa fa-caret-right"></i></a>';
				$getsupername = $this->getsupername($c);
				$this->breadcrups .= '<a href="?action=sitemap&super='.$_GET['super'].'">'.$getsupername.' <i class="fa fa-caret-right"></i></a>';
				$getpagetitle = $this->getpagetitle($c);
				$this->breadcrups .= '<a href="?action=editSitemap&super='.$_GET['super'].'&id='.$_GET['newsidx'].'&token='.$_SESSION['token'].'">'.$getpagetitle.' <i class="fa fa-caret-right"></i></a>';	
				$this->breadcrups .= '<a href="?action=newsModule&type=newspage&id='.$_GET['newsidx'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'">Manage <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=addNews&newsidx='.$_GET['newsidx'].'&super='.$_GET['super'].'">Add news <i class="fa fa-caret-right"></i></a>';
				break;
				case "editNewsItem":
				$this->breadcrups .= '<a href="?action=menuManagment">Page managment <i class="fa fa-caret-right"></i></a>';
				$getsupername = $this->getsupername($c);
				$this->breadcrups .= '<a href="?action=sitemap&super='.$_GET['super'].'">'.$getsupername.' <i class="fa fa-caret-right"></i></a>';
				$getpagetitle = $this->getpagetitle($c);
				$this->breadcrups .= '<a href="?action=editSitemap&super='.$_GET['super'].'&id='.$_GET['id'].'&token='.$_SESSION['token'].'">'.$getpagetitle.' <i class="fa fa-caret-right"></i></a>';	
				$this->breadcrups .= '<a href="?action=newsModule&type=newspage&id='.$_GET['id'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'">Manage <i class="fa fa-caret-right"></i></a>';
				$getnewstitle = $this->getnewstitle($c);
				$this->breadcrups .= '<a href="?action=editNewsItem&id='.$_GET['id'].'&newsidx='.$_GET['newsidx'].'&super='.$_GET['super'].'">'.$getnewstitle.' <i class="fa fa-caret-right"></i></a>';
				break;
				case "userList":
				$this->breadcrups .= '<a href="?action=userList">User list <i class="fa fa-caret-right"></i></a>';
				break;
				case "addAdmin":
				$this->breadcrups .= '<a href="?action=userList">User list <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=addAdmin">Add admin <i class="fa fa-caret-right"></i></a>';
				break;
				case "editprofile":
				$this->breadcrups .= '<a href="?action=userList">User list <i class="fa fa-caret-right"></i></a>';
				$getadminname = $this->getadminname($c);
				$this->breadcrups .= '<a href="?action=editprofile&id='.$_GET['id'].'&token='.$_SESSION['token'].'">'.$getadminname.' <i class="fa fa-caret-right"></i></a>';
				break;
				case "userRights":
				$this->breadcrups .= '<a href="?action=userRights">User right groups <i class="fa fa-caret-right"></i></a>';
				break;
				case "addAdminRights":
				$this->breadcrups .= '<a href="?action=userRights">User right groups <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=addAdminRights">Add right groups <i class="fa fa-caret-right"></i></a>';
				break;
				case "editAdminRights":
				$this->breadcrups .= '<a href="?action=userRights">User right groups <i class="fa fa-caret-right"></i></a>';
				$getrightname = $this->getrightname($c);
				$this->breadcrups .= '<a href="?action=editAdminRights">'.$getrightname.' <i class="fa fa-caret-right"></i></a>';
				break;
				case "textConverter":
				$this->breadcrups .= '<a href="?action=textConverter">Text converter <i class="fa fa-caret-right"></i></a>';
				break;
				case "log":
				$this->breadcrups .= '<a href="?action=log">Log <i class="fa fa-caret-right"></i></a>';
				break;
				case "profileSettings":
				$this->breadcrups .= '<a href="?action=profileSettings">Profile sessings <i class="fa fa-caret-right"></i></a>';
				break;
				case "changePassword":
				$this->breadcrups .= '<a href="?action=changePassword">Change password <i class="fa fa-caret-right"></i></a>';
				break;
				case "catalogModule":
				$this->breadcrups .= '<a href="?action=menuManagment">Page managment <i class="fa fa-caret-right"></i></a>';
				$getsupername = $this->getsupername($c);
				$this->breadcrups .= '<a href="?action=sitemap&super='.$_GET['super'].'">'.$getsupername.' <i class="fa fa-caret-right"></i></a>';
				$getpagetitle = $this->getpagetitle($c);
				$this->breadcrups .= '<a href="?action=editSitemap&super='.$_GET['super'].'&id='.$_GET['id'].'&token='.$_SESSION['token'].'">'.$getpagetitle.' <i class="fa fa-caret-right"></i></a>';	
				$this->breadcrups .= '<a href="?action=catalogModule&type=catalogpage&id='.$_GET['id'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'">Manage <i class="fa fa-caret-right"></i></a>';
				break;
				case "addCatalog":
				$this->breadcrups .= '<a href="?action=menuManagment">Page managment <i class="fa fa-caret-right"></i></a>';
				$getsupername = $this->getsupername($c);
				$this->breadcrups .= '<a href="?action=sitemap&super='.$_GET['super'].'">'.$getsupername.' <i class="fa fa-caret-right"></i></a>';
				$getpagetitle = $this->getpagetitle($c);
				$this->breadcrups .= '<a href="?action=editSitemap&super='.$_GET['super'].'&id='.$_GET['catalogidx'].'&token='.$_SESSION['token'].'">'.$getpagetitle.' <i class="fa fa-caret-right"></i></a>';	
				$this->breadcrups .= '<a href="?action=catalogModule&type=catalogpage&id='.$_GET['catalogidx'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'">Manage <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=addCatalog&catalogidx='.$_GET['catalogidx'].'&super='.$_GET['super'].'">Add item <i class="fa fa-caret-right"></i></a>';
				break;
				case "editCatalogItem":
				$this->breadcrups .= '<a href="?action=menuManagment">Page managment <i class="fa fa-caret-right"></i></a>';
				$getsupername = $this->getsupername($c);
				$this->breadcrups .= '<a href="?action=sitemap&super='.$_GET['super'].'">'.$getsupername.' <i class="fa fa-caret-right"></i></a>';
				$getpagetitle = $this->getpagetitle($c);
				$this->breadcrups .= '<a href="?action=editSitemap&super='.$_GET['super'].'&id='.$_GET['id'].'&token='.$_SESSION['token'].'">'.$getpagetitle.' <i class="fa fa-caret-right"></i></a>';	
				$this->breadcrups .= '<a href="?action=catalogModule&type=catalogpage&id='.$_GET['id'].'&super='.$_GET['super'].'&token='.$_GET['token'].'">Manage <i class="fa fa-caret-right"></i></a>';
				$getnewstitle = $this->getnewstitle($c);
				$this->breadcrups .= '<a href="?action=editCatalogItem&id='.$_GET['id'].'&cidx='.$_GET['cidx'].'&super='.$_GET['super'].'">'.$getnewstitle.' <i class="fa fa-caret-right"></i></a>';
				break;
				case "catalogMoreInfo":
				$this->breadcrups .= '<a href="?action=catalogMoreInfo">Catalog more info <i class="fa fa-caret-right"></i></a>';
				break;
				case "addCatalogMoreInfo":
				$this->breadcrups .= '<a href="?action=catalogMoreInfo">Catalog more info <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=addCatalogMoreInfo">Add catalog more info <i class="fa fa-caret-right"></i></a>';
				break;
				case "editCatalogMoreInfo":
				$this->breadcrups .= '<a href="?action=catalogMoreInfo">Catalog more info <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=editCatalogMoreInfo">Edit catalog more info <i class="fa fa-caret-right"></i></a>';
				break;
				case "components":
				$this->breadcrups .= '<a href="?action=components">Components <i class="fa fa-caret-right"></i></a>';
				break;
				case "addComponents":
				$this->breadcrups .= '<a href="?action=components">Components <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=addComponents">Add components <i class="fa fa-caret-right"></i></a>';
				break;
				case "editComponents":
				$this->breadcrups .= '<a href="?action=components">Components <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=editComponents&id='.$_GET['id'].'&token='.$_GET['token'].'">Edit components <i class="fa fa-caret-right"></i></a>';
				break;
				case "componentModule":
				$this->breadcrups .= '<a href="?action=components">Components <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=editComponents&id='.$_GET['id'].'&token='.$_SESSION['token'].'">Edit components <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=componentModule&id='.$_GET['id'].'&token='.$_SESSION['token'].'">Components module <i class="fa fa-caret-right"></i></a>';
				break;
				case "addComponentsModule":
				$this->breadcrups .= '<a href="?action=components">Components <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=editComponents&id='.$_GET['id'].'&token='.$_SESSION['token'].'">Edit components <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=componentModule&id='.$_GET['id'].'&token='.$_SESSION['token'].'">Components module <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=addComponentsModule&id='.$_GET['id'].'">Add components module <i class="fa fa-caret-right"></i></a>';
				break;
				case "editComponentsModule":
				$this->breadcrups .= '<a href="?action=components">Components <i class="fa fa-caret-right"></i></a>';
				$componentId = $this->getComponentCid($c,$_GET['id']);
				$this->breadcrups .= '<a href="?action=editComponents&id='.$componentId.'&token='.$_SESSION['token'].'">Edit components <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=componentModule&id='.$componentId.'&token='.$_SESSION['token'].'">Components module <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=editComponentsModule&id='.$_GET['id'].'">Edit components module <i class="fa fa-caret-right"></i></a>';
				break;
				case "languages":
				$this->breadcrups .= '<a href="?action=languages">Languages <i class="fa fa-caret-right"></i></a>';
				break;
				case "addlanguage":
				$this->breadcrups .= '<a href="?action=languages">Languages <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=addlanguage">Add language <i class="fa fa-caret-right"></i></a>';
				break;
				case "editLanguage":
				$this->breadcrups .= '<a href="?action=languages">Languages <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=editLanguage">Edit language <i class="fa fa-caret-right"></i></a>';
				break;
				case "languageData":
				$this->breadcrups .= '<a href="?action=languages">Languages <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=languageData">Language data<i class="fa fa-caret-right"></i></a>';
				break;
				case "addlanguageData":
				$this->breadcrups .= '<a href="?action=languages">Languages <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=languageData">Language data<i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=addlanguageData">Add language data<i class="fa fa-caret-right"></i></a>';
				break;
				case "editLanguageData":
				$this->breadcrups .= '<a href="?action=languages">Languages <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=languageData">Language data<i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=editLanguageData&id='.$_GET['id'].'&token='.$_SESSION['token'].'">Edit language data<i class="fa fa-caret-right"></i></a>';
				break;
				case "invoices":
				$this->breadcrups .= '<a href="?action=invoices">invoices <i class="fa fa-caret-right"></i></a>';
				break;
				case "addInvoice":
				$this->breadcrups .= '<a href="?action=invoices">invoices <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=addInvoice">Add invoice <i class="fa fa-caret-right"></i></a>';
				break;
				case "editInvoice":
				$this->breadcrups .= '<a href="?action=invoices">invoices <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=editInvoice&id='.$_GET["id"].'&token='.$_SESSION["token"].'">edit invoice <i class="fa fa-caret-right"></i></a>';
				break;
				case "gallery":
				$this->breadcrups .= '<a href="?action=menuManagment">Page managment <i class="fa fa-caret-right"></i></a>';
				$getsupername = $this->getsupername($c);
				$this->breadcrups .= '<a href="?action=sitemap&super='.$_GET['super'].'">'.$getsupername.' <i class="fa fa-caret-right"></i></a>';
				$getpagetitle = $this->getpagetitle($c);
				$this->breadcrups .= '<a href="?action=editSitemap&super='.$_GET['super'].'&id='.$_GET['id'].'&token='.$_SESSION['token'].'">'.$getpagetitle.' <i class="fa fa-caret-right"></i></a>';	
				$this->breadcrups .= '<a href="?action=gallery&type=photogallerypage&id='.$_GET['id'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'">Manage gallery folder <i class="fa fa-caret-right"></i></a>';
				break;
				case "addGallery":
				$this->breadcrups .= '<a href="?action=menuManagment">Page managment <i class="fa fa-caret-right"></i></a>';
				$getsupername = $this->getsupername($c);
				$this->breadcrups .= '<a href="?action=sitemap&super='.$_GET['super'].'">'.$getsupername.' <i class="fa fa-caret-right"></i></a>';
				$getpagetitle = $this->getpagetitle($c);
				$this->breadcrups .= '<a href="?action=editSitemap&super='.$_GET['super'].'&id='.$_GET['mediaidx'].'&token='.$_SESSION['token'].'">'.$getpagetitle.' <i class="fa fa-caret-right"></i></a>';	
				$this->breadcrups .= '<a href="?action=gallery&type=photogallerypage&id='.$_GET['mediaidx'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'">Manage gallery folder <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=addGallery&mediaidx='.$_GET['mediaidx'].'&super='.$_GET['super'].'">Add gallery <i class="fa fa-caret-right"></i></a>';
				break;
				case "editMediaItem":
				$this->breadcrups .= '<a href="?action=menuManagment">Page managment <i class="fa fa-caret-right"></i></a>';
				$getsupername = $this->getsupername($c);
				$this->breadcrups .= '<a href="?action=sitemap&super='.$_GET['super'].'">'.$getsupername.' <i class="fa fa-caret-right"></i></a>';
				$getpagetitle = $this->getpagetitle($c);
				$this->breadcrups .= '<a href="?action=editSitemap&super='.$_GET['super'].'&id='.$_GET['id'].'&token='.$_SESSION['token'].'">'.$getpagetitle.' <i class="fa fa-caret-right"></i></a>';	
				$this->breadcrups .= '<a href="?action=gallery&type=photogallerypage&id='.$_GET['id'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'">Manage gallery folder <i class="fa fa-caret-right"></i></a>';
				$this->breadcrups .= '<a href="?action=editMediaItem&id='.$_GET["id"].'&midx='.$_GET['midx'].'&super='.$_GET['super'].'&token='.$_SESSION["token"].'">Edit gallery folder item <i class="fa fa-caret-right"></i></a>';
				break;
			}
			$this->breadcrups .= '</div>';
		}
		return $this->breadcrups;
	}

	private function getComponentCid($c,$id){
		$conn = $this->conn($c);
		$sql = 'SELECT `cid` FROM `studio404_components_inside` WHERE `idx`=:idx AND `lang`=:lang AND `status`!=:status';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":idx"=>$id, 
			":lang"=>LANG_ID, 
			":status"=>1
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		return $fetch["cid"];
	}

	private function getsupername($c){
		$conn = $this->conn($c);
		$sql = 'SELECT `title` FROM `studio404_pages` WHERE `menu_type`=:menu_type AND `idx`=:idx AND `lang`=:lang AND `status`!=:status';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":menu_type"=>"super", 
			":idx"=>$_GET['super'], 
			":lang"=>LANG_ID, 
			":status"=>1
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		return $fetch['title'];
	}

	private function getpagetitle($c){
		$conn = $this->conn($c);
		if(isset($_GET['newsidx']) && $_GET['action']!="editNewsItem"){ $idx = $_GET['newsidx']; }
		else if(isset($_GET['catalogidx']) && $_GET['action']!="editCatalogItem"){ $idx = $_GET['catalogidx']; }
		else if(isset($_GET['mediaidx']) && $_GET['action']=="addGallery"){ $idx = $_GET['mediaidx']; }
		else{ $idx = $_GET['id']; }
		$sql = 'SELECT `title` FROM `studio404_pages` WHERE `menu_type`=:menu_type AND `idx`=:idx AND `lang`=:lang AND `status`!=:status';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":menu_type"=>"sub", 
			":idx"=>$idx, 
			":lang"=>LANG_ID, 
			":status"=>1
		));
		
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		return $fetch['title'];
	}

	private function getnewstitle($c){
		$conn = $this->conn($c);
		if(isset($_GET['newsidx'])){ $idx = $_GET['newsidx']; }
		else if(isset($_GET['cidx'])){ $idx = $_GET['cidx']; }

		$sql = 'SELECT `title` FROM `studio404_module_item` WHERE `idx`=:idx AND `lang`=:lang AND `status`!=:status';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":idx"=>$idx, 
			":lang"=>LANG_ID, 
			":status"=>1
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		return $fetch['title'];
	}

	private function getadminname($c){
		$conn = $this->conn($c);
		$sql = 'SELECT `namelname` FROM `studio404_users` WHERE `id`=:idx AND `status`!=:status';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":idx"=>$_GET['id'],
			":status"=>1
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		return $fetch['namelname'];
	}

	private function getrightname($c){
		$conn = $this->conn($c);
		$sql = 'SELECT `name` FROM `studio404_user_right` WHERE `id`=:id AND `status`!=:status';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":id"=>$_GET['id'],
			":status"=>1
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		return $fetch['name'];
	}

	function __destruct(){

	}
}
?>