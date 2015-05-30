<?php
define("DIR", __FILE__);
@include('../../config.php');
@include('../../functions/connection.php');
$connection = new connection();
$conn = $connection->conn($c);
if(!isset($_GET['u']) || empty($_GET['u']) || !is_numeric($_GET['u'])){ die("Error"); }
try{
$sql = 'SELECT `individualemail`,`subject`,`message` FROM `studio404_newsletter` WHERE `type`=:type AND `uid`=:uid';
$prepare = $conn->prepare($sql);
$prepare->execute(array(
":type"=>'send', 
":uid"=>$_GET['u']
));
$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
}catch(Exception $e){
die($e);
}
if(!$fetch['subject']){ die('Error'); }
if(!empty($fetch['individualemail'])){ $to = $fetch['individualemail']; }else{ $to = (isset($_GET['e'])) ? $_GET['e'] : "group"; }
?>
<html>
<head>
<meta charset="utf-8">
<title>Newsletter</title>
<style type="text/css">
@font-face {
font-family:'roboto'; 
src: url('<?=$c["site.url"]?>_plugins/roboto/Roboto-Regular.eot?#iefix') format('embedded-opentype'),  
url('<?=$c["site.url"]?>_plugins/roboto/Roboto-Regular.woff') format('woff'), 
url('<?=$c["site.url"]?>_plugins/roboto/Roboto-Regular.ttf')  format('truetype'), 
url('<?=$c["site.url"]?>_plugins/roboto/Roboto-Regular.svg#Roboto-Regular') format('svg');
font-weight: normal;
font-style: normal;
} 
</style>
</head>
<body style="margin: 0; padding: 0; border: 0; font-family:'roboto';">
<div class="toplink" style="margin: 10px 0 10px 10px; padding: 0; width: 715px; float:left; text-align: right; line-height: 14px; font-size: 12px;">Can’t you see mail properly? <a href="<?=$c["site.url"]?>_plugins/newsletter/index.php?u=<?=$_GET['u']?>&e=<?=$_GET['e']?>&r=<?=$_GET['r']?>&t=<?=$_GET['t']?>">Click here»</a></div>
<div style="margin: 0; padding: 0; border: 0; width: 725px; float:left; background-image: url('<?=$c["site.url"]?>_plugins/newsletter/bg.png'); background-repeat: no-repeat; background-position: center center; background-size: cover;">
<div class="header" style="margin: 10px; padding: 10px 0; border: 0; width: 705px; float:left; height: 153px; background-image: url('<?=$c["site.url"]?>_plugins/newsletter/header.png'); background-repeat: no-repeat; background-position: left; background-size: 488px 153px; float:left; "></div>
<div class="title" style="margin: 0 10px; padding: 0; border: 0; width: 705px; float:left; line-height: 55px; font-size: 45px; color: #214199;"><?=html_entity_decode($fetch['subject'])?></div>
<div class="line" style="margin: 5px 10px; padding: 0; border: 0; width: 705px; float:left; height: 6px; background-image: url('<?=$c["site.url"]?>_plugins/newsletter/line.png'); background-repeat: repeat-x; background-position: center center; background-size: 705px 6px;"></div>
<div class="content" style="margin: 10px; padding: 0; border: 0; width: 705px; float:left; font-size:16px">
<?=html_entity_decode($fetch['message'])?>
</div>
<div class="footer" style="margin: 0 10px; padding: 10px 0; border: 0; width: 705px; float:left; background-color: #14a5fc;">
<p style="margin: 0; padding: 0; border: 0; width: 705px; color: #ffffff; text-align: center; line-height: 18px; font-size: 16px; color: #ffffff; ">Enterpreneurship  Development Agency  E-newsletter <p>
<p style="margin: 0; padding: 0; border: 0; width: 705px; color: #ffffff; text-align: center; line-height: 18px; font-size: 16px; color: #ffffff; ">contact us:Tbilisi Office: D.Uznadze strey N2, 0179, Tbilisi, georgia</p>
<p style="margin: 0; padding: 0; border: 0; width: 705px; color: #ffffff; text-align: center; line-height: 18px; font-size: 16px; color: #ffffff; ">Tel: <a href="tel:%2B995%20322339893" value="+995322339893" target="_blank" style="color:#fff; text-decoration:none">+995 322339893</a><p>
<p style="margin: 0; padding: 0; border: 0; width: 705px; color: #ffffff; text-align: center; line-height: 18px; font-size: 16px; color: #ffffff; ">E-mail: <a href="mailto:info@enterprise.ge" target="_blank" style="color:#ffffff; text-decoration:none">info@enterprise.ge</a></p>
<p style="margin: 0; padding: 0; border: 0; width: 705px; color: #ffffff; text-align: center; line-height: 18px; font-size: 16px; color: #ffffff; "><a href="http://www.eda.gov.ge" target="_blank" style="color:#ffffff; text-decoration:none">www.eda.gov.ge</a></p>
</div>
<div class="footerLinks" style="margin: 10px; padding: 0; border: 0; width: 705px; float:left; text-align: center;">
<p style="margin: 0; padding: 0; line-height: 14px; font-size: 12px; color: #ffffff;"><a href="" style="margin: 0; padding: 0 5px; border: 0; background: #13a5fc; color: #ffffff; text-decoration:none">This message was sent to <?=$to?></a></p>
<p style="margin: 0; padding: 0; line-height: 14px; font-size: 12px; color: #ffffff;">
	<a href="<?=$c["site.url"]?>unsubscribe/<?=$_GET['r']?>" style="margin: 0; padding: 0 5px; border: 0; background: #13a5fc; color: #ffffff; text-decoration:none">Unsubscribe</a>
	<!-- <a href="javascript:void(0)" style="margin: 0; padding: 0 5px; border: 0; background: #13a5fc; color: #ffffff; text-decoration:none">  |  </a> -->
	<!-- <a href="" style="margin: 0; padding: 0 5px; border: 0; background: #13a5fc; color: #ffffff; text-decoration:none">Forward To a Friend</a></p> -->
</div><div class="br" style="margin: 0; padding: 0; border: 0; width: 100%; height: 10px;"></div>
</div>

</body>
</html>