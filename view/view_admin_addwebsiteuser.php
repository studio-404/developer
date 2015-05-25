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
						<p>Data inserted !</p>
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
					<div class="from-header" style="color:#ef4836; text-transform:uppercase">Add website user</div>
					
					<label for="username">Username: <font color="RED">*</font></label>
					<input type="text" name="username" id="username" value="" autocomplete="off">

					<label for="password">Password: <font color="RED">*</font></label>
					<input type="password" name="password" id="password" value="">

					<label for="company_type">Company type: <font color="RED">*</font></label>
					<select name="company_type" class="company_type">
						<option value="">Choose</option>
						<option value="individual">Individual</option>
						<option value="manufacturing">Manufacturing</option>
					</select>
					<div class="load_inputs"></div>


					<input type="submit" name="add_website_user" id="submit" value="Submit"><br>
				</form>
			</div>
		</div>
	</main>
	<div class="clearfix"></div>
	<?php
	@include("view/parts/footer.php");
	?>
	<script type="text/javascript">
	$(document).on("change",".company_type", function(){
		var chosen = $(this).val();
		if(chosen=="individual"){
			o = '<label for="namelname">Company name: <font color="RED">*</font></label>';
			o += '<input type="text" name="namelname" id="namelname" value="" autocomplete="off" />';

			o += '<label for="email">Company email:</label>';
			o += '<input type="text" name="email" id="email" value="" autocomplete="off" />';

			o += '<label for="address">Address:</label>';
			o += '<input type="text" name="address" id="address" value="" autocomplete="off" />';

			o += '<label for="contact_person">Contact person: </label>';
			o += '<input type="text" name="contact_person" id="contact_person" value="" autocomplete="off" />';

			o += '<label for="cp_email">Person email: </label>';
			o += '<input type="text" name="cp_email" id="cp_email" value="" autocomplete="off" />';

			o += '<label for="cp_phone">Person phone: </label>';
			o += '<input type="text" name="cp_phone" id="cp_phone" value="" autocomplete="off" />';

			o += '<label for="cp_mobile">Person mobile: </label>';
			o += '<input type="text" name="cp_mobile" id="cp_mobile" value="" autocomplete="off" />';

			o += '<label for="web_address">Web address:</label>';
			o += '<input type="text" name="web_address" id="web_address" value="" autocomplete="off" />';
		}else if(chosen=="manufacturing"){
			o = '<label for="namelname">Company name: <font color="RED">*</font></label>';
			o += '<input type="text" name="namelname" id="namelname" value="" autocomplete="off">';

			o += '<label for="email">Company email:</label>';
			o += '<input type="text" name="email" id="email" value="" autocomplete="off">';

			o += '<label for="sector">Sector: </label>';
			o += '<select name="sector_id" id="sector"><option value="">Choose</option></select>';

			o += '<label for="subsector">Sub sector: </label>';
			o += '<select name="sub_sector_id" id="subsector"><option value="">Choose</option></select>';

			o += '<label for="products">Products: </label>';
			o += '<input type="text" name="products" id="products" value="" autocomplete="off">';

			o += '<label for="established_in">Established in: </label>';
			o += '<input type="text" name="established_in" id="established_in" value="" autocomplete="off">';

			o += '<label for="number_of_employes">Number of employes: </label>';
			o += '<input type="text" name="number_of_employes" id="number_of_employes" value="" autocomplete="off">';

			o += '<label for="sme_classification">SME classification: </label>';
			o += '<select name="sme_classification_id" id="sme_classification"><option value="">Choose</option></select>';

			o += '<label for="production_capacity">Production capacity: </label>';
			o += '<input type="text" name="production_capacity" id="production_capacity" value="" autocomplete="off">';

			o += '<label for="certificates">Certificates: </label>';
			o += '<input type="text" name="certificates" id="certificates" value="" autocomplete="off">';

			o += '<label for="export_markets">Export markets: </label>';
			o += '<select name="export_markets_id" id="export_markets"><option value="">Choose</option></select>';

			o += '<label for="address">Address: </label>';
			o += '<input type="text" name="address" id="address" value="" autocomplete="off">';

			o += '<label for="contact_person">Contact person: </label>';
			o += '<input type="text" name="contact_person" id="contact_person" value="" autocomplete="off">';

			o += '<label for="cp_email">Person email: </label>';
			o += '<input type="text" name="cp_email" id="cp_email" value="" autocomplete="off">';

			o += '<label for="cp_phone">Person phone: </label>';
			o += '<input type="text" name="cp_phone" id="cp_phone" value="" autocomplete="off" />';

			o += '<label for="cp_mobile">Person mobile: </label>';
			o += '<input type="text" name="cp_mobile" id="cp_mobile" value="" autocomplete="off" />';

			o += '<label for="office_phone">Office phone: </label>';
			o += '<input type="text" name="office_phone" id="office_phone" value="" autocomplete="off" />';

			o += '<label for="web_address">Web address:</label>';
			o += '<input type="text" name="web_address" id="web_address" value="" autocomplete="off">';

			o += '<label for="about">About: <font color="RED">*</font></label>';
			o += '<textarea name="about" class="tinyMce"></textarea>';

			$.get("/<?=LANG?>/ajaxloadoptions",{ sector:"true" },function(data){
				$("#sector").html(data);
			});

			$.get("/<?=LANG?>/ajaxloadoptions",{ sme:"true" },function(data){
				$("#sme_classification").html(data);
			});

			$.get("/<?=LANG?>/ajaxloadoptions",{ export_markets:"true" },function(data){
				$("#export_markets").html(data);
			});			


			$(document).on("change","#sector",function(){
				var sidx = $(this).val();
				$.get("/<?=LANG?>/ajaxloadoptions",{ sub_sector:"true", sub_idx:sidx },function(data){	
					$("#subsector").html(data);
				});
			});
		}
		$(".load_inputs").html(o);
		tinymce.init({
			selector: ".tinyMce" 
		});
	});
	</script>
</body>
</html>