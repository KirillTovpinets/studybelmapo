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

	$valueObj = $mysqli->query("SELECT * FROM arrivals WHERE id = $arrivalId");
	$valueArr = $valueObj->fetch_assoc();
	$jsonValue = json_encode($valueArr);

	$today = date("Y-m-d H:i:s");
	$mysqli->query("INSERT INTO `trash`(`tablename`, `value`, `userId`, `date`) VALUES ('arrivals', '$jsonValue', '$userId', '$today')");
	$mysqli->query("DELETE FROM arrivals WHERE id = $arrivalId");
	
	mysqli_close($mysqli);
	echo "Приезд успешно удалён";
?>