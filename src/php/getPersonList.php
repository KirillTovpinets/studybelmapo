<?php 
	ini_set("display_errors", 1);
	require_once("config.php");
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подклчюения: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	$data = json_decode(file_get_contents("php://input"));
	$limit = $data->limit;
	$offset = $data->offset;
	$query = "";
	$condition = "";
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
	function getCrossTableData($table, $field, $mysqli, $data){
		$data = getInitialData($table, $field, $mysqli, $data);
		mysqli_close($mysqli);
		exit(json_encode($data));
	}
	function getInitialData($table, $field, $mysqli, $data){
		$limit = $data->limit;
		$offset = $data->offset;
		$condition = "";
		$limitation = "";
		if (isset($data->params->name)) {
			$value = $data->params->name;
			$condition .= "WHERE name LIKE '$value%'";
		}
		if ($limit !== 0 || $offset !== 0) {
			 $limitation = "LIMIT $limit OFFSET $offset";
		}
		$query = "SELECT * FROM $table $condition ORDER BY name ASC $limitation";
		$result = $mysqli->query($query) or die ("Ошибка запроса '$query': " . mysqli_error($mysqli));
		$data = getList($mysqli, $result, $field);
		return $data;
	}
	function getMultipleTablesData($tables, $mysqli, $data){
		$response = array();
		for ($i=0; $i < count($tables); $i++) { 
			$table = $tables[$i];
			$field = $table;
			$data = getInitialData($table, $field, $mysqli, $data);
			$response[$tables[$i]] = $data;
		}
		mysqli_close($mysqli);
		exit(json_encode($response));
	}
	switch ($data->info) {
		case 'age':{
			$max = $data->params->max;
			$min = $data->params->min;
			$condition = "WHERE (YEAR(CURDATE()) - YEAR(personal_card.birthday)) >= $min AND (YEAR(CURDATE()) - YEAR(personal_card.birthday)) <= $max";
			break;
		}
		case 'gender':{
			$isMale = $data->params->isMale;
			$condition = "WHERE personal_card.isMale = $isMale";
			break;
		}
		case "establishment":{
			$table = "personal_establishment";
			$field = "ee";
			getCrossTableData($table, $field, $mysqli, $data);
		}
		case "job":{
			$table = "personal_organizations";
			$field = "organization";
			getCrossTableData($table, $field, $mysqli, $data);
		}
		case "appointment":{
			$table = "personal_appointment";
			$field = "appointment";
			getCrossTableData($table, $field, $mysqli, $data);
		}
		case "speciality":{
			$tables = ["speciality_doct", "speciality_retraining", "speciality_other"];
			getMultipleTablesData($tables, $mysqli, $data);
		}
		case "qualification":{
			$tables = ["qualification_main", "qualification_add", "qualification_other"];
			getMultipleTablesData($tables, $mysqli, $data);	
		}

	}
	
	$query = "SELECT arrivals.Date, personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, personal_card.birthday FROM personal_card INNER JOIN arrivals ON personal_card.id = arrivals.PersonId $condition LIMIT $limit OFFSET $offset";
	$result = $mysqli->query($query) or die ("Ошибка запроса '$query': " . mysqli_error($mysqli));
	$personsArr = array();

	while ($row = $result->fetch_assoc()) {
		array_push($personsArr, $row);
	}
	mysqli_close($mysqli);
	echo json_encode($personsArr);
?>