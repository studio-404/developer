<?php
class get_files extends connection{
	public $sgf_id, $sgf_idx, $sgf_file,$sgf_title, $handler;

	function __construct(){
		$file = $this->sgf_file;
		$exe = explode(".",$file);
		$this->handler = end($exe);
	} 
}
?>