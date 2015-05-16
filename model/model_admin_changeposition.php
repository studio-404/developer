<?php if(!defined("DIR")){ exit(); }
class model_admin_changeposition extends connection{
	public $outMessage = 2;
	function __construct(){

	}
	
	public function act($c){ 
		$conn = $this->conn($c);
		if(isset($_GET['down'],$_GET['id'],$_GET['token']) && $_GET['action']=="sitemap" && is_numeric($_GET['id']) && !isset($_GET['up']) && $_GET['token']==$_SESSION['token'])
		{	
			// select current position
			$sql = 'SELECT `cid`,`position` FROM `studio404_pages` WHERE `idx`=:idx AND `lang`=:lang AND `status`!=:status';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":idx"=>$_GET['id'], 
				":lang"=>LANG_ID, 
				":status"=>1
			));
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
			$position = $fetch['position'];
			$cid = $fetch['cid'];
			
			// update current position to zero
			$sql2 = 'UPDATE `studio404_pages` SET `position`=0 WHERE `idx`=:idx AND `status`!=:status';
			$prepare2 = $conn->prepare($sql2);
			$prepare2->execute(array(
				":idx"=>$_GET['id'], 
				":status"=>1
			));

			// set next position to current position
			$sql3 = 'UPDATE `studio404_pages` SET `position`=:newposition WHERE `cid`=:cid AND `position`=:position AND `status`!=:status';
			$prepare3 = $conn->prepare($sql3);
			$prepare3->execute(array(
				":newposition"=>$position, 
				":cid"=>$cid, 
				":position"=>$position+1, 
				":status"=>1
			));
			//set current position to next position
			$sql4 = 'UPDATE `studio404_pages` SET `position`=:position WHERE `cid`=:cid AND `position`=:zeroposition AND `status`!=:status';
			$prepare4 = $conn->prepare($sql4);
			$prepare4->execute(array(
				":position"=>$position+1, 
				":cid"=>$cid, 
				":zeroposition"=>0, 
				":status"=>1
			));
		}

		if(isset($_GET['up'],$_GET['id'],$_GET['token']) && $_GET['action']=="sitemap" && is_numeric($_GET['id']) && !isset($_GET['down']) && $_GET['token']==$_SESSION['token'])
		{
			// select current position
			$sql = 'SELECT `cid`,`position` FROM `studio404_pages` WHERE `idx`=:idx AND `lang`=:lang AND `status`!=:status';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":idx"=>$_GET['id'], 
				":lang"=>LANG_ID, 
				":status"=>1
			));
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
			$position = $fetch['position'];
			$cid = $fetch['cid'];
			
			// update current position to zero
			$sql2 = 'UPDATE `studio404_pages` SET `position`=0 WHERE `idx`=:idx AND `status`!=:status';
			$prepare2 = $conn->prepare($sql2);
			$prepare2->execute(array(
				":idx"=>$_GET['id'], 
				":status"=>1
			));
			// set prev position to current position
			$sql3 = 'UPDATE `studio404_pages` SET `position`=:newposition WHERE `cid`=:cid AND `position`=:position AND `status`!=:status';
			$prepare3 = $conn->prepare($sql3);
			$prepare3->execute(array(
				":newposition"=>$position, 
				":cid"=>$cid, 
				":position"=>$position-1, 
				":status"=>1
			));
			//set current position to prev position
			$sql4 = 'UPDATE `studio404_pages` SET `position`=:position WHERE `cid`=:cid AND `position`=:zeroposition AND `status`!=:status';
			$prepare4 = $conn->prepare($sql4);
			$prepare4->execute(array(
				":position"=>$position-1, 
				":cid"=>$cid, 
				":zeroposition"=>0, 
				":status"=>1
			));
		}
		$_SESSION['token'] = md5(sha1(time()));
		$go = '?action=sitemap&super='.$_GET['super'];
		$redirect = new redirect();
		$redirect->go($go);
	}

	public function act_catalog($c){
		$conn = $this->conn($c);
		// get current item position and module_idx
		$sql = 'SELECT `module_idx`, `position` FROM `studio404_module_item` WHERE `idx`=:idx AND `lang`=:lang AND `status`!=:status';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":idx"=>$_GET['cidx'], 
			":lang"=>LANG_ID, 
			":status"=>1
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		$position = $fetch['position'];
		$module_idx = $fetch['module_idx'];

		if(isset($_GET['action'],$_GET['type'],$_GET['id'],$_GET['cidx'],$_GET['super'],$_GET['token'],$_GET['up']) && is_numeric($_GET['id']) && is_numeric($_GET['cidx']) && $_GET['token']==$_SESSION['token']){
			//make current to zero
			$sqlz = 'UPDATE `studio404_module_item` SET `position`=:position WHERE `idx`=:idx AND `status`!=:status';
			$preparez = $conn->prepare($sqlz);
			$preparez->execute(array(
				":position"=>0,
				":idx"=>$_GET['cidx'], 
				":status"=>1
			));
			$minusposition = $position-1;
			// change upper item position to current
			$sqlu = 'UPDATE `studio404_module_item` SET `position`=:newposition WHERE `position`=:position AND `module_idx`=:module_idx AND `status`!=:status';
			$prepareu = $conn->prepare($sqlu);
			$prepareu->execute(array(
				":newposition"=>$position, 
				":position"=>$minusposition,
				":module_idx"=>$module_idx, 
				":status"=>1
			));	
			// update current to minus one
			$sqlc = 'UPDATE `studio404_module_item` SET `position`=:newposition2 WHERE `position`=:zeroposition2 AND `module_idx`=:module_idx AND `status`!=:status';
			$preparec = $conn->prepare($sqlc);
			$preparec->execute(array(
				":newposition2"=>$minusposition, 
				":zeroposition2"=>0, 
				":module_idx"=>$module_idx, 
				":status"=>1
			)); 

			
		}

		if(isset($_GET['action'],$_GET['type'],$_GET['id'],$_GET['cidx'],$_GET['super'],$_GET['token'],$_GET['down']) && is_numeric($_GET['id']) && is_numeric($_GET['cidx']) && $_GET['token']==$_SESSION['token']){
			//make current to zero
			$sqlz = 'UPDATE `studio404_module_item` SET `position`=:position WHERE `idx`=:idx AND `status`!=:status';
			$preparez = $conn->prepare($sqlz);
			$preparez->execute(array(
				":position"=>0,
				":idx"=>$_GET['cidx'], 
				":status"=>1
			));
			$minusposition = $position+1;
			// change upper item position to current
			$sqlu = 'UPDATE `studio404_module_item` SET `position`=:newposition WHERE `position`=:position AND `module_idx`=:module_idx AND `status`!=:status';
			$prepareu = $conn->prepare($sqlu);
			$prepareu->execute(array(
				":newposition"=>$position, 
				":position"=>$minusposition,
				":module_idx"=>$module_idx, 
				":status"=>1
			));	
			// update current to minus one
			$sqlc = 'UPDATE `studio404_module_item` SET `position`=:newposition2 WHERE `position`=:zeroposition2 AND `module_idx`=:module_idx AND `status`!=:status';
			$preparec = $conn->prepare($sqlc);
			$preparec->execute(array(
				":newposition2"=>$minusposition, 
				":zeroposition2"=>0, 
				":module_idx"=>$module_idx, 
				":status"=>1
			)); 
		}
		$_SESSION['token'] = md5(sha1(time()));
		$go = '?action='.$_GET['action'].'&type='.$_GET['type'].'&id='.$_GET['id'].'&super='.$_GET['super'].'&token='.$_SESSION['token'];
		$redirect = new redirect();
		$redirect->go($go);
	}


	public function act_component($c){
		$conn = $this->conn($c);
		// get current item position and idx
		$sql = 'SELECT `position` FROM `studio404_components_inside` WHERE `cid`=:cid AND `idx`=:idx AND `status`!=:status';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":cid"=>$_GET['id'], 
			":idx"=>$_GET['cidx'], 
			":status"=>1
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		$current_idx = $_GET['cidx'];
		$current_position = $fetch['position'];

		if(isset($_GET['action'],$_GET['id'],$_GET['cidx'],$_GET['token'],$_GET['up']) && is_numeric($_GET['id']) && is_numeric($_GET['cidx']) && $_GET['token']==$_SESSION['token']){
			//make current to zero
			$sqlz = 'UPDATE `studio404_components_inside` SET `position`=:zero WHERE `idx`=:idx AND `cid`=:cid AND `status`!=:status';
			$preparez = $conn->prepare($sqlz); 
			$preparez->execute(array(
				":zero"=>0, 
				":idx"=>$current_idx, 
				":cid"=>$_GET['id'], 
				":status"=>1
			));

			// change upper item position to current
			$upper_position = $current_position - 1;
			$sqlu = 'UPDATE `studio404_components_inside` SET `position`=:current_position WHERE `position`=:upper_position AND `cid`=:cid AND `status`!=:status';
			$prepareu = $conn->prepare($sqlu);
			$prepareu->execute(array(
				":current_position"=>$current_position, 
				":upper_position"=>$upper_position, 
				":cid"=>$_GET['id'], 
				":status"=>1
			));

			// update current(zero) to minus one
			$sqlc = 'UPDATE `studio404_components_inside` SET `position`=:minus_position WHERE `position`=:zero AND `cid`=:cid AND `status`!=:status';
			$preparec = $conn->prepare($sqlc);
			$preparec->execute(array(
				":minus_position"=>$upper_position, 
				":zero"=>0, 
				":cid"=>$_GET['id'], 
				":status"=>1
			));	
		}

		if(isset($_GET['action'],$_GET['id'],$_GET['cidx'],$_GET['token'],$_GET['down']) && is_numeric($_GET['id']) && is_numeric($_GET['cidx']) && $_GET['token']==$_SESSION['token']){
			//make current to zero
			$sqlz = 'UPDATE `studio404_components_inside` SET `position`=:zero WHERE `idx`=:idx AND `cid`=:cid AND `status`!=:status';
			$preparez = $conn->prepare($sqlz); 
			$preparez->execute(array(
				":zero"=>0, 
				":idx"=>$current_idx, 
				":cid"=>$_GET['id'], 
				":status"=>1
			));

			// change down item position to current
			$down_position = $current_position + 1;
			$sqlu = 'UPDATE `studio404_components_inside` SET `position`=:current_position WHERE `position`=:down_position AND `cid`=:cid AND `status`!=:status';
			$prepareu = $conn->prepare($sqlu);
			$prepareu->execute(array(
				":current_position"=>$current_position, 
				":down_position"=>$down_position, 
				":cid"=>$_GET['id'], 
				":status"=>1
			));
				
			// update current(zero) to plus one
			$sqlc = 'UPDATE `studio404_components_inside` SET `position`=:plus_position WHERE `position`=:zero AND `cid`=:cid AND `status`!=:status';
			$preparec = $conn->prepare($sqlc);
			$preparec->execute(array(
				":plus_position"=>$down_position, 
				":zero"=>0, 
				":cid"=>$_GET['id'], 
				":status"=>1
			));	
			
		}
		$_SESSION['token'] = md5(sha1(time()));
		$go = '?action='.$_GET['action'].'&id='.$_GET['id'].'&token='.$_SESSION['token'];
		$redirect = new redirect();
		$redirect->go($go);
	}


	public function act_gallery($c){
		$conn = $this->conn($c);
		// get current item position and media_idx
		$sql = 'SELECT `media_idx`, `position` FROM `studio404_media_item` WHERE `idx`=:idx AND `lang`=:lang AND `status`!=:status';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":idx"=>$_GET['midx'], 
			":lang"=>LANG_ID, 
			":status"=>1
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		$position = $fetch['position'];
		$media_idx = $fetch['media_idx'];

		if(isset($_GET['action'],$_GET['type'],$_GET['id'],$_GET['midx'],$_GET['super'],$_GET['token'],$_GET['up']) && is_numeric($_GET['id']) && is_numeric($_GET['midx']) && $_GET['token']==$_SESSION['token']){
			//make current to zero
			$sqlz = 'UPDATE `studio404_media_item` SET `position`=:position WHERE `idx`=:idx AND `status`!=:status';
			$preparez = $conn->prepare($sqlz);
			$preparez->execute(array(
				":position"=>0,
				":idx"=>$_GET['midx'], 
				":status"=>1
			));
			$minusposition = $position-1;
			// change upper item position to current
			$sqlu = 'UPDATE `studio404_media_item` SET `position`=:newposition WHERE `position`=:position AND `media_idx`=:media_idx AND `status`!=:status';
			$prepareu = $conn->prepare($sqlu);
			$prepareu->execute(array(
				":newposition"=>$position, 
				":position"=>$minusposition,
				":media_idx"=>$media_idx, 
				":status"=>1
			));	
			// update current to minus one
			$sqlc = 'UPDATE `studio404_media_item` SET `position`=:newposition2 WHERE `position`=:zeroposition2 AND `media_idx`=:media_idx AND `status`!=:status';
			$preparec = $conn->prepare($sqlc);
			$preparec->execute(array(
				":newposition2"=>$minusposition, 
				":zeroposition2"=>0, 
				":media_idx"=>$media_idx, 
				":status"=>1
			)); 

			
		}

		if(isset($_GET['action'],$_GET['type'],$_GET['id'],$_GET['midx'],$_GET['super'],$_GET['token'],$_GET['down']) && is_numeric($_GET['id']) && is_numeric($_GET['midx']) && $_GET['token']==$_SESSION['token']){
			//make current to zero
			$sqlz = 'UPDATE `studio404_media_item` SET `position`=:position WHERE `idx`=:idx AND `status`!=:status';
			$preparez = $conn->prepare($sqlz);
			$preparez->execute(array(
				":position"=>0,
				":idx"=>$_GET['midx'], 
				":status"=>1
			));
			$minusposition = $position+1;
			// change upper item position to current
			$sqlu = 'UPDATE `studio404_media_item` SET `position`=:newposition WHERE `position`=:position AND `media_idx`=:media_idx AND `status`!=:status';
			$prepareu = $conn->prepare($sqlu);
			$prepareu->execute(array(
				":newposition"=>$position, 
				":position"=>$minusposition,
				":media_idx"=>$media_idx, 
				":status"=>1
			));	
			// update current to minus one
			$sqlc = 'UPDATE `studio404_media_item` SET `position`=:newposition2 WHERE `position`=:zeroposition2 AND `media_idx`=:media_idx AND `status`!=:status';
			$preparec = $conn->prepare($sqlc);
			$preparec->execute(array(
				":newposition2"=>$minusposition, 
				":zeroposition2"=>0, 
				":media_idx"=>$media_idx, 
				":status"=>1
			)); 
		}
		$_SESSION['token'] = md5(sha1(time()));
		$go = '?action='.$_GET['action'].'&type='.$_GET['type'].'&id='.$_GET['id'].'&super='.$_GET['super'].'&token='.$_SESSION['token'];
		$redirect = new redirect();
		$redirect->go($go);
	}

	function __destruct(){

	}
}
?>