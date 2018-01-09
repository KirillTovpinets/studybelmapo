<?php 
	ini_set("display_errors", 1);
	require_once 'config.php';

	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Error connecting to db: " . mysqli_connect_errorr());
	$mysqli->query("SET NAMES utf8");

	$data = json_decode(file_get_contents("php://input"));

	$arrivaId = $data->_arrivalId;
	$courseId = $data->_courseId;
	$date = $data->_DateGet;
	$docNumber = $data->_docNumber;
	$mark = $data->_mark;
	try {
		$mysqli->query("INSERT INTO `certificates`(`Arrival_id`, `CourseId`, `DateGet`, `DocNumber`, `MarkId`) VALUES (
			'$arrivaId',
			'$courseId',
			'$date',
			'$docNumber',
			'$mark')") or die ("Error in query: " . mysqli_error($mysqli));	
	} catch (Exception $e) {
		echo "ERROR: " . $e;
	}
	echo "SUCCESS";
	mysqli_close($mysqli);
?>