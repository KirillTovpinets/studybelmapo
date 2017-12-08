<?php 
	ini_set("display_errors", 1);
	require_once("rb.php");
	require_once("config.php");
	session_start();

	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");

	$data = json_decode(file_get_contents("php://input"));
	$isDoctor = $data->isDoctor == true ? 1 : 0;
	$isCowoker = $data->isCowoker == true ? 1 : 0;
	$isMale = $data->isMale == true ? 1 : 0;
	$mysqli->query("INSERT INTO personal_card (surname, name, patername, birthday, ee, citizenship, diploma_start, appointment, isDoctor, tel_number, organization, region, isMale, isCowoker, experience_general, experiance_special, insurance_number, department, faculty, name_in_to_form, diploma_number) VALUES ('$data->surname', '$data->name', '$data->patername', '$data->birthday', '$data->educational_establishment', '$data->cityzenship', '$data->diploma_start', '$data->appointment', '$isDoctor', '$data->tel_number', '$data->organization', '$data->region', '$isMale', '$isCowoker', '$data->experiance_general', '$data->experiance_special', '$data->insurance_number', '$data->department', '$data->faculty', '$data->nameInDativeForm', '$data->diploma_number')") or die ("Ошибка: " . mysqli_error($mysqli));
	
	
	$date = date("Y-m-d");

	$Loged_user = $_SESSION["loged_user"];
	$cathedraLoged = false;
	$departmentLoged = false;
	$cathedraId = $Loged_user->dep_id;

	$cathedraObj = $mysqli->query("SELECT * FROM cathedras WHERE id = $cathedraId") or die ("Ошибка запроса 'SELECT * FROM cathedra WHERE id = $cathedraId': " . mysqli_error($mysqli));
	$newPersonIdObj = $mysqli->query("SELECT MAX(id) AS newPersonId FROM personal_card");
	$newPersonIdArr = $newPersonIdObj->fetch_assoc();
	$newPersonId = $newPersonIdArr["newPersonId"];
	$cathedraArr = $cathedraObj->fetch_assoc();
	$faculty = $cathedraArr["facultId"];
	$mysqli->query("INSERT INTO arrivals (date, FacultId, CathedrId, CourseId, GroupNum, EducType, ResidPlace, FormEduc, Dic_count, Status, PersonId) VALUES ('$date', '$faculty', '$cathedraId', '$data->belmapo_course', '$data->belmapo_course', '$data->belmapo_educType', '$data->belmapo_residense', '$data->belmapo_educForm', '$data->belmapo_paymentData', '0', '$newPersonId')") or die ("Ошибка: " . mysqli_error($mysqli));

	mysqli_close($mysqli);
	echo "Слушатель зачислен";
?>