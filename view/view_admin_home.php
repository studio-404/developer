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

				<div id="table">
					<div class="header-row row">
						<span class="cell primary">Welcome to Website: CMS version <?=$data['c']['cmsversion']?></span>
						<span class="cell">&nbsp;</span>
					</div>
					<div class="row">
						<span class="cell primary" data-label="Vehicle">
							Site Name:
						</span>
						<span class="cell" data-label="Action">
							<?=$data['c']['site.name']?>
						</span>
					</div>
					<div class="row">
						<span class="cell primary" data-label="Vehicle">
							Website Address:
						</span>
						<span class="cell" data-label="Action">
							<a href="<?=$data['c']['site.url']?>" target="_blank"><?=$data['c']['site.url']?></a>
						</span>
					</div>
					<div class="row">
						<span class="cell primary" data-label="Vehicle">
							User:
						</span>
						<span class="cell" data-label="Action">
							<?=$_SESSION["user404"]?> (<?=$_SESSION["user_type"]?>)
						</span>
					</div>
					<div class="row">
						<span class="cell primary" data-label="Vehicle">
							CMS Version:
						</span>
						<span class="cell" data-label="Action">
							<?=$data['c']['cmsversion']?>
						</span>
					</div>
					<div class="row">
						<span class="cell primary" data-label="Vehicle">
							Your IP Address:
						</span>
						<span class="cell" data-label="Action">
							<?=$data["userIp"]?>
						</span>
					</div>
					<div class="row">
						<span class="cell primary" data-label="Vehicle">
							Loged:
						</span>
						<span class="cell" data-label="Action">
							<?=$_SESSION["log"]?>
						</span>
					</div>
					<div class="row">
						<span class="cell primary" data-label="Vehicle">
							Session expired time:
						</span>
						<span class="cell" data-label="Action">
							<?php
							$expired = $_SESSION["expired_sessioned_time"];
							echo date("d-m-Y H:i:s",$expired);
							?>
						</span>
					</div>
				</div>
				
				<div class="shortTable noneMargin">
					<div id="table">
						<div class="header-row row">
							<span class="cell primary">Page Managment</span>
							<span class="cell">Action</span>
						</div>
						<?=$data["managed_pages2"]?>		
						<div class="row">
							<span class="cell primary" data-label="Vehicle">Page managment</span>
							<span class="cell" data-label="Action">
								<a href=""><i class="fa fa-pencil-square-o"></i></a>
							</span>
						</div>
					</div>
				</div>

				<div class="shortTable">
					<div id="table">
						<div class="header-row row">
							<span class="cell primary">Users</span>
							<span class="cell">Action</span>
						</div>
						<div class="row">
							<span class="cell primary" data-label="Vehicle">User lists</span>
							<span class="cell" data-label="Action">
								<a href="?action=userList"><i class="fa fa-pencil-square-o"></i></a>
							</span>
						</div>
						<div class="row">
							<span class="cell primary" data-label="Vehicle">User rights</span>
							<span class="cell" data-label="Action">
								<a href="?action=userRights"><i class="fa fa-pencil-square-o"></i></a>
							</span>
						</div>
					</div>
				</div>

				<div class="shortTable">
					<div id="table">
						<div class="header-row row">
							<span class="cell primary">Settings & tools</span>
							<span class="cell">Action</span>
						</div>
						<div class="row">
							<span class="cell primary" data-label="Vehicle">Site Settings</span>
							<span class="cell" data-label="Action">
								<a href=""><i class="fa fa-pencil-square-o"></i></a>
							</span>
						</div>
						<div class="row">
							<span class="cell primary" data-label="Vehicle">Language data</span>
							<span class="cell" data-label="Action">
								<a href=""><i class="fa fa-pencil-square-o"></i></a>
							</span>
						</div>
						<div class="row">
							<span class="cell primary" data-label="Vehicle">Profile settings</span>
							<span class="cell" data-label="Action">
								<a href="?action=profileSettings"><i class="fa fa-pencil-square-o"></i></a>
							</span>
						</div>
						<div class="row">
							<span class="cell primary" data-label="Vehicle">Change password</span>
							<span class="cell" data-label="Action">
								<a href="?action=changePassword"><i class="fa fa-pencil-square-o"></i></a>
							</span>
						</div>
						<div class="row">
							<span class="cell primary" data-label="Vehicle">Backup</span>
							<span class="cell" data-label="Action">
								<a href=""><i class="fa fa-pencil-square-o"></i></a>
							</span>
						</div>
						<div class="row">
							<span class="cell primary" data-label="Vehicle">Text converter</span>
							<span class="cell" data-label="Action">
								<a href="?action=textConverter"><i class="fa fa-pencil-square-o"></i></a>
							</span>
						</div>
						<div class="row">
							<span class="cell primary" data-label="Vehicle">Log</span>
							<span class="cell" data-label="Action">
								<a href="?action=log"><i class="fa fa-pencil-square-o"></i></a>
							</span>
						</div>
					</div>
				</div>
					<div class="clearfix"></div>
				

			</div>
		</div>
	</main>
	<div class="clearfix"></div>
	<?php
	@include("view/parts/footer.php");
	?>
</body>
</html>