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

	<link rel="stylesheet" href="http://developer.404.ge/_plugins/jquery-ui-1.11.4.custom/jquery-ui.css">
	<script src="http://developer.404.ge/_plugins/jquery-ui-1.11.4.custom/jquery-ui.js"></script>

</head>
<body>
	<?php
	@include("view/parts/header.php");
	?>
	<main>
		<div class="center">
			<?php
			@include("view/parts/change_language.php");
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
					<div class="from-header" style="color:#ef4836; text-transform:uppercase">Edit invoce</div>
					
					<label for="startdate">Start date: <font color="RED">*</font></label>
					<input type="text" name="startdate" id="startdate" class="datepicker" value="<?=date("d-m-Y",$data["info"]["si_start_date"])?>" autocomplete="off" />
					
					<label for="enddate">End date: <font color="RED">*</font></label>
					<input type="text" name="enddate" id="enddate" class="datepicker" value="<?=date("d-m-Y",$data["info"]["si_end_date"])?>" autocomplete="off" />
					

					<label for="userid">User ID: <font color="RED">*</font></label>
					<input type="text" name="userid" id="userid" value="<?=htmlentities($data["info"]["su_namelname"].":".$data["info"]["su_id"])?>" autocomplete="off" disabled="disabled" />

					<label for="service">Service: <font color="RED">*</font></label>
					<select name="service" class="service" id="service" disabled="disabled">
					
					<option value="webhosting"<?=($data["info"]["si_service"]=="webhosting") ? ' selected="selected"':''?>>
					<?=ucfirst($data["webhosting"])?>
					</option>
					
					<option value="creatingawebsite"<?=($data["info"]["si_service"]=="creatingawebsite") ? ' selected="selected"':''?>>
					<?=ucfirst($data["creatingawebsite"])?>
					</option>
					
					<option value="otherservice"<?=($data["info"]["si_service"]=="otherservice") ? ' selected="selected"':''?>>
					<?=ucfirst($data["otherservice"])?>
					</option>
					
					</select>

					<label for="description">Description: (Domain :: package)</label>
					<input type="text" name="description" id="description" value="<?=htmlentities($data["info"]["si_description"])?>" autocomplete="off" />
					
					<label for="price">Price:</label><div class="clearfix"></div>
					<input type="text" name="price" id="price" value="<?=htmlentities($data["info"]["si_price"])?>" autocomplete="off" disabled="disabled">
					<div class="clearfix"></div>
					
					<?php if($data["info"]["si_discount"]) : ?>
					<label for="discount">Discount: ( % )</label>
					<input type="text" name="discount" id="discount" value="<?=htmlentities($data["info"]["si_discount"])?>" autocomplete="off" disabled="disabled" />
					<?php endif; ?>
					
					<label for="paystatus">Pay status:</label>
					<select name="paystatus">
						<option value="1" <?=($data["info"]["si_paystatus"]==1) ? 'selected="selected"' : ''?>><?=$data["gadaxdilia"]?></option>
						<option value="2" <?=($data["info"]["si_paystatus"]==2) ? 'selected="selected"' : ''?>><?=$data["gadasaxdeli"]?></option>
					</select>
					
					<input type="submit" name="edit_invoce" id="submit" value="Submit"><br>
				</form>
			</div>
		</div>
	</main>
	<div class="clearfix"></div>

<script>
$(function() {
	$( ".datepicker" ).datepicker({ dateFormat: 'dd-mm-yy', changeYear: true });
	var availableTags = [
		<?php foreach($data["fetch"] as $f){ ?>
			"<?=htmlentities($f['namelname'])?> - <?=htmlentities($f['username'])?>:<?=$f['id']?>",
		<?php } ?>
	];
	$( "#userid" ).autocomplete({
			source: availableTags
	});
});
</script>

	<?php
	@include("view/parts/footer.php");
	?>
</body>
</html>