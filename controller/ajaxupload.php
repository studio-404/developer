<?php if(!defined("DIR")){ exit(); }
class ajaxupload extends connection{
	function __construct(){
		set_time_limit($_SESSION["C"]["time.limit"]); 
		$conn = $this->conn($_SESSION["C"]);
		$allowfiletypes = array("doc","docx","xls","xlsx","zip","rar","pdf");
		$allowfiletypes2 = array("jpg","jpeg","gif","png","mp4","avi");

		if(!isset($_GET['extention']) && !isset($_GET['filename']) && !isset($_GET['removefile']) && !isset($_GET['idxes']) && !isset($_GET['idxes2']) && !isset($_GET['idxes3']) && !isset($_GET['idxes_photos']) && !isset($_POST['youtubeLink'])){
			$str = file_get_contents("php://input");
			$filename = md5(time()).".jpg";
			$path = 'files_pre/'.$filename;
			file_put_contents($path, $str);
			echo $path;	
		}else if(isset($_GET['pageidx'],$_GET['extention'],$_GET['token']) && in_array($_GET['extention'], $allowfiletypes)){
			$pageidx = (isset($_GET['newsidx']) && $_GET['newsidx']!="false") ? $_GET['newsidx'] : $_GET['pageidx'];
			// get page type
			$get_page_type = new get_page_type();
			$page_type = $get_page_type->type($_SESSION["C"],$_GET['pageidx']);

			$str = file_get_contents("php://input");
			$timegenerate = md5(time());
			$filename = $timegenerate.".".$_GET['extention'];
			$path = 'files_pre/'.$filename;
			$color_array = array(
			"pdf"=>"#e74c3c", 
			"doc"=>"#2ecc71", 
			"docx"=>"#27ae60", 
			"xls"=>"#1abc9c", 
			"xlsx"=>"#16a085", 
			"zip"=>"#4aa3df", 
			"rar"=>"#2980b9" 
			);
			file_put_contents($path, $str);
			
			// check if exists attachment
			$sql = 'SELECT 
			`studio404_gallery`.`idx` AS `sg_idx` 
			FROM 
			`studio404_gallery_attachment`,`studio404_gallery` 
			WHERE 
			`studio404_gallery_attachment`.`connect_idx`=:connect_idx AND 
			`studio404_gallery_attachment`.`status`!=:status AND 
			`studio404_gallery_attachment`.`pagetype`=:page_type AND 
			`studio404_gallery_attachment`.`idx`=`studio404_gallery`.`idx` AND 
			`studio404_gallery`.`status`!=:status
			';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":connect_idx"=>$pageidx, 
				":page_type"=>$page_type,
				":status"=>1
			));
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
			if($fetch['sg_idx']){
				// select max idx gallery photo
				try{
					$sql2 = 'SELECT `id`, MAX(`idx`) as maxid FROM `studio404_gallery_file` WHERE `lang`=:lang AND `status`!=:status'; 
					$prepare2 = $conn->prepare($sql2);  
					$prepare2->execute(array( "lang"=>LANG_ID, ":status"=>1));
					$fetch2 = $prepare2->fetch(PDO::FETCH_ASSOC);
					$maxid = ($fetch2['maxid']) ? $fetch2['maxid']+1 : 1;
					$fileid = $fetch2['id'];
				}catch(Exeption $e){
					$maxid = 1;
				}
				
				// select max position of gallery photo
				try{
					$sql3 = 'SELECT MAX(`position`) as maxpos FROM `studio404_gallery_file` WHERE `media_type`=:media_type AND `lang`=:lang AND `gallery_idx`=:gallery_idx AND `status`!=:status';
					$prepare3 = $conn->prepare($sql3);
					$prepare3->execute(array(
						":media_type"=>'document', 
						":lang"=>LANG_ID, 
						":gallery_idx"=>$fetch['sg_idx'], 
						":status"=>1
					));
					$fetch3 = $prepare3->fetch(PDO::FETCH_ASSOC);
					$maxpos = ($fetch3['maxpos']) ? $fetch3['maxpos']+1 : 1;
				}catch(Exeption $e){
					$maxpos = 1;
				}
				
				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$languages = $model_admin_selectLanguage->select_languages($_SESSION["C"]); 
				// move file to file folder
				$path_new = "files/document/".$timegenerate.".".$_GET["extention"];
				if(@copy($path,$path_new)){
					@unlink($path);
				}
				$filesize = @filesize($path_new);
				foreach($languages as $lang){
					//insert gallery photo
					$sql4 = 'INSERT INTO `studio404_gallery_file` SET 
					`idx`=:idx, 
					`date`=:datex,
					`gallery_idx`=:gallery_idx, 
					`file`=:file, 
					`media_type`=:media_type, 
					`title`=:title, 
					`description`=:description, 
					`filesize`=:filesize, 
					`insert_admin`=:insert_admin, 
					`position`=:position, 
					`lang`=:lang, 
					`status`=:status 
					';
					$prepare4 = $conn->prepare($sql4);
					$prepare4->execute(array(
						":idx"=>$maxid, 
						":datex"=>time(), 
						":gallery_idx"=>$fetch['sg_idx'], 
						":file"=>$path_new, 
						":media_type"=>"document", 
						":title"=>"Not defined", 
						":description"=>"Not defined", 
						":filesize"=>$filesize, 
						":insert_admin"=>$_SESSION["user404_id"],
						":position"=>$maxpos,
						":lang"=>$lang['id'], 
						":status"=>0
					));
				}
				//get inserted file id with current language
				$sql5 = 'SELECT `id`,`position` FROM `studio404_gallery_file` WHERE `media_type`=:media_type AND `idx`=:idx AND `lang`=:lang AND `status`!=:status';
				$prepare5 = $conn->prepare($sql5);
				$prepare5->execute(array(
					":media_type"=>'document', 
					":idx"=>$maxid, 
					":lang"=>LANG_ID, 
					":status"=>1
				));
				$fetch5 = $prepare5->fetch(PDO::FETCH_ASSOC);
				
				$out = '<div class="filebox" style="background-color:'.$color_array[$_GET['extention']].'" id="flexbox-'.$maxid.'">';
				$out .= '<div class="action_panel">';
				$out .= '<a href="/'.$path.'" target="_blank"><i class="fa fa-eye"></i></a>';
				$out .= '<a href="javascript:;" onclick="openPromt(\''.$maxid.'\')"><i class="fa fa-pencil-square-o"></i></a>';
				$out .= '<a href="javascript:;" onclick="removeFile(\''.$maxid.'\')"><i class="fa fa-times"></i></a>';
				$out .= '</div>';
				$out .= '<div class="extention">'.$_GET['extention'].'</div>';
				$out .= '<div class="filename n-'.$maxid.'" id="fid-'.$fetch5['id'].'">Not defined</div>';
				$out .= '</div>';
				echo $out;
			}
		}else if(isset($_GET['id'],$_GET['filename'])){
			$sql = 'UPDATE `studio404_gallery_file` SET `title`=:title WHERE `id`=:id';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":title"=>$_GET['filename'], 
				":id"=>$_GET['id']
			));
		}else if(isset($_GET['idx'],$_GET['idxes2'])){
			$sql = 'UPDATE `studio404_gallery_file` SET `status`=:status WHERE `idx`=:idx';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":status"=>1, 
				":idx"=>$_GET['idx']
			));
			$position=1;
			foreach($_GET['idxes2'] as $idx){
				$sql2 = 'UPDATE `studio404_gallery_file` SET `position`=:position WHERE `media_type`=:media_type AND `idx`=:idx AND `status`!=:status';
				$prepare2 = $conn->prepare($sql2);
				$prepare2->execute(array(
					":media_type"=>"document", 
					":position"=>$position, 
					":idx"=>$idx, 
					":status"=>1
				));
				$position++; 
			}
		}else if(isset($_GET['idx'],$_GET['idxes3'])){
			$media_type = (isset($_GET["media_type"]) && $_GET["media_type"]=="video") ? "video" : "photo";
			$sql = 'UPDATE `studio404_gallery_file` SET `status`=:status WHERE `idx`=:idx';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":status"=>1, 
				":idx"=>$_GET['idx']
			));
			$position=1;
			if($_GET["idxes3"]!="empty"){
				foreach($_GET['idxes3'] as $idx){
					$sql2 = 'UPDATE `studio404_gallery_file` SET `position`=:position WHERE `media_type`=:media_type AND `idx`=:idx AND `status`!=:status';
					$prepare2 = $conn->prepare($sql2);
					$prepare2->execute(array(
						":media_type"=>$media_type, 
						":position"=>$position, 
						":idx"=>$idx, 
						":status"=>1
					));
					$position++; 
				}
			}
		}else if(isset($_GET['idxes'])){
			$position=1;
			foreach($_GET['idxes'] as $idx){
				$sql = 'UPDATE `studio404_gallery_file` SET `position`=:position WHERE `media_type`=:media_type AND `idx`=:idx AND `status`!=:status';
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
					":media_type"=>"document", 
					":position"=>$position, 
					":idx"=>$idx, 
					":status"=>1
				));
				$position++; 
			}
		}else if(isset($_GET['idxes_photos'])){
			$position=1;
			$media_type = (isset($_GET["type"]) && $_GET["type"]=="videogallerypage") ? "video" : "photo";
			foreach($_GET['idxes_photos'] as $idx){
				$sql = 'UPDATE `studio404_gallery_file` SET `position`=:position WHERE `media_type`=:media_type AND `idx`=:idx AND `status`!=:status';
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
					":media_type"=>$media_type, 
					":position"=>$position, 
					":idx"=>$idx, 
					":status"=>1
				));
				$position++; 
			}
		}else if(isset($_GET['pageidx'],$_GET['extention'],$_GET['token']) && in_array($_GET['extention'], $allowfiletypes2)){
			
			$pageidx = (isset($_GET['newsidx']) && $_GET['newsidx']!="false") ? $_GET['newsidx'] : $_GET['pageidx'];
			$media_type = (isset($_GET["media"]) && $_GET["media"]=="false") ? "video" : "photo";
			// get page type
			$get_page_type = new get_page_type();
			$page_type = $get_page_type->type($_SESSION["C"],$_GET['pageidx']);
			
			// photo upload
			$str = file_get_contents("php://input");
			$timegenerate = md5(time());
			$filename = $timegenerate.".".$_GET['extention'];
			$path = 'files_pre/'.$filename;
			file_put_contents($path, $str);
			
			// check if exists attachment
			$sql = 'SELECT 
			`studio404_gallery`.`idx` AS `sg_idx` 
			FROM 
			`studio404_gallery_attachment`,`studio404_gallery` 
			WHERE 
			`studio404_gallery_attachment`.`connect_idx`=:connect_idx AND 
			`studio404_gallery_attachment`.`pagetype`=:pagetype AND 
			`studio404_gallery_attachment`.`status`!=:status AND 
			`studio404_gallery_attachment`.`idx`=`studio404_gallery`.`idx` AND 
			`studio404_gallery`.`status`!=:status
			';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":connect_idx"=>$pageidx, 
				":pagetype"=>$page_type, 
				":status"=>1 
			));
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
			if($fetch['sg_idx']){
				// select max idx gallery photo
				try{
					$sql2 = 'SELECT `id`, MAX(`idx`) as maxid FROM `studio404_gallery_file` WHERE `lang`=:lang AND `status`!=:status'; 
					$prepare2 = $conn->prepare($sql2);  
					$prepare2->execute(array( "lang"=>LANG_ID, ":status"=>1));
					$fetch2 = $prepare2->fetch(PDO::FETCH_ASSOC);
					$maxid = ($fetch2['maxid']) ? $fetch2['maxid']+1 : 1;
					$fileid = $fetch2['id'];
				}catch(Exeption $e){
					$maxid = 1;
				}
				
				// select max position of gallery photo
				try{
					$sql3 = 'SELECT MAX(`position`) as maxpos FROM `studio404_gallery_file` WHERE `media_type`=:media_type AND `lang`=:lang AND `gallery_idx`=:gallery_idx AND `status`!=:status';
					$prepare3 = $conn->prepare($sql3);
					$prepare3->execute(array(
						":media_type"=>$media_type, 
						":lang"=>LANG_ID, 
						":gallery_idx"=>$fetch['sg_idx'], 
						":status"=>1
					));
					$fetch3 = $prepare3->fetch(PDO::FETCH_ASSOC);
					$maxpos = ($fetch3['maxpos']) ? $fetch3['maxpos']+1 : 1;
				}catch(Exeption $e){
					$maxpos = 1;
				}
				
				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$languages = $model_admin_selectLanguage->select_languages($_SESSION["C"]); 
				// move file to file folder
				$path_new = "files/".$media_type."/".$timegenerate.".".$_GET["extention"];
				if(@copy($path,$path_new)){
					@unlink($path);
				}
				$filesize = @filesize($path_new);
				foreach($languages as $lang){
					//insert gallery photo
					$sql4 = 'INSERT INTO `studio404_gallery_file` SET 
					`idx`=:idx, 
					`date`=:datex,
					`gallery_idx`=:gallery_idx, 
					`file`=:file, 
					`media_type`=:media_type, 
					`title`=:title, 
					`description`=:description, 
					`filesize`=:filesize, 
					`insert_admin`=:insert_admin, 
					`position`=:position, 
					`lang`=:lang, 
					`status`=:status 
					';
					$prepare4 = $conn->prepare($sql4);
					$prepare4->execute(array(
						":idx"=>$maxid, 
						":datex"=>time(), 
						":gallery_idx"=>$fetch['sg_idx'], 
						":file"=>$path_new, 
						":media_type"=>$media_type, 
						":title"=>"Not defined", 
						":description"=>"Not defined", 
						":filesize"=>$filesize, 
						":insert_admin"=>$_SESSION["user404_id"], 
						":position"=>$maxpos,
						":lang"=>$lang['id'], 
						":status"=>0
					));
				}
				//get inserted file id with current language
				$sql5 = 'SELECT `id`,`position` FROM `studio404_gallery_file` WHERE `media_type`=:media_type AND `idx`=:idx AND `lang`=:lang AND `status`!=:status';
				$prepare5 = $conn->prepare($sql5);
				$prepare5->execute(array(
					":media_type"=>$media_type, 
					":idx"=>$maxid, 
					":lang"=>LANG_ID, 
					":status"=>1
				));
				$fetch5 = $prepare5->fetch(PDO::FETCH_ASSOC);
				$out = '<div class="filebox2" id="flexbox2-'.$maxid.'">';
				$out .= '<div class="action_panel2">';
				$out .= '<a href="/'.$path_new.'" class="fancybox"><i class="fa fa-eye"></i></a>';
				$out .= '<a href="javascript:;" onclick="openPromt2(\''.$maxid.'\')"><i class="fa fa-pencil-square-o"></i></a>';
				$out .= '<a href="javascript:;" onclick="removeFile2(\''.$maxid.'\')"><i class="fa fa-times"></i></a>';
				$out .= '</div>';
				if($media_type=="video"){
					$out .= '<div class="extention2"><img src="/images/video_icon.png" width="100%" /></div>';	
				}else{
					$out .= '<div class="extention2"><img src="/'.$path_new.'" width="100%" /></div>';
				}
				
				$out .= '<div class="filename2 n2-'.$maxid.'" id="fid2-'.$fetch5['id'].'">Not defined</div>';
				$out .= '</div>';
				echo $out;
			}
		}else if(isset($_POST['youtubeLink'])){
			///////////////////////////////////////////////////////////////////////

			$pageidx = (isset($_POST['yt_mid'])) ? $_POST['yt_mid'] : 0;
			$media_type = "video";
			$page_type = "videogallerypage";
			$sql = 'SELECT 
			`studio404_gallery`.`idx` AS `sg_idx` 
			FROM 
			`studio404_gallery_attachment`,`studio404_gallery` 
			WHERE 
			`studio404_gallery_attachment`.`connect_idx`=:connect_idx AND 
			`studio404_gallery_attachment`.`pagetype`=:pagetype AND 
			`studio404_gallery_attachment`.`status`!=:status AND 
			`studio404_gallery_attachment`.`idx`=`studio404_gallery`.`idx` AND 
			`studio404_gallery`.`status`!=:status
			';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":connect_idx"=>$pageidx, 
				":pagetype"=>$page_type, 
				":status"=>1 
			));
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
			if($fetch['sg_idx']){
				// select max idx gallery photo
				try{
					$sql2 = 'SELECT `id`, MAX(`idx`) as maxid FROM `studio404_gallery_file` WHERE `lang`=:lang AND `status`!=:status'; 
					$prepare2 = $conn->prepare($sql2);  
					$prepare2->execute(array( "lang"=>LANG_ID, ":status"=>1));
					$fetch2 = $prepare2->fetch(PDO::FETCH_ASSOC);
					$maxid = ($fetch2['maxid']) ? $fetch2['maxid']+1 : 1;
					$fileid = $fetch2['id'];
				}catch(Exeption $e){
					$maxid = 1;
				}
				
				// select max position of gallery photo
				try{
					$sql3 = 'SELECT MAX(`position`) as maxpos FROM `studio404_gallery_file` WHERE `media_type`=:media_type AND `lang`=:lang AND `gallery_idx`=:gallery_idx AND `status`!=:status';
					$prepare3 = $conn->prepare($sql3);
					$prepare3->execute(array(
						":media_type"=>$media_type, 
						":lang"=>LANG_ID, 
						":gallery_idx"=>$fetch['sg_idx'], 
						":status"=>1
					));
					$fetch3 = $prepare3->fetch(PDO::FETCH_ASSOC);
					$maxpos = ($fetch3['maxpos']) ? $fetch3['maxpos']+1 : 1;
				}catch(Exeption $e){
					$maxpos = 1;
				}
				
				$model_admin_selectLanguage = new model_admin_selectLanguage();
				$languages = $model_admin_selectLanguage->select_languages($_SESSION["C"]); 
				foreach($languages as $lang){
					//insert gallery photo
					$sql4 = 'INSERT INTO `studio404_gallery_file` SET 
					`idx`=:idx, 
					`date`=:datex,
					`gallery_idx`=:gallery_idx, 
					`file`=:file, 
					`media_type`=:media_type, 
					`title`=:title, 
					`description`=:description, 
					`filesize`=:filesize, 
					`insert_admin`=:insert_admin, 
					`position`=:position, 
					`lang`=:lang, 
					`status`=:status 
					';
					$prepare4 = $conn->prepare($sql4);
					$prepare4->execute(array(
						":idx"=>$maxid, 
						":datex"=>time(), 
						":gallery_idx"=>$fetch['sg_idx'], 
						":file"=>$_POST['youtubeLink'], 
						":media_type"=>$media_type, 
						":title"=>"Not defined", 
						":description"=>"Not defined", 
						":filesize"=>"0", 
						":insert_admin"=>$_SESSION["user404_id"], 
						":position"=>$maxpos,
						":lang"=>$lang['id'], 
						":status"=>0
					));
				}
				//get inserted file id with current language
				$sql5 = 'SELECT `id`,`position` FROM `studio404_gallery_file` WHERE `media_type`=:media_type AND `idx`=:idx AND `lang`=:lang AND `status`!=:status';
				$prepare5 = $conn->prepare($sql5);
				$prepare5->execute(array(
					":media_type"=>$media_type, 
					":idx"=>$maxid, 
					":lang"=>LANG_ID, 
					":status"=>1
				));
				$fetch5 = $prepare5->fetch(PDO::FETCH_ASSOC);
				$out = '<div class="filebox2" id="flexbox2-'.$maxid.'">';
				$out .= '<div class="action_panel2">';
				$out .= '<a href="'.$_POST['youtubeLink'].'" target="_blank"><i class="fa fa-eye"></i></a>';
				$out .= '<a href="javascript:;" onclick="openPromt2(\''.$maxid.'\')"><i class="fa fa-pencil-square-o"></i></a>';
				$out .= '<a href="javascript:;" onclick="removeFile2(\''.$maxid.'\')"><i class="fa fa-times"></i></a>';
				$out .= '</div>';
				$out .= '<div class="extention2"><img src="/images/video_icon.png" width="100%" /></div>';	
				
				$out .= '<div class="filename2 n2-'.$maxid.'" id="fid2-'.$fetch5['id'].'">Not defined</div>';
				$out .= '</div>';
				echo $out;
			}
			/////////////////////////////////////////////////////////////////

		}else{
			echo "error";
			exit();
		}	
	}
}
?>