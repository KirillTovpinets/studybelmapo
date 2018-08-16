<?php 
	ini_set("display_errors", 1);

	require_once("config.php");

	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");

	$data = json_decode(file_get_contents("php://input"));
	if(is_object($data->value)){
		$name = $data->value->name;
		$sn = $data->value->short_name;
		$type = $data->value->form->id;
		$isP = $data->value->isPublic;
		$country = $data->value->country->id;
		$region = $data->value->region->id;
		$city = $data->value->city->id;
		$street = $data->value->street;
		$building = $data->value->building;
		$mysqli->query("INSERT INTO $data->table (name, form, short_name, location_cntr, location_city, location_street, location_building, location_region, isPublic) VALUES ('$name', '$type', '$sn', '$country', '$city', '$street', '$building', '$region', '$isP');") or die ("Ошибка: " . mysqli_error($mysqli));
		$result = $mysqli->query("SELECT id, name AS value FROM $data->table WHERE name LIKE '$name' AND location_cntr = $country");
	}else{
		$mysqli->query("INSERT INTO $data->table (name) VALUES ('$data->value');") or die ("Ошибка: " . mysqli_error($mysqli));
		$result = $mysqli->query("SELECT id, name AS value FROM $data->table WHERE name LIKE '$data->value'");
	}

	$response = $result->fetch_assoc();

	mysqli_close($mysqli);
	echo json_encode($response);
?>