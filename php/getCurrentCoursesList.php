<?php 
	ini_set("display_errors", 1);
	require("config.php");
	require("rb.php");
    session_start();
    $LogedUser = $_SESSION["loged_user"];
    $depId = $LogedUser->dep_id;
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения к базе данных: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	$query = "SELECT * FROM cources where cathedraId = $depId";
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