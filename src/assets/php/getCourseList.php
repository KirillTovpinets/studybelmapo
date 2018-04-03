<?php 
	ini_set("display_errors", 1);
	require("config.php");
    require("rb.php");
    session_start();

    $logeduser = $_SESSION["loged_user"];
    
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения к базе: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
    $response = array();
	if (isset($_GET["year"])) {
        $year = $_GET["year"];
        $query = "SELECT cources_zip.id, cources_zip.Number, cources_zip.name FROM cources_zip WHERE cources_zip.year = $year ORDER BY cources_zip.Number ASC";
        $result = $mysqli->query($query) or die ("Ошибка запроса '$query':" . mysqli_error($mysqli));    
        $response = array();
        while ($row = $result->fetch_assoc()) {
            $row["limit"] = 30;
            $row["offset"] = 0;
            array_push($response, $row);
        }
    }else{
        $query = "SELECT DISTINCT year FROM cources_zip ORDER BY year DESC";
        $result = $mysqli->query($query) or die ("Ошибка запроса '$query':" . mysqli_error($mysqli));    
        $response["years"] = array();
        while ($row = $result->fetch_assoc()) {
            array_push($response["years"], $row["year"]);
        }
    }
    echo json_encode($response);    
 ?>