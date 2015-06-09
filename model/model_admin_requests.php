<?php if(!defined("DIR")){ exit(); }
class model_admin_requests extends connection{
	function __construct(){

	}

	public function requestx($c){
		if(isset($_POST["admin_login"])){// if submited
			$model_check_user = new model_check_user();
			$data["login_try"] = $model_check_user->user($c);
		}

		if(isset($_POST['admin_change_password'])){// if password change
			$model_change_admin_password = new model_change_admin_password();
			$data["outMessage"] = $model_change_admin_password->change($c);
		}

		if(isset($_POST['add_email'])){
			$model_admin_emaillist = new model_admin_emaillist(); 
			$model_admin_emaillist->add($c);
			$data["outMessage"] = $model_admin_emaillist->outMessage;
		}

		if(isset($_POST['edit_email'])){
			$model_admin_emaillist = new model_admin_emaillist(); 
			$model_admin_emaillist->edit($c);
			$data["outMessage"] = $model_admin_emaillist->outMessage;
		}

		if(isset($_GET['remove']) && isset($_GET['action']) && $_GET['action']=="showemails"){
			$model_admin_emaillist = new model_admin_emaillist();
			$model_admin_emaillist->removeMe($c);
			if($model_admin_emaillist->outMessage==1){
				$redirect = new redirect();
				$redirect->go('?action=showemails&id='.$_GET['id']);
			}
		}

		if(isset($_POST['newsletter_send'])){
			$model_admin_menageemails = new model_admin_menageemails();
			$model_admin_menageemails->addSendEmail($c); 
			$data["outMessage"] = $model_admin_menageemails->outMessage;
		}

		if($_POST['admin_change_profile']){
			$model_admin_profile = new model_admin_profile();
			$model_admin_profile->updateMe($c);
			$data["outMessage"] = $model_admin_profile->outMessage;
		}

		if(isset($_POST['add_admin'])){
			$model_admin_adduser = new model_admin_adduser();
			$data["outMessage"] = $model_admin_adduser->add($c);
		}

		if(isset($_POST['add_emailgroup'])){
			$model_admin_menageemails = new model_admin_menageemails();
			$model_admin_menageemails->add($c); 
			$data["outMessage"] = $model_admin_menageemails->outMessage; 
		}

		if(isset($_POST['edit_emailgroup'])){
			$model_admin_menageemails = new model_admin_menageemails();
			$model_admin_menageemails->edit($c); 
			$data["outMessage"] = $model_admin_menageemails->outMessage; 
		}


		if(isset($_POST['add_website_user'])){
			$model_admin_adduser = new model_admin_adduser();
			$data["outMessage"] = $model_admin_adduser->addwebsiteuser($c);
		}

		if(isset($_POST['edit_admin'])){
			$model_admin_editprofile = new model_admin_editprofile();
			$model_admin_editprofile->edit($c);
			$data["outMessage"] = $model_admin_editprofile->outMessage;
		}

		if(isset($_POST['newsletter_main'])){
			$model_admin_newslettermain = new model_admin_newslettermain();
			$model_admin_newslettermain->edit_main($c); 
			$data["outMessage"] = $model_admin_newslettermain->outMessage;
		}

		if(isset($_POST['edit_website_user'])){
			$model_admin_editprofile = new model_admin_editprofile();
			$model_admin_editprofile->wedit($c);
			$data["outMessage"] = $model_admin_editprofile->outMessage;
		}

		if(isset($_GET['remove']) && isset($_GET['action']) && $_GET['action']=="userList"){
			$model_admin_editprofile = new model_admin_editprofile();
			$model_admin_editprofile->removeMe($c);
			if($model_admin_editprofile->outMessage==1){
				$redirect = new redirect();
				$redirect->go('?action=userList');
			}
		}

		if(isset($_GET['remove']) && isset($_GET['action']) && $_GET['action']=="managedemails"){
			$model_admin_menageemails = new model_admin_menageemails();
			$model_admin_menageemails->removeMe($c);
			if($model_admin_menageemails->outMessage==1){
				$redirect = new redirect();
				$redirect->go('?action=managedemails');
			}
		}

		if(isset($_GET['remove']) && isset($_GET['action']) && $_GET['action']=="wuserList"){
			$model_admin_editprofile = new model_admin_editprofile();
			$model_admin_editprofile->removeMe($c);
			if($model_admin_editprofile->outMessage==1){
				$redirect = new redirect();
				$redirect->go('?action=wuserList');
			}
		}

		if(isset($_GET['remove']) && isset($_GET['action']) && $_GET['action']=="catalogModule" && isset($_GET['rcidx'])){
			$model_admin_editcatalogsitem = new model_admin_editcatalogsitem();
			$model_admin_editcatalogsitem->removeMe($c);
			if($model_admin_editcatalogsitem->outMessage==1){
				$redirect = new redirect();
				$redirect->go('?action=catalogModule&type=catalogpage&id='.$_GET['id'].'&super='.$_GET['super'].'&token='.$_SESSION['token']);
			}
		}

		if(isset($_GET['remove']) && isset($_GET['action']) && $_GET['action']=="log"){
			$model_admin_logs = new model_admin_logs();
			$model_admin_logs->removeMe($c);
			if($model_admin_logs->outMessage==1){
				$redirect = new redirect();
				$redirect->go('?action=log');
			}
		}

		if(isset($_POST['add_admin_userrights'])){
			$model_admin_userrights = new model_admin_userrights();
			$model_admin_userrights->update_admin_right($c);
			$data["outMessage"] = $model_admin_userrights->outMessage;
		}

		if(isset($_POST['edit_admin_userrights'])){
			$model_admin_userrights = new model_admin_userrights();
			$model_admin_userrights->edit($c);
			$data["outMessage"] = $model_admin_userrights->outMessage;
		}
		
		if(isset($_GET['remove']) && isset($_GET['action']) && $_GET['action']=="userRights"){
			$model_admin_userrights = new model_admin_userrights();
			$model_admin_userrights->removeMe($c);
			if($model_admin_userrights->outMessage==1){
				$redirect = new redirect();
				$redirect->go('?action=userRights');
			}
		}

		if(isset($_POST['convert_text'])){
			$input = (string)$_POST['input'];
			if(isset($_POST['convertMethod']) && !empty($_POST['convertMethod']) && $_POST['convertMethod']=="englishToGeorgian"){
				$converter = new converter();				
				$data['output'] = $converter->englishToGeorgian($input);
			}else if(isset($_POST['convertMethod']) && !empty($_POST['convertMethod']) && $_POST['convertMethod']=="removeTags"){
				$converter = new converter();
				$data['output'] = $converter->removeTags($input);
			}else if(isset($_POST['convertMethod']) && !empty($_POST['convertMethod']) && $_POST['convertMethod']=="removeSpace"){
				$converter = new converter();
				$data['output'] = $converter->compress($input);
			} 
		}

		if(isset($_POST['page_managment'])){
			$model_admin_editMenuManagment = new model_admin_editMenuManagment();
			$model_admin_editMenuManagment->edit($c);
			$data["outMessage"] = $model_admin_editMenuManagment->outMessage;
		}

		if(isset($_POST['add_pageManager'])){
			$model_admin_menumanagment = new model_admin_menumanagment();
			$data["outMessage"] = $model_admin_menumanagment->add($c);
		}

		if(isset($_GET['remove']) && isset($_GET['action']) && $_GET['action']=="menuManagment"){
			$model_admin_editMenuManagment = new model_admin_editMenuManagment();
			$model_admin_editMenuManagment->removeMe($c);
			if($model_admin_editMenuManagment->outMessage==1){
				$redirect = new redirect();
				$redirect->go('?action=menuManagment');
			}
		}
		if(isset($_GET['remove']) && isset($_GET['action']) && $_GET['action']=="newsModule"){
			$model_admin_editnewsitem = new model_admin_editnewsitem();
			$model_admin_editnewsitem->removeMe($c);
			if($model_admin_editnewsitem->outMessage==1){
				$redirect = new redirect();
				$redirect->go('?action=newsModule&type=newspage&id='.$_GET['id'].'&super='.$_GET['super'].'&token='.$_SESSION['token']);
			}
		}
		

		if(isset($_POST['add_page'])){
			$model_admin_addpage = new model_admin_addpage();
			$data["outMessage"] = $model_admin_addpage->add($c);
		}

		if(isset($_POST['add_news'])){
			$model_admin_addnews = new model_admin_addnews();
			$data["outMessage"] = $model_admin_addnews->add($c);
		}

		if(isset($_POST['add_catalog'])){
			$model_admin_addcatalog = new model_admin_addcatalog();
			$data["outMessage"] = $model_admin_addcatalog->add($c);
		}

		if(isset($_GET['visibilitychnage'],$_GET['action'],$_GET['type'],$_GET['id'],$_GET['token']) && $_GET['visibilitychnage']=="true" && is_numeric($_GET['id']) && $_GET['token']===$_SESSION['token']){
			if(isset($_GET['newsidx']) || isset($_GET['catalogidx'])){
				$action = (isset($_GET['newsidx'])) ? "newsModule" : "catalogModule";
				$pagetype = $_GET['type'];
				
				$_SESSION['token'] = md5(sha1(time()));
				$model_admin_changeVisibility = new model_admin_changeVisibility();
				$model_admin_changeVisibility->change_news($c);
				if($model_admin_changeVisibility->outMessage==1){
					$redirect = new redirect();
					$redirect->go('?action='.$action.'&type='.$pagetype.'&id='.$_GET['id'].'&super='.$_GET['super'].'&token='.$_SESSION['token']);
				}
			}else if(isset($_GET["mediaidx"])){
				$action = "gallery";
				$pagetype = $_GET['type']; 
				$_SESSION['token'] = md5(sha1(time()));
				$model_admin_changeVisibility = new model_admin_changeVisibility();
				$model_admin_changeVisibility->change_media($c);
				if($model_admin_changeVisibility->outMessage==1){
					$redirect = new redirect();
					$redirect->go('?action='.$action.'&type='.$pagetype.'&id='.$_GET['id'].'&super='.$_GET['super'].'&token='.$_SESSION['token']);
				}
			}
		}

		if(isset($_GET['visibilitychnage'],$_GET['super'],$_GET['token']) && $_GET['visibilitychnage']=="true" && is_numeric($_GET['super']) && $_GET['token']===$_SESSION['token']){
			$_SESSION['token'] = md5(sha1(time()));
			$model_admin_changeVisibility = new model_admin_changeVisibility();
			$model_admin_changeVisibility->change($c);
			if($model_admin_changeVisibility->outMessage==1){
				$redirect = new redirect();
				$redirect->go('?action=sitemap&super='.$_GET['super']);
			}
		}

		if(isset($_GET['visibilitychnage'],$_GET["wuserid"]) && $_GET['visibilitychnage']=="true" && $_GET['token']===$_SESSION['token']){
			$_SESSION['token'] = md5(sha1(time()));
			$model_admin_changeVisibility = new model_admin_changeVisibility();
			$model_admin_changeVisibility->changeUserAllowed($c);
			if($model_admin_changeVisibility->outMessage==1){
				$redirect = new redirect();
				$redirect->go('?action=wuserList'); 
			}
		}

		if(isset($_GET['remove']) && isset($_GET['action']) && $_GET['action']=="sitemap"){
			$model_admin_editMenuManagment = new model_admin_editMenuManagment();
			$model_admin_editMenuManagment->removeMe($c);
			if($model_admin_editMenuManagment->outMessage==1){
				$redirect = new redirect();
				$redirect->go('?action=sitemap&super='.$_GET['super']);
			}
		}

		if(isset($_POST['edit_page'])){
			$model_admin_editMenuManagment = new model_admin_editMenuManagment();
			$model_admin_editMenuManagment->editPage($c); 
			$data["outMessage"] = $model_admin_editMenuManagment->outMessage;
		}

		
		if(isset($_GET['up']) || isset($_GET['down']) && ($_GET['token']===$_SESSION['token'])){
			$model_admin_changeposition = new model_admin_changeposition(); 
			if($_GET['action']!="catalogModule" && $_GET['action']!="componentModule" && $_GET['action']!="gallery"){
				$model_admin_changeposition->act($c);
				$_SESSION['token'] = md5(sha1(time()));
			}else if($_GET['action']=="componentModule"){
				$model_admin_changeposition->act_component($c);
				$_SESSION['token'] = md5(sha1(time()));
			}else if($_GET['action']=="gallery"){
				$model_admin_changeposition->act_gallery($c);
				$_SESSION['token'] = md5(sha1(time()));
			}else{
				$model_admin_changeposition->act_catalog($c);
				$_SESSION['token'] = md5(sha1(time()));
			}
			$data["outMessage"] = $model_admin_changeposition->outMessage;
		}

		if(isset($_POST['edit_news_item'])){
			$model_admin_editnewsitem = new model_admin_editnewsitem();
			$model_admin_editnewsitem->edit($c);
			$data["outMessage"] = $model_admin_editnewsitem->outMessage;
		}

		if(isset($_POST['edit_catalog_item'])){
			$model_admin_editcatalogsitem = new model_admin_editcatalogsitem();
			$model_admin_editcatalogsitem->edit($c);
			$data["outMessage"] = $model_admin_editcatalogsitem->outMessage;
		}

		if(isset($_POST['edit_media_item'])){
			$model_admin_editmediaitem = new model_admin_editmediaitem();
			$model_admin_editmediaitem->edit($c);
			$data["outMessage"] = $model_admin_editmediaitem->outMessage;
		}

		if(isset($_POST['edit_vectormap'])){
			$model_admin_vectormap = new model_admin_vectormap();
			$model_admin_vectormap->edit($c);
			$data["outMessage"] = $model_admin_vectormap->outMessage;
		}

		if(isset($_POST['add_catalog_more_info'])){
			$model_admin_addcatalogmoreinfo = new model_admin_addcatalogmoreinfo(); 
			$model_admin_addcatalogmoreinfo->add($c);
			$data['outMessage'] = $model_admin_addcatalogmoreinfo->outMessage;
		}

		if(isset($_GET['remove'],$_GET['action'],$_GET['cridxremove']) && $_GET['action']=="catalogMoreInfo"){
			$model_admin_addcatalogmoreinfo = new model_admin_addcatalogmoreinfo();
			$model_admin_addcatalogmoreinfo->removeMe($c);
			if($model_admin_addcatalogmoreinfo->outMessage==1){
				$redirect = new redirect();
				$redirect->go('?action=catalogMoreInfo');
			}
		}

		if(isset($_POST['edit_catalog_more_info'],$_GET['id']) && is_numeric($_GET['id'])){
			$model_admin_catalogmoreinfo = new model_admin_catalogmoreinfo();
			$model_admin_catalogmoreinfo->updateMe($c);
			$data["outMessage"] = $model_admin_catalogmoreinfo->outMessage;
		}

		if(isset($_POST['add_components'])){
			$model_admin_components = new model_admin_components();
			$model_admin_components->add($c);
			$data['outMessage'] = $model_admin_components->outMessage;
		}

		if(isset($_GET['remove'],$_GET['action'],$_GET['comid']) && $_GET['action']=="components"){
			$model_admin_components = new model_admin_components();
			$model_admin_components->removeMe($c);
			if($model_admin_components->outMessage==1){
				$redirect = new redirect();
				$redirect->go('?action=components');
			}
		}

		if(isset($_POST['edit_components'])){
			$model_admin_components = new model_admin_components();
			$model_admin_components->edit($c);
			$data['outMessage'] = $model_admin_components->outMessage;
		}

		if(isset($_POST['add_componentmodel'])){
			$model_admin_componentsmodele = new model_admin_componentsmodele();
			$model_admin_componentsmodele->add($c); 
			$data['outMessage'] = $model_admin_componentsmodele->outMessage;
		}

		if(isset($_POST['edit_componentmodel'])){
			$model_admin_componentsmodele = new model_admin_componentsmodele();
			$model_admin_componentsmodele->edit($c); 
			$data['outMessage'] = $model_admin_componentsmodele->outMessage;
		}

		if(isset($_GET['remove'],$_GET['action'],$_GET['commodelid']) && $_GET['action']=="componentModule"){
			$model_admin_componentsmodele = new model_admin_componentsmodele();
			$model_admin_componentsmodele->removeMe($c);
			if($model_admin_componentsmodele->outMessage==1){
				$redirect = new redirect();
				$redirect->go('?action=componentModule&id='.$_GET['id'].'&token='.$_SESSION["token"]);
			}
		}
	
		if(isset($_POST['add_language'],$_GET['action']) && $_GET['action']=="addlanguage"){
			$model_admin_languages = new model_admin_languages();
			$model_admin_languages->add($c);
			$data['outMessage'] = $model_admin_languages->outMessage;
		}

		if(isset($_POST['edit_language'],$_GET['action'],$_GET["id"]) && $_GET['action']=="editLanguage"){
			$model_admin_languages = new model_admin_languages();
			$model_admin_languages->edit($c);
			$data['outMessage'] = $model_admin_languages->outMessage;
		}

		if(isset($_GET['remove'],$_GET['action'],$_GET['langid']) && $_GET['action']=="languages"){
			$model_admin_languages = new model_admin_languages();
			$model_admin_languages->removeMe($c);
			if($model_admin_languages->outMessage==1){
				$redirect = new redirect();
				$redirect->go('?action=languages');
			}
		}

		if(isset($_POST['add_language_data'],$_GET['action']) && $_GET['action']=="addlanguageData"){
			$model_admin_languageData = new model_admin_languageData();
			$model_admin_languageData->add($c);
			$data['outMessage'] = $model_admin_languageData->outMessage;
		}

		if(isset($_POST['add_invoce'],$_GET['action']) && $_GET['action']=="addInvoice"){
			$model_admin_invoices = new model_admin_invoices();
			$model_admin_invoices->add($c);
			$data['outMessage'] = $model_admin_invoices->outMessage;
		}

		if(isset($_POST['edit_language_data'],$_GET['action']) && $_GET['action']=="editLanguageData"){
			$model_admin_languageData = new model_admin_languageData();
			$model_admin_languageData->edit($c);
			$data['outMessage'] = $model_admin_languageData->outMessage;
		}

		if(isset($_GET['remove'],$_GET['action'],$_GET['langdataid']) && $_GET['action']=="languageData"){
			$model_admin_languageData = new model_admin_languageData();
			$model_admin_languageData->removeMe($c);
			if($model_admin_languageData->outMessage==1){
				$redirect = new redirect();
				$redirect->go('?action=languageData');
			}
		}

		if(isset($_POST["edit_invoce"],$_GET["action"]) && $_GET["action"]=="editInvoice"){
			$model_admin_invoices = new model_admin_invoices();
			$model_admin_invoices->edit($c);
			$data['outMessage'] = $model_admin_invoices->outMessage;
		}

		if(isset($_GET['remove'],$_GET['action'],$_GET['rinvoice']) && $_GET['action']=="invoices"){
			$model_admin_invoices = new model_admin_invoices();
			$model_admin_invoices->removeMe($c);
			if($model_admin_invoices->outMessage==1){
				$redirect = new redirect();
				$redirect->go('?action=invoices');
			}
		}

		if(isset($_GET['remove'],$_GET['action'],$_GET['rmidx']) && $_GET['action']=="gallery"){
			$model_admin_gallery = new model_admin_gallery();
			$model_admin_gallery->removeMe($c);
			if($model_admin_gallery->outMessage==1){
				$redirect = new redirect();
				$redirect->go('?action=gallery&type='.$_GET['type'].'&id='.$_GET['id'].'&super='.$_GET['super'].'&token='.$_SESSION["token"]);
			}
		}

		if(isset($_POST['add_gallery'])){
			$model_admin_addgallery = new model_admin_addgallery();
			$data["outMessage"] = $model_admin_addgallery->add($c);
		}
	
		return $data;
	}

	function __destruct(){

	}
}

?>