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

	$lastArrivalObj = $mysqli->query("SELECT MAX(id) as id From arrivals_zip");
	$lastArrivalArr = $lastArrivalObj->fetch_assoc();
	$lastArrid = $lastArrivalArr["id"];

	$courseObj = $mysqli->query("SELECT * FROM cources WHERE id = $courseId");
	$courseArr = $courseObj->fetch_assoc();
	$courseNumber = $courseArr["Number"];

	$year = date("Y");
	$courseObjArch = $mysqli->query("SELECT id FROM cources_zip WHERE Number = '$courseNumber' AND year = '$year'");
	$archId = 0;
	if ($courseObjArch->{"num_rows"} == 0) {
		$type = $courseArr["Type"];
		$name = $courseArr["name"];
		$year = $courseArr["year"];
		$Start = $courseArr["Start"];
		$Finish = $courseArr["Finish"];
		$Duration = $courseArr["Duration"];
		$Size = $courseArr["Size"];
		$Notes = $courseArr["Notes"];

		$mysqli->query("INSERT INTO `cources_zip`(`Number`, `type`, `name`, `year`, `start`, `finish`, `duration`, `size`, `Notes`) VALUES (
		'$courseNumber',
		'$type',
		'$name',
		'$year',
		'$Start',
		'$Finish',
		'$Duration',
		'$Size',
		'$Notes')");

		$archIdObj = $mysqli->query("SELECT MAX(id) AS id FROM cources_zip");
		$archArr = $archIdObj->fetch_assoc();
		$archId = $archArr["id"];
	}else{
		$courseArr = $courseObjArch->fetch_assoc();
		$archId = $courseArr["id"];
	}

	$mysqli->query("Update arrivals_zip SET CourseId = $archId WHERE id = $lastArrid");


	$mysqli->query("INSERT INTO `certificates`(`Arrival_id`, `DateGet`, `MarkId`) VALUES (
		'$lastArrid',
		'$date',
		'$mark')") or die ("Error in query INSERT INTO `certificates`: " . mysqli_error($mysqli));	
	echo "SUCCESS";
	mysqli_close($mysqli);
?>