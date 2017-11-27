<?php 
	ini_set("display_errors", 1);
	require_once("config.php");
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подклчюения: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	$data = json_decode(file_get_contents("php://input"));
	$limit = $data->limit;
	$offset = $data->offset;
	$query = "";
	switch ($data->info) {
		case 'age':{
			$max = $data->params->max;
			$min = $data->params->min;
			$query = "SELECT arrivals.Date, personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, personal_card.birthday FROM personal_card INNER JOIN arrivals ON personal_card.unique_Id = arrivals.PersonLink WHERE (YEAR(CURDATE()) - YEAR(personal_card.birthday)) >= $min AND (YEAR(CURDATE()) - YEAR(personal_card.birthday)) <= $max LIMIT $limit OFFSET $offset";
			break;
		}
		case 'gender':{
			$isMale = $data->params->isMale;
			$query = "SELECT arrivals.Date, personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, personal_card.birthday FROM personal_card INNER JOIN arrivals ON personal_card.unique_Id = arrivals.PersonLink WHERE personal_card.isMale = $isMale LIMIT $limit OFFSET $offset";
			break;
		}
		case 'sirname':{
			$query = "SELECT arrivals.Date, personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, personal_card.birthday FROM personal_card INNER JOIN arrivals ON personal_card.unique_Id = arrivals.PersonLink LIMIT $limit OFFSET $offset";
			break;
		}
		case "establishment":{
			$query = ""
		}
	}
	
	$result = $mysqli->query($query) or die ("Ошибка запроса '$query': " . mysqli_error($mysqli));
	$personsArr = array();

	while ($row = $result->fetch_assoc()) {
		array_push($personsArr, $row);
	}
	mysqli_close($mysqli);
	echo json_encode($personsArr);
?>