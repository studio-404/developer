<?php if(!defined("DIR")){ exit(); }
class model_admin_adduser extends connection{
	
	function __construct(){

	}

	public function add($c){
		$conn = $this->conn($c);
		if($this->noEmpty($_POST['username']) && $this->noEmpty($_POST['password']) && $this->noEmpty($_POST['namelname']) && $this->noEmpty($_POST['ucode']) && $this->noEmpty($_POST['usertype']))
		{ 
			$sql = 'INSERT INTO `studio404_users` SET `username`=:username, `password`=:password, `namelname`=:namelname, `ucode`=:ucode, `email`=:email, `phone`=:phone, `mobile`=:mobile, `user_type`=:user_type, `log`=:log, `logtime`=:logtime, `status`=:status';
			$insert = $conn->prepare($sql);
			$insert->execute(array(
				":username"=>$_POST['username'],
				":password"=>md5($_POST['password']),
				":namelname"=>$_POST['namelname'],
				":ucode"=>$_POST['ucode'],
				":email"=>$_POST['email'],
				":phone"=>$_POST['phone'],
				":mobile"=>$_POST['mobile'],
				":user_type"=>$_POST['usertype'],
				":logtime"=>time(),
				":log"=>0,
				":status"=>0,
			));
			return 1;
		}else{
			return 2;
		}
	}

	public function addwebsiteuser($c){
		$conn = $this->conn($c);
		if(isset($_POST['company_type'],$_POST['username'],$_POST['password'],$_POST['namelname']) && $this->noEmpty($_POST['username']) && $this->noEmpty($_POST['password']) && $this->noEmpty($_POST['namelname']) && $_POST['company_type']=="individual"){
			$sql = 'INSERT INTO `studio404_users` SET `username`=:username, `password`=:password, `namelname`=:namelname, `company_type`=:company_type, `user_type`=:user_type, `email`=:email, `address`=:address, `contact_person`=:contact_person, `cp_email`=:cp_email, `cp_phone`=:cp_phone, `cp_mobile`=:cp_mobile, `web_address`=:web_address';
			$insert = $conn->prepare($sql);
			$insert->execute(array(
				":username"=>$_POST['username'],
				":password"=>md5($_POST['password']),
				":namelname"=>$_POST['namelname'],
				":company_type"=>$_POST['company_type'],
				":user_type"=>"website",
				":email"=>$_POST['email'],
				":address"=>$_POST['address'],
				":contact_person"=>$_POST['contact_person'],
				":cp_email"=>$_POST['cp_email'],
				":cp_phone"=>$_POST['cp_phone'],
				":cp_mobile"=>$_POST['cp_mobile'],
				":web_address"=>$_POST['web_address']
			));
			return 1;
		}else if($this->noEmpty($_POST['username']) && $this->noEmpty($_POST['password']) && $this->noEmpty($_POST['namelname']) )
		{ 
			$sql = 'INSERT INTO `studio404_users` SET 
					`username`=:username, 
					`password`=:password, 
					`namelname`=:namelname, 
					`company_type`=:company_type, 
					`user_type`=:user_type, 
					`email`=:email, 
					`sector_id`=:sector_id, 
					`sub_sector_id`=:sub_sector_id, 
					`products`=:products, 
					`established_in`=:established_in, 
					`number_of_employes`=:number_of_employes, 
					`sme_classification_id`=:sme_classification_id, 
					`production_capacity`=:production_capacity, 
					`certificates`=:certificates, 
					`export_markets_id`=:export_markets_id, 
					`address`=:address, 
					`contact_person`=:contact_person, 
					`cp_email`=:cp_email, 
					`cp_phone`=:cp_phone, 
					`cp_mobile`=:cp_mobile, 
					`office_phone`=:office_phone, 
					`web_address`=:web_address, 
					`about`=:about';
			$insert = $conn->prepare($sql);
			$insert->execute(array(
				":username"=>$_POST['username'],
				":password"=>md5($_POST['password']),
				":namelname"=>$_POST['namelname'],
				":company_type"=>$_POST['company_type'],
				":user_type"=>'website',
				":email"=>$_POST['email'],
				":sector_id"=>$_POST['sector_id'],
				":sub_sector_id"=>$_POST['sub_sector_id'],
				":products"=>$_POST['products'],
				":established_in"=>$_POST['established_in'],
				":number_of_employes"=>$_POST['number_of_employes'],
				":sme_classification_id"=>$_POST['sme_classification_id'],
				":production_capacity"=>$_POST['production_capacity'],
				":certificates"=>$_POST['certificates'],
				":export_markets_id"=>$_POST['export_markets_id'],
				":address"=>$_POST['address'],
				":contact_person"=>$_POST['contact_person'],
				":cp_email"=>$_POST['cp_email'],
				":cp_phone"=>$_POST['cp_phone'],
				":cp_mobile"=>$_POST['cp_mobile'],
				":office_phone"=>$_POST['office_phone'],
				":web_address"=>$_POST['web_address'],
				":about"=>$_POST['about'] 
			));
			return 1;
		}else{
			return 2;
		}
	}

	private function noEmpty($foo){
		if(empty($foo)){
			return false;
		}
		return true;
	}

	function __destruct(){

	}
}

?>