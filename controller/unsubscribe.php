<?php if(!defined("DIR")){ exit(); }
class unsubscribe extends connection{
	function __construct($c,$encr){
        $this->remove($c,$encr); 
    }

    public function remove($c,$encr){
    	//if someone try to unsibscrime others emails
    	if(!$_SESSION['countme']){ $_SESSION['countme'] = $_SESSION['countme']+1; }
    	if(isset($_SESSION['countme']) && $_SESSION['countme']>100){ die(); }
    	
    	$conn = $this->conn($c); 
    	$sql = 'UPDATE `studio404_newsletter_emails` SET `status`=:status WHERE `unsubscribe`=:unsubscribe AND `status`!=:one';
    	$prepare = $conn->prepare($sql); 
    	$prepare->execute(array(
    		":status"=>1, 
    		":unsubscribe"=>$encr, 
    		":one"=>1
    	));
    	if($prepare->rowCount()){
    		$data["website_title"] = "Your email unsubscribed !";
    		$data["website_text"] = "Your email unsubscribed !";
    		@include($c["website.directory"]."/unsubscribe.php"); 
    	}else{
    		@include($c["website.directory"]."/error_page.php"); 
    	}
    }
}
?>