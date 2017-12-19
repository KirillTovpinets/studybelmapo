<?php 
	require_once("rb.php");
	require_once("config.php");
	session_start();
	$logedUser = $_SESSION["loged_user"];
	$userId = $logedUser->id;
	R::setup("mysql:host=$host;dbname=$dbname", $user, $passwd);
	$logedInfo = R:findOne("login_users", "userId = ?", array($userId));
	R::trash($logedInfo);
    unset($_SESSION["loged_user"]);
    $_SESSION["loged_user"] = NULL;
	session_destroy();
 ?>