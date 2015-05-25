<?php if(!defined("DIR")){ exit(); }
class model_admin_editprofile extends connection{
	
	public $outMessage;

	function __construct(){

	}

	public function select_profile($c){
		$conn = $this->conn($c);
		$out = array();
		$token_get = $_GET["token"];
		$token_session = $_SESSION["token"];
		$edit_id = $_GET["id"];
		if($token_get==$token_session){
			$sql = 'SELECT * FROM `studio404_users` WHERE `id`=:id AND `status`!=:status';
			$exe_array = array("id"=>$edit_id, ":status"=>1);
			$query = $conn->prepare($sql);
			$query->execute($exe_array);
			$fetch = $query->fetch(PDO::FETCH_ASSOC);
			return $fetch;
		}		
		return $out;
	}

	public function select_profile2($c){
		$conn = $this->conn($c);
		$out = array();
		$edit_id = $_GET["id"];
		$sql = 'SELECT * FROM `studio404_users` WHERE `id`=:id AND `status`!=:status';
		$exe_array = array("id"=>$edit_id, ":status"=>1);
		$query = $conn->prepare($sql);
		$query->execute($exe_array);
		$fetch = $query->fetch(PDO::FETCH_ASSOC);
		foreach($fetch as $k=>$v){
			if($k=="sector_id"){
				$out["sector_id"] = $this->get_sector_title($c,$v);
			}else if($k=="sub_sector_id"){
				$out["sub_sector_id"] = $this->get_sector_title($c,$v);
			}else if($k=="export_markets_id"){
				$out["export_markets_id"] = $this->get_sector_title($c,$v);
			}else if($k=="sme_classification_id"){
				$out["sme_classification_id"] = $this->get_sector_title($c,$v);
			}else{
				$out[$k] = $v;
			}
		}
		return $out;
	}

	public function get_sector_title($c,$v){
		$conn = $this->conn($c);
		$sql = 'SELECT `title` FROM `studio404_pages` WHERE `idx`=:idx AND `lang`=:lang AND `status`!=:status';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":idx"=>$v, 
			":lang"=>LANG_ID, 
			":status"=>1 
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		return $fetch["title"];
	}

	public function removeMe($c){
		$conn = $this->conn($c);
		$token_get = $_GET["token"];
		$token_session = $_SESSION["token"];
		if(isset($_GET["remove"]) && isset($_GET['id']) && is_numeric($_GET['id']) && $token_get==$token_session){
			$sql = 'UPDATE `studio404_users` SET `status`=:status WHERE `id`=:id';
			$query = $conn->prepare($sql);
			$query->execute(array(
				":status"=>1,
				":id"=>$_GET['id']
			));
			$this->outMessage = 1;
		}else{
			$this->outMessage = 2;
		}
	}

	public function edit($c){
		$conn = $this->conn($c);
		$namelname = strip_tags($_POST['namelname']);
		$ucode = strip_tags($_POST['ucode']);
		$email = strip_tags($_POST['email']);
		$phone = strip_tags($_POST['phone']);
		$mobile = strip_tags($_POST['mobile']);
		$user_type = strip_tags($_POST['usertype']);
		$token = $_GET['token'];
		$token_get = $_GET["token"];
		$token_session = $_SESSION["token"];
		
		if( $this->noEmpty($namelname) && $this->noEmpty($user_type) && $this->noEmpty($ucode) && isset($_GET['id']) && $this->noEmpty($_GET['id']) && is_numeric($_GET['id']) && $token_get==$token_session){
			$sql = 'UPDATE `studio404_users` SET `namelname`=:namelname, `ucode`=:ucode, `email`=:email, `phone`=:phone, `mobile`=:mobile, `user_type`=:user_type WHERE `id`=:id AND `status`!=:status';
			$query = $conn->prepare($sql);
			$query->execute(array(
			":namelname"=>$namelname,
			":ucode"=>$ucode,
			":email"=>$email,
			":phone"=>$phone,
			":mobile"=>$mobile, 
			":user_type"=>$user_type, 
			":id"=>$_GET['id'], 
			":status"=>1 
			));
			$this->outMessage = 1;	
		}else{
			$this->outMessage = 2;
		}
	}


	public function wedit($c){
		$conn = $this->conn($c);
		$namelname = strip_tags($_POST['namelname']);
		$company_email = strip_tags($_POST['company_email']);
		$products = strip_tags($_POST['products']);
		$established_in = strip_tags($_POST['established_in']);
		$number_of_employes = strip_tags($_POST['number_of_employes']);
		$production_capacity = strip_tags($_POST['production_capacity']);
		$certificates = strip_tags($_POST['certificates']);
		$contact_person = strip_tags($_POST['contact_person']);
		$email = strip_tags($_POST['email']);
		$cp_email = strip_tags($_POST['cp_email']);
		$cp_phone = strip_tags($_POST['cp_phone']);
		$cp_mobile = strip_tags($_POST['cp_mobile']);
		$office_phone = strip_tags($_POST['office_phone']);
		$address = strip_tags($_POST['address']);
		$web_address = strip_tags($_POST['web_address']);
		$about = strip_tags($_POST['about']);
		$token = $_GET['token'];
		$token_get = $_GET["token"];
		$token_session = $_SESSION["token"];
		if( $this->noEmpty($namelname) && isset($_GET['id']) && $this->noEmpty($_GET['id']) && is_numeric($_GET['id']) && $token_get==$token_session){
			$sql = 'UPDATE `studio404_users` SET 
			`namelname`=:namelname, 
			`company_email`=:company_email, 
			`products`=:products, 
			`established_in`=:established_in, 
			`number_of_employes`=:number_of_employes, 
			`production_capacity`=:production_capacity, 
			`certificates`=:certificates, 
			`contact_person`=:contact_person, 
			`email`=:email, 
			`cp_email`=:cp_email, 
			`cp_phone`=:cp_phone, 
			`cp_mobile`=:cp_mobile, 
			`office_phone`=:office_phone, 
			`address`=:address, 
			`web_address`=:web_address, 
			`about`=:about
			WHERE 
			`id`=:id AND 
			`status`!=:status';
			$query = $conn->prepare($sql);
			$query->execute(array(
			":namelname"=>$namelname,
			":company_email"=>$company_email,
			":products"=>$products,
			":established_in"=>$established_in,
			":number_of_employes"=>$number_of_employes,
			":production_capacity"=>$production_capacity,
			":certificates"=>$certificates, 
			":contact_person"=>$contact_person, 
			":email"=>$email, 
			":cp_email"=>$cp_email, 
			":cp_phone"=>$cp_phone, 
			":cp_mobile"=>$cp_mobile, 
			":office_phone"=>$office_phone, 
			":address"=>$address, 
			":web_address"=>$web_address, 
			":about"=>$about, 
			":id"=>$_GET['id'], 
			":status"=>1 
			));
			$this->outMessage = 1;	
		}else{
			$this->outMessage = 2;
		}
	}


	private function noEmpty($foo){
		if(!empty($foo)){
			return true;
		}
		return false;
	}

	function __destruct(){

	}
}
?>