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
	<script src="<?=SCRIPTS?>drop_files.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" href="<?=PLUGINS?>jquery-ui-1.11.4.custom/jquery-ui.css">
	<script src="<?=PLUGINS?>jquery-ui-1.11.4.custom/jquery-ui.js"></script>
	<script src="<?=PLUGINS?>/tinymce/tinymce.min.js"></script>
	<!--Fancybox popup START-->
	<script type="text/javascript" src="<?=PLUGINS?>jquery.fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
	<script type="text/javascript" src="<?=PLUGINS?>jquery.fancybox/source/jquery.fancybox.pack.js"></script>
	<script type="text/javascript" src="<?=PLUGINS?>jquery.fancybox/source/jquery.fancybox.js"></script>
	<link rel="stylesheet" type="text/css" href="<?=PLUGINS?>jquery.fancybox/source/jquery.fancybox.css" media="screen" />
	<!--Fancybox popup END-->
	<!--Start timepicker-->
	<link href="<?=STYLES?>jquery-ui-timepicker-addon.css" type="text/css" rel="stylesheet" /> 
	<script src="<?=SCRIPTS?>jquery-ui-timepicker-addon.js" type="text/javascript" charset="utf-8"></script>
	<!--End timepicker-->
	<script type="text/javascript">
	tinymce.init({
		selector: ".tinyMce" 
	});
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
			@include("view/parts/change_language.php");
			@include("view/parts/breadcrups.php");
			?>
			<div class="content">
				<?php
				if(!empty($data["outMessage"]) && $data["outMessage"]==1){
				?>
					<div class="success message" onclick="hideMe('.message')">
					  <h2>Success</h2>
					  <p>Data updated !</p>
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
					<div class="from-header" style="color:#ef4836; text-transform:uppercase">Edit sitemap item</div>
					<div id="tabs">
						<?php echo $data["interface"][0]; ?>
						<?php echo $data['interface'][1]; ?>
					</div>
					<input type="submit" name="edit_page" id="submit" value="Submit"><br>
					<button id="cancel" onclick="redirect('_self','<?=WEBSITE.LANG?>/admin?action=sitemap&super=<?=$_GET['super']?>'); return false;">Back</button>
				</form>
			</div>
		</div>
	</main>
	<div class="clearfix"></div>
	<?php
	@include("view/parts/footer.php");
	?>
	<script type="text/javascript">
	$('.makeFileDragable').click(function(e) { 
		e.stopPropagation();
		e.preventDefault();
		var status = $("#dragText",this).html();   
		if(status=="Start sorting"){
			$(".makeFileDragable").attr("style","background-color:red");
			$("#dragText",this).html("Stop sorting");
			$("main .center .content .dropArea .dragElements").sortable({
				 disabled: false
			});
		}else if(status=="Stop sorting"){
			$(".makeFileDragable").attr("style","background-color:green");
			$("#dragText",this).html("Start sorting");
			$("main .center .content .dropArea .dragElements").sortable({
		   		 disabled: true
			});
			var send_idx_array = new Array();
			$("main .center .content .dropArea .dragElements .filebox").each(function(index){
				var get_id = $(this).attr("id");
				var idx = get_id.split("flexbox-");
				send_idx_array.push(idx[1]); 
			}); 
			$.get("/en/ajaxupload",{ idxes:send_idx_array },function(d){
				console.log(d);
			});
		}        
    });

    $(".fancyBox").fancybox({
		'overlayShow'	: false,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic'
	});

    $('.makeFileDragable2').click(function(e) { 
    	e.stopPropagation();
		e.preventDefault();
		var status = $("#dragText2",this).html();   
		if(status=="Start sorting"){
			$(".makeFileDragable2").attr("style","background-color:red");
			$("#dragText2",this).html("Stop sorting");
			$("main .center .content .dropArea2 .dragElements2").sortable({
				 disabled: false
			});
		}else if(status=="Stop sorting"){
			$(".makeFileDragable2").attr("style","background-color:green");
			$("#dragText2",this).html("Start sorting");
			$("main .center .content .dropArea2 .dragElements2").sortable({
		   		 disabled: true
			});
			var send_idx_array = new Array();
			$("main .center .content .dropArea2 .dragElements2 .filebox2").each(function(index){
				var get_id = $(this).attr("id");
				var idx = get_id.split("flexbox2-");
				send_idx_array.push(idx[1]); 
			}); 
			$.get("/en/ajaxupload",{ idxes_photos:send_idx_array },function(d){
				console.log(d);
			});
		}        
    });
	</script>
</body>
</html>