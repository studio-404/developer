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
				<div class="button">
					<a href="?action=waddUser"><i class="fa fa-plus-circle"></i> <span>Add</span></a>
				</div>
				<div class="wrap">
					<div class="search">
					<input type="text" class="searchTerm" value="" placeholder="Name or Username or User code" />
					<input type="submit" class="searchButton" value="">
					</div>
				</div>

				<div id="table">

					<div class="header-row row">
						<span class="cell">Allowed</span>
						<span class="cell primary">Name</span>
						<span class="cell">Username</span>
						<span class="cell">User code</span>
						<span class="cell">User type</span>
						<span class="cell">Log time</span>
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