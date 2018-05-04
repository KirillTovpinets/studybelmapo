<?php 
	ini_set("display_errors", 1);

	require_once("config.php");

	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");

	$data = json_decode(file_get_contents("php://input"));

	$number = $data->_number;
	$type = $data->_type;
	$name = $data->_name;
	$startStr = $data->_startStr;
	$finishStr = $data->_finishStr;
	$size = $data->_size;
	$notes = $data->_notes;
	$year = date("Y");
	$splitString = explode('-', $number);
	$initialNumber = $splitString[0];

	$query = "SELECT * FROM cources WHERE Number = $initialNumber";
	$relatedCourse = $mysqli->query($query) or die ("Error in '$query': " . mysqli_error($mysqli));
	$arr = $relatedCourse->fetch_assoc();
	$cathId = $arr["cathedraId"];
	$mysqli->query("INSERT INTO `cources`(`Number`, `Type`, `name`, `year`, `Start`, `Finish`, `Size`, `Notes`, `cathedraId`) VALUES (
		'$number',
		'$type',
		'$name',
		'$year',
		'$startStr',
		'$finishStr',
		'$size',
		'$notes',
		'$cathId'
	)") or die ("Ошибка: " . mysqli_error($mysqli));
	echo "success";
	mysqli_close($mysqli);
?>