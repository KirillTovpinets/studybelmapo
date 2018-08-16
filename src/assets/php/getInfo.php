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
    				$query = "SELECT COUNT(*) AS total FROM arrivals WHERE arrivals.CourseId = $courseId";
					$allStudents = $mysqli->query($query) or die ("Ошибка в запросе $query: " . mysqli_error($mysqli));
					$payQuery = "SELECT COUNT(*) as total FROM arrivals WHERE Dic_count != '' AND arrivals.CourseId = $courseId";
					$payfulStudents = $mysqli->query($payQuery) or die ("Ошибка в запросе $payQuery: " . mysqli_error($mysqli));
					$arr = $payfulStudents->fetch_assoc();
    				$all = $allStudents->fetch_assoc();
					$course["payful"] = $arr["total"];
					$course["total"] = $all["total"];
					$course["isCurrent"] = 0;
					if(!in_array($course["id"], $oldcourses)){
						$course["isCurrent"] = 1;
					}

					$payfulCathedra += $course["payful"];
					$payfulFaculty += $course["payful"];
					$totalCathedra += $all["total"];
					$totalFaculty += $all["total"];
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
