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
	<script src="<?=PLUGINS?>/tinymce/tinymce.min.js"></script>
	<script type="text/javascript">
	$(function() {
		$( "#tabs" ).tabs();
		$(".justlink").attr({"aria-controls":""});
	});
	</script>
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
						<?php if(isset($_POST['newsletter_send'])) : ?>
						<p>Data inserted !</p>
						<?php endif; ?>
						<?php if(!isset($_POST['newsletter_send'])) : ?>
						<p>Data updated !</p>
						<?php endif; ?>
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
				$_SESSION['token'] = md5(time());
				?>

				<form action="" method="post" class="my-form hundredPorsent" autocomplete="off" enctype="multipart/form-data">
					<div class="from-header" style="color:#ef4836; text-transform:uppercase">Newsletter</div>
					<div id="tabs">
						<ul>
							<li><a href="#tabs-1">General (SMTP data)</a></li>
							<li><a href="#tabs-2">Send email (Dayly limit <?=$data["email_limit"]?>)</a></li>
							<li class="justlink"><a href="javascript:;" onclick="redirect('_self','?action=outbox&token=<?=$_SESSION['token']?>')">Outbox</a></li>
							<li class="justlink"><a href="javascript:;" onclick="redirect('_self','?action=managedemails&token=<?=$_SESSION['token']?>')">Manage email groups</a></li>
						</ul>
						<div id="tabs-1">
							<label for="host">Host: <font color="red">*</font></label>
							<input type="text" name="host" id="host" value="<?=htmlentities($data["info"]["host"])?>" />
							<label for="user">User: <font color="red">*</font></label>
							<input type="text" name="user" id="user" value="<?=htmlentities($data["info"]["user"])?>" />
							<label for="pass">Pass: <font color="red">*</font></label>
							<input type="text" name="pass" id="pass" value="<?=htmlentities($data["info"]["pass"])?>" />
							<label for="from">Sender email: <font color="red">*</font></label>
							<input type="text" name="from" id="from" value="<?=htmlentities($data["info"]["from"])?>" />
							<label for="fromname">Sender name: <font color="red">*</font></label>
							<input type="text" name="fromname" id="fromname" value="<?=htmlentities($data["info"]["fromname"])?>" />
							<input type="submit" name="newsletter_main" id="submit" value="Submit"><br />
						</div>
						<div id="tabs-2">
							<label for="subject">Subject: <font color="red">*</font></label>
							<input type="text" name="subject" id="subject" value="" />
							<label for="sendtype">Send type: <font color="red">*</font></label>
							<select name="sendtype" id="sendtype">
								<option value="">Choose</option>
								<option value="individual">Individual</option>
								<option value="groups">Groups</option>
							</select>
							<div class="loadtype"></div>
							<input type="submit" name="newsletter_send" id="submit" value="Submit"><br />
						</div>
					</div>
					
				</form>
			</div>
		</div>
	</main>
	<div class="clearfix"></div>
	<?php
	@include("view/parts/footer.php");
	?>
	<script type="text/javascript">
		$(document).on("change","#sendtype",function(){
			var i = $(this).val();
			var o = '';
			if(i){
				if(i=="individual"){
					o += '<label for="email">Email: </label>'; 
					o += '<input type="text" name="email" value="" />'; 
				}else if(i=="groups"){
					o += '<label for="groups">Groups: </label>'; 
					o += '<select name="groups" id="groups"><option value="">Choose</option></select>'; 
				}
				o += '<label for="message">Message: </label>'; 
				o += '<textarea class="tinyMce" name="message"></textarea>';
				$.get("/en/ajaxloadoptions", { newsletterGroups:"true" }, function(data){
					$("#groups").html(data);
				});
			} 



			$(".loadtype").html(o);
			tinymce.init({
				selector: ".tinyMce", 
				theme: "modern",
			    plugins: [
			        "autolink lists link image hr pagebreak",
			        "wordcount visualblocks",
			        "insertdatetime save table contextmenu directionality",
			        "paste textcolor colorpicker textpattern"
			    ],
			    toolbar1: "insertfile undo redo | styleselect | bold italic | link image",
			    image_advtab: true
			});
		});
	</script>
</body>
</html>