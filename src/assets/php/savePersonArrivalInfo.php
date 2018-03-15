<?php 
	ini_set("display_errors", 1);
	require_once("config.php");
	require_once("rb.php");
	session_start();

	$logedUser = $_SESSION["loged_user"];
	$logedUserId = $logedUser["id"];
	$data = json_decode(file_get_contents("php://input"));
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	$docNumber = $data->DocNumber;
	$arrivalId = $data->arrivalId;
	
	$query = "UPDATE arrivals SET DocNumber='$docNumber' WHERE id = $arrivalId";
	$mysqli->query($query) or die ("Error in '$query': " . mysqli_error($mysqli));
	mysqli_close($mysqli);
	echo "Изменения успешно внесены";
?>