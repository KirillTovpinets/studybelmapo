<?php 
	ini_set("display_errors", 1);
	require_once("config.php");
	
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения к базе " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	$personId = $_GET["id"];

	$response = array();
	$query = "SELECT arrivals.Date, cathedras.name AS cathedra, faculties.name AS faculty, cources.name AS course, educType.name AS educType, status.name AS status FROM arrivals INNER JOIN cources ON arrivals.CourseId = cources.id INNER JOIN cathedras ON cources.cathedraId = cathedras.id INNER JOIN faculties ON cathedras.facultId = faculties.id  INNER JOIN educType ON cources.Type = educType.id INNER JOIN status ON arrivals.Status = status.id WHERE arrivals.PersonId = $personId";
	$currentArrivalsObj = $mysqli->query($query) or die ("Ошибка в запросе '$query': " . mysqli_error($mysqli));

	if ($currentArrivalsObj->{"num_rows"} > 0) {
		while ($row = $currentArrivalsObj->fetch_assoc()) {
			array_push($response, $row);
		}
	}

	$query = "SELECT arrivals_zip.Date, cathedras.name AS cathedra, faculties.name AS faculty, cources.name AS course, educType.name AS educType, status.name AS status FROM arrivals_zip INNER JOIN cources ON arrivals_zip.CourseId = cources.id INNER JOIN cathedras ON arrivals_zip.CathedrId = cathedras.id INNER JOIN faculties ON arrivals_zip.FacultId = faculties.id  INNER JOIN educType ON arrivals_zip.EducType = educType.id INNER JOIN status ON arrivals_zip.Status = status.id WHERE arrivals_zip.PersonId = $personId";
	$oldArrivalsObj = $mysqli->query($query) or die ("Ошибка в запросе '$query': " . mysqli_error($mysqli));

	if ($oldArrivalsObj->{"num_rows"} > 0) {
		while ($row = $oldArrivalsObj->fetch_assoc()) {
			array_push($response, $row);
		}
	}
	mysqli_close($mysqli);
	echo json_encode($response);
 ?>