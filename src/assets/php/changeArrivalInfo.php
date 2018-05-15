<?php 
	ini_set("display_errors", 1);
	require_once("config.php");

	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die("Ошибка подклчюения: " . mysqli_connect_error());
    $mysqli->query("SET NAMES utf8");
    
    $data = json_decode(file_get_contents("php://input"));
	$arrivalId = $data->arrival->arrivalId;
	$field = $data->params->field;
    $value = $data->params->value;

	$query = "UPDATE arrivals SET $field = $value WHERE id = $arrivalId";
	$mysqli->query($query) or die ("Ошибка выполнения запроса $query: " . mysqli_error($mysqli));
	mysqli_close($mysqli);
    echo "success";
?>