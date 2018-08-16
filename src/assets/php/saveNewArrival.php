<?php 
	ini_set("display_errors", 1);
	require_once("config.php");
	$data = json_decode(file_get_contents("php://input"));
	$person = $data->person;
	$course = $data->course;

	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die("Ошибка подклчюения: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");

	$CourseId = $course->id;
	$courseObj = $mysqli->query("SELECT Start FROM cources where id = $CourseId");
	$courseArr = $courseObj->fetch_assoc();
	$courseDate = $courseArr["Start"];

	$ResidPlace = $person->_belmapo_residense;
	$FormEduc = $person->belmapo_educForm;
	$dateEnter = $person->dateEnter;
	if (isset($person->_belmapo_paymentData)) {
		$Dic_count = $person->_belmapo_paymentData;
	}else{
		$Dic_count = "";
	}
	$DocNumber = "";
	$isDeleted = 0;
	$Status = 1;
	$PersonId = $person->id;
	$query = "INSERT INTO `arrivals`(`Date`, `CourseId`, `ResidPlace`, `FormEduc`, `Dic_count`, `DocNumber`, `Status`, `PersonId`) VALUES ('$dateEnter', '$CourseId', '$ResidPlace', '$FormEduc', '$Dic_count', '$DocNumber', '$Status', '$PersonId')";
	broadcastUpdate("studList", $mysqli);
	
	$mysqli->query($query) or die ("Ошибка выполнения запроса $query: " . mysqli_error($mysqli));
	mysqli_close($mysqli);

?>