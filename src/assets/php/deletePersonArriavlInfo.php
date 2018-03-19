<?php 
	ini_set("display_errors", 1);
	require_once("config.php");
	$data = json_decode(file_get_contents("php://input"));
	$arrivalId = $data->arrivalId;

	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die("Ошибка подклчюения: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");

	$mysqli->query("DELETE FROM arrivals WHERE id = $arrivalId");
	mysqli_close($mysqli);
	echo "Приезд успешно удалён";
?>