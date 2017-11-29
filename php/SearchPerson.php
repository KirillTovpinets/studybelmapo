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
	$query = "SELECT arrivals.Date, personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, personal_card.birthday FROM personal_card INNER JOIN arrivals ON personal_card.unique_Id = arrivals.PersonLink WHERE personal_card.surname LIKE '$value%' $paramsCondition LIMIT 50";
	$result = $mysqli->query($query) or die ("Ошибка запроса: " . mysqli_error($mysqli));

	$response = array();

	while ($row = $result->fetch_assoc()) {
		array_push($response, $row);
	}

	mysqli_close($mysqli);
	echo json_encode($response);
?>