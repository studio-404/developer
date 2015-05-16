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
				$menu_managment = ($data["user_rights"]["menu_managment"]) ? 'checked="checked"' : '';
				$modules = ($data["user_rights"]["modules"]) ? 'checked="checked"' : '';
				$users = ($data["user_rights"]["users"]) ? 'checked="checked"' : '';
				$tools = ($data["user_rights"]["tools"]) ? 'checked="checked"' : '';
				$settings = ($data["user_rights"]["settings"]) ? 'checked="checked"' : '';
				?>


				<form action="" method="post" class="my-form hundredPorsent" autocomplete="off">
				<div class="from-header" style="color:#ef4836; text-transform:uppercase">Edit user right groups</div>
				<label for="username">User group:</label>
				<input type="text" name="usergroup" id="usergroup" value="<?=htmlentities($data["user_rights"]["name"])?>" />
				<label>Menu_managment:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="menumanagment" value="" 
					<?=$menu_managment?> /></label><br />
				<label>Modules:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="modules" value="1" <?=$modules?> /></label><br />
				<label>Users:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="users" value="1" <?=$users?> /></label><br />
				<label>Tools:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="tools" value="1" <?=$tools?> /></label><br />
				<label>Settings:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="settings" value="1" <?=$settings?> /></label><br />
				<input type="submit" name="edit_admin_userrights" id="submit" value="Submit"><br>
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