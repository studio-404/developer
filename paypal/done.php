<html>
<head>
	<meta charset="utf-8">
	<title>Paypal</title>
</head>
<body>
<?php
require 'Paypal_IPN.php';
$paypal = new Paypal_IPN('live'); 
$paypal->run(); 
?>
</body>
</html>