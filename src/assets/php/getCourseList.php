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
	$query = "SELECT * FROM $courseTable INNER JOIN arrivals ON $courseTable.Number = arrivals.CourseId WHERE arrivals.Status = 0 AND cources.Start BETWEEN '$dateFrom' AND '$dateTo'";
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