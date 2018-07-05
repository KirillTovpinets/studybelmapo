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
        $totalInYear = 0;
        $year = $_GET["year"];
        $limit = $_GET["limit"];
        $offset = $_GET["offset"];
        $query = "SELECT cources_zip.id, cources_zip.Number, cources_zip.name, cources_zip.Start, cources_zip.Finish FROM cources_zip WHERE cources_zip.year = $year ORDER BY cources_zip.Number ASC LIMIT $limit OFFSET $offset";
        $result = $mysqli->query($query) or die ("Ошибка запроса '$query':" . mysqli_error($mysqli));    
        $response = array();
        while ($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $numberQuery = "SELECT COUNT(*) AS total FROM certificates INNER JOIN arrivals_zip ON certificates.Arrival_id = arrivals_zip.id WHERE arrivals_zip.CourseId = $id";
            $numberObj = $mysqli->query($numberQuery);
            $numberArr = $numberObj->fetch_assoc();
            $row["limit"] = 30;
            $row["offset"] = 0;
            $row["total"] = $numberArr["total"];
            array_push($response, $row);
        }
    }else{
        $query = "SELECT DISTINCT year FROM cources_zip ORDER BY year DESC";
        $result = $mysqli->query($query) or die ("Ошибка запроса '$query':" . mysqli_error($mysqli));    
        $response["years"] = array();

        


        while ($row = $result->fetch_assoc()) {
            $year = $row["year"];

            $numberQuery = "SELECT COUNT(*) as total FROM certificates INNER JOIN arrivals_zip ON certificates.Arrival_id = arrivals_zip.id INNER JOIN cources_zip ON arrivals_zip.CourseId = cources_zip.id WHERE cources_zip.year = $year";
            $numberObj = $mysqli->query($numberQuery);
            $numberArr = $numberObj->fetch_assoc();
            $rowPush = array(
                'year' => $year,
                'total' => $numberArr["total"]
            );
            array_push($response["years"], $rowPush);
        }
    }
    echo json_encode($response);    
 ?>