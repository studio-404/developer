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
					<div class="from-header" style="color:#ef4836; text-transform:uppercase">Edit vector map</div>
					
					<label for="title">Title: <font color="RED">*</font></label>
					<input type="text" name="title" id="title" value="<?=htmlentities($data["select"]["title"])?>" autocomplete="off">

					<label for="code">Code: <font color="RED">*</font></label>
					<input type="text" name="code" id="code" value="<?=htmlentities($data["select"]["code"])?>" autocomplete="off" disabled="disabled" />

					<label for="export">Export: </label>
                    <input type="text" name="export" id="export" value="<?=htmlentities($data["select"]["export"])?>" autocomplete="off" />

                    <label for="import">Import: </label>
                    <input type="text" name="import" id="import" value="<?=htmlentities($data["select"]["import"])?>" autocomplete="off" />

                    <label for="traderegime">Trade regime: </label>
                    <select name="traderegime">
                    	<option value="Free trade" <?=($data["select"]["trade_regime"]=="Free trade") ? 'selected="selected"' : ''?>>Free trade</option>
                    	<option value="GSP+" <?=($data["select"]["trade_regime"]=="GSP+") ? 'selected="selected"' : ''?>>GSP+</option>
                    	<option value="Ongoing Free Trade Negotiation" <?=($data["select"]["trade_regime"]=="Ongoing Free Trade Negotiation") ? 'selected="selected"' : ''?>>Ongoing Free Trade Negotiation</option>
                    </select>

                    <label for="countrygroups">Country groups: </label>
                    <select name="countrygroups">
                    	<option value="Others" <?=($data["select"]["countrygroups"]=="Others") ? 'selected="selected"' : ''?>>Others</option>
                    	<option value="CIS" <?=($data["select"]["countrygroups"]=="CIS") ? 'selected="selected"' : ''?>>CIS</option>
                    	<option value="EU" <?=($data["select"]["countrygroups"]=="EU") ? 'selected="selected"' : ''?>>EU</option>
                    </select>

                   
					<div class="clearfix"></div>
					
					<input type="submit" name="edit_vectormap" id="submit" value="Submit"><br>
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