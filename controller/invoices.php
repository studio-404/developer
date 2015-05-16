<?php if(!defined("DIR")){ exit(); }
class invoices extends connection{
	function __construct($obj,$c){
		$lang = new model_admin_languageData();
		$this->view($obj,$c,$lang);
	}

	public function view($obj,$c,$lang){		
		$lg = $obj->url("segment",1);
		$file = INVOICE.strtolower($lg).$_GET["uid"].".pdf";
		// echo $file;
		if(!file_exists($file))
		{
			$conn = $this->conn($c); 
			$sql = 'SELECT 
			`studio404_invoices`.`uid` AS si_uid,
			`studio404_invoices`.`start_date` AS si_start_date,
			`studio404_invoices`.`end_date` AS si_end_date,
			`studio404_users`.`namelname` AS su_namelname,
			`studio404_users`.`ucode` AS su_ucode, 
			`studio404_users`.`mobile` AS su_mobile, 
			`studio404_users`.`phone` AS su_phone, 
			`studio404_invoices`.`service` AS si_service,
			`studio404_invoices`.`description` AS si_description,
			`studio404_invoices`.`discount` AS si_discount,
			`studio404_invoices`.`price` AS si_price,
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
				":uid"=>$_GET["uid"],
				":lang"=>LANG_ID,
				":status"=>1,
			)); 
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC); 
			if(!isset($fetch["si_uid"]) OR $_SESSION["token"]!=$_GET['token']){ die("Sorry, invoice does not exists or token expired !"); }
			@include("_plugins/tcpdf/tcpdf.php");		
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator("Studio 404");
			$pdf->SetAuthor('Studio 404');
			$pdf->SetTitle('invoice #'.$fetch["si_uid"]);
			$pdf->SetSubject($lang->l("faqtura"));
			$pdf->SetKeywords('PDF, invoice');
			$pdf->SetFont('dejavusans', '', 14, '', true);
			$pdf->AddPage();
			$start_date = date( "d/m/Y", $fetch['si_start_date']);
			$end_date = date("d/m/Y",$fetch['si_end_date']); 
			$pay_due = date('d/m/Y',($fetch['si_start_date']+$c["invoice.due.date"]));
			$html = ''; 
			$html .= '<h1 style="text-align:center; font-size:18px">'.$lang->l("faqtura").' #'.$fetch["si_uid"].'</h1>'; 
			$html .= '<h3 style="text-align:center; font-size:12px">'.$lang->l("tarigi").': '.$start_date.'</h3>'; 

			$html .= '<table border="0" cellspacing="0" cellpadding="4" style="border: 1px solid #cccccc; font-size:10px">';
			$html .= '<tr><td colspan="2"><h2>'.$lang->l("momsaxurebisgamwevi").'</h2></td></tr>';
			$html .= '<tr><th>'.$lang->l("kompania").': </th><td>'.$lang->l("studia404").'</td></tr>';
			$html .= '<tr><th>'.$lang->l("kompaniiskodi").': </th><td>406095014</td></tr>';

			$html .= '<tr><th>'.$lang->l("bankisdasaxeleba").': </th><td>'.$lang->l("tibisibanki").'</td></tr>';
			$html .= '<tr><th>'.$lang->l("bankiskodi").': </th><td>TBCBGE22</td></tr>';
			$html .= '<tr><th>'.$lang->l("angarishisnomeri").': </th><td>GE28TB7860936080100001</td></tr>';
			$html .= '<tr><th>'.$lang->l("paypalmomxmareblisangarishi").': </th><td>ltdstudio404@gmail.com</td></tr>';
			$html .= '<tr><th>'.$lang->l("sakontaqtonomeri").': </th><td>599623555</td></tr>';
			$html .= '<tr><th>'.$lang->l("sakontaqtopiri").': </th><td>'.$lang->l("giorgigvazava").'</td></tr>';
			$html .= '<tr><th>'.$lang->l("elfosta").': </th><td>info@404.ge, ltdstudio404@gmail.com</td></tr>';
			$html .= '</table>';
			$html .= '<div style="width:100%; height:5px"></div>';
			$html .= '<table border="0" cellspacing="0" cellpadding="4" style="border: 1px solid #cccccc; font-size:10px">';
			$html .= '<tr><td colspan="2"><h2>'.$lang->l("momsaxurebismimgebi").'</h2></td></tr>';
			$html .= '<tr><th>'.$lang->l("kompania").': </th><td>'.$fetch['su_namelname'].'</td></tr>';
			$html .= '<tr><th>'.$lang->l("kompaniiskodi").': </th><td>'.$fetch['su_ucode'].'</td></tr>';
			$html .= '<tr><th>'.$lang->l("sakontaqtonomeri").': </th><td>'.$fetch['su_mobile'].' '.$fetch['su_phone'].'</td></tr>';
			$html .= '</table>';

			$html .= '<div style="width:100%; height:5px"></div>';
			$html .= '<table border="0" cellspacing="0" cellpadding="4" style="border: 1px solid #cccccc; font-size:10px">';
			$html .= '<tr><td colspan="2"><h2>'.$lang->l("momsaxureba").'</h2></td></tr>';
			$html .= '<tr><th>'.$lang->l("dasaxeleba").': </th><td>'.$lang->l($fetch['si_service']).'</td></tr>'; 
			
			$html .= '<tr><th>'.$lang->l("dawyebistarigi").' / '.$lang->l("dasrulebistarigi").': </th><td>'.$start_date.' / '.$end_date.'</td></tr>';
			$html .= '<tr><th>'.$lang->l("agwera").': </th><td>'.$fetch['si_description'].'</td></tr>';
			
			if($fetch['si_discount']>0){
				$exprice = explode(" ",$fetch['si_price']);
				$discounted = ($exprice[0]*$fetch['si_discount']) / 100;
				$html .= '<tr><th>'.$lang->l("rirebuleba").': </th><td><span style="color:red">'.$fetch['si_price'].'</span> - <span style="color:green">'.$discounted.' '.$exprice[1].'</span> = <span>'.($fetch['si_price']-$discounted).' '.$exprice[1].'</span> ('.$lang->l("discount").' '.$fetch['si_discount'].'%) </td></tr>';
			}else{
				$html .= '<tr><th>'.$lang->l("rirebuleba").': </th><td>'.$fetch['si_price'].'</td></tr>';
			}
			
			$html .= '</table>';
			
			$html .= '<p>'.$lang->l("gadaxdisbolovada").': <font color="#555555">'.$pay_due.'</font></p>';
			$gadaxdilia = '<font color="green">'.$lang->l("gadaxdilia").'</font>';
			$gadasaxdeli = '<font color="red">'.$lang->l("gadasaxdeli").'</font>';
			$paystatus = ($fetch['si_paystatus']==1) ? $gadaxdilia : $gadasaxdeli;

			$html .= '<p>'.$lang->l("statusi").': '.$paystatus.'</p>';
			$html .= '<p>'.$lang->l("xelmowera").', '.$lang->l("bechedi").':</p> <img src="/images/beWedi.png" width="100" height="104" />'; 


			$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);
			ob_start();
			$pdf->Output('invoice.pdf', 'I');
			$output = ob_get_contents();
			ob_end_clean();
			echo $output;

			$fp = fopen($file, 'w');
			fwrite($fp, $output);
			fclose($fp);
		}else{
			if($_SESSION["token"]!=$_GET['token']){ die("Sorry, invoice does not exists or token expired !"); }
			header("Content-type:application/pdf");
			header('Content-Disposition: inline; filename="invoice.pdf"');
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: ' . filesize($file));
			header('Accept-Ranges: bytes');
			@readfile($file);
		}

	}

	function __destruct(){
		
	}
}
?>