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
	<script src="<?=SCRIPTS?>drop.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" href="<?=PLUGINS?>jquery-ui-1.11.4.custom/jquery-ui.css">
	<script src="<?=PLUGINS?>jquery-ui-1.11.4.custom/jquery-ui.js"></script>
	<script src="<?=PLUGINS?>/tinymce/tinymce.min.js"></script>
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
			@include("view/parts/change_language.php");
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
					<div class="from-header" style="color:#ef4836; text-transform:uppercase">Edit component module</div>
					
					<label for="title">Title: <font color="RED">*</font></label>
					<input type="text" name="title" id="title" value="<?=htmlentities($data["select"]["title"])?>" autocomplete="off">

					<label for="shortdesc">Short desc</label>
					<input type="text" name="shortdesc" id="shortdesc" value="<?=htmlentities($data["select"]["desc"])?>" autocomplete="off" />

					<label for="url">Url: <font color="RED">*</font></label>
                    <input type="text" name="url" id="url" value="<?=htmlentities($data["select"]["url"])?>" autocomplete="off" />

                    <label for="backgroundImage">Image:</label><br />
					<input type="hidden" name="background" id="background" value="" />
					<div class="dragableArea">
						<h3>Drag and drop image (jpeg,jpg,gif,png)</h3>
						<div id="progress-bar"></div>
					</div><br />
					<div id="img">
						<?php if($data["select"]["image"]){ ?>
						<img src="<?=$data["select"]["image"]?>" />
						<?php }else{ ?>
						<p>No Image</p>
						<?php } ?>
					</div>
					<div class="clearfix"></div>
					
					<input type="submit" name="edit_componentmodel" id="submit" value="Submit"><br>
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