<?php 
	ini_set("display_errors", 1);

	require_once("config.php");

	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	function getIdFromTable($parameter, $tableName, $mysqli){
		$SqlObj = $mysqli->query("SELECT id FROM $tableName WHERE name = '$parameter'") or die ("Ошибка: " . mysqli_error($mysqli));
		if ($SqlObj->{"num_rows"} > 0) {
			$SqlArr = $SqlObj->fetch_assoc();
			$id = $SqlArr["id"];
		}
		else{
			$mysqli->query("INSERT INTO $tableName (name) VALUES ('$parameter');") or die ("Ошибка: " . mysqli_error($mysqli));
			$SqlObj = $mysqli->query("SELECT MAX(id) AS id FROM $tableName") or die ("Ошибка: " . mysqli_error($mysqli));
			$SqlArr = $SqlObj->fetch_assoc();
			$id = $SqlArr["id"];
		}
		return $id;
	}
	
	function getCourseIdFromTable($parameter, $tableName, $mysqli){
		$SqlObj = $mysqli->query("SELECT Number FROM $tableName WHERE name LIKE '$parameter'") or die ("Ошибка: " . mysqli_error($mysqli));
		if ($SqlObj->{"num_rows"} > 0) {
			$SqlArr = $SqlObj->fetch_assoc();
			$id = $SqlArr["Number"];
			return $id;
		}
	}
	$EstName = $_POST["EstName"];
	$estId = getIdFromTable($EstName, "personal_establishment", $mysqli);
	$AppName = $_POST["AppName"];
	$appId = getIdFromTable($AppName, "personal_appointment", $mysqli);
	$ResName = $_POST["ResName"];
	$resId = getIdFromTable($ResName, "countries", $mysqli);
	$OrgName = $_POST["OrgName"];
	$orgId = getIdFromTable($OrgName, "personal_organizations", $mysqli);
	$RegName = $_POST["RegName"];
	$regId = getIdFromTable($RegName, "regions", $mysqli);
	$DepName = $_POST["DepName"];
	$depid = getIdFromTable($DepName, "personal_department", $mysqli);
	$FacName = $_POST["FacName"];
	$facId = getIdFromTable($FacName, "personal_faculty", $mysqli);

	$surname = $_POST["surname"];
	$name = $_POST["name"];
	$patername = $_POST["patername"];
	$birthday = $_POST["birthday"];
	$diploma_start = $_POST["diploma_start"];
	$tel_number = $_POST["tel_number"];
	$isDoctor = $_POST["isDoctor"] ? 1 : 0;
	$insurance_number = $_POST["insurance_number"];
	$diploma_number = $_POST["diploma_number"];
	
	
	$facultyMAPO = $_POST["facultyMAPO"];
	$cathedra = $_POST["cathedra"];
	$cathedra = getIdFromTable($cathedra, "cathedras", $mysqli);
	$course = $_POST["course"];
	$course = getCourseIdFromTable($course, "cources", $mysqli);
	$educType = $_POST["educType"];
	$residence = $_POST["residence"];
	$formEduc = $_POST["formEduc"];
	if(isset($_POST["accountNumber"])){
	    $dic_count = $_POST["accountNumber"];    
	}else{
	    $dic_count = 0;
	}
	if(isset($_POST["numDoc"])){
	    $numDoc = $_POST["numDoc"];    
	}else{
	    $numDoc = 0;
	}

	if(isset($_POST["exp"])){
	    $exp = $_POST["exp"];    
	}else{
	    $exp = 0;
	}
	if(isset($_POST["expAdd"])){
	    $expAdd = $_POST["expAdd"];    
	}else{
	    $expAdd = 0;
	}
	if($_POST["isMale"] == "true"){
	    $isMale = 1;
	}else{
	    $isMale = 0;
	}
	if(isset($_POST["isCowoker"])){
	    if($_POST["isCowoker"] == "true"){
	        $isCowoker = 1;
    	}else{
    	    $isCowoker = 0;
    	}
	}else{
	    $isCowoker = 0;
	}
	$in_to_form = $_POST["in_to_form"];

	$simbols = "ASDFGHJKLQWERTYUIOPZXCVBNM123456789";

	$unique_Id = "";
	$isNotUnique = true;
	while ($isNotUnique) {
		for ($i=0; $i < 32; $i++) { 
			$unique_Id .= $simbols[rand(0, 31)];
		}
		$result = $mysqli->query("SELECT id FROM personal_card WHERE unique_id = '$unique_Id'");

		if ($result->{"num_rows"} == 0) {
			$isNotUnique = false;
		}
		
		$result = $mysqli->query("SELECT id FROM arrivals WHERE UniqueId = '$unique_Id'");

		if ($result->{"num_rows"} == 0) {
			$isNotUnique = false;
		}
	}
	
	$unique_id_arrivals = "";
	$isNotUnique = true;
	while ($isNotUnique) {
		for ($i=0; $i < 32; $i++) { 
			$unique_id_arrivals .= $simbols[rand(0, 31)];
		}
		$result = $mysqli->query("SELECT id FROM personal_card WHERE unique_id = '$unique_id_arrivals'");

		if ($result->{"num_rows"} == 0) {
			$isNotUnique = false;
		}
		
		$result = $mysqli->query("SELECT id FROM arrivals WHERE UniqueId = '$unique_id_arrivals'");

		if ($result->{"num_rows"} == 0) {
			$isNotUnique = false;
		}
	}
	$mysqli->query("INSERT INTO personal_card (surname, name, patername, birthday, ee, citizenship, diploma_start, appointment, isDoctor, tel_number, organization, region, isMale, isCowoker, experience_general, experiance_special, insurance_number, department, unique_Id, faculty, name_in_to_form, diploma_number) VALUES ('$surname', '$name', '$patername', '$birthday', '$estId', '$resId', '$diploma_start', '$appId', '$isDoctor', '$tel_number', '$orgId', '$regId', '$isMale', '$isCowoker', '$exp', '$expAdd', '$insurance_number', '$depid', '$unique_Id', '$facId', '$in_to_form', '$diploma_number')") or die ("Ошибка: " . mysqli_error($mysqli));
	
	
	$date = date("Y-m-d");
	$mysqli->query("INSERT INTO arrivals (date, FacultId, CathedrId, CourseId, GroupNum, EducType, ResidPlace, FormEduc, Dic_count, DocNumber, UniqueId, Status, PersonLink) VALUES ('$date', '$facultyMAPO', '$cathedra', '$course', '$course', '$educType', '$residence', '$formEduc', '$dic_count', '$numDoc', '$unique_id_arrivals', '0', '$unique_Id')") or die ("Ошибка: " . mysqli_error($mysqli));


	if (isset($_POST["specialities"])) {
		$specialities = $_POST["specialities"];

		foreach ($specialities as $key => $value) {
			$spId = getIdFromTable($value, "personal_speciality_list", $mysqli);
			$mysqli->query("INSERT INTO personal_speciality (idPerson, idSpeciality) VALUES ('$unique_Id', '$spId')") or die ("Ошибка выполнения запроса:" . mysqli_error($mysqli));
		}
	}
	if (isset($_POST["qualifications"])) {
		$qualifications = $_POST["qualifications"];

		foreach ($qualifications as $key => $value) {
			$quId = getIdFromTable($value, "personal_qualifications_list", $mysqli);
			$mysqli->query("INSERT INTO personal_qualification (idPerson, idQualification) VALUES ('$unique_Id', '$quId')") or die ("Ошибка выполнения запроса:" . mysqli_error($mysqli));
		}
	}
	mysqli_close($mysqli);
	echo "Слушатель зачислен";
?>