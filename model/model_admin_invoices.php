<?php if(!defined("DIR")){ exit(); }
class model_admin_invoices extends connection{
	public $outMessage = 2;
	function __construct(){

	}

	public function select($c){
		$out = array();		
		if(isset($_GET["search"]) && !empty($_GET["search"])){
			$where = ' (`studio404_invoices`.`uid`=:search OR `studio404_users`.`id`=:search) AND '; 
			$order='end_date'; 
			$exe_array = array(
			":search"=>urldecode($_GET["search"]), 
			":lang"=>LANG_ID,
			":status"=>1
			);
		}else{
			$where = ''; 
			$order='end_date'; 
			$exe_array = array(
			":lang"=>LANG_ID,
			":status"=>1
			);
		}
		if(isset($_GET["duedate"])){
			$order='end_date'; 
			$path = '?action=invoices&duedate&pn=';
			$where = ' `studio404_invoices`.`service`=:service AND `end_date`<:currenttime AND '; 
			$exe_array = array(
			":currenttime"=>time(), 
			":service"=>"webhosting", 
			":lang"=>LANG_ID,
			":status"=>1
			);
		}else if(!isset($_GET["search"])){ 
			$order='start_date'; 
			$path = '?action=invoices&pn='; 
			$where = ''; 
			$exe_array = array(
			":lang"=>LANG_ID,
			":status"=>1
			);
		}

		$sql = 'SELECT 
		`studio404_invoices`.`uid` AS si_uid,
		`studio404_invoices`.`start_date` AS si_start_date,
		`studio404_invoices`.`end_date` AS si_end_date,
		`studio404_users`.`id` AS su_id,
		`studio404_users`.`namelname` AS su_namelname,
		`studio404_invoices`.`service` AS si_service,
		`studio404_invoices`.`price` AS si_price,
		`studio404_invoices`.`description` AS si_description,
		`studio404_invoices`.`paystatus` AS si_paystatus  
		FROM 
		`studio404_invoices`,`studio404_users` 
		WHERE 
		`studio404_invoices`.`lang`=:lang AND 
		`studio404_invoices`.`status`!=:status AND 
		`studio404_invoices`.`user_id`=`studio404_users`.`id` AND 
		'.$where.' 
		`studio404_users`.`status`!=:status ORDER BY `studio404_invoices`.`'.$order.'` DESC
		';
		//echo $sql;
		
		$itemsPerPage = 20;
		$pager = new pager();
		$pager = $pager->action($c,$sql,$exe_array,$path,$itemsPerPage);	
		$out['table'] = $this->table($c,$pager[0],$exe_array);
		$out['pager'] = $pager[1];
		return $out;
	}

	public function select_one($c){
		$conn = $this->conn($c); 
		$sql = 'SELECT 
		`studio404_invoices`.`start_date` AS si_start_date,
		`studio404_invoices`.`end_date` AS si_end_date,
		`studio404_users`.`id` AS su_id,
		`studio404_users`.`namelname` AS su_namelname,
		`studio404_invoices`.`service` AS si_service,
		`studio404_invoices`.`price` AS si_price,
		`studio404_invoices`.`description` AS si_description,
		`studio404_invoices`.`discount` AS si_discount,
		`studio404_invoices`.`paystatus` AS si_paystatus  
		FROM 
		`studio404_invoices`,`studio404_users` 
		WHERE 
		`studio404_invoices`.`uid`=:uid AND 
		`studio404_invoices`.`lang`=:lang AND 
		`studio404_invoices`.`status`!=:status AND 
		`studio404_invoices`.`user_id`=`studio404_users`.`id` AND 
		`studio404_users`.`status`!=:status 
		';
		$prepare = $conn->prepare($sql);

		$prepare->execute(array(
			":uid"=>$_GET['id'],
			":lang"=>LANG_ID,
			":status"=>1
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		return $fetch;
	}

	public function table($c,$sql,$exe_array){
		$out = '';
		$conn = $this->conn($c);
		$query = $conn->prepare($sql);
		$lang = new model_admin_languageData();
		try{ 
			$query->execute($exe_array);
			$_SESSION['token'] = md5(sha1(time()));
			//some variables
			$lang = new model_admin_languageData();
			while($rows = $query->fetch()){
				$out .= '<div class="row">';				
				$out .= '<span class="cell"><a href="invoices?uid='.$rows['si_uid'].'&token='.$_SESSION['token'].'" title="View invoice" target="_blank">'.$rows['si_uid'].'</a></span>';
				$out .= '<span class="cell" style="width:100px">'.date("d-m-Y",$rows['si_start_date']).'</span>';
				$out .= '<span class="cell" style="width:100px">'.date("d-m-Y",$rows['si_end_date']).'</span>';
				$out .= '<span class="cell"><a href="?action=editprofile&id='.$rows["su_id"].'&token='.$_SESSION["token"].'"> ('.$rows["su_id"].') '.$rows['su_namelname'].'</a></span>';			
				$out .= '<span class="cell" style="width:100px"><a href="">'.$lang->l($rows['si_service']).'</a></span>';			
				$out .= '<span class="cell">'.htmlentities($rows['si_description']).'</span>';			
				$out .= '<span class="cell" style="width:100px"><a href="">'.$rows['si_price'].'</a></span>';			
				$pay_status = ($rows['si_paystatus']==1) ? $lang->l("gadaxdilia") : $lang->l("gadasaxdeli"); 
				$color = ($rows['si_paystatus']==1) ? "green" : "red"; 
				$out .= '<span class="cell" style="width:100px; color:'.$color.'">'.$pay_status.'</span>';		
				$out .= '<span class="cell" style="width:130px;">'; 

				$out .= '<a href="invoices?uid='.$rows['si_uid'].'&token='.$_SESSION['token'].'" title="View invoice" target="_blank"><i class="fa fa-file-pdf-o"></i> </a>';
				$out .= '<a href="?action=editInvoice&id='.$rows['si_uid'].'&token='.$_SESSION['token'].'" title="Edit invoice"><i class="fa fa-pencil-square-o"></i></a>';
				$out .= '<a href="javascript:;" onclick="deleteComfirm(\'?action=invoices&remove=true&rinvoice='.$rows['si_uid'].'&token='.$_SESSION['token'].'\')" title="Remove invoice"><i class="fa fa-times"></i></a>';
			
				$out .= '</span>';

				$out .= '</div>';
			}
		}catch(Exception $e){
			
		}
		return $out;
	}


	public function add($c){
		if(isset($_POST["startdate"],$_POST["enddate"],$_POST["userid"],$_POST["service"],$_POST["description"],$_POST["price"],$_POST["currency"],$_POST["paystatus"],$_POST["discount"])){
			$conn = $this->conn($c); 
			$startdate = strtotime($_POST["startdate"]); 
			$enddate = strtotime($_POST["enddate"]); 
			$userid = explode(":",$_POST["userid"]); 
			$userid = end($userid); 
			$service = $_POST["service"]; 
			$description = $_POST["description"]; 
			$discount = $_POST["discount"]; 
			$wholePrice = $_POST["price"]." ".$_POST["currency"];
			$paystatus = $_POST["paystatus"]; 

			$model_admin_selectLanguage = new model_admin_selectLanguage();
			$lang_query = $model_admin_selectLanguage->select_languages($c);

			$uid = new uid();
			$generate_uid = $uid->generate(6);
			
			try{
					foreach($lang_query as $lang_row){
						$sql = 'INSERT INTO `studio404_invoices` SET 
									`uid`=:uid,
									`start_date`=:start_date, 
									`end_date`=:end_date, 
									`user_id`=:user_id,
									`service`=:service, 
									`description`=:description, 
									`price`=:price, 
									`discount`=:discount, 
									`paystatus`=:paystatus, 
									`insert_admin`=:insert_admin, 
									`lang`=:lang
							';
						$insert = $conn->prepare($sql);
						$insert->execute(array(
								":uid"=>$generate_uid,
								":start_date"=>$startdate, 
								":end_date"=>$enddate, 
								":user_id"=>$userid,
								":service"=>$service, 
								":description"=>$description, 
								":price"=>$wholePrice, 
								":discount"=>$discount, 
								":paystatus"=>$paystatus, 
								":insert_admin"=>$_SESSION["user404_id"], 
								":lang"=>$lang_row['id']						
						));
					}
			}catch(PDOException $e){
				echo $e;
			}
			$this->outMessage = 1;
			return $this->outMessage;
		}
	}


	public function edit($c){
		if(isset($_POST["startdate"],$_POST["enddate"],$_POST["description"],$_POST["paystatus"],$_GET["id"])){
			$conn = $this->conn($c); 
			$startdate = strtotime($_POST["startdate"]); 
			$enddate = strtotime($_POST["enddate"]); 
			$description = $_POST["description"]; 
			$paystatus = $_POST["paystatus"]; 
			$id = $_GET["id"]; 

			$sql = 'UPDATE `studio404_invoices` SET `start_date`=:startdate, `end_date`=:enddate, `paystatus`=:paystatus WHERE `uid`=:id';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":startdate"=>$startdate, 
				":enddate"=>$enddate, 
				":paystatus"=>$paystatus, 
				":id"=>$id
			));

			//description only current language
			$sql2 = 'UPDATE `studio404_invoices` SET `description`=:description WHERE `uid`=:id AND `lang`=:lang';
			$prepare2 = $conn->prepare($sql2);
			$prepare2->execute(array(
				":description"=>$description, 
				":lang"=>LANG_ID, 
				":id"=>$id
			));
			$obj  = new url_controll();
			$lg = $obj->url("segment",1);
			$file = INVOICE.strtolower($lg).$_GET["id"].".pdf";
			if(file_exists($file)){
				@unlink($file);
			}
			$this->outMessage = 1;
		}
	}

	public function removeMe($c){
		$conn = $this->conn($c); 
		$rinvoice= $_GET['rinvoice'];
		$sql = 'UPDATE `studio404_invoices` SET `status`=:status WHERE `uid`=:id';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":id"=>$rinvoice, 
			":status"=>1
		));
		$this->outMessage = 1;
	}

	function __destruct(){

	}
}
?>