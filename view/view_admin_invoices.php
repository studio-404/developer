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
			@include("view/parts/change_language.php");
			@include("view/parts/breadcrups.php");
			?>
			<div class="content">
				<div class="button">
					<a href="?action=addInvoice"><i class="fa fa-plus-circle"></i> <span>Add</span></a>
				</div>
				<div class="button" style="margin-left:10px;">
					<a href="?action=invoices&duedate"><i class="fa fa-clock-o"></i> <span>Due date (web hotting)</span></a>
				</div>
				<div class="wrap">
					<div class="search">
					<input type="text" class="searchTerm" value="" placeholder="Invoice id OR Users name">
					<input type="submit" class="searchButton">
					</div>
				</div>

				<div id="table">

					<div class="header-row row">
						<span class="cell primary">UID</span>
						<span class="cell">Start date</span>
						<span class="cell">End date</span>
						<span class="cell">(ID) Usern's name</span>
						<span class="cell">Service</span>
						<span class="cell">Description</span>
						<span class="cell">Price</span>
						<span class="cell">Pay status</span>
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