<?php 
	ini_set("display_errors", 1);
	require_once("config.php");
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подклчюения: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	$data = json_decode(file_get_contents("php://input"));
	$id = $data->personal->_insurance_number;
	$result = $mysqli->query("SELECT personal_card.surname, personal_card.name, personal_card.patername, personal_private_info.insurance_number FROM personal_private_info INNER JOIN personal_card ON personal_private_info.PersonId = personal_card.id WHERE personal_private_info.insurance_number LIKE '$id'") or die ("Error: " . mysqli_error($mysqli));
	mysqli_close($mysqli);
	if ($result->{"num_rows"} > 0) {
		echo json_encode($result->fetch_assoc());
	}else{
		echo json_encode(array());
	}
?>