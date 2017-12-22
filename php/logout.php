<?php 
	require_once("rb.php");
	require_once("config.php");
	session_start();
	$logedUser = $_SESSION["loged_user"];
	$userId = $logedUser->id;
	R::setup("mysql:host=$host;dbname=$dbname", $user, $passwd);
	$logedInfo = R::findOne("loginusers", "user_id = ?", array($userId));
	R::trash($logedInfo);
	print_r($logedInfo);
	session_destroy();
 ?>