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
				<div class="button">
					<a href="?action=addEmailGroup"><i class="fa fa-plus-circle"></i> <span>Add</span></a>
				</div>

				<div class="wrap">
					<div class="search">
					<input type="text" class="searchTerm" placeholder="What are you looking for?">
					<input type="submit" class="searchButton">
					</div>
				</div>

				<div id="table">
					<div class="header-row row">
						<span class="cell">ID</span>
						<span class="cell primary">Group name</span>
						<span class="cell">Emails</span>
						<span class="cell" style="width:100px">Action</span>
					</div>					
					<?=$data['table']?>
				</div>
			<?=$data['pager']?>
		</div>
	</main>
	<div class="clearfix"></div>
	<?php
	@include("view/parts/footer.php");
	?>
</body>
</html>