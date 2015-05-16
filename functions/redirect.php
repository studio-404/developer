<?php if(!defined("DIR")){ exit(); }
class redirect{
	public function go($url=""){
		if(empty($url)){
			echo '<meta http-equiv="refresh" content="0"/>';
		}else{
			header("Location: ".$url."");
			echo '<meta http-equiv="refresh" content="0; url='.$url.'"/>';
		}
		exit();
	}
}