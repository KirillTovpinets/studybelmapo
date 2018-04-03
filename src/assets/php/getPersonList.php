<?php 
	ini_set("display_errors", 1);
	require_once("rb.php");
	require_once("config.php");
	session_start();
	$logeduser = $_SESSION["loged_user"];
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подклчюения: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	$data = json_decode(file_get_contents("php://input"));
	$limit = $data->limit;
	$offset = $data->offset;
	$query = "";
	$condition = "";
	$connection = "";
	function getList($connection, $SqlObject, $field, $data, $logeduser){
		$Arr = array();
		$limit = $data->params->listLimit;
		$offset = $data->params->listOffset;
		while ($row = $SqlObject->fetch_assoc()) {
			$Id = $row["id"];
			$condition = "";
			// if ($logeduser->is_cathedra == 1) {
			// 	$condition = "AND cources.cathedraId = $logeduser->dep_id";
			// }
			$withArrival = "INNER JOIN arrivals ON personal_card.id = arrivals.PersonId";
			$withArrival = "";
			$PersonQuery = "SELECT personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, personal_card.birthday FROM personal_card $withArrival WHERE personal_card.$field = $Id $condition LIMIT $limit OFFSET $offset";
			$PersonResult = $connection->query($PersonQuery) or die ("Ошибка выполнения запроса '$PersonQuery': " . mysqli_error($connection));
			$resultArray = array();
			if ($PersonResult->{"num_rows"} == 0) {
				continue;
			}
			while ($PersonRow = $PersonResult->fetch_assoc()) {
				array_push($resultArray, $PersonRow);
			}

			$currentPersonQuery = "SELECT personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, personal_card.birthday, arrivals.Status FROM personal_card INNER JOIN arrivals ON personal_card.id = arrivals.PersonId WHERE personal_card.$field = $Id $condition LIMIT $limit OFFSET $offset";
			$currentPersonResult = $connection->query($currentPersonQuery) or die ("Ошибка выполнения запроса '$PersonQuery': " . mysqli_error($connection));
			$currentresultArray = array();
			if ($currentPersonResult->{"num_rows"} == 0) {
				continue;
			}
			while ($PersonRow = $currentPersonResult->fetch_assoc()) {
				array_push($currentresultArray, $PersonRow);
			}

			$row["List"] = $resultArray;
			$row["CurrentList"] = $currentresultArray;

			$CountQuery = "SELECT COUNT(*) AS total FROM  personal_card WHERE personal_card.$field = $Id";
			$CountResult = $connection->query($CountQuery) or die ("Ошибка выполнения запроса '$CountQuery': " . mysqli_error($connection));
			$CountArray = $CountResult->fetch_assoc();

			$CurrentCountQuery = "SELECT COUNT(*) AS total FROM  personal_card INNER JOIN arrivals ON personal_card.id = arrivals.PersonId WHERE personal_card.$field = $Id";
			$CurrentCountResult = $connection->query($CurrentCountQuery) or die ("Ошибка выполнения запроса '$CountQuery': " . mysqli_error($connection));
			$CurrentCountArray = $CurrentCountResult->fetch_assoc();

			$row["CurrentTotal"] = $CurrentCountArray["total"];

			array_push($Arr, $row);
		}
		return $Arr;
	}
	function getCrossTableData($table, $field, $mysqli, $data, $logeduser){
		$data = getInitialData($table, $field, $mysqli, $data, $logeduser);
		$response = array();
		$response["data"] = $data;
		mysqli_close($mysqli);
		exit(json_encode($response));
	}
	function getInitialData($table, $field, $mysqli, $data, $logeduser){
		$limit = $data->limit;
		$offset = $data->offset;
		$condition = "";
		$limitation = "";
		if (isset($data->params->name)) {
			$value = $data->params->name;
			$condition .= "WHERE name LIKE '$value%'";
		}else if (isset($data->params->estId)) {
			$id = $data->params->estId;
			$condition .= "WHERE id = $id";
		}
		if($limit !== 0 || $offset !== 0){
			$limitation = "LIMIT $limit OFFSET $offset";
		}
		$query = "SELECT * FROM $table $condition ORDER BY name ASC $limitation";
		$result = $mysqli->query($query) or die ("Ошибка запроса '$query': " . mysqli_error($mysqli));
		$data = getList($mysqli, $result, $field, $data, $logeduser);
		return $data;
	}
	function getMultipleTablesData($tables, $mysqli, $data){
		$response = array();
		for ($i=0; $i < count($tables); $i++) { 
			$table = $tables[$i];
			$field = $table;
			$data = getInitialData($table, $field, $mysqli, $data, $logeduser);
			$response[$tables[$i]] = $data;
		}
		mysqli_close($mysqli);
		exit(json_encode($response));
	}
	switch ($data->info) {
		case "sirname":{
			$withArrival = "INNER JOIN arrivals ON personal_card.id = arrivals.PersonId";
			$query = "SELECT personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, personal_card.birthday FROM personal_card $condition LIMIT $limit OFFSET $offset";
			$currentQuery = "SELECT personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, personal_card.birthday, arrivals.Status FROM personal_card $withArrival $condition AND arrivals.Status != 3 LIMIT $limit OFFSET $offset";
			break;
		}
		case "all":{
			$query = "SELECT personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, concat(personal_card.surname, personal_card.name, personal_card.patername) AS fullname, personal_card.birthday FROM personal_card LEFT JOIN arrivals ON personal_card.id = arrivals.PersonId WHERE arrivals.id IS NULL ORDER BY fullname LIMIT $limit OFFSET $offset";
			break;
		}
		case 'age':{
			$max = $data->params->max;
			$min = $data->params->min;
			$connection = "INNER JOIN personal_private_info ON personal_private_info.PersonId = personal_card.id";
			$condition = "WHERE (YEAR(CURDATE()) - YEAR(personal_private_info.birthday)) >= $min AND (YEAR(CURDATE()) - YEAR(personal_private_info.birthday)) <= $max";
			$withArrival = "INNER JOIN arrivals ON personal_card.id = arrivals.PersonId";
			$withArrival = "";
			$query = "SELECT personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, personal_card.birthday FROM personal_card $connection $withArrival $condition LIMIT $limit OFFSET $offset";
			$currentQuery = "SELECT personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, personal_card.birthday, arrivals.Status FROM personal_card $connection INNER JOIN arrivals ON personal_card.id = arrivals.PersonId $condition AND arrivals.Status != 3 LIMIT $limit OFFSET $offset";
			break;
		}
		case 'gender':{
			$isMale = $data->params->isMale;
			$connection = "INNER JOIN personal_private_info ON personal_private_info.PersonId = personal_card.id";
			$condition = "WHERE personal_private_info.isMale = $isMale";
			$withArrival = "INNER JOIN arrivals ON personal_card.id = arrivals.PersonId";
			$query = "SELECT personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, personal_card.birthday FROM personal_card INNER JOIN personal_private_info ON personal_card.id = personal_private_info.PersonId $condition LIMIT $limit OFFSET $offset";
			$currentQuery = "SELECT personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, personal_card.birthday FROM personal_card $withArrival INNER JOIN personal_private_info ON personal_card.id = personal_private_info.PersonId $condition AND arrivals.Status != 3 LIMIT $limit OFFSET $offset";
			break;
		}
		case "establishment":{
			$table = "personal_establishment";
			$field = "ee";
			getCrossTableData($table, $field, $mysqli, $data, $logeduser);
		}
		case "job":{
			$table = "personal_organizations";
			$field = "organization";
			getCrossTableData($table, $field, $mysqli, $data, $logeduser);
		}
		case "appointment":{
			$table = "personal_appointment";
			$field = "appointment";
			getCrossTableData($table, $field, $mysqli, $data, $logeduser);
		}
		case "speciality" || "qualification":{
			$table = $data->params->table;
			$field = $table;
			getCrossTableData($table, $field, $mysqli, $data, $logeduser);
		}

	}
	
	$responseData = array();
	$result = $mysqli->query($query) or die ("Ошибка запроса '$query': " . mysqli_error($mysqli));
	if (isset($currentQuery)) {
		$CurrentResult = $mysqli->query($currentQuery) or die ("Ошибка запроса '$query': " . mysqli_error($mysqli));
		$CurrentPersonsArr = array();
		while ($row = $CurrentResult->fetch_assoc()) {
			array_push($CurrentPersonsArr, $row);
		}
		$responseData["current"] = $CurrentPersonsArr;

		$CurrentCountQuery = "SELECT COUNT(*) AS total FROM personal_card INNER JOIN arrivals ON personal_card.id = arrivals.PersonId $connection $condition AND arrivals.Status != 3";
		$CurrentCountResult = $mysqli->query($CurrentCountQuery) or die ("Ошибка выполнения запроса '$CountQuery': " . mysqli_error($mysqli));
		$CurrentCountArray = $CurrentCountResult->fetch_assoc();
		$responseData["CurrentTotal"] = $CurrentCountArray["total"];
	}
	$personsArr = array();
	
	while ($row = $result->fetch_assoc()) {
		array_push($personsArr, $row);
	}
	$responseData["data"] = $personsArr;

	$CountQuery = "SELECT COUNT(*) AS total FROM personal_card  $connection $condition";
	$CountResult = $mysqli->query($CountQuery) or die ("Ошибка выполнения запроса '$CountQuery': " . mysqli_error($mysqli));
	$CountArray = $CountResult->fetch_assoc();

	$responseData["Total"] = $CountArray["total"];
	mysqli_close($mysqli);
	echo json_encode($responseData);
?>