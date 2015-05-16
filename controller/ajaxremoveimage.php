<?php if(!defined("DIR")){ exit(); }
class ajaxremoveimage extends connection{
	protected $c;
	function __construct(){
		global $c;
        $this->c =& $c;

		if(isset($_GET['idx']) && is_numeric($_GET['idx']))
		{
			try{
				$idx = $_GET['idx']; 
				$conn = $this->conn($this->c);
				$sql = 'UPDATE `studio404_pages` SET `background`=:background WHERE `idx`=:idx AND `status`!=:status';
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
					":background"=>'', 
					":idx"=>$_GET['idx'], 
					":status"=>1
				));
				echo "Done"; 
			}catch(Exception $e){
				echo "Exception";
			}
		}
	}
	
	function __destruct(){

	}
}
?>