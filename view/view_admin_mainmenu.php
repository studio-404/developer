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
			<div class="content">
				<div class="button">
					<a href="?action=addAdmin"><i class="fa fa-plus-circle"></i> <span>Add</span></a>
				</div>

				<div class="wrap">
					<div class="search">
					<input type="text" class="searchTerm" placeholder="What are you looking for?">
					<input type="submit" class="searchButton">
					</div>
				</div>

				<div id="table">
					<div class="header-row row">
						<span class="cell primary">Vehcile</span>
						<span class="cell">Exterior</span>
						<span class="cell">Interior</span>
						<span class="cell">Engine</span>
						<span class="cell">Action</span>
					</div>
					<div class="row">
						<span class="cell primary" data-label="Vehicle">2013 Subaru WRX</span>
						<span class="cell" data-label="Exterior">World Rally Blue</span>
						<span class="cell" data-label="Interior">Black</span>
						<span class="cell" data-label="Engine">2.5L H4 Turbo</span>
						<span class="cell" data-label="Action">
							<a href=""><i class="fa fa-search"></i></a>
							<a href=""><i class="fa fa-pencil-square-o"></i></a>
							<a href=""><i class="fa fa-file"></i></a>
							<a href=""><i class="fa fa-link"></i></a>
							<a href=""><i class="fa fa-plus"></i></a>
							<a href=""><i class="fa fa-times"></i></a>
						</span>
					</div>
					<div class="row">
						<span class="cell primary" data-label="Vehicle">2013 Subaru WRX STI</span>
						<span class="cell" data-label="Exterior">Crystal Black Silica</span>
						<span class="cell" data-label="Interior">Black</span>
						<span class="cell" data-label="Engine">2.5L H4 Turbo</span>
						<span class="cell" data-label="Action">
							<a href=""><i class="fa fa-search"></i></a>
							<a href=""><i class="fa fa-pencil-square-o"></i></a>
							<a href=""><i class="fa fa-file"></i></a>
							<a href=""><i class="fa fa-link"></i></a>
							<a href=""><i class="fa fa-plus"></i></a>
							<a href=""><i class="fa fa-times"></i></a>
						</span>
					</div>
					<div class="row">
						<span class="cell primary" data-label="Vehicle">2013 Subaru BRZ</span>
						<span class="cell" data-label="Exterior">Dark Grey Metallic</span>
						<span class="cell" data-label="Interior">Black</span>
						<span class="cell" data-label="Engine">2.0L H4</span>
						<span class="cell" data-label="Action">
							<a href=""><i class="fa fa-search"></i></a>
							<a href=""><i class="fa fa-pencil-square-o"></i></a>
							<a href=""><i class="fa fa-file"></i></a>
							<a href=""><i class="fa fa-link"></i></a>
							<a href=""><i class="fa fa-plus"></i></a>
							<a href=""><i class="fa fa-times"></i></a>
						</span>
					</div>
					<div class="row">
						<span class="cell primary" data-label="Vehicle">2013 Subaru Legacy</span>
						<span class="cell" data-label="Exterior">Satin White Pearl</span>
						<span class="cell" data-label="Interior">Black</span>
						<span class="cell" data-label="Engine">2.5L H4</span>
						<span class="cell" data-label="Action">
							<a href=""><i class="fa fa-search"></i></a>
							<a href=""><i class="fa fa-pencil-square-o"></i></a>
							<a href=""><i class="fa fa-file"></i></a>
							<a href=""><i class="fa fa-link"></i></a>
							<a href=""><i class="fa fa-plus"></i></a>
							<a href=""><i class="fa fa-times"></i></a>
						</span>
					</div>
					<div class="row">
						<span class="cell primary" data-label="Vehicle">2013 Subaru Legacy</span>
						<span class="cell" data-label="Exterior">Twilight Blue Metallic</span>
						<span class="cell" data-label="Interior">Black</span>
						<span class="cell" data-label="Engine">2.5L H4</span>
						<span class="cell" data-label="Action">
							<a href=""><i class="fa fa-search"></i></a>
							<a href=""><i class="fa fa-pencil-square-o"></i></a>
							<a href=""><i class="fa fa-file"></i></a>
							<a href=""><i class="fa fa-link"></i></a>
							<a href=""><i class="fa fa-plus"></i></a>
							<a href=""><i class="fa fa-times"></i></a>
						</span>
					</div>
					<div class="row">
						<span class="cell primary" data-label="Vehicle">2013 Subaru Forester</span>
						<span class="cell" data-label="Exterior">Ice Silver Metallic</span>
						<span class="cell" data-label="Interior">Black</span>
						<span class="cell" data-label="Engine">2.5L H4 Turbo</span>
						<span class="cell" data-label="Action">
							<a href=""><i class="fa fa-search"></i></a>
							<a href=""><i class="fa fa-pencil-square-o"></i></a>
							<a href=""><i class="fa fa-file"></i></a>
							<a href=""><i class="fa fa-link"></i></a>
							<a href=""><i class="fa fa-plus"></i></a>
							<a href=""><i class="fa fa-times"></i></a>
						</span>
					</div>
				</div>

				<div class="pagination">
					<a href="#" class="page gradient">prev</a>
					<a href="#" class="page gradient">2</a>
					<a href="#" class="page gradient">3</a>
					<span class="page active">4</span>
					<a href="#" class="page gradient">5</a>
					<a href="#" class="page gradient">6</a>
					<a href="#" class="page gradient">next</a>
				</div>

			</div>
		</div>
	</main>
	<div class="clearfix"></div>
	<?php
	@include("view/parts/footer.php");
	?>
</body>
</html>