<?php 
	ini_set("display_errors", 1);
	require_once 'config.php';

	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Error connecting to db: " . mysqli_connect_errorr());
	$mysqli->query("SET NAMES utf8");

	$data = json_decode(file_get_contents("php://input"));

	$arrivalId = $data->_arrivalId;
	$courseId = $data->_courseId;
	$date = $data->_DateGet;
	$docNumber = $data->_docNumber;
	$mark = $data->_mark;
	$query = "INSERT INTO `arrivals_zip`(`Date`, `CourseId`, `ResidPlace`, `FormEduc`, `Dic_count`, `DocNumber`,`Status`, `PersonId`) SELECT `Date`, `CourseId`, `ResidPlace`, `FormEduc`, `Dic_count`, `DocNumber`, `Status`, `PersonId` FROM `arrivals` WHERE id = $arrivalId";
	$mysqli->query($query) or die ("Error in query '$query': " . mysqli_error($mysqli));

	$query = "DELETE FROM `arrivals` WHERE id = $arrivalId";
	$result = $mysqli->query($query) or die ("Error in query '$query': " . mysqli_error($mysqli));

	$mysqli->query("INSERT INTO `certificates`(`Arrival_id`, `CourseId`, `DateGet`, `DocNumber`, `MarkId`) VALUES (
		'$arrivalId',
		'$courseId',
		'$date',
		'$docNumber',
		'$mark')") or die ("Error in query: " . mysqli_error($mysqli));	
	echo "SUCCESS";
	mysqli_close($mysqli);
?>