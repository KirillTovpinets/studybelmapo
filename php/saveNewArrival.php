<?php 
	ini_set("display_errors", 1);
	require_once("config.php");
	$data = json_decode(file_get_contents("php://input"));
	$person = $data->person;
	$course = $data->course;

	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die("Ошибка подклчюения: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");

	$cathderaId = $course->cathedraId;
	$cathedraObj = $mysqli->query("SELECT * FROM cathedras WHERE id=$cathderaId");
	$cathedra = $cathedraObj->fetch_assoc();
	$Date = date("Y-m-d");
	$FacultId = $cathedra["facultId"];
	$CathedrId = $cathedra["id"];
	$CourseId = $course->id;
	$GroupNum = $course->Number;
	$EducType = $course->Type;
	$ResidPlace = $person->_belmapo_residense;
	$FormEduc = $person->_belmapo_educForm;
	if (isset($person->_belmapo_paymentData)) {
		$Dic_count = $person->_belmapo_paymentData;
	}else{
		$Dic_count = "";
	}
	$DocNumber = "";
	$isDeleted = 0;
	$Status = 0;
	$PersonId = $person->_id;
	$query = "INSERT INTO `arrivals`(`Date`, `FacultId`, `CathedrId`, `CourseId`, `GroupNum`, `EducType`, `ResidPlace`, `FormEduc`, `Dic_count`, `DocNumber`, `IsDeleted`, `Status`, `PersonId`) VALUES ('$Date', '$FacultId','$CathedrId', '$CourseId', '$GroupNum', '$EducType', '$ResidPlace', '$FormEduc', '$Dic_count', '$DocNumber', '$isDeleted', '$Status', '$PersonId')";
	$mysqli->query($query) or die ("Ошибка выполнения запроса $query: " . mysqli_error($mysqli));
	mysqli_close($mysqli);

?>