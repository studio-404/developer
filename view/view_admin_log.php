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

	<link rel="stylesheet" href="<?=PLUGINS?>jquery-ui-1.11.4.custom/jquery-ui.css">
	<script src="<?=PLUGINS?>jquery-ui-1.11.4.custom/jquery-ui.js"></script>
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
				<div class="wrap">
					<div class="search">
						<input type="text" class="searchTerm" value="<?=(isset($_GET['search'])) ? $_GET['search'] :date("d-m-Y")?>">
						<input type="submit" class="searchButton">
					</div>
					<script>
						$(function() {
							$( ".searchTerm" ).datepicker({ dateFormat: 'dd-mm-yy' });
						});
					</script>
				</div><div class="clearfix"></div><br />

				<div id="table">

					<div class="header-row row">
						<span class="cell primary">Log time</span>
						<span class="cell primary">Firstname Lastname</span>
						<span class="cell primary">Username</span>
						<span class="cell primary">Browser</span>
						<span class="cell">OS</span>
						<span class="cell">Ip address</span>
						<span class="cell">Action</span>
					</div>

					<?=$data['table']?>
					
				</div>

				<?=$data['pager']?>

			</div>
		</div>
	</main>
	<div class="clearfix"></div>
	<?php
	@include("view/parts/footer.php");
	?>
</body>
</html>