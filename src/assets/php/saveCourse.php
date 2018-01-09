<?php 
	ini_set("display_errors", 1);

	require_once("config.php");
	require_once('rb.php');
	session_start();
	$login = $_SESSION["loged_user"];
	$cathId = $login->dep_id;
// _number ;
// _type ;
// _name ;
// _start ;
// _startStr ;
// _finish ;
// _finishStr ;
// _ducation ;
// _size ;
// _notes ;
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