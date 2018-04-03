<?php 
	require_once "config.php";

	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения к базе данных: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	$value = $_GET["sirname"];

	function cleanFields($value){
		return strip_tags($value);
	}

	extract(array_map('cleanFields', $_GET));

	$paramsCondition = "";
	if(isset($isMale)){
		$paramsCondition .= " AND isMale = $isMale";
	}
	if(isset($min)){
		$paramsCondition .= " AND (YEAR(CURDATE()) - YEAR(personal_card.birthday)) >= $min AND (YEAR(CURDATE()) - YEAR(personal_card.birthday)) <= $max";
	}
	if(isset($personal_card) && $personal_card == "1"){
		$query = "SELECT * FROM (SELECT personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, concat(personal_card.surname, ' ', personal_card.name, ' ', personal_card.patername) AS full_name, personal_card.birthday FROM personal_card LEFT JOIN arrivals ON personal_card.id = arrivals.PersonId WHERE concat(personal_card.surname, ' ', personal_card.name, ' ', personal_card.patername) LIKE '$value%' AND arrivals.PersonId IS NULL LIMIT 50) AS sub ORDER BY full_name ASC";
	}else{
		$query = "SELECT * FROM (SELECT personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, concat(personal_card.surname, ' ', personal_card.name, ' ', personal_card.patername) AS full_name, personal_card.birthday FROM personal_card WHERE concat(personal_card.surname, ' ', personal_card.name, ' ', personal_card.patername) LIKE '$value%' $paramsCondition LIMIT 50) AS sub ORDER BY sub.full_name ASC";
	}
	$result = $mysqli->query($query) or die ("Ошибка запроса: " . mysqli_error($mysqli));

	$response = array();

	while ($row = $result->fetch_assoc()) {
		$name = $row["name"];
		$surname = $row["surname"];
		$patername = $row["patername"];
		$full_name = $surname . " " . $name . " " . $patername;
		if (stristr($full_name, $value)) {
			array_push($response, $row);
		}
	}
	mysqli_close($mysqli);
	echo json_encode($response);
?>