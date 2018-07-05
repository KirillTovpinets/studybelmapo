<?php 
	ini_set("display_errors", 1);
	require_once("config.php");
	require_once("rb.php");
	session_start();


	$logedUser = $_SESSION["loged_user"];
	$userId = $logedUser->id;

	$data = json_decode(file_get_contents("php://input"));
	$arrivalId = $data->arrivalId;

	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die("Ошибка подклчюения: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");

	$mysqli->query("UPDATE arrivals SET `Status` = 2 WHERE id = $arrivalId");
	
	mysqli_close($mysqli);
	echo "Слушатель успешно зачислен";
?>