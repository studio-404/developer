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
				?>

				<form action="" method="post" class="my-form hundredPorsent" autocomplete="off">
					<div class="from-header" style="color:#ef4836; text-transform:uppercase">Add admin</div>
					
					<label for="username">Username: <font color="RED">*</font></label>
					<input type="text" name="username" id="username" value="" autocomplete="off">
					
					<label for="password">Password: <font color="RED">*</font></label>
					<input type="password" name="password" id="password" value="">

					<label for="namelname">Name: <font color="RED">*</font></label>
					<input type="text" name="namelname" id="namelname" value="" autocomplete="off">

					<label for="ucode">User code: <font color="RED">*</font></label>
					<input type="text" name="ucode" id="ucode" value="" autocomplete="off">

					<label for="email">Email:</label>
					<input type="text" name="email" id="email" value="" autocomplete="off">

					<label for="phone">Phone:</label>
					<input type="text" name="phone" id="phone" value="" autocomplete="off">

					<label for="mobile">Mobile:</label>
					<input type="text" name="mobile" id="mobile" value="" autocomplete="off">

					<label for="usertype">User type: <font color="RED">*</font></label><br />
					<select name="usertype">
						<?php
						foreach ($data["admin_types"] as $v) {
							echo '<option value="'.$v['name'].'">'.ucfirst($v['name']).'</option>';
						}
						?>
					</select>
					
					<input type="submit" name="add_admin" id="submit" value="Submit"><br>
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