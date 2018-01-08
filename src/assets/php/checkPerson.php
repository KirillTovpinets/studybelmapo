<?php 
	ini_set("display_errors", 1);
	require_once("config.php");
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подклчюения: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	$data = json_decode(file_get_contents("php://input"));
	$name = $data->general->_name;
	$surname = $data->general->_surname;
	$patername = $data->general->_patername;
	$nameInDativeForm = $data->general->_nameInDativeForm;
	$appointment = $data->general->_appointment->id;
	$organization = $data->general->_organization->id;
	$department = $data->general->_department->id;
	$result = $mysqli->query("SELECT * FROM personal_card WHERE name LIKE '$name' AND surname LIKE '$surname' AND patername LIKE '$patername'") or die ("Error: " . mysqli_error($mysqli));
	if ($result->{"num_rows"} > 0) {
		$id = 0;
		while ($row = $result->fetch_assoc()) {
			$id = $row["id"];
		}
		$correspondings = array(
			"appointment" => "personal_appointment.",
			"organization" => "personal_organizations",
			"department" => "personal_department",
			"establishmentId" => "personal_establishment",
			"facultyId" => "personal_faculty",
			"qualification_add" => "qualification_add",
			"qualification_main" => "qualification_main",
			"qualification_other" => "qualification_other",
			"speciality_doc" => "speciality_doct",
			"speciality_other" => "speciality_other",
			"speciality_retraining" => "speciality_retraining",
			"citizenshi" => "ountries",
			"region" => "regions"
		);
		//Общая информация
		$infoQuery = "SELECT personal_card.id, 
							personal_card.surname AS surname,  
							personal_card.name AS name, 
							personal_card.patername AS patername, 
							personal_card.name_in_to_form AS nameInDativeForm,  
							personal_appointment.name AS appointment,  
							personal_card.isDoctor AS isDoctor,  
							personal_organizations.name AS organization,  
							personal_card.isCowoker AS isCowoker, 
							personal_department.name AS department
					FROM personal_card LEFT JOIN personal_appointment  
						ON personal_card.appointment = personal_appointment.id  LEFT JOIN personal_organizations  
						ON  personal_card.organization = personal_organizations.id LEFT JOIN personal_department  
						ON personal_card.department = personal_department.id WHERE personal_card.id = $id";
		//Проф информация
		$profInfoQuery = "SELECT personal_establishment.name AS educational_establishment,  
								personal_prof_info.diploma_start,  
								qualification_main.name AS qualification_main, 
								qualification_other.name AS qualification_other, 
								qualification_add.name AS qualification_add, 
								speciality_doct.name AS speciality_doc, 
								speciality_other.name AS speciality_other, 
								speciality_retraining.name AS speciality_retraining, 
								personal_prof_info.experiance_general,  
								personal_prof_info.experiance_special,
								personal_prof_info.experiance_last,  
								personal_faculty.name AS faculty,  
								personal_prof_info.diploma_number,
								personal_prof_info.main_category AS mainCategory,
								personal_prof_info.main_category_date AS mainCategory_date,
								personal_prof_info.add_category AS addCategory,
								personal_prof_info.add_category_date AS addCategory_date  
						FROM personal_prof_info LEFT JOIN personal_establishment
								ON personal_prof_info.establishmentId = personal_establishment.id  LEFT JOIN personal_faculty  
								ON personal_prof_info.facultyId = personal_faculty.id LEFT JOIN qualification_add  
								ON personal_prof_info.qualification_add = qualification_add.id LEFT JOIN qualification_main  
								ON personal_prof_info.qualification_main = qualification_main.id LEFT JOIN qualification_other  
								ON personal_prof_info.qualification_other = qualification_other.id LEFT JOIN speciality_doct 
								ON personal_prof_info.speciality_doc = speciality_doct.id LEFT JOIN speciality_other  
								ON personal_prof_info.speciality_other = speciality_other.id LEFT JOIN speciality_retraining  
								ON personal_prof_info.speciality_retraining = speciality_retraining.id WHERE personal_prof_info.PersonId = $id";
		//Личная информация
		$privateInfoQuery = "SELECT personal_private_info.birthday AS birthday,  
									countries.name AS cityzenship,
									personal_private_info.isMale,
									personal_private_info.city_type AS cityType, 
									personal_private_info.city, 
									personal_private_info.street, 
									personal_private_info.region, 
									personal_private_info.building,
									personal_private_info.flat, 
									personal_private_info.country, 
									personal_private_info.pasport_seria, 
									personal_private_info.pasport_number, 
									personal_private_info.pasport_date, 
									personal_private_info.pasport_organ,  
									personal_private_info.insurance_number,  
									personal_private_info.tel_number_mobile,
									personal_private_info.tel_number_home,  
									personal_private_info.tel_number_work,
									regions.name AS region
							FROM personal_private_info LEFT JOIN countries  
									ON personal_private_info.cityzenship=countries.id LEFT JOIN regions  
									ON personal_private_info.region = regions.id WHERE personal_private_info.PersonId = $id";
		$getRetrainings = "SELECT personal_retrainings.id, personal_retrainings.personId, speciality_retraining.name, personal_retrainings.diploma_number, personal_retrainings.diploma_start FROM `personal_retrainings` INNER JOIN speciality_retraining ON personal_retrainings.specialityId = speciality_retraining.id WHERE personal_retrainings.personId = $id";
		
		$result = $mysqli->query($infoQuery) or die ("Ошибка запроса в запросе\n$infoQuery\n " . mysqli_error($mysqli));
		
		$resultProf = $mysqli->query($profInfoQuery) or die ("Ошибка запроса в запросе\n$profInfoQuery\n " . mysqli_error($mysqli));
		$resultPrivate = $mysqli->query($privateInfoQuery) or die ("Ошибка запроса в запросе\n$privateInfoQuery\n " . mysqli_error($mysqli));
		$resultRetraining = $mysqli->query($getRetrainings) or die ("Ошибка запроса в запросе\n$getRetrainings\n " . mysqli_error($mysqli));
		$response["general"] = $result->fetch_assoc();
		$response["personal"] = $resultPrivate->fetch_assoc();
		$response["profesional"] = $resultProf->fetch_assoc();
			$retrainings = array();
		if ($resultRetraining->{"num_rows"} > 0) {
			while ($row = $resultRetraining->fetch_assoc()) {
				array_push($retrainings, $row);
			}
			$response['profesional']["speciality_retraining"] = $retrainings;
		}else{
			$response['profesional']["speciality_retraining"] = array();
		}
		$updateData = "SELECT * FROM history_of_changes WHERE personId = $id ORDER BY id ASC";
		$updateObj = $mysqli->query($updateData) or die ("Error in '$updateData': " . mysqli_error($mysqli));
		while ($row = $updateObj->fetch_assoc()) {
			foreach ($response as $key => $value) {
				foreach ($value as $keyIn => $valueIn) {
					if ($keyIn == $row["field"]) {
						$newValue = $row["new_value"];
						foreach ($correspondings as $keyOut => $valueOut) {
							if ($keyOut == $keyIn) {
								$table = $valueOut;
								$query = "SELECT name FROM $table WHERE id = $newValue";
								$result = $mysqli->query($query) or die ("Error in '$query': " . mysqli_error($mysqli));
								$newNameArr = $result->fetch_assoc();
								$newName = $newNameArr["name"];
								$value[$keyIn] = $newName;
								$response[$key] = $value;
							}
						}
					}
				}
			}
		}
		echo json_encode($response);
	}else{
		echo "Not exist";
	}
	mysqli_close($mysqli);
?>