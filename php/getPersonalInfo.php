<?php 
	require_once("config.php");

	ini_set("display_arrors", 1);
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");

	$generalFields = array('id', 'surname', 'name', 'patername', 'name_in_to_form', 'AppName', 'OrgName', 'DepName');
	$profInfoFields = array('EstName', 'FacName', 'diploma_start', 'diploma_number', 'experience_general', 'experiance_special', 'speciality_doct', 'speciality_other', 'speciality_retraining', 'qualification_add', 'qualification_main', 'speciality_retraining');
	$personalFields = array('birthday','ResName','isMale','insurance_number');
	$id = $_GET["id"];
	if (isset($_GET["selected"]) && $_GET["selected"] === "true") {
		$infoQuery = "SELECT * FROM personal_card WHERE personal_card.id = $id";
	}else{
		$infoQuery = "SELECT personal_card.id, 
							personal_card.surname AS surname,  
							personal_card.name AS name, 
							personal_card.patername AS patername, 
							personal_card.name_in_to_form,  
							
							personal_card.birthday AS birthday,  
							countries.name AS ResName,
							personal_card.isMale, 
							personal_card.insurance_number,  
							
							personal_establishment.name AS EstName,  
							personal_card.diploma_start,  

							personal_appointment.name AS AppName,  
							qualification_add.name AS qualification_add, 
							qualification_main.name AS qualification_main, 
							qualification_other.name AS qualification_other, 
							personal_card.isDoctor AS isDoctor,  
							personal_card.tel_number,  
							personal_organizations.name AS OrgName,  
							regions.name AS RegName,  
							
							personal_card.isCowoker AS isCowoker, 
							speciality_doct.name AS speciality_doct, 
							speciality_other.name AS speciality_other, 
							speciality_retraining.name AS speciality_retraining, 
							personal_card.experience_general,  
							personal_card.experiance_special,  
							
							personal_department.name AS DepName,  
							personal_faculty.name AS FacName,  
							personal_card.diploma_number  
					FROM personal_card LEFT JOIN personal_establishment  
						ON personal_card.ee=personal_establishment.id  LEFT JOIN personal_appointment  
						ON personal_card.appointment = personal_appointment.id  LEFT JOIN personal_organizations  
						ON  personal_card.organization = personal_organizations.id  LEFT JOIN countries  
						ON personal_card.citizenship=countries.id  LEFT JOIN regions  
						ON personal_card.region = regions.id  LEFT JOIN personal_department  
						ON personal_card.department = personal_department.id  LEFT JOIN personal_faculty  
						ON personal_card.faculty = personal_faculty.id LEFT JOIN qualification_add  
						ON personal_card.qualification_add = qualification_add.id LEFT JOIN qualification_main  
						ON personal_card.qualification_main = qualification_main.id LEFT JOIN qualification_other  
						ON personal_card.qualification_other = qualification_other.id LEFT JOIN speciality_doct 
						ON personal_card.speciality_doct = speciality_doct.id LEFT JOIN speciality_other  
						ON personal_card.speciality_other = speciality_other.id LEFT JOIN speciality_retraining  
						ON personal_card.speciality_retraining = speciality_retraining.id WHERE personal_card.id = $id";
	}
	
	$result = $mysqli->query($infoQuery) or die ("Ошибка запроса в запросе\n$infoQuery\n " . mysqli_error($mysqli));
	mysqli_close($mysqli);

	if(isset($_GET["selected"]) && $_GET["selected"] === "true"){
		$response = $result->fetch_assoc();
	}else{
		$generalInfo = array();
		$personalInfo = array();
		$profInfo = array();
		if ($result->{"num_rows"} > 0) {
			$responseArray = $result->fetch_assoc();
			foreach ($responseArray as $key => $value) {
				if (in_array($key, $generalFields)) {
					$generalInfo[$key] = $value;
				}else if(in_array($key, $personalFields)){
					$personalInfo[$key] = $value;
				}else if(in_array($key, $profInfoFields)){
					$profInfo[$key] = $value;
				}
			}
			$response["general"] = $generalInfo;
			$response["personal"] = $personalInfo;
			$response["prof"] = $profInfo;
		}
	}
	echo json_encode($response);
?>