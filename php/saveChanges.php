<?php 
	ini_set("display_errors", 1);
	require_once("config.php");
	require_once("rb.php");
	session_start();

	$logedUser = $_SESSION["loged_user"];
	$data = json_decode(file_get_contents("php://input"));
	$userId = $logedUser->id;
	print_r($data);
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die("Ошибка подклчюения: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	mysqli_close($mysqli);
?>