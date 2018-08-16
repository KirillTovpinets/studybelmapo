<?php 
	// ini_set("display_errors", 1);
	require_once("config.php");

	function getSqlObj($tableName, $mysqli){
		switch ($tableName) {
			case 'cources_zip':
				$result = $mysqli->query("SELECT *, concat('№-',Number, ' - ', year, ' год' ) AS value FROM $tableName ORDER BY year DESC") or die ("Error: " . mysqli_error($mysqli));
				break;
			case 'personal_organizations':
				$result = $mysqli->query("SELECT personal_organizations.id, concat(personal_organizations.name, ' (', personal_organizations.short_name, ' ', cities.name , ')' ) AS value FROM $tableName INNER JOIN cities ON $tableName.location_city = cities.id ORDER BY personal_organizations.name ASC") or die ("Error: " . mysqli_error($mysqli));
				break;
			default:
				$result = $mysqli->query("SELECT *, name AS value FROM $tableName ORDER BY value ASC") or die ("Error: " . mysqli_error($mysqli));
				break;
		}
		return $result;
	}
	function getArray($SqlObj){
		$newArray = array();
		while ($row = $SqlObj->fetch_assoc()) {
			if (isset($row["Id"]) && $row["Id"] == 0) {
				continue;
			}
			if (isset($row["id"]) && $row["id"] == 0) {
				continue;
			}
			array_push($newArray, $row);
		}
		return $newArray;
	}

	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");

	if(isset($_GET["fields"])){
		$fields = explode(";", $_GET["fields"]);
		$response = array();
		for($i = 0; $i < count($fields); $i++){
			if(file_exists("./cash/" . $fields[$i] . ".txt")){
				$cash = file_get_contents("./cash/" . $fields[$i] . ".txt");
				$response[$fields[$i]] = json_decode($cash);
			}else{
				$obj = getSqlObj($fields[$i], $mysqli);
				$response[$fields[$i]] = getArray($obj);
				file_put_contents("./cash/" . $fields[$i] . ".txt", json_encode( $response[$fields[$i]] ) );
			}
		}
		echo json_encode($response);
		return;
	}
?>