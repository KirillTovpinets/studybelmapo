<?php 
    require_once("config.php");
    
    $table = $_GET["table"];
    $mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die("Ошибка подключения к базе данных: " . mysqli_connect_error());
    $mysqli->query("SET NAMES utf8");
    $query = "SELECT * FROM $table ORDER BY name ASC";
    $result = $mysqli->query($query) or die ("Ошибка в запросе: $query" . mysqli_error($mysqli));
    
    $response = array();
    while($row = $result->fetch_assoc()){
        array_push($response, $row);
    }
    mysqli_close($mysqli);
    echo json_encode($response);
    
?>