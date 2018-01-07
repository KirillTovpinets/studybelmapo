<?php 
	ini_set("display_errors", 1);
	require_once("config.php");
	
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения к базе " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	$personId = $_GET["id"];

	$personObj = $mysqli->query("SELECT unique_Id FROM personal_card WHERE id = $personId");
	$personArr = $personObj->fetch_assoc();
	$key = $personArr["unique_Id"];
	$query = "SELECT certificates.DateGet, cathedras.name AS cathedra, faculties.name AS faculty, cources_zip.name AS course, cources_zip.Number AS courseNumber, certificates.DocNumber, educType.name AS educType, marks.name AS mark FROM certificates INNER JOIN cathedras ON certificates.Cathedra = cathedras.id INNER JOIN faculties ON certificates.Faculty = faculties.id INNER JOIN cources_zip ON certificates.CourseId = cources_zip.id INNER JOIN educType ON certificates.EducType = educType.id INNER JOIN marks ON certificates.MarkId = marks.id WHERE certificates.PersonCardLink LIKE '$key'";
	$result = $mysqli->query($query) or die ("Ошибка в запросе '$query': " . mysqli_error($mysqli));

	$response = array();
	while ($row = $result->fetch_assoc()) {
		array_push($response, $row);
	}
	mysqli_close($mysqli);
	echo json_encode($response);
 ?>