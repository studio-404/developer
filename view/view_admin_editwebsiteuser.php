<?php
//session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title><?=$data["website_title"]?></title>
	<link href="<?=STYLES?>reset.css" type="text/css" rel="stylesheet" /> 
	<link href="<?=PLUGINS."font-awesome-4.3.0/css/font-awesome.css"?>" type="text/css" rel="stylesheet" />
	<link href="<?=STYLES?>en.css" type="text/css" rel="stylesheet" /> 
	<link href="<?=STYLES?>general.css" type="text/css" rel="stylesheet" /> 
	<script src="<?=SCRIPTS?>jquery-1.11.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?=SCRIPTS?>javascript.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?=PLUGINS?>/tinymce/tinymce.min.js"></script>
</head>
<body>
	<?php
	@include("view/parts/header.php");
	?>
	<main>
		<div class="center">
			<?php
			@include("view/parts/breadcrups.php");
			?>
			<div class="content">

				<?php
				if(!empty($data["outMessage"]) && $data["outMessage"]==1){
				?>
					<div class="success message" onclick="hideMe('.message')">
					  <h2>Success</h2>
						<p>Data updated !</p>
					</div>
				<?php
				}
				if(!empty($data["outMessage"]) && $data["outMessage"]==2){
				?>
					<div class="error message" onclick="hideMe('.message')">
					  <h2>Error</h2>
						<p>Something went wrong !</p>
					</div>
				<?php
				}
				?>

				<form action="" method="post" class="my-form hundredPorsent" autocomplete="off">
					<div class="from-header" style="color:#ef4836; text-transform:uppercase">Edit website user</div>
					
					
					<label for="username">Username: <font color="RED">*</font></label>
					<input type="text" name="username" id="username" value="<?=htmlentities($data["profile"]["username"])?>" autocomplete="off" disabled="disabled">

					<label for="company_type">Company type: <font color="RED">*</font></label>
					<select name="company_type" class="company_type" disabled="disabled">
						<option value="">Choose</option>
						<option value="individual" <?=($data["profile"]["company_type"]=="individual") ? 'selected="selected"' : ''?>>Individual</option>
						<option value="manufacturing" <?=($data["profile"]["company_type"]=="manufacturing") ? 'selected="selected"' : ''?>>Manufacturing</option>
					</select>
						
					<label for="namelname">Company name: <font color="RED">*</font></label>
					<input type="text" name="namelname" id="namelname" value="<?=htmlentities($data["profile"]["namelname"])?>" autocomplete="off">

					<label for="email">Company email:</label>
					<input type="text" name="email" id="email" value="<?=htmlentities($data["profile"]["email"])?>" autocomplete="off">

					<?php
					if($data["profile"]["company_type"]=="manufacturing"){
					?>

					<label for="sector">Sector: </label>
					<select name="sector_id" id="sector" disabled="disabled"><option value="<?=htmlentities($data["profile"]["sector_id"])?>"><?=htmlentities($data["profile"]["sector_id"])?></option></select>

					<label for="subsector">Sub sector: </label>
					<select name="sub_sector_id" id="subsector" disabled="disabled"><option value="<?=htmlentities($data["profile"]["sub_sector_id"])?>"><?=htmlentities($data["profile"]["sub_sector_id"])?></option></select>

					<label for="products">Products: </label>
					<input type="text" name="products" id="products" value="<?=htmlentities($data["profile"]["products"])?>" autocomplete="off">

					<label for="established_in">Established in: </label>
					<input type="text" name="established_in" id="established_in" value="<?=htmlentities($data["profile"]["established_in"])?>" autocomplete="off">

					<label for="number_of_employes">Number of employes: </label>
					<input type="text" name="number_of_employes" id="number_of_employes" value="<?=htmlentities($data["profile"]["number_of_employes"])?>" autocomplete="off">

					<label for="sme_classification">SME classification: </label>
					<select name="sme_classification_id" id="sme_classification" disabled="disabled"><option value="<?=htmlentities($data["profile"]["sme_classification_id"])?>"><?=$data["profile"]["sme_classification_id"]?></option></select>

					<label for="production_capacity">Production capacity: </label>
					<input type="text" name="production_capacity" id="production_capacity" value="<?=htmlentities($data["profile"]["production_capacity"])?>" autocomplete="off">

					<label for="certificates">Certificates: </label>
					<input type="text" name="certificates" id="certificates" value="<?=htmlentities($data["profile"]["certificates"])?>" autocomplete="off">

					<label for="export_markets">Export markets: </label>
					<select name="export_markets_id" id="export_markets" disabled="disabled"><option value="<?=htmlentities($data["profile"]["export_markets_id"])?>"><?=$data["profile"]["export_markets_id"]?></option></select>

					<label for="address">Address: </label>
					<input type="text" name="address" id="address" value="<?=htmlentities($data["profile"]["address"])?>" autocomplete="off">

					<label for="contact_person">Contact person: </label>
					<input type="text" name="contact_person" id="contact_person" value="<?=htmlentities($data["profile"]["contact_person"])?>" autocomplete="off">

					<label for="cp_email">Person email: </label>
					<input type="text" name="cp_email" id="cp_email" value="<?=htmlentities($data["profile"]["cp_email"])?>" autocomplete="off">

					<label for="cp_phone">Person phone: </label>
					<input type="text" name="cp_phone" id="cp_phone" value="<?=htmlentities($data["profile"]["cp_phone"])?>" autocomplete="off" />

					<label for="cp_mobile">Person mobile: </label>
					<input type="text" name="cp_mobile" id="cp_mobile" value="<?=htmlentities($data["profile"]["cp_mobile"])?>" autocomplete="off" />

					<label for="office_phone">Office phone: </label>
					<input type="text" name="office_phone" id="office_phone" value="<?=htmlentities($data["profile"]["office_phone"])?>" autocomplete="off" />

					<label for="web_address">Web address:</label>
					<input type="text" name="web_address" id="web_address" value="<?=htmlentities($data["profile"]["web_address"])?>" autocomplete="off">

					<label for="about">About: <font color="RED">*</font></label>
					<textarea name="about" class="tinyMce"><?=htmlentities($data["profile"]["about"])?></textarea>
					<?php }else if($data["profile"]["company_type"]=="individual"){ ?>

					<label for="address">Address:</label>
					<input type="text" name="address" id="address" value="<?=htmlentities($data["profile"]["address"])?>" autocomplete="off" />

					<label for="contact_person">Contact person: </label>
					<input type="text" name="contact_person" id="contact_person" value="<?=htmlentities($data["profile"]["contact_person"])?>" autocomplete="off" />

					<label for="cp_email">Person email: </label>
					<input type="text" name="cp_email" id="cp_email" value="<?=htmlentities($data["profile"]["cp_email"])?>" autocomplete="off" />

					<label for="cp_phone">Person phone: </label>
					<input type="text" name="cp_phone" id="cp_phone" value="<?=htmlentities($data["profile"]["cp_phone"])?>" autocomplete="off" />

					<label for="cp_mobile">Person mobile: </label>
					<input type="text" name="cp_mobile" id="cp_mobile" value="<?=htmlentities($data["profile"]["cp_mobile"])?>" autocomplete="off" />

					<label for="web_address">Web address:</label>
					<input type="text" name="web_address" id="web_address" value="<?=htmlentities($data["profile"]["web_address"])?>" autocomplete="off" />
					<?php } ?>

					<input type="submit" name="edit_website_user" id="submit" value="Submit"><br>
				</form>
			</div>
		</div>
	</main>
	<div class="clearfix"></div>
	<script type="text/javascript">
	tinymce.init({
		selector: ".tinyMce" 
	});
	</script>
	<?php
	@include("view/parts/footer.php");
	?>
</body>
</html>