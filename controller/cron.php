<?php if(!defined("DIR")){ exit(); }
class cron extends connection{
	protected $c;
	function __construct(){
		global $c;
        $this->c = $c;
        header("Content-type: text/html; charset=utf-8");
		$this->index($this->c);
	}

	public function index($c){
		$conn = $this->conn($c);
		// if dayly limit ended run exit
		$today = date("Y-m-d"); 
		$check_today_sents = 'SELECT `num` FROM `studio404_newsletter_sentcount` WHERE `today`=:today';
		$prepare_check_today_sents = $conn->prepare($check_today_sents); 
		$prepare_check_today_sents->execute(array(
			":today"=>$today
		));
		$fetch_check_today_sents = $prepare_check_today_sents->fetch(PDO::FETCH_ASSOC);
		if($fetch_check_today_sents['num']>=$c['max.send.email.per.day']){
			die("Limit");
		}
		$sql = 'SELECT * FROM `studio404_newsletter` WHERE `type`=:type AND `send_status`=:send_status ORDER BY `date` ASC';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":type"=>'send', 
			":send_status"=>'pending'
		));
		$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC); 
		$sent = 0;

		foreach($fetch as $f){
			$count = $this->getSentEmailNumber($c,$f['group_id']); 
			if($count=="break"){ break; }
			else{ $sent++; }
			if($sent>=20){ break; }
		}
	}

	private function getSentEmailNumber($c,$group_id){
		$conn = $this->conn($c);
		$send_email = new send_email();

		//select general info
		$sql_einfo = 'SELECT * FROM `studio404_newsletter` WHERE `type`=:type AND `group_id`=:group_id';
		$prepare_einfo = $conn->prepare($sql_einfo);
		$prepare_einfo->execute(array(
			":type"=>'general',
			":group_id"=>0
		));
		$fetch_einfo = $prepare_einfo->fetch(PDO::FETCH_ASSOC);
		
		//select subject and message
		$sql_subj_msg = 'SELECT * FROM `studio404_newsletter` WHERE `type`=:type AND `send_status`=:send_status';
		$prepare_subj_msg = $conn->prepare($sql_subj_msg);
		$prepare_subj_msg->execute(array(
			":type"=>'send', 
			":send_status"=>'pending'
		));
		$fetch_subj_msg = $prepare_subj_msg->fetchAll(PDO::FETCH_ASSOC);

		

		//init important variables
		$host = $fetch_einfo['host'];
		$user = $fetch_einfo['user'];
		$pass = $fetch_einfo['pass'];
		$from = $fetch_einfo['from'];
		$fromname = $fetch_einfo['fromname'];

		foreach($fetch_subj_msg as $s){
			$uid = $s['uid']; 
			$group_id = $s['group_id']; 
			$individualemail = $s['individualemail']; 
			$subject = $s['subject']; 

			if(empty($individualemail) && $group_id!=0){// its group newsletter
				//select emails to sent
				$sql = 'SELECT * FROM `studio404_newsletter_emails` WHERE `type`=:type AND `group_id`=:group_id AND `status`!=:status';
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
					":type"=>'email', 
					":group_id"=>$group_id, 
					":status"=>1
				));
				$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
				foreach($fetch as $f){
					$getmessageurl = $c['site.url'].'_plugins/newsletter/index.php?u='.$uid.'&e='.$f['email'].'&r='.$f['unsubscribe'].'&t='.time();
					$message = file_get_contents($getmessageurl); 
					$send_email->send($host,$user,$pass,$from,$fromname,$f['email'],$subject,$message);
				}
				$sql_update = 'UPDATE `studio404_newsletter` SET `send_status`=:send_status WHERE `uid`=:uid';
				$prepare_update = $conn->prepare($sql_update);
				$prepare_update->execute(array(
					":send_status"=>'sent', 
					":uid"=>$uid
				));
			}else{//individual sending
				$getmessageurl = $c['site.url'].'_plugins/newsletter/index.php?u='.$uid.'&e='.$individualemail.'&t='.time();
				$message = file_get_contents($getmessageurl);  
				//$message = htmlentities($message);
				//echo $message;
				$send_email->send($host,$user,$pass,$from,$fromname,$individualemail,$subject,$message);
				
				//update sent
				$sql_update = 'UPDATE `studio404_newsletter` SET `send_status`=:send_status WHERE `uid`=:uid';
				$prepare_update = $conn->prepare($sql_update);
				$prepare_update->execute(array(
					":send_status"=>'sent', 
					":uid"=>$uid
				));
			}
			// select today sent counter
			$today = date("Y-m-d");
			$sent_c = 'SELECT `id` FROM `studio404_newsletter_sentcount` WHERE `today`=:today';
			$prepare_c = $conn->prepare($sent_c); 
			$prepare_c->execute(array(
				":today"=>$today
			));
			$fetch_c = $prepare_c->fetch(PDO::FETCH_ASSOC);
			if(!empty($fetch_c['id'])){// if exits update
				$sent_c2 = 'UPDATE `studio404_newsletter_sentcount` SET `num`=`num`+1 WHERE `today`=:today';
				$prepare_c2 = $conn->prepare($sent_c2); 
				$prepare_c2->execute(array(
					":today"=>$today
				));
			}else{ // not exists insert
				$sent_c3 = 'INSERT INTO `studio404_newsletter_sentcount` SET `num`=1, `today`=:today';
				$prepare_c3 = $conn->prepare($sent_c3); 
				$prepare_c3->execute(array(
					":today"=>$today
				));
			}
		}
	}

	private function getEmails($c,$group_id){

	}

	function __destruct(){

	}
}
?>