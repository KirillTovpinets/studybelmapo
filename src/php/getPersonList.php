<?php 
	ini_set("display_errors", 1);
	require_once("config.php");
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подклчюения: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	$data = json_decode(file_get_contents("php://input"));
	$limit = $data->limit;
	$offset = $data->offset;
	$query = "";

	function getList($connection, $SqlObject, $field){
		$Arr = array();
		while ($row = $SqlObject->fetch_assoc()) {
			$Id = $row["id"];
			$PersonQuery = "SELECT arrivals.Date, personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, personal_card.birthday FROM personal_card INNER JOIN arrivals ON personal_card.id = arrivals.PersonId WHERE personal_card.$field = $Id";
			$PersonResult = $connection->query($PersonQuery) or die ("Ошибка выполнения запроса '$query': " . mysqli_error($connection));
			$resultArray = array();

			if ($PersonResult->{"num_rows"} == 0) {
				continue;
			}
			while ($PersonRow = $PersonResult->fetch_assoc()) {
				array_push($resultArray, $PersonRow);
			}

			$row["List"] = $resultArray;
			$row["Total"] = $PersonResult->{"num_rows"};

			array_push($Arr, $row);
		}
		return $Arr;
	}
	switch ($data->info) {
		case 'age':{
			$max = $data->params->max;
			$min = $data->params->min;
			$query = "SELECT arrivals.Date, personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, personal_card.birthday FROM personal_card INNER JOIN arrivals ON personal_card.id = arrivals.PersonId WHERE (YEAR(CURDATE()) - YEAR(personal_card.birthday)) >= $min AND (YEAR(CURDATE()) - YEAR(personal_card.birthday)) <= $max LIMIT $limit OFFSET $offset";
			break;
		}
		case 'gender':{
			$isMale = $data->params->isMale;
			$query = "SELECT arrivals.Date, personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, personal_card.birthday FROM personal_card INNER JOIN arrivals ON personal_card.id = arrivals.PersonId WHERE personal_card.isMale = $isMale LIMIT $limit OFFSET $offset";
			break;
		}
		case 'sirname':{
			$query = "SELECT arrivals.Date, personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, personal_card.birthday FROM personal_card INNER JOIN arrivals ON personal_card.id = arrivals.PersonId LIMIT $limit OFFSET $offset";
			break;
		}
		case "establishment":{
			$query = "SELECT * FROM personal_establishment ORDER BY name ASC LIMIT $limit OFFSET $offset";
			$result = $mysqli->query($query) or die ("Ошибка запроса '$query': " . mysqli_error($mysqli));

			$establArr = getList($mysqli, $result, "ee");
			mysqli_close($mysqli);
			exit(json_encode($establArr));
		}
		case "job":{
			$query = "SELECT * FROM personal_organizations ORDER BY name ASC LIMIT $limit OFFSET $offset";
			$result = $mysqli->query($query) or die ("Ошибка запроса '$query': " . mysqli_error($mysqli));

			$OrgArr = getList($mysqli, $result, "organization");
			mysqli_close($mysqli);
			exit(json_encode($OrgArr));
		}
		case "appointment":{
			$query = "SELECT * FROM personal_appointment ORDER BY name ASC LIMIT $limit OFFSET $offset";
			$result = $mysqli->query($query) or die ("Ошибка запроса '$query': " . mysqli_error($mysqli));

			$OrgArr = getList($mysqli, $result, "appointment");
			mysqli_close($mysqli);
			exit(json_encode($OrgArr));
		}
		case "speciality":{
			$response = array();
			$query = "SELECT * FROM speciality_doct ORDER BY name ASC LIMIT $limit OFFSET $offset";
			$result = $mysqli->query($query) or die ("Ошибка запроса '$query': " . mysqli_error($mysqli));

			$Doct = getList($mysqli, $result, "speciality_doct");
			$response["main"] = $Doct;

			$query = "SELECT * FROM speciality_retraining ORDER BY name ASC LIMIT $limit OFFSET $offset";
			$result = $mysqli->query($query) or die ("Ошибка запроса '$query': " . mysqli_error($mysqli));

			$Retr = getList($mysqli, $result, "speciality_retraining");
			$response["retraining"] = $Retr;

			$query = "SELECT * FROM speciality_other ORDER BY name ASC LIMIT $limit OFFSET $offset";
			$result = $mysqli->query($query) or die ("Ошибка запроса '$query': " . mysqli_error($mysqli));

			$Other = getList($mysqli, $result, "speciality_other");
			$response["other"] = $Other;
			mysqli_close($mysqli);
			exit(json_encode($response));
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