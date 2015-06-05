<?php if(!defined("DIR")){ exit(); }
class get_slug_from_url {

	public function slug(){
		$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$removeQ = explode("?",$actual_link);
		$r = WEBSITE.LANG."/";
		$slug = explode($r,$removeQ[0]); 
		return $slug[1];
	}

}
?>