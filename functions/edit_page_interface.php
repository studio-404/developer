<?php if(!defined("DIR")){ exit(); }
class edit_page_interface extends connection{
	public $out = array();
	function __construct(){

	}
	public function out_interface($c){
		$conn = $this->conn($c);
		$sql_get_type = 'SELECT * FROM `studio404_pages` WHERE `idx`=:idx AND `status`!=:status AND `lang`=:lang';
		$prepare = $conn->prepare($sql_get_type);
		$prepare->execute(array(
			":idx"=>$_GET['id'],
			":status"=>1, 
			":lang"=>LANG_ID 
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		$page_type = $fetch['page_type'];
		
		switch($page_type){
			case "textpage": 
			$this->out[0] = '<ul>';
			$this->out[0] .= '<li><a href="#tabs-1">General</a></li>';
			$this->out[0] .= '<li><a href="#tabs-2">Content</a></li>';
			$this->out[0] .= '<li><a href="#tabs-3">Manage photo</a></li>';
			$this->out[0] .= '<li><a href="#tabs-4">Manage files</a></li>';			
			$this->out[0] .= '</ul>';
			$this->out[1] = '<div id="tabs-1">';
			$this->out[1] .= $this->general_form($fetch,'Text Page');
			$this->out[1] .= '</div>';
			$this->out[1] .= '<div id="tabs-2">';
			$this->out[1] .= $this->content_form($fetch);
			$this->out[1] .= '</div>';
			$this->out[1] .= '<div id="tabs-3">';
			$this->out[1] .= $this->content_images($fetch,$c);
			$this->out[1] .= '</div>';
			$this->out[1] .= '<div id="tabs-4">';
			$this->out[1] .= $this->content_files($fetch,$c);
			$this->out[1] .= '</div>';
			break;
			case "homepage": 
			$this->out[0] = '<ul>';
			$this->out[0] .= '<li><a href="#tabs-1">General</a></li>';
			$this->out[0] .= '<li><a href="#tabs-2">Content</a></li>';
			$this->out[0] .= '<li><a href="#tabs-3">Manage photo</a></li>';	
			$this->out[0] .= '<li><a href="#tabs-4">Manage files</a></li>';					
			$this->out[0] .= '</ul>';
			$this->out[1] = '<div id="tabs-1">';
			$this->out[1] .= $this->general_form($fetch,'Text Page');
			$this->out[1] .= '</div>';
			$this->out[1] .= '<div id="tabs-2">';
			$this->out[1] .= $this->content_form($fetch);
			$this->out[1] .= '</div>';
			$this->out[1] .= '<div id="tabs-3">';
			$this->out[1] .= $this->content_images($fetch2,$c);
			$this->out[1] .= '</div>';
			$this->out[1] .= '<div id="tabs-4">';
			$this->out[1] .= $this->content_files($fetch,$c);
			$this->out[1] .= '</div>';
			break;
			case "eventpage": 
			if(isset($_GET['action']) && $_GET['action']=="editNewsItem"){
				$sql = 'SELECT 
				`studio404_module_item`.`idx` AS smi_idx,
				`studio404_module_item`.`date` AS smi_date,  
				`studio404_module_item`.`expiredate` AS smi_expiredate,  
				`studio404_module_item`.`module_idx` AS smi_module_idx,  
				`studio404_module_item`.`title` AS smi_title,  
				`studio404_module_item`.`videourl` AS smi_videourl,  
				`studio404_module_item`.`short_description` AS smi_short_description,  
				`studio404_module_item`.`long_description` AS smi_long_description,  
				`studio404_module_item`.`tags` AS smi_tags,  
				`studio404_module_item`.`slug` AS smi_slug,  
				`studio404_module_item`.`position` AS smi_position,  
				`studio404_module_item`.`lang` AS smi_lang,  
				`studio404_module_item`.`visibility` AS smi_visibility 
				FROM 
				`studio404_module_attachment`,`studio404_module`,`studio404_module_item` 
				WHERE 
				`studio404_module_attachment`.`connect_idx`=:connect_idx AND 
				`studio404_module_attachment`.`lang`=:lang AND 
				`studio404_module_attachment`.`status`!=:status AND 
				`studio404_module_attachment`.`idx`=`studio404_module`.`idx` AND 
				`studio404_module`.`lang`=:lang AND 
				`studio404_module`.`status`!=:status AND 
				`studio404_module`.`idx`=`studio404_module_item`.`module_idx` AND 
				`studio404_module_item`.`idx`=:smi_idx AND 
				`studio404_module_item`.`lang`=:lang AND 
				`studio404_module_item`.`status`!=:status 
				';
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
				":connect_idx"=>$_GET['id'], 
				":smi_idx"=>$_GET['newsidx'], 
				":lang"=>LANG_ID, 
				":status"=>1
				));
				$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
				$this->out[0] = '<ul>';
				$this->out[0] .= '<li><a href="#tabs-1">General</a></li>';
				$this->out[0] .= '<li><a href="#tabs-2">Content</a></li>';
				$this->out[0] .= '<li><a href="#tabs-3">Manage photo</a></li>';
				$this->out[0] .= '<li><a href="#tabs-4">Manage files</a></li>';			
				$this->out[0] .= '</ul>';
				$this->out[1] = '<div id="tabs-1">';
				$this->out[1] .= $this->general_form_news($fetch);
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-2">';
				$this->out[1] .= $this->content_form_news($fetch);
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-3">';
				$this->out[1] .= $this->content_images($fetch,$c);
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-4">';
				$this->out[1] .= $this->content_files($fetch,$c);
				$this->out[1] .= '</div>';
			}else{
				$this->out[0] = '<ul>';
				$this->out[0] .= '<li><a href="#tabs-1">General</a></li>';
				$this->out[0] .= '<li><a href="#tabs-2">Content</a></li>';
				$this->out[0] .= '<li class="justlink"><a href="javascript:;" onclick="redirect(\'_self\',\'?action=newsModule&type=newspage&id='.$_GET['id'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'\')">Manage events</a></li>';
				$this->out[0] .= '</ul>';
				$this->out[1] = '<div id="tabs-1">';
				$this->out[1] .= $this->general_form($fetch,'Text Page');
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-2">';
				$this->out[1] .= $this->content_form($fetch);
				$this->out[1] .= '</div>';
			}
			break;
			case "feedbackpage": 
			$this->out[0] = '<ul>';
			$this->out[0] .= '<li><a href="#tabs-1">General</a></li>';
			$this->out[0] .= '<li><a href="#tabs-2">Content</a></li>';
			$this->out[0] .= '</ul>';
			$this->out[1] = '<div id="tabs-1">';
			$this->out[1] .= $this->general_form($fetch,'Text Page');
			$this->out[1] .= '</div>';
			$this->out[1] .= '<div id="tabs-2">';
			$this->out[1] .= $this->content_form($fetch);
			$this->out[1] .= '</div>';
			break;
			case "newspage": 
			if(isset($_GET['action']) && $_GET['action']=="editNewsItem"){
				$sql = 'SELECT 
				`studio404_module_item`.`idx` AS smi_idx,
				`studio404_module_item`.`date` AS smi_date,  
				`studio404_module_item`.`expiredate` AS smi_expiredate,  
				`studio404_module_item`.`module_idx` AS smi_module_idx,  
				`studio404_module_item`.`title` AS smi_title,  
				`studio404_module_item`.`videourl` AS smi_videourl,  
				`studio404_module_item`.`short_description` AS smi_short_description,  
				`studio404_module_item`.`long_description` AS smi_long_description,  
				`studio404_module_item`.`tags` AS smi_tags,  
				`studio404_module_item`.`slug` AS smi_slug,  
				`studio404_module_item`.`position` AS smi_position,  
				`studio404_module_item`.`lang` AS smi_lang,  
				`studio404_module_item`.`visibility` AS smi_visibility 
				FROM 
				`studio404_module_attachment`,`studio404_module`,`studio404_module_item` 
				WHERE 
				`studio404_module_attachment`.`connect_idx`=:connect_idx AND 
				`studio404_module_attachment`.`lang`=:lang AND 
				`studio404_module_attachment`.`status`!=:status AND 
				`studio404_module_attachment`.`idx`=`studio404_module`.`idx` AND 
				`studio404_module`.`lang`=:lang AND 
				`studio404_module`.`status`!=:status AND 
				`studio404_module`.`idx`=`studio404_module_item`.`module_idx` AND 
				`studio404_module_item`.`idx`=:smi_idx AND 
				`studio404_module_item`.`lang`=:lang AND 
				`studio404_module_item`.`status`!=:status 
				';
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
				":connect_idx"=>$_GET['id'], 
				":smi_idx"=>$_GET['newsidx'], 
				":lang"=>LANG_ID, 
				":status"=>1
				));
				$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
				$this->out[0] = '<ul>';
				$this->out[0] .= '<li><a href="#tabs-1">General</a></li>';
				$this->out[0] .= '<li><a href="#tabs-2">Content</a></li>';
				$this->out[0] .= '<li><a href="#tabs-3">Manage photo</a></li>';
				$this->out[0] .= '<li><a href="#tabs-4">Manage files</a></li>';			
				$this->out[0] .= '</ul>';
				$this->out[1] = '<div id="tabs-1">';
				$this->out[1] .= $this->general_form_news($fetch);
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-2">';
				$this->out[1] .= $this->content_form_news($fetch);
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-3">';
				$this->out[1] .= $this->content_images($fetch,$c);
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-4">';
				$this->out[1] .= $this->content_files($fetch,$c);
				$this->out[1] .= '</div>';
			}else{
				$this->out[0] = '<ul>';
				$this->out[0] .= '<li><a href="#tabs-1">General</a></li>';
				$this->out[0] .= '<li><a href="#tabs-2">Content</a></li>';
				$this->out[0] .= '<li class="justlink"><a href="javascript:;" onclick="redirect(\'_self\',\'?action=newsModule&type=newspage&id='.$_GET['id'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'\')">Manage news</a></li>';
				$this->out[0] .= '</ul>';
				$this->out[1] = '<div id="tabs-1">';
				$this->out[1] .= $this->general_form($fetch,'Text Page');
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-2">';
				$this->out[1] .= $this->content_form($fetch);
				$this->out[1] .= '</div>';
			}
			break;
			case "catalogpage": 
			if(isset($_GET['action']) && $_GET['action']=="editCatalogItem"){
				$sql = 'SELECT 
				`studio404_module_item`.`idx` AS smi_idx,
				`studio404_module_item`.`date` AS smi_date,  
				`studio404_module_item`.`expiredate` AS smi_expiredate,  
				`studio404_module_item`.`module_idx` AS smi_module_idx,  
				`studio404_module_item`.`title` AS smi_title,  
				`studio404_module_item`.`videourl` AS smi_videourl,  
				`studio404_module_item`.`short_description` AS smi_short_description,  
				`studio404_module_item`.`long_description` AS smi_long_description,  
				`studio404_module_item`.`tags` AS smi_tags,  
				`studio404_module_item`.`slug` AS smi_slug,  
				`studio404_module_item`.`position` AS smi_position,  
				`studio404_module_item`.`lang` AS smi_lang,  
				`studio404_module_item`.`visibility` AS smi_visibility 
				FROM 
				`studio404_module_attachment`,`studio404_module`,`studio404_module_item` 
				WHERE 
				`studio404_module_attachment`.`connect_idx`=:connect_idx AND 
				`studio404_module_attachment`.`lang`=:lang AND 
				`studio404_module_attachment`.`status`!=:status AND 
				`studio404_module_attachment`.`idx`=`studio404_module`.`idx` AND 
				`studio404_module`.`lang`=:lang AND 
				`studio404_module`.`status`!=:status AND 
				`studio404_module`.`idx`=`studio404_module_item`.`module_idx` AND 
				`studio404_module_item`.`idx`=:smi_idx AND 
				`studio404_module_item`.`lang`=:lang AND 
				`studio404_module_item`.`status`!=:status 
				';
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
				":connect_idx"=>$_GET['id'], 
				":smi_idx"=>$_GET['cidx'], 
				":lang"=>LANG_ID, 
				":status"=>1
				));
				$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
				$this->out[0] = '<ul>';
				$this->out[0] .= '<li><a href="#tabs-1">General</a></li>';
				$this->out[0] .= '<li><a href="#tabs-2">Content</a></li>';
				$this->out[0] .= '<li><a href="#tabs-3">More info</a></li>';
				$this->out[0] .= '<li><a href="#tabs-4">Manage photo</a></li>';
				$this->out[0] .= '<li><a href="#tabs-5">Manage files</a></li>';			
				$this->out[0] .= '</ul>';
				$this->out[1] = '<div id="tabs-1">';
				$this->out[1] .= $this->general_form_news($fetch);
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-2">';
				$this->out[1] .= $this->content_form_news($fetch);
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-3">';
				$this->out[1] .= $this->content_more_info($fetch,$c);
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-4">';
				$this->out[1] .= $this->content_images($fetch,$c);
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-5">';
				$this->out[1] .= $this->content_files_catalog($fetch,$c);
				$this->out[1] .= '</div>';
			}else{
				$this->out[0] = '<ul>';
				$this->out[0] .= '<li><a href="#tabs-1">General</a></li>';
				$this->out[0] .= '<li><a href="#tabs-2">Content</a></li>';
				$this->out[0] .= '<li class="justlink"><a href="javascript:;" onclick="redirect(\'_self\',\'?action=catalogModule&type=catalogpage&id='.$_GET['id'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'\')">Manage catalogs</a></li>';
				$this->out[0] .= '</ul>';
				$this->out[1] = '<div id="tabs-1">';
				$this->out[1] .= $this->general_form($fetch,'Text Page');
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-2">';
				$this->out[1] .= $this->content_form($fetch);
				$this->out[1] .= '</div>';
			}
			break;
			case "publicationpage": 
			if(isset($_GET['action']) && $_GET['action']=="editCatalogItem"){
				$sql = 'SELECT 
				`studio404_module_item`.`idx` AS smi_idx,
				`studio404_module_item`.`date` AS smi_date,  
				`studio404_module_item`.`expiredate` AS smi_expiredate,  
				`studio404_module_item`.`module_idx` AS smi_module_idx,  
				`studio404_module_item`.`title` AS smi_title,  
				`studio404_module_item`.`videourl` AS smi_videourl,  
				`studio404_module_item`.`short_description` AS smi_short_description,  
				`studio404_module_item`.`long_description` AS smi_long_description,  
				`studio404_module_item`.`tags` AS smi_tags,  
				`studio404_module_item`.`slug` AS smi_slug,  
				`studio404_module_item`.`position` AS smi_position,  
				`studio404_module_item`.`lang` AS smi_lang,  
				`studio404_module_item`.`visibility` AS smi_visibility 
				FROM 
				`studio404_module_attachment`,`studio404_module`,`studio404_module_item` 
				WHERE 
				`studio404_module_attachment`.`connect_idx`=:connect_idx AND 
				`studio404_module_attachment`.`lang`=:lang AND 
				`studio404_module_attachment`.`status`!=:status AND 
				`studio404_module_attachment`.`idx`=`studio404_module`.`idx` AND 
				`studio404_module`.`lang`=:lang AND 
				`studio404_module`.`status`!=:status AND 
				`studio404_module`.`idx`=`studio404_module_item`.`module_idx` AND 
				`studio404_module_item`.`idx`=:smi_idx AND 
				`studio404_module_item`.`lang`=:lang AND 
				`studio404_module_item`.`status`!=:status 
				';
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
				":connect_idx"=>$_GET['id'], 
				":smi_idx"=>$_GET['cidx'], 
				":lang"=>LANG_ID, 
				":status"=>1
				));
				$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
				$this->out[0] = '<ul>';
				$this->out[0] .= '<li><a href="#tabs-1">General</a></li>';
				$this->out[0] .= '<li><a href="#tabs-2">Content</a></li>';
				$this->out[0] .= '<li><a href="#tabs-3">More info</a></li>';
				$this->out[0] .= '<li><a href="#tabs-4">Manage photo</a></li>';
				$this->out[0] .= '<li><a href="#tabs-5">Manage files</a></li>';			
				$this->out[0] .= '</ul>';
				$this->out[1] = '<div id="tabs-1">';
				$this->out[1] .= $this->general_form_news($fetch);
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-2">';
				$this->out[1] .= $this->content_form_news($fetch);
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-3">';
				$this->out[1] .= $this->content_more_info($fetch,$c);
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-4">';
				$this->out[1] .= $this->content_images($fetch,$c);
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-5">';
				$this->out[1] .= $this->content_files_catalog($fetch,$c);
				$this->out[1] .= '</div>';
			}else{
				$this->out[0] = '<ul>';
				$this->out[0] .= '<li><a href="#tabs-1">General</a></li>';
				$this->out[0] .= '<li><a href="#tabs-2">Content</a></li>';
				$this->out[0] .= '<li class="justlink"><a href="javascript:;" onclick="redirect(\'_self\',\'?action=catalogModule&type=catalogpage&id='.$_GET['id'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'\')">Manage publications</a></li>';
				$this->out[0] .= '</ul>';
				$this->out[1] = '<div id="tabs-1">';
				$this->out[1] .= $this->general_form($fetch,'Text Page');
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-2">';
				$this->out[1] .= $this->content_form($fetch);
				$this->out[1] .= '</div>';
			}
			break;
			case "teampage": 
			if(isset($_GET['action']) && $_GET['action']=="editCatalogItem"){
				$sql = 'SELECT 
				`studio404_module_item`.`idx` AS smi_idx,
				`studio404_module_item`.`date` AS smi_date,  
				`studio404_module_item`.`expiredate` AS smi_expiredate,  
				`studio404_module_item`.`module_idx` AS smi_module_idx,  
				`studio404_module_item`.`title` AS smi_title,  
				`studio404_module_item`.`videourl` AS smi_videourl,  
				`studio404_module_item`.`short_description` AS smi_short_description,  
				`studio404_module_item`.`long_description` AS smi_long_description,  
				`studio404_module_item`.`tags` AS smi_tags,  
				`studio404_module_item`.`slug` AS smi_slug,  
				`studio404_module_item`.`position` AS smi_position,  
				`studio404_module_item`.`lang` AS smi_lang,  
				`studio404_module_item`.`visibility` AS smi_visibility 
				FROM 
				`studio404_module_attachment`,`studio404_module`,`studio404_module_item` 
				WHERE 
				`studio404_module_attachment`.`connect_idx`=:connect_idx AND 
				`studio404_module_attachment`.`lang`=:lang AND 
				`studio404_module_attachment`.`status`!=:status AND 
				`studio404_module_attachment`.`idx`=`studio404_module`.`idx` AND 
				`studio404_module`.`lang`=:lang AND 
				`studio404_module`.`status`!=:status AND 
				`studio404_module`.`idx`=`studio404_module_item`.`module_idx` AND 
				`studio404_module_item`.`idx`=:smi_idx AND 
				`studio404_module_item`.`lang`=:lang AND 
				`studio404_module_item`.`status`!=:status 
				';
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
				":connect_idx"=>$_GET['id'], 
				":smi_idx"=>$_GET['cidx'], 
				":lang"=>LANG_ID, 
				":status"=>1
				));
				$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
				$this->out[0] = '<ul>';
				$this->out[0] .= '<li><a href="#tabs-1">General</a></li>';
				$this->out[0] .= '<li><a href="#tabs-2">Content</a></li>';
				$this->out[0] .= '<li><a href="#tabs-3">More info</a></li>';
				$this->out[0] .= '<li><a href="#tabs-4">Manage photo</a></li>';
				$this->out[0] .= '<li><a href="#tabs-5">Manage files</a></li>';			
				$this->out[0] .= '</ul>';
				$this->out[1] = '<div id="tabs-1">';
				$this->out[1] .= $this->general_form_news($fetch);
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-2">';
				$this->out[1] .= $this->content_form_news($fetch);
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-3">';
				$this->out[1] .= $this->content_more_info($fetch,$c);
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-4">';
				$this->out[1] .= $this->content_images($fetch,$c);
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-5">';
				$this->out[1] .= $this->content_files_catalog($fetch,$c);
				$this->out[1] .= '</div>';
			}else{
				$this->out[0] = '<ul>';
				$this->out[0] .= '<li><a href="#tabs-1">General</a></li>';
				$this->out[0] .= '<li><a href="#tabs-2">Content</a></li>';
				$this->out[0] .= '<li class="justlink"><a href="javascript:;" onclick="redirect(\'_self\',\'?action=catalogModule&type=catalogpage&id='.$_GET['id'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'\')">Manage team</a></li>';
				$this->out[0] .= '</ul>';
				$this->out[1] = '<div id="tabs-1">';
				$this->out[1] .= $this->general_form($fetch,'Text Page');
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-2">';
				$this->out[1] .= $this->content_form($fetch);
				$this->out[1] .= '</div>';
			}
			break;
			case "photogallerypage": 
			if(isset($_GET['action']) && $_GET['action']=="editMediaItem"){
				$sql = 'SELECT 
				`studio404_media_item`.`idx` AS smi_idx,
				`studio404_media_item`.`date` AS smi_date,  
				`studio404_media_item`.`expiredate` AS smi_expiredate,  
				`studio404_media_item`.`media_idx` AS smi_media_idx,  
				`studio404_media_item`.`title` AS smi_title,  
				`studio404_media_item`.`description` AS smi_description,  
				`studio404_media_item`.`tags` AS smi_tags,  
				`studio404_media_item`.`slug` AS smi_slug,  
				`studio404_media_item`.`position` AS smi_position,  
				`studio404_media_item`.`lang` AS smi_lang,  
				`studio404_media_item`.`visibility` AS smi_visibility 
				FROM 
				`studio404_media_attachment`,`studio404_media`,`studio404_media_item` 
				WHERE 
				`studio404_media_attachment`.`connect_idx`=:connect_idx AND 
				`studio404_media_attachment`.`lang`=:lang AND 
				`studio404_media_attachment`.`status`!=:status AND 
				`studio404_media_attachment`.`idx`=`studio404_media`.`idx` AND 
				`studio404_media`.`lang`=:lang AND 
				`studio404_media`.`status`!=:status AND 
				`studio404_media`.`idx`=`studio404_media_item`.`media_idx` AND 
				`studio404_media_item`.`idx`=:smi_idx AND 
				`studio404_media_item`.`lang`=:lang AND 
				`studio404_media_item`.`status`!=:status 
				';
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
				":connect_idx"=>$_GET['id'], 
				":smi_idx"=>$_GET['midx'], 
				":lang"=>LANG_ID, 
				":status"=>1
				));
				$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
				$this->out[0] = '<ul>';
				$this->out[0] .= '<li><a href="#tabs-1">General</a></li>';
				$this->out[0] .= '<li><a href="#tabs-2">Content</a></li>';
				$this->out[0] .= '<li><a href="#tabs-3">Manage photo</a></li>';		
				$this->out[0] .= '</ul>';
				$this->out[1] = '<div id="tabs-1">';
				$this->out[1] .= $this->general_form_gallery($fetch);
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-2">';
				$this->out[1] .= $this->content_form_gallery($fetch);
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-3">';
				$this->out[1] .= $this->content_images($fetch,$c);
				$this->out[1] .= '</div>';
			}else{
				$this->out[0] = '<ul>';
				$this->out[0] .= '<li><a href="#tabs-1">General</a></li>';
				$this->out[0] .= '<li><a href="#tabs-2">Content</a></li>';
				$this->out[0] .= '<li class="justlink"><a href="javascript:;" onclick="redirect(\'_self\',\'?action=gallery&type=photogallerypage&id='.$_GET['id'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'\')">Manage gallery folders</a></li>';
				$this->out[0] .= '</ul>';
				$this->out[1] = '<div id="tabs-1">';
				$this->out[1] .= $this->general_form($fetch,'Text Page');
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-2">';
				$this->out[1] .= $this->content_form($fetch);
				$this->out[1] .= '</div>';
			}
			break;
			case "videogallerypage": 
			if(isset($_GET['action']) && $_GET['action']=="editMediaItem"){
				$sql = 'SELECT 
				`studio404_media_item`.`idx` AS smi_idx,
				`studio404_media_item`.`date` AS smi_date,  
				`studio404_media_item`.`expiredate` AS smi_expiredate,  
				`studio404_media_item`.`media_idx` AS smi_media_idx,  
				`studio404_media_item`.`title` AS smi_title,  
				`studio404_media_item`.`description` AS smi_description,  
				`studio404_media_item`.`tags` AS smi_tags,  
				`studio404_media_item`.`slug` AS smi_slug,  
				`studio404_media_item`.`position` AS smi_position,  
				`studio404_media_item`.`lang` AS smi_lang,  
				`studio404_media_item`.`visibility` AS smi_visibility 
				FROM 
				`studio404_media_attachment`,`studio404_media`,`studio404_media_item` 
				WHERE 
				`studio404_media_attachment`.`connect_idx`=:connect_idx AND 
				`studio404_media_attachment`.`lang`=:lang AND 
				`studio404_media_attachment`.`status`!=:status AND 
				`studio404_media_attachment`.`idx`=`studio404_media`.`idx` AND 
				`studio404_media`.`lang`=:lang AND 
				`studio404_media`.`status`!=:status AND 
				`studio404_media`.`idx`=`studio404_media_item`.`media_idx` AND 
				`studio404_media_item`.`idx`=:smi_idx AND 
				`studio404_media_item`.`lang`=:lang AND 
				`studio404_media_item`.`status`!=:status 
				';
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
				":connect_idx"=>$_GET['id'], 
				":smi_idx"=>$_GET['midx'], 
				":lang"=>LANG_ID, 
				":status"=>1
				));
				$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
				$this->out[0] = '<ul>';
				$this->out[0] .= '<li><a href="#tabs-1">General</a></li>';
				$this->out[0] .= '<li><a href="#tabs-2">Content</a></li>';
				$this->out[0] .= '<li><a href="#tabs-3">Manage video</a></li>';		
				$this->out[0] .= '</ul>';
				$this->out[1] = '<div id="tabs-1">';
				$this->out[1] .= $this->general_form_gallery($fetch);
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-2">';
				$this->out[1] .= $this->content_form_gallery($fetch);
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-3">';
				$this->out[1] .= $this->content_images($fetch,$c,"video");
				$this->out[1] .= '</div>';
			}else{
				$this->out[0] = '<ul>';
				$this->out[0] .= '<li><a href="#tabs-1">General</a></li>';
				$this->out[0] .= '<li><a href="#tabs-2">Content</a></li>';
				$this->out[0] .= '<li class="justlink"><a href="javascript:;" onclick="redirect(\'_self\',\'?action=gallery&type=videogallerypage&id='.$_GET['id'].'&super='.$_GET['super'].'&token='.$_SESSION['token'].'\')">Manage gallery folders</a></li>';
				$this->out[0] .= '</ul>';
				$this->out[1] = '<div id="tabs-1">';
				$this->out[1] .= $this->general_form($fetch,'Text Page');
				$this->out[1] .= '</div>';
				$this->out[1] .= '<div id="tabs-2">';
				$this->out[1] .= $this->content_form($fetch);
				$this->out[1] .= '</div>';
			}
			break;
		}

		return $this->out;
	}

	public function general_form_components($c){
		$conn = $this->conn($c); 
		$sql = 'SELECT `name` FROM `studio404_components` WHERE `id`=:id';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":id"=>$_GET['id']
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC); 


		$this->out[0] = '<ul>';
		$this->out[0] .= '<li><a href="#tabs-1">General</a></li>';
		$this->out[0] .= '<li class="justlink"><a href="javascript:;" onclick="redirect(\'_self\',\'?action=componentModule&id='.$_GET['id'].'&token='.$_SESSION['token'].'\')">Manage '.htmlentities($fetch["name"]).'</a></li>';
		$this->out[0] .= '</ul>';
		$this->out[1] = '<div id="tabs-1">';
		$this->out[1] .= '<label for="title">Name: <font color="RED">*</font></label>';
		$this->out[1] .= '<input type="text" name="name" id="name" value="'.htmlentities($fetch["name"]).'" autocomplete="off">';
		$this->out[1] .= '</div>';

		return $this->out;
	}

	public function content_more_info($fetch,$c){
		$out = '<div class="button" style="background-color:green">
					<a href="http://developer.404.ge/en/admin?action=addCatalogMoreInfo" style="color:white"><i class="fa fa-plus"></i><span>Add info</span> </a>
				</div>
				<div class="button makeFileDragable3" style="background-color:green; margin-left:10px;">
					<a href="#" style="color:white"><i class="fa fa-arrows"></i><span id="dragText3">Start sorting</span> </a>
				</div>
				';
		$out .= '<div class="clearfix"></div>';
		

		$out .= '<div class="moreinfo-add-list">';
		$out .= $this->selectmoreinfo($c);
		$out .= '</div>';

		$out .= '<div class="dragElements3"><div id="appmoreinfo">';

		$out .= $this->insertedmoreinfo($c);

		$out .= '</div>';

		$out .= '<div class="clearfix"></div>';

		$out .= '</div>';

		$out .= '<script type="text/javascript">';
		$out .= "$(\".info-name\").click(function(){
		var htm = $(this).html();
		var htm_id = $(this).data('id');
		$(this).fadeOut('slow');
		var o = ''; 
		o += '<div class=\"info-list\" style=\"display:block; margin-top:10px; width:100%; float:left\">';
		o += '<input type=\"hidden\" name=\"infoname_id[]\" value=\"'+htm_id+'\" class=\"hiddenVal\" />';
		o += '<input type=\"text\" name=\"infoname[]\" class=\"readOnlyName\" value=\"'+htm+'\" readonly=\"readonly\" autocomplete=\"off\" placeholder=\"Name\" style=\"width:300px;\" />';
		o += '<input type=\"text\" name=\"infovalue[]\" value=\"\" autocomplete=\"off\" placeholder=\"Value\" style=\"width:450px; margin-left:10px;\" />';
		o += '<a href=\"#\" class=\"ddrag\" style=\"width:20px; font-size:18px; margin-left:10px; color:#555555; \"><i class=\"fa fa-arrows\" title=\"drag info\"></i></a>';
		o += '<a href=\"javascript:;\" style=\"width:20px; font-size:18px; margin-left:10px;\" class=\"removeInfo\"><i class=\"fa fa-times\"></i></a>';
		o += '</div><div class=\"clearfix\"></div>';
		$(\"#appmoreinfo\").append(o);
		});";
		$out .= '</script>';
		return $out;
	}

	public function general_form_news($fetch){
		$date = (empty($fetch['smi_date'])) ? date('d-m-Y H:i') : date('d-m-Y H:i',$fetch['smi_date']);
		$expiredate = (empty($fetch['smi_expiredate'])) ? date('d-m-Y H:i') : date('d-m-Y H:i',$fetch['smi_expiredate']);
		
		$out = '<label for="date">Date: <font color="RED">*</font></label>';
		$out .= '<input type="text" name="date" id="date" class="datepicker" value="'.$date.'" />';
		$out .= '<label for="expiredate">Expire date: <font color="RED">*</font></label>';
		$out .= '<input type="text" name="expiredate" id="expiredate" class="datepicker" value="'.$expiredate.'" />';
		$out .= '<script>$(function(){ $(".datepicker").datetimepicker({ dateFormat: \'dd-mm-yy\', changeYear: true }); }); </script>';



		$out .= '<label for="title">Title: <font color="RED">*</font></label>';
		$out .= '<input type="text" name="title" id="title" value="'.htmlentities($fetch["smi_title"]).'" autocomplete="off">';

		$out .= '<label for="friendlyurl">Friendly URL: <font color="RED">*</font></label><br />';

		$out .= '<input type="text" name="friendlyurl" value="'.htmlentities(WEBSITE.LANG.'/'.$fetch["smi_slug"]).'" disabled="disabled" /><div class="clearfix"></div>';

		$out .= '<label for="videourl">Video Url: (youtube,myvideo)</label>';
		$out .= '<input type="text" name="videourl" id="videourl" value="'.htmlentities($fetch["smi_videourl"]).'" autocomplete="off">';

		$out .= '<label for="tags">Tags: (Comma seperated value)</label>';
		$out .= '<input type="text" name="tags" id="tags" value="'.htmlentities($fetch["smi_tags"]).'" autocomplete="off">';

		$out .= '<label for="visibility">Visibility: <font color="RED">*</font></label><br />';
		if($fetch['smi_visibility']==1){ $true = ''; $false = 'checked="checked"'; }
		else if($fetch['smi_visibility']==2){ $true = 'checked="checked"'; $false = ''; }
		else{ $true = ''; $false = 'checked="checked"'; }

		$out .= '<label>Show &nbsp;&nbsp;&nbsp;<input type="radio" name="visibility" value="true" '.$true.' /></label>&nbsp;&nbsp;&nbsp;';
		
		$out .= '<label>Hide &nbsp;&nbsp;&nbsp;<input type="radio" name="visibility" value="false" '.$false.' /></label>';

		return $out;
	}


	public function general_form_gallery($fetch){
		$date = (empty($fetch['smi_date'])) ? date('d-m-Y H:i') : date('d-m-Y H:i',$fetch['smi_date']);
		$expiredate = (empty($fetch['smi_expiredate'])) ? date('d-m-Y H:i') : date('d-m-Y H:i',$fetch['smi_expiredate']);
		
		$out = '<label for="date">Date: <font color="RED">*</font></label>';
		$out .= '<input type="text" name="date" id="date" class="datepicker" value="'.$date.'" />';
		$out .= '<label for="expiredate">Expire date: <font color="RED">*</font></label>';
		$out .= '<input type="text" name="expiredate" id="expiredate" class="datepicker" value="'.$expiredate.'" />';
		$out .= '<script>$(function(){ $(".datepicker").datetimepicker({ dateFormat: \'dd-mm-yy\', changeYear: true }); }); </script>';



		$out .= '<label for="title">Title: <font color="RED">*</font></label>';
		$out .= '<input type="text" name="title" id="title" value="'.htmlentities($fetch["smi_title"]).'" autocomplete="off">';

		$out .= '<label for="friendlyurl">Friendly URL: <font color="RED">*</font></label><br />';

		$out .= '<input type="text" name="friendlyurl" value="'.htmlentities(WEBSITE.LANG.'/'.$fetch["smi_slug"]).'" disabled="disabled" /><div class="clearfix"></div>';

		$out .= '<label for="tags">Tags: (Comma seperated value)</label>';
		$out .= '<input type="text" name="tags" id="tags" value="'.htmlentities($fetch["smi_tags"]).'" autocomplete="off">';

		$out .= '<label for="visibility">Visibility: <font color="RED">*</font></label><br />';
		if($fetch['smi_visibility']==1){ $true = ''; $false = 'checked="checked"'; }
		else if($fetch['smi_visibility']==2){ $true = 'checked="checked"'; $false = ''; }
		else{ $true = ''; $false = 'checked="checked"'; }

		$out .= '<label>Show &nbsp;&nbsp;&nbsp;<input type="radio" name="visibility" value="true" '.$true.' /></label>&nbsp;&nbsp;&nbsp;';
		
		$out .= '<label>Hide &nbsp;&nbsp;&nbsp;<input type="radio" name="visibility" value="false" '.$false.' /></label>';

		return $out;
	}



	public function general_form($fetch,$page_type){
		$date = (empty($fetch['date'])) ? date('d-m-Y H:i') : date('d-m-Y H:i',$fetch['date']);
		$expiredate = (empty($fetch['expiredate'])) ? date('d-m-Y H:i') : date('d-m-Y H:i',$fetch['expiredate']);
		
		$out = '<label for="date">Date: <font color="RED">*</font></label>';
		$out .= '<input type="text" name="date" id="date" class="datepicker" value="'.$date.'" />';
		$out .= '<label for="expiredate">Expire date: <font color="RED">*</font></label>';
		$out .= '<input type="text" name="expiredate" id="expiredate" class="datepicker" value="'.$expiredate.'" />';
		$out .= '<script>$(function(){ $(".datepicker").datetimepicker({ dateFormat: \'dd-mm-yy\', changeYear: true }); }); </script>';
		
		$out .= '<label for="title">Title: <font color="RED">*</font></label>';
		$out .= '<input type="text" name="title" id="title" value="'.htmlentities($fetch['title']).'" autocomplete="off">';
		$out .= '<label for="shorttitle">Short title: <font color="RED">*</font></label>';
		$out .= '<input type="text" name="shorttitle" id="shorttitle" value="'.htmlentities($fetch['shorttitle']).'" autocomplete="off">';
		$out .= '<label for="friendlyurl">Friendly URL: <font color="RED">*</font></label><br />';
		$out .= '<span class="frURL">'.WEBSITE.LANG.'/</span>';
		$out .= '<input type="text" name="friendlyurl" id="friendlyurl" class="frURLInput" value="'.htmlentities($fetch['slug']).'" autocomplete="off" /><div class="clearfix"></div>';
		
		$out .= '<label for="page_type">Page type: <font color="RED">*</font></label>';
		$out .= '<select name="page_type" id="page_type" class="page_type" disabled>';
		$out .= '<option value="false">'.$page_type.'</option>';
		$out .= '</select>';
		$out .= '<label for="redirectLink">Redirect link:</label>';
		$out .= '<input type="text" name="redirectLink" id="redirectLink" value="'.htmlentities($fetch['redirectlink']).'" autocomplete="off">';
		$out .= '<label for="keywords">Keywords: (example: money, transfer, bussiness )</label>';
		$out .= '<input type="text" name="keywords" id="keywords" value="'.htmlentities($fetch['keywords']).'" autocomplete="off">';
		$out .= '<label for="backgroundImage">Background Image:</label><br />';
		$out .= '<input type="hidden" name="background" id="background" value="" />';
		$out .= '<div class="dragableArea"> <h3>Drag and drop image (jpeg,jpg,gif,png)</h3><div id="progress-bar"></div></div><br />';
		if($fetch['background']){
			$out .= '<div id="img"><img src="'.$fetch['background'].'" width="100%"><div class="close" onclick="removePreFile(\''.$_GET['id'].'\')"><i class="fa fa-times"></i></div></div>';
		}else{
			$out .= '<div id="img"> <p>No Image</p> </div> <div class="clearfix"></div> <br />';
		}
		$out .= '<label for="videourl">Video Url: (youtube,myvideo)</label>';
		$out .= '<input type="text" name="videourl" id="videourl" value="'.htmlentities($fetch['videourl']).'" autocomplete="off">';
		$out .= '<label for="visibility">Visibility: <font color="RED">*</font></label><br />';
		if($fetch['visibility']==1){ $true = ''; $false = 'checked="checked"'; }
		else if($fetch['visibility']==2){ $true = 'checked="checked"'; $false = ''; }
		else{ $true = ''; $false = 'checked="checked"'; }

		$out .= '<label>Show &nbsp;&nbsp;&nbsp;<input type="radio" name="visibility" value="true" '.$true.' /></label>&nbsp;&nbsp;&nbsp;';
		
		$out .= '<label>Hide &nbsp;&nbsp;&nbsp;<input type="radio" name="visibility" value="false" '.$false.' /></label>';
		return $out;
	}

	public function content_form_news($fetch){
		$out = '<label>Short description: </label>';
		$out .= '<textarea name="short_description" class="tinyMce">'.htmlentities($fetch['smi_short_description']).'</textarea>';
		$out .= '<label>Long description: </label>';
		$out .= '<textarea name="long_description" class="tinyMce">'.htmlentities($fetch['smi_long_description']).'</textarea>';
		return $out;
	}

	public function content_form_gallery($fetch){
		$out .= '<label>Description: </label>';
		$out .= '<textarea name="description" class="tinyMce">'.htmlentities($fetch['smi_description']).'</textarea>';
		return $out;
	}

	public function content_form($fetch){
		$out = '<label>Description: </label>';
		$out .= '<textarea name="description" class="tinyMce">'.htmlentities($fetch['description']).'</textarea>';
		$out .= '<label>Page content: </label>';
		$out .= '<textarea name="pagecontent" class="tinyMce">'.htmlentities($fetch['text']).'</textarea>';
		return $out;
	}

	public function content_files_catalog($fetch,$c){
		$color_array = array(
			"pdf"=>"#e74c3c", 
			"doc"=>"#2ecc71", 
			"docx"=>"#27ae60", 
			"xls"=>"#1abc9c", 
			"xlsx"=>"#16a085", 
			"zip"=>"#4aa3df", 
			"rar"=>"#2980b9" 
		);
		$out = '<div class="button makeFileDragable" style="background-color:green">
					<a href="#" style="color:white"><i class="fa fa-arrows"></i><span id="dragText">Start sorting</span></a>
				</div><div class="clearfix"></div>';
		$out .= '<div class="dropArea">';
		$out .= '<div class="Droptitle">Drag and drop file (pdf,doc,docx,xls,xlsx,zip,rar) <span id="progress">0%</span></div>';
		$out .= '<div class="dragElements" id="dragElements">';
		//select files
		$conn = $this->conn($c);
		if(isset($_GET['cidx'])){ $sp_idx=$_GET['cidx']; }
		// get page type
		$get_page_type = new get_page_type();
		$page_type = $get_page_type->type($_SESSION["C"],$_GET['id']);

		$sql = 'SELECT 
		`studio404_gallery_file`.`id` AS sgf_id,
		`studio404_gallery_file`.`idx` AS sgf_idx, 
		`studio404_gallery_file`.`title` AS sgf_title, 
		`studio404_gallery_file`.`file` AS sgf_file
		FROM 
		`studio404_gallery_attachment`,`studio404_gallery`, `studio404_gallery_file`
		WHERE 
		`studio404_gallery_attachment`.`connect_idx`=:sp_idx AND  
		`studio404_gallery_attachment`.`lang`=:lang AND  
		`studio404_gallery_attachment`.`pagetype`=:page_type AND  
		`studio404_gallery_attachment`.`status`!=:status AND  
		`studio404_gallery_attachment`.`idx`=`studio404_gallery`.`idx` AND  
		`studio404_gallery`.`lang`=:lang AND 
		`studio404_gallery`.`status`!=:status AND 
		`studio404_gallery`.`idx`=`studio404_gallery_file`.`gallery_idx` AND 
		`studio404_gallery_file`.`lang`=:lang AND 
		`studio404_gallery_file`.`media_type`=:media_type AND 
		`studio404_gallery_file`.`status`!=:status 
		ORDER BY `studio404_gallery_file`.`position` ASC
		';
		$prepare = $conn->prepare($sql); 
		$prepare->execute(array(
			":sp_idx"=>$sp_idx, 
			":lang"=>LANG_ID, 
			":media_type"=>'document', 
			":page_type"=>$page_type, 
			":status"=>1
		));
		$prepare->setFetchMode(PDO::FETCH_CLASS, "get_files"); 
		while($r = $prepare->fetch()){
			$out .= '<div class="filebox" style="background-color:'.$color_array[$r->handler].'" id="flexbox-'.$r->sgf_idx.'">';
			$out .= '<div class="action_panel">';
			$out .= '<a href="/'.$r->sgf_file.'" target="_blank"><i class="fa fa-eye"></i></a>';
			$out .= '<a href="javascript:;" onclick="openPromt(\''.$r->sgf_idx.'\')"><i class="fa fa-pencil-square-o"></i></a>';
			$out .= '<a href="javascript:;" onclick="askBeforeDelete(\'file\',\''.$r->sgf_idx.'\')"><i class="fa fa-times"></i></a>';
			$out .= '</div>';
			$out .= '<div class="extention">'.$r->handler.'</div>';
			$out .= '<div class="filename n-'.$r->sgf_idx.'" id="fid-'.$r->sgf_id.'">'.$r->sgf_title.'</div>';
			$out .= '</div>';
		}		
		$out .= '</div><div class="clearfix"></div></div><div class="clearfix"></div>';
		return $out;
	}

	public function content_files($fetch,$c){
		$color_array = array(
			"pdf"=>"#e74c3c", 
			"doc"=>"#2ecc71", 
			"docx"=>"#27ae60", 
			"xls"=>"#1abc9c", 
			"xlsx"=>"#16a085", 
			"zip"=>"#4aa3df", 
			"rar"=>"#2980b9" 
		);
		$out = '<div class="button makeFileDragable" style="background-color:green">
					<a href="#" style="color:white"><i class="fa fa-arrows"></i><span id="dragText">Start sorting</span></a>
				</div><div class="clearfix"></div>';
		$out .= '<div class="dropArea">';
		$out .= '<div class="Droptitle">Drag and drop file (pdf,doc,docx,xls,xlsx,zip,rar) <span id="progress">0%</span></div>';
		$out .= '<div class="dragElements" id="dragElements">';
		//select files
		$conn = $this->conn($c);
		if(isset($_GET['newsidx'])){ $sp_idx=$_GET['newsidx']; }
		else if(isset($_GET['cidx'])){ $sp_idx=$_GET['cidx']; }
		else{ $sp_idx=$_GET['id']; }
		// get page type
		$get_page_type = new get_page_type();
		$page_type = $get_page_type->type($_SESSION["C"],$_GET['id']);

		$sql = 'SELECT 
		`studio404_gallery_file`.`id` AS sgf_id,
		`studio404_gallery_file`.`idx` AS sgf_idx, 
		`studio404_gallery_file`.`title` AS sgf_title, 
		`studio404_gallery_file`.`file` AS sgf_file
		FROM 
		`studio404_gallery_attachment`,`studio404_gallery`, `studio404_gallery_file`
		WHERE 
		`studio404_gallery_attachment`.`connect_idx`=:sp_idx AND  
		`studio404_gallery_attachment`.`lang`=:lang AND  
		`studio404_gallery_attachment`.`pagetype`=:page_type AND  
		`studio404_gallery_attachment`.`status`!=:status AND  
		`studio404_gallery_attachment`.`idx`=`studio404_gallery`.`idx` AND  
		`studio404_gallery`.`lang`=:lang AND 
		`studio404_gallery`.`status`!=:status AND 
		`studio404_gallery`.`idx`=`studio404_gallery_file`.`gallery_idx` AND 
		`studio404_gallery_file`.`lang`=:lang AND 
		`studio404_gallery_file`.`media_type`=:media_type AND 
		`studio404_gallery_file`.`status`!=:status 
		ORDER BY `studio404_gallery_file`.`position` ASC
		';
		$prepare = $conn->prepare($sql); 
		$prepare->execute(array(
			":sp_idx"=>$sp_idx, 
			":lang"=>LANG_ID, 
			":media_type"=>'document', 
			":page_type"=>$page_type, 
			":status"=>1
		));
		$prepare->setFetchMode(PDO::FETCH_CLASS, "get_files"); 
		while($r = $prepare->fetch()){
			$out .= '<div class="filebox" style="background-color:'.$color_array[$r->handler].'" id="flexbox-'.$r->sgf_idx.'">';
			$out .= '<div class="action_panel">';
			$out .= '<a href="/'.$r->sgf_file.'" target="_blank"><i class="fa fa-eye"></i></a>';
			$out .= '<a href="javascript:;" onclick="openPromt(\''.$r->sgf_idx.'\')"><i class="fa fa-pencil-square-o"></i></a>';
			$out .= '<a href="javascript:;" onclick="askBeforeDelete(\'file\',\''.$r->sgf_idx.'\')"><i class="fa fa-times"></i></a>';
			$out .= '</div>';
			$out .= '<div class="extention">'.$r->handler.'</div>';
			$out .= '<div class="filename n-'.$r->sgf_idx.'" id="fid-'.$r->sgf_id.'">'.$r->sgf_title.'</div>';
			$out .= '</div>';
		}		
		$out .= '</div><div class="clearfix"></div></div><div class="clearfix"></div>';
		return $out;
	}


	public function content_images($fetch,$c,$media_type="photo"){
		if(isset($_GET["type"]) && $_GET["type"]=='videogallerypage'){
			$ext = 'mp4,avi';
		}else{
			$ext = 'jpeg,jpg,gif,png';
		}

		$out = '<div class="button makeFileDragable2" style="background-color:green">
					<a href="#" style="color:white"><i class="fa fa-arrows"></i><span id="dragText2">Start sorting</span> </a>
				</div><div class="clearfix"></div>';	

		$out .= '<div class="dropArea2">';
		$out .= '<div class="Droptitle2">
				Drag and drop photo ('.$ext.') 
				<span id="progress2">0%</span>
			</div>';
		$out .= '<div class="dragElements2">';
		/////////////// start
		$conn = $this->conn($c);
		if(isset($_GET['newsidx'])){ $sp_idx=$_GET['newsidx']; }
		else if(isset($_GET['cidx'])){ $sp_idx=$_GET['cidx']; }
		else if(isset($_GET['midx'])){ $sp_idx=$_GET['midx']; }
		else{ $sp_idx=$_GET['id']; }
		// get page type
		$get_page_type = new get_page_type();
		$page_type = $get_page_type->type($_SESSION["C"],$_GET['id']);

		$sql = 'SELECT 
		`studio404_gallery_file`.`id` AS sgf_id,
		`studio404_gallery_file`.`idx` AS sgf_idx, 
		`studio404_gallery_file`.`title` AS sgf_title, 
		`studio404_gallery_file`.`file` AS sgf_file
		FROM 
		`studio404_gallery_attachment`,`studio404_gallery`, `studio404_gallery_file`
		WHERE 
		`studio404_gallery_attachment`.`connect_idx`=:sp_idx AND  
		`studio404_gallery_attachment`.`lang`=:lang AND  
		`studio404_gallery_attachment`.`pagetype`=:page_type AND  
		`studio404_gallery_attachment`.`status`!=:status AND  
		`studio404_gallery_attachment`.`idx`=`studio404_gallery`.`idx` AND  
		`studio404_gallery`.`lang`=:lang AND 
		`studio404_gallery`.`status`!=:status AND 
		`studio404_gallery`.`idx`=`studio404_gallery_file`.`gallery_idx` AND 
		`studio404_gallery_file`.`lang`=:lang AND 
		`studio404_gallery_file`.`media_type`=:media_type AND 
		`studio404_gallery_file`.`status`!=:status 
		ORDER BY `studio404_gallery_file`.`position` ASC
		';
		$prepare = $conn->prepare($sql); 
		$prepare->execute(array(
			":sp_idx"=>$sp_idx, 
			":lang"=>LANG_ID, 
			":media_type"=>$media_type, 
			":page_type"=>$page_type, 
			":status"=>1
		));
		$prepare->setFetchMode(PDO::FETCH_CLASS, "get_files"); 
		while($r = $prepare->fetch()){
			$out .= '<div class="filebox2" id="flexbox2-'.$r->sgf_idx.'">';
			$out .= '<div class="action_panel2">';
			$out .= '<a href="/'.$r->sgf_file.'" class="fancyBox"><i class="fa fa-eye"></i></a>';
			$out .= '<a href="javascript:;" onclick="openPromt2(\''.$r->sgf_idx.'\')"><i class="fa fa-pencil-square-o"></i></a>';
			$out .= '<a href="javascript:;" onclick="askBeforeDelete(\''.$media_type.'\',\''.$r->sgf_idx.'\')"><i class="fa fa-times"></i></a>';
			$out .= '</div>';
			if($media_type=="video"){
				$out .= '<div class="extention2"><img src="/images/video_icon.png" width="100%" /></div>';	
			}else{
				$out .= '<div class="extention2"><img src="/'.$r->sgf_file.'" width="100%" /></div>';
			}
			$out .= '<div class="filename2 n2-'.$r->sgf_idx.'" id="fid2-'.$r->sgf_id.'">'.$r->sgf_title.'</div>';
			$out .= '</div>';
		}		
		/////////////// end
		$out .= '</div><div class="clearfix"></div>';
		$out .= '</div>';
		return $out;
	}

	public function selectmoreinfo($c){
		$out = '';
		$conn = $this->conn($c); 
		$sql = 'SELECT `idx`,`name` FROM `studio404_catalog_info` WHERE `lang`=:lang AND `status`!=:status';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":lang"=>LANG_ID,
			":status"=>1
		));
		$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		foreach ($fetch as $value) {
			if($this->checkInfoExists($c, $value['idx'])){ continue; }
			$out .= '<div class="info-name" data-id="'.$value['idx'].'">'.$value['name'].'</div>';
		} 
		return $out;
	}

	public function checkInfoExists($c, $idx){
		$conn = $this->conn($c); 
		$sql = 'SELECT `id` FROM `studio404_catalog_info_values` WHERE `cidx`=:cidx AND `item_idx`=:item_idx AND `sci_idx`=:idx AND `lang`=:lang';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":cidx"=>$_GET['cidx'], 
			":item_idx"=>$_GET['id'], 
			":idx"=>$idx, 
			":lang"=>LANG_ID
		));
		$rowCount = $prepare->rowCount();
		return $rowCount;
	}

	public function insertedmoreinfo($c){
		$conn = $this->conn($c);
		$sql = 'SELECT 
		`studio404_catalog_info`.`name` AS sci_name, 
		`studio404_catalog_info_values`.`sci_idx` AS sciv_sci_idx, 
		`studio404_catalog_info_values`.`value` AS sciv_value, 
		`studio404_catalog_info_values`.`lang` AS sciv_lang, 
		`studio404_catalog_info_values`.`position` AS sciv_position 
		FROM 
		`studio404_catalog_info_values`, `studio404_catalog_info` 
		WHERE 
		`studio404_catalog_info_values`.`cidx`=:cidx AND 
		`studio404_catalog_info_values`.`item_idx`=:item_idx AND 
		`studio404_catalog_info_values`.`lang`=:lang AND 
		`studio404_catalog_info_values`.`sci_idx`=`studio404_catalog_info`.`idx` AND 
		`studio404_catalog_info`.`lang`=:lang AND 
		`studio404_catalog_info`.`status`!=:status 
		ORDER BY `studio404_catalog_info_values`.`position` ASC  
		';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":cidx"=>$_GET['cidx'], 
			":item_idx"=>$_GET['id'], 
			":lang"=>LANG_ID, 
			":status"=>1
		));
		$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);

		foreach($fetch as $row)
		{
			$out .= '<div class="info-list" style="display:block; margin-top:10px;" id="l-0">';
			$out .= '<input type="hidden" name="infoname_id[]" value="'.htmlentities($row['sciv_sci_idx']).'" class="hiddenVal" />';
			$out .= '<input type="text" name="infoname[]" value="'.htmlentities($row['sci_name']).'" autocomplete="off" placeholder="Name" style="width:300px;" />';
			$out .= '<input type="text" name="infovalue[]" value="'.htmlentities($row['sciv_value']).'" autocomplete="off" placeholder="Value" style="width:450px; margin-left:10px;" />';
			$out .= '<a href="#" class="ddrag" style="width:20px; font-size:18px; margin-left:10px; color:#555555;"><i class="fa fa-arrows" title="drag info"></i></a>';
			$out .= '<a href="#" class="removeInfo" style="width:20px; font-size:18px; margin-left:10px;" title="remove info"><i class="fa fa-times"></i></a>';
			$out .= '</div>';
		}
		return $out;
	}

	function __destruct(){
		
	}
}
?>