<?php
session_start();
if(isset($_GET["get_token"])){
	$_SESSION["token"] = md5(sha1(time()));
	echo $_SESSION["token"];
}
?>