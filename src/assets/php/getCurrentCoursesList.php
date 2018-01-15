<?php 
	ini_set("display_errors", 1);
	require("config.php");
	require("rb.php");
    session_start();
    $LogedUser = $_SESSION["loged_user"];
    $depId = $LogedUser->dep_id;
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения к базе данных: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	$condition = "";
	if (isset($_GET["id"])) {
		$courseId = $_GET["id"];
		$condition = "id = $courseId";
	}else{
		$condition = "cathedraId = $depId";
	}

	$query = "SELECT * FROM cources where $condition";
	$result = $mysqli->query($query) or die ("Ошибка запроса '$query':" . mysqli_error($mysqli));
	$response = array();
	while ($row = $result->fetch_assoc()) {
		$courseId = $row["id"];
		$studListObj = $mysqli->query("SELECT arrivals.id AS arrivalId,arrivals.Date, personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, personal_card.birthday FROM personal_card INNER JOIN arrivals ON personal_card.id = arrivals.PersonId WHERE arrivals.CourseId = $courseId") or die ("Ошибка в запросе $query: " . mysqli_error($mysqli));
		$studList = array();
		while ($student = $studListObj->fetch_assoc()) {
			array_push($studList, $student);
		}
		$row["StudList"] = $studList;
		array_push($response, $row);
	}
    
    if(count($response) == 0){
        echo "Нет курсов, удовлетворяющих условиям поиска";
    }else{
        echo json_encode($response);    
    }
 ?>