<?php 
	ini_set("display_errors", 1);
	require("config.php");
    require("rb.php");
    session_start();

    $logeduser = $_SESSION["loged_user"];
    
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения к базе: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
    $response = array();
	if (isset($_GET["course"])) {
        $course = $_GET["course"];
        $limit = $_GET["limit"];
        $offset = $_GET["offset"];
        $forCathedras = "";
        $forCathedrasConnection = "";
        if ($logeduser->is_cathedra === 1) {
            $cathedraId = $logeduser->dep_id;
            $forCathedras = " AND cathedras.id = $cathedraId";
            $forCathedrasConnection = "INNER JOIN cathedras ON course";
        }
        $query = "SELECT certificates.DateGet, marks.name AS Mark, personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, arrivals_zip.DocNumber FROM certificates INNER JOIN arrivals_zip ON certificates.Arrival_id = arrivals_zip.id INNER JOIN personal_card ON arrivals_zip.PersonId = personal_card.id INNER JOIN marks ON certificates.MarkId = marks.id WHERE arrivals_zip.CourseId = $course LIMIT $limit OFFSET $offset ";
        $result = $mysqli->query($query) or die ("Ошибка запроса '$query':" . mysqli_error($mysqli));    
        $response = array();
        while ($row = $result->fetch_assoc()) {
            array_push($response, $row);
        }
    }
    echo json_encode($response);    
 ?>