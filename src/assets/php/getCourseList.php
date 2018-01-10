<?php 
	ini_set("display_errors", 1);
	require("config.php");
    
    $data = json_decode(file_get_contents("php://input"));
    $dateFrom = "";
    $dateTo = "";
    if (isset($data->dateFrom) && ($data->dateFrom !== "")) {
    	$dateFrom = $data->dateFrom;
    }
    if(isset($data->dateTo) && ($data->dateTo !== "")){
    	$dateTo = $data->dateTo;
    }
    
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения к базе: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	$currentYear = date("Y");
	$courseTable = "cources";
	$query = "SELECT DISTINCT * FROM (SELECT $courseTable.`id`, $courseTable.`Number`, $courseTable.`Type`, $courseTable.`name`, $courseTable.`year`, $courseTable.`Start`, $courseTable.`Finish`, $courseTable.`Duration`, $courseTable.`Size`, $courseTable.`Notes`, $courseTable.`cathedraId` FROM $courseTable INNER JOIN arrivals ON $courseTable.id = arrivals.CourseId WHERE arrivals.Status = 0 AND cources.Start BETWEEN '$dateFrom' AND '$dateTo') AS main";
	$result = $mysqli->query($query) or die ("Ошибка запроса '$query':" . mysqli_error($mysqli));
	$response = array();
	while ($row = $result->fetch_assoc()) {
		array_push($response, $row);
	}
    
    if(count($response) == 0){
        echo "Нет курсов, удовлетворяющих условиям поиска";
    }else{
        echo json_encode($response);    
    }
 ?>