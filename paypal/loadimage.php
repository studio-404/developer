<html>
<head>
	<title>loadimage</title>
	<style type="text/css">
	.box{ margin: 0; padding: 0; width: 100%; height: 600px; text-align: center; }
	.box .loader{ width:100%; height:600px; }
	.box img{ display: none; width:100%; height:600px; }
	</style>
	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
</head>
<body>
<div class="box">
	<div class="loader">Please wait</div>
	<img src="http://egyptbiotech.com/wp-content/uploads/2015/03/shopping-online.jpg" width="100%" height="600" id="main_img" />
</div>


<script type="text/javascript">
$('#main_img').on('load', function(){
	$('.box .loader').fadeOut("slow",function(){
		$('#main_img').fadeIn("slow");
	});
});
	</script>
</body>
</html>