<?php 
	require_once "config.php";

	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения к базе данных: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	extract(array_map('cleanFields', $_GET));

	function cleanFields($value){
		return strip_tags($value);
	}

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

	function getInitialData($table, $field, $mysqli, $params){
		$query = "SELECT * FROM $table WHERE name LIKE '$name'";
		$result = $mysqli->query($query) or die ("Ошибка запроса '$query': " . mysqli_error($mysqli));
		$data = getList($mysqli, $result, $field);
		return $data;
	}

	function getCrossTableData($table, $field, $mysqli){
		$data = getInitialData($table, $field, $mysqli);
		mysqli_close($mysqli);
		exit(json_encode($data));
	}

	switch ($parameter) {
		case 'establishment':{
			$table = "personal_establishment";
			$field = "ee";
			getCrossTableData($table, $field, $mysqli);
			break;
		}
		case 'job':{
			$table = "personal_organizations";
			$field = "organization";
			getCrossTableData($table, $field, $mysqli);
			break;
		}
		
		default:
			# code...
			break;
	}
?>