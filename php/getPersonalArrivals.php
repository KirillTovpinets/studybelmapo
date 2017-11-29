<?php 
	ini_set("display_errors", 1);
	require_once("config.php");
	
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения к базе " . mysqli_connect_error());
	$personId = $_GET["id"];

	$personObj = $mysqli->query("SELECT unique_Id FROM personal_card WHERE id = $personId");
	$personArr = $personObj->fetch_assoc();
	$key = $personArr["unique_Id"];
	$query = "SELECT arrivals_zip.Date, cathedras.name, faculties.name, cources_zip.name, arrivals_zip.GroupNum, educType.name, status.name FROM arrivals_zip INNER JOIN cathedras ON arrivals_zip.CathedrId = cathedras.id INNER JOIN faculties ON arrivals_zip.FacultId = faculties.id INNER JOIN cources_zip ON arrivals_zip.CourseId = cources_zip.id INNER JOIN educType ON arrivals_zip.EducType = educType.id INNER JOIN status ON arrivals_zip.Status = status.id WHERE arrivals_zip.PersonLink LIKE '$key'";
	$result = $mysqli->query($query) or die ("Ошибка в запросе '$query': " . mysqli_error($mysqli));

	$response = array();
	while ($row = $result->fetch_assoc()) {
		array_push($resopnse, $row);
	}
	mysqli_close($mysqli);
	echo json_encode($response);
 ?>