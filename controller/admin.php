<?php if(!defined("DIR")){ exit(); }
/*
** Select all neccessery database data
*/
class admin extends connection{

	public $data = array();

	function __construct($obj,$c){
		$this->view($obj,$c);
	}

	public function view($obj,$c){
		// post and get request handler
		$model_admin_requests = new model_admin_requests();
		$data = $model_admin_requests->requestx($c);
		// select page managed menu
		$model_admin_selectManagedMenu = new model_admin_selectManagedMenu();
		$data["managed_pages"] = $model_admin_selectManagedMenu->select($c);		
		$data["managed_pages2"] = $model_admin_selectManagedMenu->select($c,true);		
		// breadcrups module
		$model_admin_breadcrups = new model_admin_breadcrups();
		$data["breadcrups"] = $model_admin_breadcrups->get($c);
		// get componemt menu
		$model_admin_components = new model_admin_components();
		$data["components"] = $model_admin_components->select_components_menu($c);
		
		if(isset($_SESSION["user404"]) && !empty($_SESSION["user404"])){
			if(isset($_GET["action"]) && $_GET["action"]=="mainMenu"){
				$data["website_title"] = "Welcome / Admin Panel - v: ".$c['cmsversion'];
				@include("view/view_admin_mainmenu.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="addAdmin"){
				$data["website_title"] = "Add admin / Admin Panel - v: ".$c['cmsversion'];
				$model_admin_select_admintypes = new model_admin_select_admintypes();
				$data["admin_types"] = $model_admin_select_admintypes->select($c);
				@include("view/view_admin_addAdmin.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="userList"){
				$data["website_title"] = "Admin users / Admin Panel - v: ".$c['cmsversion'];
				$model_admin_select = new model_admin_select();
				$admin_list = $model_admin_select->select_admins($c);
				$data['table'] = $admin_list['table'];
				$data['pager'] = $admin_list['pager'];
				@include("view/view_admin_userlist.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="wuserList"){
				$data["website_title"] = "Website users / Admin Panel - v: ".$c['cmsversion'];
				$model_admin_select = new model_admin_select();
				$admin_list = $model_admin_select->select_websiteusers($c);
				$data['table'] = $admin_list['table'];
				$data['pager'] = $admin_list['pager'];

				@include("view/view_admin_wuserlist.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="waddUser"){
				$data["website_title"] = "Add website user / Admin Panel - v: ".$c['cmsversion'];
				@include("view/view_admin_addwebsiteuser.php"); 
			}else if(isset($_GET["action"]) && $_GET["action"]=="weditprofile"){
				$data["website_title"] = "Edit website user / Admin Panel - v: ".$c['cmsversion'];
				$model_admin_editprofile = new model_admin_editprofile();
				$_SESSION["token"] = $_GET['token'];
				$data["profile"] = $model_admin_editprofile->select_profile2($c);

				@include("view/view_admin_editwebsiteuser.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="editprofile"){
				$data["website_title"] = "Edit profile / Admin Panel - v: ".$c['cmsversion'];
				$model_admin_editprofile = new model_admin_editprofile();
				$data["profile"] = $model_admin_editprofile->select_profile($c);

				$model_admin_select_admintypes = new model_admin_select_admintypes();
				$data["admin_types"] = $model_admin_select_admintypes->select($c);

				@include("view/view_admin_editprofile.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="changePassword"){
				$data["website_title"] = "Change Password / Admin Panel - v: ".$c['cmsversion'];
				@include("view/view_admin_changePassword.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="profileSettings"){
				$model_admin_profile = new model_admin_profile();
				$data["profile"] = $model_admin_profile->selectAdminProfile($c);
				$data["website_title"] = "Profile settings / Admin Panel - v: ".$c['cmsversion'];
				@include("view/view_admin_profileSettings.php"); 
			}else if(isset($_GET["action"]) && $_GET["action"]=="signout"){
					unset($_SESSION["user404"]);
					$redirect = new redirect();
					$redirect->go("?action=login");
			}else if(isset($_GET["action"]) && $_GET["action"]=="userRights"){
				$data["website_title"] = "User rights / Admin Panel - v: ".$c['cmsversion'];
				$model_admin_userrights = new model_admin_userrights();
				$admin_rightgroups = $model_admin_userrights->select_admins_rightgroups($c);
				$data['table'] = $admin_rightgroups['table'];
				$data['pager'] = $admin_rightgroups['pager'];
				@include("view/view_admin_userRights.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="addAdminRights"){
				$data["website_title"] = "Add admin user rights / Admin Panel - v: ".$c['cmsversion'];
				@include("view/view_admin_rights.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="editAdminRights"){
				$data["website_title"] = "Edit admin user rights / Admin Panel - v: ".$c['cmsversion'];
				$model_admin_userrights = new model_admin_userrights();
				$data["user_rights"] = $model_admin_userrights->select_userright($c);

				@include("view/view_admin_editAdminRights.php");
			}else if($_GET['action']=="log"){
				$data["website_title"] = "Logs / Admin Panel - v: ".$c['cmsversion'];
				$model_admin_logs = new model_admin_logs();
				$admin_logs = $model_admin_logs->select_admin_logs($c);
				$data['table'] = $admin_logs['table'];
				$data['pager'] = $admin_logs['pager'];
				@include("view/view_admin_log.php");
			}else if($_GET['action']=="textConverter"){
				$data["website_title"] = "Text converter / Admin Panel - v: ".$c['cmsversion'];
				@include("view/view_admin_textconverter.php");
			}else if($_GET['action']=="menuManagment"){
				$data["website_title"] = "Page managment/ Admin Panel - v: ".$c['cmsversion'];
				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$data["language_select"] = $model_admin_selectLanguage->select_option($c);
				$model_admin_menumanagment = new model_admin_menumanagment();
				$admin_list = $model_admin_menumanagment->select_menus($c);
				$data['table'] = $admin_list['table'];
				$data['pager'] = $admin_list['pager'];
				@include("view/view_admin_pagemanagment.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="editMenuManagment"){
				$data["website_title"] = "Edit page managment / Admin Panel - v: ".$c['cmsversion'];
				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$data["language_select"] = $model_admin_selectLanguage->select_option($c);
				$model_admin_editMenuManagment = new model_admin_editMenuManagment();
				$data["pagesManagment"] = $model_admin_editMenuManagment->select_editMenuManagment($c);
				@include("view/view_admin_editMenuManagment.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="addPageManagment"){
				$data["website_title"] = "Add page managment / Admin Panel - v: ".$c['cmsversion'];
				@include("view/view_admin_addMenuManagment.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="sitemap"){
				$data["website_title"] = "Sitemap / Admin Panel - v: ".$c['cmsversion'];

				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$data["language_select"] = $model_admin_selectLanguage->select_option($c);
				$model_admin_menumanagment = new model_admin_menumanagment();
				$admin_list = $model_admin_menumanagment->select_sub($c);
				$data['table'] = $admin_list['table'];
				$data['pager'] = $admin_list['pager'];

				@include("view/view_admin_sitemap.php"); 
			}else if(isset($_GET["action"]) && $_GET["action"]=="addSitemapItem"){
				$data["website_title"] = "Add Sitemap Item / Admin Panel - v: ".$c['cmsversion']; 
				// $model_admin_selectLanguage = new model_admin_selectLanguage();
				// $data["language_select"] = $model_admin_selectLanguage->select_option($c);
				$check_super = new check_super();
				$super_exists = $check_super->super($c);
				if(!$super_exists){ $data["outMessage"] = 2; }
				else{
					if(isset($_GET['super'],$_GET['sub'])){
						$pre_slug = new pre_slug();
						$pre_slug_method = $pre_slug->slug($c,$_GET['super'],$_GET['sub']);
						if(is_array($pre_slug_method)){
							$reverse = array_reverse($pre_slug_method);
							$data['pre_slug'] = implode("/",$reverse);
						}
					}
				}
				@include("view/view_admin_addSitemapItem.php"); 
			}else if(isset($_GET["action"]) && $_GET["action"]=="editSitemap"){
				$data["website_title"] = "Edit sitemap / Admin Panel - v: ".$c['cmsversion'];
				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$data["language_select"] = $model_admin_selectLanguage->select_option($c);

				$edit_page_interface = new edit_page_interface();
				$data["interface"] = $edit_page_interface->out_interface($c);
				@include("view/view_admin_editSiteMap.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="newsModule"){
				$data["website_title"] = "News module / Admin Panel - v: ".$c['cmsversion'];

				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$data["language_select"] = $model_admin_selectLanguage->select_option($c);

				$model_admin_newsmodule = new model_admin_newsmodule();
				$news_list = $model_admin_newsmodule->select_list($c);
				$data['table'] = $news_list['table'];
				$data['pager'] = $news_list['pager'];

				@include("view/view_admin_news_module.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="addNews" && isset($_GET['newsidx'])){
				$data["website_title"] = "Add news / Admin Panel - v: ".$c['cmsversion'];
				$news_slug = new news_slug();
				$data["pre_slug"] = $news_slug->slug($c); 

				@include("view/view_admin_addnews.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="addCatalog" && isset($_GET['catalogidx'])){
				$data["website_title"] = "Add catalog / Admin Panel - v: ".$c['cmsversion'];
				$news_slug = new news_slug();
				$data["pre_slug"] = $news_slug->slug($c); 
				@include("view/view_admin_addcatalog.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="catalogModule"){
				$data["website_title"] = "Catalog module / Admin Panel - v: ".$c['cmsversion'];

				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$data["language_select"] = $model_admin_selectLanguage->select_option($c);

				$model_admin_catalogmodule = new model_admin_catalogmodule();
				$news_list = $model_admin_catalogmodule->select_list($c);
				$data['table'] = $news_list['table'];
				$data['pager'] = $news_list['pager'];

				@include("view/view_admin_catalog_module.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="editNewsItem"){
				$data["website_title"] = "Edit news item / Admin Panel - v: ".$c['cmsversion'];
				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$data["language_select"] = $model_admin_selectLanguage->select_option($c);

				$edit_page_interface = new edit_page_interface();
				$data["interface"] = $edit_page_interface->out_interface($c);
				@include("view/view_admin_editNewsItem.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="editCatalogItem"){
				$data["website_title"] = "Edit catalog item / Admin Panel - v: ".$c['cmsversion'];
				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$data["language_select"] = $model_admin_selectLanguage->select_option($c);

				$edit_page_interface = new edit_page_interface();
				$data["interface"] = $edit_page_interface->out_interface($c);
				@include("view/view_admin_editCatalogItem.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="catalogMoreInfo"){
				$data["website_title"] = "Catalog more info  / Admin Panel - v: ".$c['cmsversion'];
				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$data["language_select"] = $model_admin_selectLanguage->select_option($c);

				$model_admin_catalogmoreinfo = new model_admin_catalogmoreinfo();
				$news_list = $model_admin_catalogmoreinfo->select_list_all($c);
				$data['table'] = $news_list['table'];
				$data['pager'] = $news_list['pager'];
				@include("view/view_admin_catalogmoreinfo.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="addCatalogMoreInfo"){
				$data["website_title"] = "Add catalog more info / Admin Panel - v: ".$c['cmsversion'];
				$model_admin_catalogmodule = new model_admin_catalogmodule();
				$data["catalogs"] = $model_admin_catalogmodule->getcatalogs($c);

				@include("view/view_admin_addcatalogmoreinfo.php");
			}else if(isset($_GET["action"],$_GET['id']) && is_numeric($_GET['id']) && $_GET["action"]=="editCatalogMoreInfo"){
				$data["website_title"] = "Edit catalog more info / Admin Panel - v: ".$c['cmsversion'];
				$model_admin_catalogmoreinfo = new model_admin_catalogmoreinfo();
				$data['info'] = $model_admin_catalogmoreinfo->select_one($c,$_GET['id']); 
				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$data["language_select"] = $model_admin_selectLanguage->select_option($c);
				$model_admin_catalogmodule = new model_admin_catalogmodule();
				$data["catalogs"] = $model_admin_catalogmodule->getcatalogs($c);
				
				@include("view/view_admin_editcatalogmoreinfo.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="components"){
				$data["website_title"] = "Components / Admin Panel - v: ".$c['cmsversion'];

				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$data["language_select"] = $model_admin_selectLanguage->select_option($c);

				$model_admin_components = new model_admin_components();
				$components = $model_admin_components->select($c);
				$data['table'] = $components['table'];
				$data['pager'] = $components['pager'];

				@include("view/view_admin_components.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="addComponents"){
				$data["website_title"] = "Add components / Admin Panel - v: ".$c['cmsversion'];
				@include("view/view_admin_addcomponents.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="editComponents"){
				$data["website_title"] = "Edit components / Admin Panel - v: ".$c['cmsversion'];
				$edit_page_interface = new edit_page_interface();
				$data["interface"] = $edit_page_interface->general_form_components($c);

				@include("view/view_admin_editcomponents.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="componentModule"){
				$data["website_title"] = "Component module / Admin Panel - v: ".$c['cmsversion'];

				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$data["language_select"] = $model_admin_selectLanguage->select_option($c);
				
				$model_admin_componentsmodele = new model_admin_componentsmodele();
				$components = $model_admin_componentsmodele->select($c);
				$data['table'] = $components['table'];
				$data['pager'] = $components['pager'];

				@include("view/view_admin_componentsmodel.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="addComponentsModule"){
				$data["website_title"] = "Add components module / Admin Panel - v: ".$c['cmsversion'];
				@include("view/view_admin_addcomponentsmodule.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="editComponentsModule"){
				$data["website_title"] = "Edit components module / Admin Panel - v: ".$c['cmsversion'];
				
				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$data["language_select"] = $model_admin_selectLanguage->select_option($c);

				$model_admin_componentsmodele = new model_admin_componentsmodele(); 
				$data["select"] = $model_admin_componentsmodele->select_one($c);
				@include("view/view_admin_editcomponentsmodule.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="languages"){
				$data["website_title"] = "Languages / Admin Panel - v: ".$c['cmsversion'];

				$model_admin_languages= new model_admin_languages();
				$languages = $model_admin_languages->select($c);
				$data['table'] = $languages['table'];
				$data['pager'] = $languages['pager'];

				@include("view/view_admin_languages.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="addlanguage"){
				$data["website_title"] = "Add language / Admin Panel - v: ".$c['cmsversion'];
				@include("view/view_admin_addlanguage.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="editLanguage"){
				$data["website_title"] = "Edit language / Admin Panel - v: ".$c['cmsversion'];
				$model_admin_languages= new model_admin_languages();
				$data["info"] = $model_admin_languages->select_one($c);
				@include("view/view_admin_editlanguage.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="languageData"){
				$data["website_title"] = "Language data / Admin Panel - v: ".$c['cmsversion'];

				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$data["language_select"] = $model_admin_selectLanguage->select_option($c);

				$model_admin_languageData= new model_admin_languageData();
				$languages = $model_admin_languageData->select($c);

				$data['table'] = $languages['table'];
				$data['pager'] = $languages['pager'];

				@include("view/view_admin_languageData.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="addlanguageData"){
				$data["website_title"] = "Add language data / Admin Panel - v: ".$c['cmsversion'];
				@include("view/view_admin_addlanguageData.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="editLanguageData"){
				$data["website_title"] = "Edit language data / Admin Panel - v: ".$c['cmsversion'];

				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$data["language_select"] = $model_admin_selectLanguage->select_option($c);

				$model_admin_languageData= new model_admin_languageData();
				$data["info"] = $model_admin_languageData->select_one($c);
				@include("view/view_admin_editlanguagedata.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="invoices"){
				$data["website_title"] = "Invoices / Admin Panel - v: ".$c['cmsversion'];
				
				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$data["language_select"] = $model_admin_selectLanguage->select_option($c);

				$model_admin_invoices= new model_admin_invoices();
				$invoices = $model_admin_invoices->select($c);

				$data['table'] = $invoices['table'];
				$data['pager'] = $invoices['pager'];

				@include("view/view_admin_invoices.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="addInvoice"){
				$data["website_title"] = "Add invoice / Admin Panel - v: ".$c['cmsversion'];
				$lang = new model_admin_languageData();
				$data["webhosting"] = $lang->l("webhosting");
				$data["creatingawebsite"] = $lang->l("creatingawebsite");
				$data["gadaxdilia"] = $lang->l("gadaxdilia");
				$data["gadasaxdeli"] = $lang->l("gadasaxdeli");
				$data["otherservice"] = $lang->l("otherservice");
				$model_admin_select = new model_admin_select(); 
				$data["fetch"] = $model_admin_select->select_admin_names_for_invoice($c);
				@include("view/view_admin_addinvoice.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="editInvoice"){
				$data["website_title"] = "Edit invoice / Admin Panel - v: ".$c['cmsversion'];
				$lang = new model_admin_languageData();
				$data["webhosting"] = $lang->l("webhosting");
				$data["creatingawebsite"] = $lang->l("creatingawebsite");
				$data["gadaxdilia"] = $lang->l("gadaxdilia");
				$data["gadasaxdeli"] = $lang->l("gadasaxdeli");
				$data["otherservice"] = $lang->l("otherservice");
				
				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$data["language_select"] = $model_admin_selectLanguage->select_option($c);

				$model_admin_invoices= new model_admin_invoices();
				$data["info"] = $model_admin_invoices->select_one($c);
				@include("view/view_admin_editinvoice.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="gallery"){
				$data["website_title"] = "Gallery module / Admin Panel - v: ".$c['cmsversion'];

				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$data["language_select"] = $model_admin_selectLanguage->select_option($c);

				$model_admin_gallery = new model_admin_gallery();
				$news_list = $model_admin_gallery->select($c);
				$data['table'] = $news_list['table'];
				$data['pager'] = $news_list['pager'];

				@include("view/view_admin_gallery.php"); 
			}else if(isset($_GET["action"]) && $_GET["action"]=="addGallery" && isset($_GET['mediaidx'])){
				$data["website_title"] = "Add gallery / Admin Panel - v: ".$c['cmsversion'];
				$news_slug = new news_slug();
				$data["pre_slug"] = $news_slug->slug($c); 
				@include("view/view_admin_addgallery.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="editMediaItem"){
				$data["website_title"] = "Edit gallery item / Admin Panel - v: ".$c['cmsversion'];
				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$data["language_select"] = $model_admin_selectLanguage->select_option($c);

				$edit_page_interface = new edit_page_interface();
				$data["interface"] = $edit_page_interface->out_interface($c);
				@include("view/view_admin_editMediaItem.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="vectormap"){
				$data["website_title"] = "Vector map / Admin Panel - v: ".$c['cmsversion'];
				
				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$data["language_select"] = $model_admin_selectLanguage->select_option($c);

				$model_admin_vectormap = new model_admin_vectormap();
				$map = $model_admin_vectormap->select($c);

				$data['table'] = $map['table'];
				$data['pager'] = $map['pager'];

				@include("view/view_admin_map.php");
			}else if(isset($_GET["action"]) && $_GET["action"]=="editVectorMap"){
				$data["website_title"] = "Edit trade map / Admin Panel - v: ".$c['cmsversion'];
				$lang = new model_admin_languageData();
				
				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$data["language_select"] = $model_admin_selectLanguage->select_option($c);

				$model_admin_vectormap= new model_admin_vectormap();
				$data["select"] = $model_admin_vectormap->select_one($c);
				@include("view/view_admin_editvectormap.php");
			}else{
				$data["website_title"] = "Welcome / Admin Panel - v: ".$c['cmsversion'];
				$data["c"] = $c;
				$userData = new userData();
				$data["userIp"] = $userData->getUserIP();
				@include("view/view_admin_home.php");
			}
		}else{
			$data["website_title"] = "Login / Admin Panel - v: ".$c['cmsversion'];
			@include("view/view_admin_login.php");
		}		
	}

	function __destruct(){
		
	}
}



