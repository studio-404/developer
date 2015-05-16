<?php
session_start();
$name = "images/s.png";
$im = imagecreatefrompng($name);

$im = imagecreate(100, 40);
$string = $_SESSION['encoded'];
$bg = imagecolorallocate($im, 57, 155, 255);
$red = imagecolorallocate($im, 255, 255, 255);
imagestring($im, 25, 25, 10, $string, $red);
$filename = sha1("_".time()).".png";
$name = "thumbs/".$filename;
imagepng($im,$name,7);
$dir    = 'thumbs/';
$files = scandir($dir);
foreach($files as $file)
{
	if($file!="." && $file!=".." && $file!=$filename)
	{
		$cerationTime = @filemtime($file);
		$now = time() - 30;
		if($cerationTime<$now)
		{
			unlink($dir.$file);
		}
	}
}
header("location: " . $name);
?>