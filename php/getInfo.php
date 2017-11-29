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
	    if($LogedUser->is_cathedra != 0 OR $LogedUser->is_cathedra != NULL){
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
	    	$infoCondition = "WHERE cathedras.id = $depId";
	    	$condition = "WHERE arrivals.CathedrId = $depId";
	    }
        //Информация о кафедре
        $query = "SELECT faculties.name AS faculty, cathedras.name AS cathedra FROM cathedras INNER JOIN faculties ON cathedras.facultId = faculties.id $infoCondition GROUP BY faculty";
	    $FacNameObj = $mysqli->query($query) or die ("Ошибка в запросе $query: " . mysqli_error($mysqli));
	    $CathedraInfo = array();
	    while ($row = $FacNameObj->fetch_assoc()) {
	    	array_push($CathedraInfo, $row);
	    }
	   // print_r($CathedraInfo);
	    //Информация о курсах
	    $query = "SELECT cources.id, cources.Number, cources.name, cources.Start, cources.Finish FROM arrivals INNER JOIN cources ON arrivals.CourseId = cources.id $condition GROUP BY cources.name";
	    $CourceObj = $mysqli->query($query) or die ("Ошибка в запросе $query: " . mysqli_error($mysqli));
	    $courceList = array();
	    $courceWithPerson = array();
	    while($row = $CourceObj->fetch_assoc()){
	        $courseId = $row["id"];
	        //Весь список зачисленных
    	    $query = "SELECT arrivals.Date, personal_card.id, personal_card.surname, personal_card.name, personal_card.patername, personal_card.birthday FROM personal_card INNER JOIN arrivals ON personal_card.unique_Id = arrivals.PersonLink WHERE arrivals.CourseId = $courseId";
    	    if($cathedraLoged == true){
    	    	$query .= " AND arrivals.CathedrId = $depId";
    	    }
    	    $result = $mysqli->query($query) or die("Ошибка в запросе $query: " . mysqli_error($mysqli));
    	    
    	    $arrivalsList = array();
    	    while($ArrivalRow = $result->fetch_assoc()){
    	        array_push($arrivalsList, $ArrivalRow);
    	    }
    	   // $courceWithPerson[$courceId] = $arrivalsList;
    	    $row["list"] = $arrivalsList;
    	    array_push($courceList, $row);
	    }
	    $response["courseList"] = $courceList;
	    $response["cathedraInfo"] = $CathedraInfo;
	    echo json_encode($response);
	   // $query = "SELECT COUNT(*) AS total FROM arrivals WHERE CathedrId = $depId";
	}

	else if($_GET["info"] == 'nationality'){
		$result = $mysqli->query("SELECT name AS label, COUNT(*) AS y FROM (SELECT countries.name, arrivals.Date FROM personal_card INNER JOIN arrivals ON personal_card.unique_Id = arrivals.PersonLink INNER JOIN countries ON personal_card.citizenship = countries.id $condition LIMIT 1000) AS Last  GROUP BY name") or die ("Ошибка: " . mysqli_error($mysqli));
	}

	else if($_GET["info"] == 'faculty'){
		$result = $mysqli->query("SELECT name AS label, COUNT(*) AS y FROM (SELECT faculties.name, arrivals.Date FROM arrivals INNER JOIN faculties ON arrivals.FacultId = faculties.id $condition) AS Last GROUP BY name") or die ("Ошибка: " . mysqli_error($mysqli));
	}

	else if($_GET["info"] == 'speciality'){
		$result = $mysqli->query("SELECT CourseName AS label, COUNT(*) AS y FROM (SELECT cources.CourseName, arrivals.Date FROM arrivals INNER JOIN cources ON arrivals.CourseId = cources.id $condition) AS Last GROUP BY CourseName") or die ("Ошибка: " . mysqli_error($mysqli));
	}
	
	mysqli_close($mysqli);
?>
