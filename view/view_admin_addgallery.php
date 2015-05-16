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
	<link rel="stylesheet" href="<?=PLUGINS?>jquery-ui-1.11.4.custom/jquery-ui.css">
	<script src="<?=PLUGINS?>jquery-ui-1.11.4.custom/jquery-ui.js"></script>
	<script src="<?=PLUGINS?>/tinymce/tinymce.min.js"></script>
	<!--Start timepicker-->
	<link href="<?=STYLES?>jquery-ui-timepicker-addon.css" type="text/css" rel="stylesheet" /> 
	<script src="<?=SCRIPTS?>jquery-ui-timepicker-addon.js" type="text/javascript" charset="utf-8"></script>
	<!--End timepicker-->
	<script type="text/javascript">
	tinymce.init({
		selector: ".tinyMce"
	});
	</script>
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
					<div class="from-header" style="color:#ef4836; text-transform:uppercase">Add gallery item</div>
					
					<label for="date">Date: <font color="RED">*</font></label>
					<input type="text" name="date" class="datepicker" value="<?=date('d-m-Y H:i')?>" />
					
					<label for="date">Expire date: <font color="RED">*</font></label>
					<input type="text" name="expiredate" class="datepicker" value="<?=date('d-m-Y H:i')?>" />
					<script>
					$(function() {
						$( ".datepicker" ).datetimepicker({ dateFormat: 'dd-mm-yy', changeYear: true });
					});
					</script>
					
					<label for="title">Title: <font color="RED">*</font></label>
					<input type="text" name="title" id="title" value="" autocomplete="off">

					<label for="friendlyurl">Friendly URL: <font color="RED">*</font></label><br />
					<input type="hidden" name="slug" value="<?=$data["pre_slug"]?>" />
					
					<span class="frURL"><?=WEBSITE.LANG?>/<?=PRE_GALLERY?>/</span>
					<input type="text" name="friendlyurl" id="friendlyurl" value="" autocomplete="off" class="frURLInput"><div class="clearfix"></div>

                    <label>Description: </label>
                    <textarea name="description" class="tinyMce"></textarea>

                    <label for="tags">Tags: ( comma seperated value ) </label>
					<input type="text" name="tags" id="tags" value="" autocomplete="off">
					
					<input type="submit" name="add_gallery" id="submit" value="Submit"><br>
				</form>
			</div>
		</div>
	</main>
	<div class="clearfix"></div>
	<?php
	@include("view/parts/footer.php");
	?>
</body>
</html>