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
		if(isset($_GET["time"]) && !empty($_GET["time"])){
			$time = $_GET["time"];
			$today = date("Y-m-d");
			switch($time){
				case "current": {
					$condition .= " AND (Date(cources.Start) <= '$today' AND Date(cources.Finish) >= '$today')";
					break;
				}
				case 'old':{
					$condition .= " AND (Date(cources.Start) <= '$today' AND Date(cources.Finish) <= '$today')";
					break;
				}
			}
		}
	}else if($LogedUser->is_cathedra == 0){
		$condition = "1";
		$select = "DISTINCT cources.`id`, cources.`Number`, cources.`Type`, cources.`name`,cources.`year`, cources.`Start`, cources.`Finish`, cources.`Duration`, cources.`Size`, cources.`Notes`, cources.`cathedraId`";
		// $connection = "INNER JOIN arrivals ON arrivals.CourseId = cources.id";
	}

	$query = "SELECT $select FROM cources $connection WHERE $condition";
	$result = $mysqli->query($query) or die ("Ошибка запроса '$query':" . mysqli_error($mysqli));
	$response = array();
	while ($row = $result->fetch_assoc()) {
		$courseId = $row["id"];
		$query = "SELECT arrivals.id AS arrivalId, arrivals.Date, arrivals.DocNumber, arrivals.Dic_count, Residence.name As ResidPlace, personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, concat(personal_card.surname, ' ', personal_card.name, ' ', personal_card.patername) AS fullName, arrivals.Status, personal_private_info.birthday FROM personal_card INNER JOIN arrivals ON personal_card.id = arrivals.PersonId INNER JOIN Residence ON  arrivals.ResidPlace = Residence.id INNER JOIN personal_private_info ON personal_card.id = personal_private_info.PersonId WHERE arrivals.CourseId = $courseId AND arrivals.Status != 4 ORDER BY personal_card.name_in_to_form ASC";
		$countArr = $mysqli->query("SELECT COUNT(*) AS countArr FROM arrivals WHERE Status = 1 AND CourseId = $courseId");
		$countEntered = $mysqli->query("SELECT COUNT(*) AS countEntered FROM arrivals WHERE Status = 2 AND CourseId = $courseId");
		$countGraduated = $mysqli->query("SELECT COUNT(*) AS countGraduated FROM arrivals WHERE Status = 3 AND CourseId = $courseId");
		$countDeducted = $mysqli->query("SELECT COUNT(*) AS countDeducted FROM arrivals WHERE Status = 4 AND CourseId = $courseId");
		$countArrArr = $countArr->fetch_assoc();
		$countEnteredArr = $countEntered->fetch_assoc();
		$countGraduatedArr = $countGraduated->fetch_assoc();
		$countDeductedArr = $countDeducted->fetch_assoc();

		$countArrNumber = $countArrArr["countArr"];
		$countEnteredNumber = $countEnteredArr["countEntered"];
		$countGraduatedNumber = $countGraduatedArr["countGraduated"];
		$countDeductedNumber = $countDeductedArr["countDeducted"];

		$row["countArr"] = $countArrNumber;		
		$row["countEntered"] = $countEnteredNumber;		
		$row["countGraduated"] = $countGraduatedNumber;		
		$row["countDeducted"] = $countDeductedNumber;

		$studListObj = $mysqli->query($query) or die ("Ошибка в запросе $query: " . mysqli_error($mysqli));
		$studList = array();
		while ($student = $studListObj->fetch_assoc()) {
			$id = $student["id"];
			$updateData = "SELECT * FROM history_of_changes WHERE personId = $id ORDER BY id ASC";
			$updateObj = $mysqli->query($updateData) or die ("Error in '$updateData': " . mysqli_error($mysqli));
			while ($updateRow = $updateObj->fetch_assoc()) {
				if($updateRow["field"] == "name_in_to_form"){
					$updateRow["field"] = "nameInDativeForm";
				}
				foreach ($student as $key => $value) {
					if ($key == $updateRow["field"]) {
						$newValue = $updateRow["new_value"];
						if (!is_numeric($newValue)) {
							$student[$key] = $newValue;
						}
					}
				}
			}
			array_push($studList, $student);
		}
		if ($studListObj->{"num_rows"} == 0) {
			$query = "SELECT Number, year from cources where id = $courseId";
			$resultCourse = $mysqli->query($query) or die ("Error in '$query': " . mysqli_error($mysqli));

			$courseArr = $resultCourse->fetch_assoc();
			$number = $courseArr["Number"];
			$year = $courseArr["year"];

			$archobj = $mysqli->query("SELECT id from cources_zip where Number = '$number' AND year = '$year'")  or die ("Error in 'SELECT id from cources_zip where Number = '$number' AND year = '$year'': " . mysqli_error($mysqli));
			if ($archobj->{"num_rows"} > 0) {
				$archArr = $archobj->fetch_assoc();
				$archId = $archArr["id"];

				$query = "SELECT certificates.id AS certificateId,certificates.DateGet,certificates.DocNumber, personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, concat(personal_card.surname, ' ', personal_card.name, ' ', personal_card.patername) AS fullName, certificates.MarkId, personal_private_info.birthday FROM personal_card INNER JOIN certificates ON personal_card.id = certificates.Person_id INNER JOIN personal_private_info ON personal_card.id = personal_private_info.PersonId WHERE certificates.CourseId = $archId";
				$resultCert = $mysqli->query($query) or die ("Error in '$query': " . mysqli_error($mysqli));

				while ($certificate = $resultCert->fetch_assoc()) {
					array_push($studList, $certificate);
				}
			}
		}
		$row["StudList"] = $studList;
		array_push($response, $row);
	}
    
    if(count($response) == 0){
		echo $query;
        echo "Нет курсов, удовлетворяющих условиям поиска";
    }else{
        echo json_encode($response);    
    }
 ?>