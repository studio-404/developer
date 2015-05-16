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
				<form action="" method="post" class="my-form" autocomplete="off">
					<div class="from-header">Plesae Log in</div>
					<?php
					$login_try = (isset($data["login_try"])) ? "Username or Password or PIC number is incorrect !" : "";
					if(!empty($login_try)) :
					?>
					<div class="messagex"><?=$login_try?></div>
					<?php
					endif;
					?>
					<label for="username">Username:</label>
					<input type="text" name="username" id="username" value="" autocomplete="off" />
					<label for="password">Password:</label>
					<input type="password" name="password" id="password" value="" />
					<label for="captcha">Type picture code:</label>
					<input type="text" name="captcha" id="captcha" value="" autocomplete="off" />
					<div class="captcha">
						<?php
						$_SESSION['encoded'] = rand(10000,99999)
						?>
						<img src="<?=WEBSITE?>/captcha.php" width="100" height="30" alt="captcha" />
					</div>
					<input type="submit" name="admin_login" id="submit" value="Log In" /><br />
				</form>

			</div>
		</div>
	</main>
	<?php
	@include("view/parts/footer.php");
	?>
</body>
</html>