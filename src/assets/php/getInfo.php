<?php 
	ini_set("display_errors", 1);
	require_once("config.php");
	require_once("rb.php");
	session_start();
	$LogedUser = $_SESSION["loged_user"];
	
	$cathedraLoged = false;
	$departmentLoged = false;
	if($LogedUser->dep_id != 0 || $LogedUser->dep_id != NULL){
	    $depId = $LogedUser->dep_id;
	    if($LogedUser->is_cathedra != 0 && $LogedUser->is_cathedra != NULL){
	        $cathedraLoged = true;
	    }else{
	        $departmentLoged = true;
	    }
	}else{
	    $adminLoged = true;
	}
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	
	deleteUpdate($LogedUser->id, "studList", $mysqli);
//Home page last 10 arrivals
    $condition = "";
    $infoCondition = "";
	if($_GET["info"] == 'getStat'){
	    if($cathedraLoged == true){
	    	$infoCondition = "AND cathedras.id = $depId";
	    	$condition = "AND arrivals.CathedrId = $depId";
	    }
    	$query = "SELECT * FROM faculties";
    	$allFaculties = $mysqli->query($query) or die ("Ошибка в запросе $query: " . mysqli_error($mysqli));
    	$facultyList = array();
    	$today = date("Y-m-d");
    	while ($faculty = $allFaculties->fetch_assoc()) {
    		$facultyId = $faculty["id"];
			$totalFaculty = 0;
			$payfulFaculty = 0;
    		$query = "SELECT * FROM cathedras WHERE facultId = $facultyId $infoCondition ORDER BY name ASC";
    		$allCathedras = $mysqli->query($query) or die ("Ошибка в запросе $query: " . mysqli_error($mysqli));
    		// if ($allCathedras->{"num_rows"} === 0) {
    		// 	continue;
    		// }
    		$cathedraList = array();
    		while ($cathedra = $allCathedras->fetch_assoc()) {
    			$cathedraId = $cathedra["id"];
				$totalCathedra = 0;
				$payfulCathedra = 0;
				$query = "SELECT cources.id, cources.Number, cources.Size, cources.name, cources.Start, cources.Finish FROM cources WHERE cources.cathedraId = $cathedraId";
				$oldQuery = "SELECT cources.id FROM cources WHERE cources.cathedraId = $cathedraId AND cources.Finish <= '$today'";
				$allCathedraCourses = $mysqli->query($query) or die ("Ошибка в запросе $query: " . mysqli_error($mysqli));
				$oldCathedraCourses = $mysqli->query($oldQuery) or die ("Ошибка в запросе $oldQuery: " . mysqli_error($mysqli));
    			// if ($allCathedraCourses->{"num_rows"} === 0) {
	    		// 	continue;
	    		// }
				$courseList = array();
				$oldcourses = array();
				while($course = $oldCathedraCourses->fetch_assoc()){
					array_push($oldcourses, $course["id"]);
				}
    			while ($course = $allCathedraCourses->fetch_assoc()) {
    				$courseId = $course["id"];
                    $totalCourse = 0;
    				$query = "SELECT arrivals.id AS arrivalId, arrivals.FormEduc, arrivals.Dic_count, arrivals.DocNumber, arrivals.Date, Residence.name AS ResidPlace, personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, personal_private_info.birthday, personal_card.name_in_to_form AS nameInDativeForm FROM personal_card INNER JOIN personal_private_info ON personal_card.id = personal_private_info.PersonId INNER JOIN arrivals ON personal_card.id = arrivals.PersonId INNER JOIN Residence ON arrivals.ResidPlace = Residence.id WHERE arrivals.CourseId = $courseId ORDER BY nameInDativeForm ASC";
					$allStudents = $mysqli->query($query) or die ("Ошибка в запросе $query: " . mysqli_error($mysqli));
					$payQuery = "SELECT COUNT(*) as total FROM arrivals WHERE Dic_count != '' AND arrivals.CourseId = $courseId";
					$payfulStudents = $mysqli->query($payQuery) or die ("Ошибка в запросе $payQuery: " . mysqli_error($mysqli));
					$arr = $payfulStudents->fetch_assoc();
    				// if ($allStudents->{"num_rows"} === 0) {
		    		// 	continue;
		    		// }
    				$studentList = array();
    				while ($student = $allStudents->fetch_assoc()) {
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
    					array_push($studentList, $student);
					}
					for($k = 0; $k < count($studentList) - 1; $k++){
						for($j = $k + 1; $j < count($studentList); $j++){
							if(strcmp($studentList[$k]["nameInDativeForm"], $studentList[$j]["nameInDativeForm"]) > 0){
								$temp = $studentList[$k];
								$studentList[$k] = $studentList[$j];
								$studentList[$j] = $temp;
							}
						}
					}
					$course["payful"] = $arr["total"];
					$course["Total"] = $allStudents->{"num_rows"};
					$course["isCurrent"] = 0;
					if(!in_array($course["id"], $oldcourses)){
						$course["isCurrent"] = 1;
					}

					$payfulCathedra += $course["payful"];
					$payfulFaculty += $course["payful"];
					$totalCathedra += $allStudents->{"num_rows"};
					$totalFaculty += $allStudents->{"num_rows"};
					
    				$course["StudList"] = $studentList;
    				array_push($courseList, $course);
    			}
				$cathedra["Total"] = $totalCathedra;
				$cathedra["payful"] = $payfulCathedra;
    			$cathedra["CourseList"] = $courseList;
    			array_push($cathedraList, $cathedra);
    		}
			$faculty["Total"] = $totalFaculty;
			$faculty["payful"] = $payfulFaculty;
			$faculty["CathedraList"] = $cathedraList;
    		if (count($faculty["CathedraList"]) === 0) {
    			continue;
    		}
    		array_push($facultyList, $faculty);
    	}
    	$response["data"] = $facultyList;
    	mysqli_close($mysqli);
    	echo json_encode($response);
	}
?>
