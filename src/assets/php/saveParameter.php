<?php 
	ini_set("display_errors", 1);

	require_once("config.php");

	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");

	$data = json_decode(file_get_contents("php://input"));
	$mysqli->query("INSERT INTO $data->table (name) VALUES ('$data->value');") or die ("Ошибка: " . mysqli_error($mysqli));

	$result = $mysqli->query("SELECT id, name AS value FROM $data->table WHERE name LIKE '$data->value'");
	$response = $result->fetch_assoc();

	mysqli_close($mysqli);
	echo json_encode($response);
?>