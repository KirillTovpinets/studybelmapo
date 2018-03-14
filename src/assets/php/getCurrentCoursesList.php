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
	$select = "*";
	$connection = "";
	if (isset($_GET["id"])) {
		$courseId = $_GET["id"];
		$condition = "id = $courseId";
	}else if($LogedUser->is_cathedra == 1){
		$condition = "cathedraId = $depId";
	}else if($LogedUser->is_cathedra == 0){
		$condition = "1";
		$select = "DISTINCT cources.`id`, cources.`Number`, cources.`Type`, cources.`name`,cources.`year`, cources.`Start`, cources.`Finish`, cources.`Duration`, cources.`Size`, cources.`Notes`, cources.`cathedraId`";
		$connection = "INNER JOIN arrivals ON arrivals.CourseId = cources.id";
	}

	$query = "SELECT $select FROM cources $connection WHERE $condition";
	$result = $mysqli->query($query) or die ("Ошибка запроса '$query':" . mysqli_error($mysqli));
	$response = array();
	while ($row = $result->fetch_assoc()) {
		$courseId = $row["id"];
		$query = "SELECT arrivals.id AS arrivalId,arrivals.Date, arrivals.Dic_count, personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, concat(personal_card.surname, ' ', personal_card.name, ' ', personal_card.patername) AS fullName, arrivals.Status, personal_private_info.birthday FROM personal_card INNER JOIN arrivals ON personal_card.id = arrivals.PersonId INNER JOIN personal_private_info ON personal_card.id = personal_private_info.PersonId WHERE arrivals.CourseId = $courseId";
		$studListObj = $mysqli->query($query) or die ("Ошибка в запросе $query: " . mysqli_error($mysqli));
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