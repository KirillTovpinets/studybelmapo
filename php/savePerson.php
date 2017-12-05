<?php 
	ini_set("display_errors", 1);

	require_once("config.php");

	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");

	$data = json_decode(file_get_contents("php://input"));

	// surname
	// name
	// patername
	// birthday
	// nameInDativeForm
	// educational_establishment
	// cityzenship
	// isDoctor
	// isCowoker
	// isMale
	// diploma_start
	// organization
	// appointment
	// region
	// tel_number
	// experiance_general
	// experiance_special
	// insurance_number
	// department
	// faculty
	// diploma_number
	// belmapo_faculty
	// belmapo_cathedra
	// belmapo_course
	// belmapo_educType
	// belmapo_residense
	// belmapo_educForm
	// belmapo_paymentData
	// belmapo_docNumber
	$isDoctor = $data->isDoctor == true ? 1 : 0;
	$isCowoker = $data->isCowoker == true ? 1 : 0;
	$isMale = $data->isMale == true ? 1 : 0;
	$mysqli->query("INSERT INTO personal_card (surname, name, patername, birthday, ee, citizenship, diploma_start, appointment, isDoctor, tel_number, organization, region, isMale, isCowoker, experience_general, experiance_special, insurance_number, department, faculty, name_in_to_form, diploma_number) VALUES ('$data->surname', '$data->name', '$data->patername', '$data->birthday', '$data->educational_establishment', '$data->cityzenship', '$data->diploma_start', '$data->appointment', '$isDoctor', '$data->tel_number', '$data->organization', '$data->region', '$isMale', '$isCowoker', '$data->experiance_general', '$data->experiance_special', '$data->insurance_number', '$data->department', '$data->faculty', '$data->nameInDativeForm', '$data->diploma_number')") or die ("Ошибка: " . mysqli_error($mysqli));
	
	
	$date = date("Y-m-d");
	$mysqli->query("INSERT INTO arrivals (date, FacultId, CathedrId, CourseId, GroupNum, EducType, ResidPlace, FormEduc, Dic_count, Status) VALUES ('$date', '$data->belmapo_faculty', '$data->belmapo_cathedra', '$data->belmapo_course', '$data->belmapo_course', '$data->belmapo_educType', '$data->belmapo_residense', '$data->belmapo_educForm', '$data->belmapo_paymentData', '0')") or die ("Ошибка: " . mysqli_error($mysqli));

	mysqli_close($mysqli);
	echo "Слушатель зачислен";
?>