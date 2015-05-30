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

				<div id="table">

					<div class="header-row row">
						<span class="cell primary">Send date</span>
						<span class="cell">Send type</span>
						<span class="cell">Group name</span>
						<span class="cell">Subject</span>
						<span class="cell">Send status</span>
						<span class="cell">Action</span>
					</div>

					<?=$data['table']?>
					
				</div>

				<?=$data['pager']?>

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