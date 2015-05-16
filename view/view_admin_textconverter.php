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
					<div class="from-header" style="color:#ef4836; text-transform:uppercase">Text converter</div>
					<?php
					//chack which converter is on
					if(!isset($_POST['convertMethod'])){ $noIssetChecked = 'checked="checked"'; }else{ $noIssetChecked=''; }
					?>
					<label>
						<input type="radio" name="convertMethod" value="englishToGeorgian" <?php echo (isset($_POST['convertMethod']) && $_POST['convertMethod']=="englishToGeorgian") ? 'checked="checked"' : ''; echo $noIssetChecked; ?> />
						&nbsp;&nbsp;&nbsp;<font color="black">English To Georgian:</font>&nbsp;&nbsp;&nbsp;
					</label>&nbsp;&nbsp;&nbsp;
					<label>
						<input type="radio" name="convertMethod" value="removeTags" <?php echo (isset($_POST['convertMethod']) && $_POST['convertMethod']=="removeTags") ? 'checked="checked"' : ''; ?> />
						&nbsp;&nbsp;&nbsp;<font color="black">Remove html tags:</font>&nbsp;&nbsp;&nbsp;
					</label>
					<label>
						<input type="radio" name="convertMethod" value="removeSpace" <?php echo (isset($_POST['convertMethod']) && $_POST['convertMethod']=="removeSpace") ? 'checked="checked"' : ''; ?> />
						&nbsp;&nbsp;&nbsp;<font color="black">Compress (remove space):</font>&nbsp;&nbsp;&nbsp;
					</label>
					<br />

					<label for="email">Input:</label>
					<textarea name="input" id="input"><?php echo (!empty($_POST['input'])) ? htmlentities($_POST['input']) : ''; ?></textarea>
					<label for="email">Output:</label>
					<textarea name="output" id="output"><?php echo (!empty($data['output'])) ? htmlentities($data['output']) : ''; ?></textarea>
					
					
					<input type="submit" name="convert_text" id="submit" value="Submit"><br>
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