<?php 
	ini_set("display_errors", 1);
	require_once("config.php");
	
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения к базе " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	$personId = $_GET["id"];

	function getArrivas($id, $table, $mysqli){
		$query = "SELECT $table.Date, cathedras.name AS cathedra, faculties.name AS faculty, cources_zip.name AS course, $table.GroupNum, educType.name AS educType, status.name AS status FROM $table INNER JOIN cathedras ON $table.CathedrId = cathedras.id INNER JOIN faculties ON $table.FacultId = faculties.id INNER JOIN cources_zip ON $table.CourseId = cources_zip.id INNER JOIN educType ON $table.EducType = educType.id INNER JOIN status ON $table.Status = status.id WHERE $table.PersonId = $id";
		$result = $mysqli->query($query) or die ("Ошибка в запросе '$query': " . mysqli_error($mysqli));
		
		return $result;	
	}
	// $personObj = $mysqli->query("SELECT unique_Id FROM personal_card WHERE id = $personId");
	// $personArr = $personObj->fetch_assoc();

	$response = array();
	$currentArrivalsObj = getArrivas($personId, "arrivals_zip", $mysqli);

	while ($row = $currentArrivalsObj->fetch_assoc()) {
		array_push($response, $row);
	}
	$oldArrivalsObj = getArrivas($personId, "arrivals", $mysqli);

	while ($row = $oldArrivalsObj->fetch_assoc()) {
		array_push($response, $row);
	}
	mysqli_close($mysqli);
	echo json_encode($response);
 ?>