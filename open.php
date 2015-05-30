<?php
session_start(); // session start
/*
** define
*/
header("Content-type: text/html; charset=utf-8");
$dir_explode = explode("open.php",__FILE__);
define("DIR",$dir_explode[0]);
define("WEBSITE","http://developer.404.ge/");
define('START_TIME', microtime(TRUE));
define('START_MEMORY', memory_get_usage());
define('PLUGINS', WEBSITE.'_plugins/');
define('FILES', WEBSITE.'files/');
define('INVOICE', '/home/geoweb/developer.404.ge/files/invoices/');
define('FLASH', WEBSITE.'flash/');
define('IMG', WEBSITE.'images/');
define('SCRIPTS', WEBSITE.'scripts/');
define('STYLES', WEBSITE.'styles/');
/*
** includs
*/
@require_once("config.php"); 
date_default_timezone_set($c['date.timezone']); // set timezone 
set_time_limit($c["time.limit"]); // time limit
ini_set('max_execution_time',$c['execution.time']); // execute time limit
ini_set('post_max_size',$c['post.max.size']); // post max size limit
ini_set('upload_max_filesize',$c['upload.max.filesize']); // upload max file size limit
/*
** auto load class
*/

function __autoload($class_name){
	$class_load = false;
	if(file_exists('functions/'.$class_name.'.php')){// auto load function
    	@include 'functions/'.$class_name.'.php';
    	$class_load = true;
	}
	if(file_exists('controller/'.$class_name.'.php')){// auto load module
		@include 'controller/'.$class_name.'.php';
		$class_load = true;
	}
	if(file_exists('controller/custom/'.$class_name.'.php')){// auto load module
		@include 'controller/custom/'.$class_name.'.php';
		$class_load = true;
	}
	if(file_exists('model/'.$class_name.'.php')){// auto load module
		@include 'model/'.$class_name.'.php';
		$class_load = true;
	}
	if(!$class_load){
		echo "Class: <b>".$class_name."</b> can't load.."; exit();
	}
}

/*
** call main classes
*/
$obj  = new url_controll(); // url controlls

/*
** important variables
*/
$LANG = $obj->url("segment",1);

/*
** some more define
*/
$get_lang_id = new get_lang_id();
$lang_id = $get_lang_id->id($c,$LANG);
define('LANG', $LANG);
define('LANG_ID', $lang_id);
define('PRE_VIEW', $c["product.view.pre.slug"]);
define('PRE_GALLERY', $c["gallery.view.pre.slug"]);
define('WEB_DIR', $c["website.directory"]);
/*
** Controller function
*/
$controller = new controller($c);
$controller->loadpage($obj,$c);
?>