<?php 
	ini_set("display_errors", 1);
	require_once("rb.php");
	require_once("config.php");
	session_start();

	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");

	$data = json_decode(file_get_contents("php://input"));
	$isDoctor = $data->_isDoctor == true ? 1 : 0;
	$isCowoker = $data->_organization->id == 4530 ? 1 : 0;
	$isMale = $data->_isMale == true ? 1 : 0;

	$educational_establishment = $data->_educational_establishment->id;
	$cityzenship = $data->_cityzenship->id;
	$appointment = $data->_appointment->id;
	$organization = $data->_organization->id;
	$region = $data->_region->id;
	$department = $data->_department->id;
	$faculty = $data->_faculty->id;
	$mysqli->query("INSERT INTO personal_card (surname, name, patername, birthday, ee, citizenship, diploma_start, appointment, isDoctor, tel_number, organization, region, isMale, isCowoker, experience_general, experiance_special, insurance_number, department, faculty, name_in_to_form, diploma_number) VALUES (
		'$data->_surname', 
		'$data->_name', 
		'$data->_patername', 
		'$data->_birthday', 
		'$educational_establishment',
		'$cityzenship',
		'$data->_diploma_start',
		'$appointment',
		'$data->_isDoctor', 
		'$data->_tel_number_home', 
		'$organization',
		'$region',
		'$isMale', 
		'$isCowoker', 
		'$data->_experiance_general', 
		'$data->_experiance_special', 
		'$data->_insurance_number', 
		'$department',
		'$faculty',
		'$data->_nameInDativeForm', 
		'$data->_diploma_number')") or die ("Ошибка: " . mysqli_error($mysqli));
	
	
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
	$mysqli->query("INSERT INTO arrivals (date, FacultId, CathedrId, CourseId, GroupNum, EducType, ResidPlace, FormEduc, Dic_count, Status, PersonId) VALUES (
		'$date', 
		'$faculty', 
		'$cathedraId', 
		'$data->_belmapo_course', 
		'$data->_belmapo_course', 
		'$data->_belmapo_educType', 
		'$data->_belmapo_residense', 
		'$data->_belmapo_educForm', 
		'$data->_belmapo_paymentData', 
		'0', 
		'$newPersonId')") or die ("Ошибка: " . mysqli_error($mysqli));

	mysqli_close($mysqli);
	echo "Слушатель зачислен";
?>