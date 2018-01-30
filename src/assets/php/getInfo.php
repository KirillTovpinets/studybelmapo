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
    		$query = "SELECT * FROM cathedras WHERE facultId = $facultyId $infoCondition ORDER BY name ASC";
    		$allCathedras = $mysqli->query($query) or die ("Ошибка в запросе $query: " . mysqli_error($mysqli));
    		// if ($allCathedras->{"num_rows"} === 0) {
    		// 	continue;
    		// }
    		$cathedraList = array();
    		while ($cathedra = $allCathedras->fetch_assoc()) {
    			$cathedraId = $cathedra["id"];
                $totalCathedra = 0;
    			$query = "SELECT cources.id, cources.Number, cources.Size, cources.name, cources.Start, cources.Finish FROM cources WHERE cources.cathedraId = $cathedraId AND cources.Finish > '$today'";
    			$allCathedraCourses = $mysqli->query($query) or die ("Ошибка в запросе $query: " . mysqli_error($mysqli));
    			// if ($allCathedraCourses->{"num_rows"} === 0) {
	    		// 	continue;
	    		// }
    			$courseList = array();
    			while ($course = $allCathedraCourses->fetch_assoc()) {
    				$courseId = $course["id"];
                    $totalCourse = 0;
    				$query = "SELECT arrivals.id AS arrivalId, arrivals.Dic_count, arrivals.Date, personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, personal_card.birthday FROM personal_card INNER JOIN arrivals ON personal_card.id = arrivals.PersonId WHERE arrivals.CourseId = $courseId";
    				$allStudents = $mysqli->query($query) or die ("Ошибка в запросе $query: " . mysqli_error($mysqli));
    				if ($allStudents->{"num_rows"} === 0) {
		    			continue;
		    		}
    				$studentList = array();
    				while ($student = $allStudents->fetch_assoc()) {
    					array_push($studentList, $student);
    				}
                    $course["Total"] = $allStudents->{"num_rows"};
                    $totalCathedra += $allStudents->{"num_rows"};
                    $totalFaculty += $allStudents->{"num_rows"};
    				$course["StudList"] = $studentList;
    				array_push($courseList, $course);
    			}
                $cathedra["Total"] = $totalCathedra;
    			$cathedra["CourseList"] = $courseList;
    			array_push($cathedraList, $cathedra);
    		}
            $faculty["Total"] = $totalFaculty;
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
