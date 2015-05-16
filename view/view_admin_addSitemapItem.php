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
	<script src="<?=SCRIPTS?>drop.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" href="<?=PLUGINS?>jquery-ui-1.11.4.custom/jquery-ui.css">
	<script src="<?=PLUGINS?>jquery-ui-1.11.4.custom/jquery-ui.js"></script>
	<script src="<?=PLUGINS?>/tinymce/tinymce.min.js"></script>
	<!--Start timepicker-->
	<link href="<?=STYLES?>jquery-ui-timepicker-addon.css" type="text/css" rel="stylesheet" /> 
	<script src="<?=SCRIPTS?>jquery-ui-timepicker-addon.js" type="text/javascript" charset="utf-8"></script>
	<!--End timepicker-->
	<script type="text/javascript">
	tinymce.init({
		selector: ".tinyMce"
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
			// @include("view/parts/change_language.php");
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

				<form action="" method="post" class="my-form hundredPorsent" autocomplete="off" enctype="multipart/form-data">
					<div class="from-header" style="color:#ef4836; text-transform:uppercase">Add sitemap item</div>
					
					<label for="date">Date: <font color="RED">*</font></label>
					<input type="text" name="date" class="datepicker" value="<?=date('d-m-Y H:i')?>" />
					
					<label for="date">Expire date: <font color="RED">*</font></label>
					<input type="text" name="expiredate" class="datepicker" value="<?=date('d-m-Y H:i')?>" />
					<script>
					$(function() {
						$( ".datepicker" ).datetimepicker({ dateFormat: 'dd-mm-yy', changeYear: true });
					});
					</script>
					
					<label for="title">Title: <font color="RED">*</font></label>
					<input type="text" name="title" id="title" value="" autocomplete="off">

					<label for="shorttitle">Short title: <font color="RED">*</font></label>
					<input type="text" name="shorttitle" id="shorttitle" value="" autocomplete="off">

					<label for="friendlyurl">Friendly URL: <font color="RED">*</font></label><br />
					<input type="hidden" name="slug" value="<?=$data["pre_slug"]?>" />
					<span class="frURL"><?=WEBSITE.LANG?>/<?=$data["pre_slug"]?>/</span>
					<input type="text" name="friendlyurl" id="friendlyurl" value="" autocomplete="off" class="frURLInput"><div class="clearfix"></div>

					<label for="page_type">Page type: <font color="RED">*</font></label>
					<select name="page_type" id="page_type" class="page_type">
                        <option value="textpage" selected="selected">Text Page</option>
                        <option value="homepage">Home Page</option>
                        <option value="eventpage">Event page</option> 
                        <option value="newspage">News Page</option>
                        <option value="publicationpage">publication Page</option>
                        <option value="photogallerypage">Photo gallery Page</option>
                        <option value="videogallerypage">Video gallery Page</option>
                        <option value="teampage">Team page</option>
                        <option value="catalogpage">Catalog page</option>
                        <option value="custompage">Custom page</option>
                    </select>	

                    <label>Description: </label>
                    <textarea name="description" class="tinyMce"></textarea>

                    <label>Page content: </label>
                    <textarea name="pagecontent" class="tinyMce"></textarea>				

					<label for="redirectLink">Redirect link:</label>
					<input type="text" name="redirectLink" id="redirectLink" value="" autocomplete="off">

					<label for="keywords">Keywords: (example: money, transfer, bussiness )</label>
					<input type="text" name="keywords" id="keywords" value="" autocomplete="off">

					<label for="backgroundImage">Background Image:</label><br />
					<input type="hidden" name="background" id="background" value="" />
					<div class="dragableArea">
						<h3>Drag and drop image (jpeg,jpg,gif,png)</h3>
						<div id="progress-bar"></div>
					</div><br />
					<div id="img">
						<p>No Image</p>
					</div>
					<div class="clearfix"></div>
					<br />
					<label for="videourl">Video Url: (youtube,myvideo)</label>
					<input type="text" name="videourl" id="videourl" value="" autocomplete="off" />
					<br />
					<label for="visibility">Visibility: <font color="RED">*</font></label><br />
					<label>Show &nbsp;&nbsp;&nbsp;<input type="radio" name="visibility" value="true" /></label>&nbsp;&nbsp;&nbsp;
					<label>Hide &nbsp;&nbsp;&nbsp;<input type="radio" name="visibility" value="false" checked="checked" /></label>
					
					<input type="submit" name="add_page" id="submit" value="Submit"><br>
					<button id="cancel" onclick="redirect('_self','<?=WEBSITE.LANG?>/admin?action=sitemap&super=<?=$_GET['super']?>'); return false;">Back</button>
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