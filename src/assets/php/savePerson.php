<?php 
	ini_set("display_errors", 1);
	require_once("rb.php");
	require_once("config.php");
	session_start();
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	$data = json_decode(file_get_contents("php://input"));
	$isDoctor = 0;
	if (isset($data->sience->_isDoctor)) {
		$isDoctor = $data->sience->_isDoctor == true ? 1 : 0;
	}
	$isCowoker = $data->general->_organization->id == 4530 ? 1 : 0;
	$isMale = $data->personal->_isMale == true ? 1 : 0;
	$educational_establishment = $data->profesional->_educational_establishment->id;
	$cityzenship = $data->personal->_cityzenship->id;
	$appointment = $data->general->_appointment->id;
	$organization = $data->general->_organization->id;
	if (isset($data->personal->_region)) {
		$region = $data->personal->_region->id;
	}else{
		$region = 0;
	}
	$department = $data->general->_department->id;
	$faculty = $data->profesional->_faculty->id;
	$speciality_doc = $data->profesional->_speciality_doc->id;
	$speciality_other = $data->profesional->_speciality_other->id;
	$qualification_main = $data->profesional->_qualification_main->id;
	$qualification_add = $data->profesional->_qualification_add->id;
	$qualification_other = $data->profesional->_qualification_other->id;
	$country = $data->personal->_country->id;
	$city = $data->personal->_city->id;
	$birthday = $data->personal->_birthday;
	$pasport_seria = $data->personal->_pasport_seria;
	$pasport_number = $data->personal->_pasport_number;
	$pasport_date = $data->personal->_pasport_date;
	$pasport_organ = $data->personal->_pasport_organ;
	$insurance_number  = $data->personal->_insurance_number;
	$cityType = $data->personal->_cityType;
	$street = $data->personal->_street;
	$building = $data->personal->_building;
	$tel_number_home = $data->personal->_tel_number_home;
	$tel_number_work = $data->personal->_tel_number_work;
	$tel_number_mobile = $data->personal->_tel_number_mobile;
	$diploma_number = $data->profesional->_diploma_number;
	$experiance_general = $data->profesional->_experiance_general;
	$experiance_special = $data->profesional->_experiance_special;
	$experiance_last = $data->profesional->_experiance_last;
	$mainCategory = $data->profesional->_mainCategory;
	$mainCategory_date = $data->profesional->_mainCategory_date;
	$addCategory = $data->profesional->_addCategory;
	$addCategory_date = $data->profesional->_addCategory_date;
	$diploma_start = $data->profesional->_diploma_start;
	$surname = $data->general->_surname;
	$name = $data->general->_name;
	$patername = $data->general->_patername;
	$nameInDativeForm = $data->general->_nameInDativeForm;
	if (isset($data->sience->_isDoctor)) {
		$isDoctor = $data->sience->_isDoctor;
	}else{
		$isDoctor = 0;
	}
	
	if (isset($data->sience->_researchField)) {
		$researchField = $data->sience->_researchField;
	}else{
		$researchField = 0;
	}
	
	if (isset($data->sience->_statusApproveDate)) {
		$statusApproveDate = $data->sience->_statusApproveDate;
	}else{
		$statusApproveDate = 0;
	}
	
	$isDoctor = 0;
	$mysqli->query("INSERT INTO personal_card (surname, name, patername, birthday, ee, citizenship, diploma_start, appointment, isDoctor, tel_number, organization, region, isMale, isCowoker, experience_general, experiance_special, insurance_number, department, faculty, name_in_to_form, diploma_number) VALUES (
		'$surname', 
		'$name', 
		'$patername', 
		'$birthday', 
		'$educational_establishment',
		'$cityzenship',
		'$diploma_start',
		'$appointment',
		'$isDoctor', 
		'$tel_number_home', 
		'$organization',
		'$region',
		'$isMale', 
		'$isCowoker', 
		'$experiance_general', 
		'$experiance_special', 
		'$insurance_number', 
		'$department',
		'$faculty',
		'$nameInDativeForm', 
		'$diploma_number')") or die ("Ошибка personal_card: " . mysqli_error($mysqli));
	
	$newPerson = $mysqli->query("SELECT MAX(id) AS newId FROM personal_card");
	$newPersonArr = $newPerson->fetch_assoc();
	$newPersonId = $newPersonArr["newId"];
	if (count($data->profesional->_speciality_retraining) > 0) {
		foreach ($data->profesional->_speciality_retraining as $key => $item) {
			$speciality_retraining = $item->_name->id;
			$retraining_diploma_number = $item->_diploma_number;
			$retraining_diploma_start = $item->_diploma_start;
			if ($speciality_retraining != "" &&
				$retraining_diploma_number != "" &&
				$retraining_diploma_start != "") {
				$mysqli->query("INSERT INTO personal_retrainings(`personId`, `specialityId`, `diploma_number`,`diploma_start`) VALUES ('$newPersonId', '$speciality_retraining','$retraining_diploma_number','$retraining_diploma_start')") or die ("Error personal_retrainings: " . mysqli_error($mysqli));
			}
		}
	}
	$mysqli->query("INSERT INTO `personal_prof_info`(`PersonId`, `establishmentId`, `facultyId`, `diploma_number`, `speciality_doc`, `speciality_other`, `experiance_general`, `experiance_special`, `experiance_last`, `qualification_main`, `qualification_add`, `qualification_other`, `main_category`, `main_category_date`, `add_category`, `add_category_date`, `diploma_start`) VALUES (
		'$newPersonId',
		'$educational_establishment',
		'$faculty',
		'$diploma_number',
		'$speciality_doc',
		'$speciality_other',
		'$experiance_general', 
		'$experiance_special',
		'$experiance_last', 
		'$qualification_main',
		'$qualification_add',
		'$qualification_other',
		'$mainCategory',
		'$mainCategory_date',
		'$addCategory',
		'$addCategory_date',
		'$diploma_start'
	)") or die ("Ошибка personal_prof_info: " . mysqli_error($mysqli));
	$mysqli->query("INSERT INTO `personal_private_info`(`PersonId`, `birthday`, `isMale`, `cityzenship`, `pasport_seria`, `pasport_number`, `pasport_date`, `pasport_organ`, `insurance_number`, `city_type`, `city`, `street`, `region`, `building`, `country`, `tel_number_home`, `tel_number_work`, `tel_number_mobile`) VALUES (
		'$newPersonId',
		'$birthday',
		'$isMale', 
		'$cityzenship',
		'$pasport_seria',
		'$pasport_number',
		'$pasport_date',
		'$pasport_organ',
		'$insurance_number', 
		'$cityType',
		'$city',
		'$street',
		'$region',
		'$building',
		'$country',
		'$tel_number_home',
		'$tel_number_work',
		'$tel_number_mobile'
	)") or die ("Ошибка personal_private_info: " . mysqli_error($mysqli));
	if (isset($data->sience->_isDoctor)) {
		$isDoctor = $data->sience->_isDoctor;
		$researchField = $data->sience->_researchField;
		$statusApprove_date = $data->sience->_statusApprove_date;
		$statusSpeciality = $data->sience->_statusSpeciality;
		$statusCode = $data->sience->_statusCode;
		$patentNumber = $data->sience->_patentNumber;
		$publicationsNumb = $data->sience->_publicationsNumb;
		$monografsNumb = $data->sience->_monografsNumb;
		$ordenNumb = $data->sience->_ordenNumb;
		$medalNumb = $data->sience->_medalNumb;
		$gramotaNumb = $data->sience->_gramotaNumb;
		$query = "INSERT INTO `personal_sience`(`pesron_id`, `status`, `sience_field`, `start_date`, `speciality`, `code`, `patents`, `publications`, `monographs`, `ordens`, `medals`, `gramots`) VALUES ('$newPersonId','$isDoctor','$researchField','$statusApprove_date','$statusSpeciality','$statusCode','$patentNumber','$publicationsNumb','$monografsNumb','$ordenNumb','$medalNumb','$gramotaNumb')";
			$mysqli->query($query) or die ("Error in '$query': " . mysqli_error($mysqli));
	}
	$date = date("Y-m-d");
	$Loged_user = $_SESSION["loged_user"];
	$cathedraLoged = false;
	$departmentLoged = false;
	$cathedraId = $Loged_user->dep_id;
	$cathedraObj = $mysqli->query("SELECT * FROM cathedras WHERE id = $cathedraId") or die ("Ошибка запроса 'SELECT * FROM cathedra WHERE id = $cathedraId': " . mysqli_error($mysqli));
	$newPersonIdObj = $mysqli->query("SELECT MAX(id) AS newPersonId FROM personal_card");
	$newPersonIdArr = $newPersonIdObj->fetch_assoc();
	$newPersonId = $newPersonIdArr["newPersonId"];
	$cathedraArr = $cathedraObj->fetch_assoc();
	$faculty = $cathedraArr["facultId"];
	if (isset($data->_belmapo_paymentData)) {
		$paymentInfo = $data->_belmapo_paymentData;
	}else{
		$paymentInfo = "";
	}
	$courseObj = $mysqli->query("SELECT Start FROM cources where id = $data->_belmapo_course");
	$courseArr = $courseObj->fetch_assoc();
	$courseDate = $courseArr["Start"];
	$mysqli->query("INSERT INTO arrivals (date,CourseId, ResidPlace, FormEduc, Dic_count, Status, PersonId) VALUES (
		'$courseDate', 
		'$data->_belmapo_course', 
		'$data->_belmapo_residense', 
		'$data->_belmapo_educForm', 
		'$paymentInfo', 
		'1', 
		'$newPersonId')") or die ("Ошибка arrivals: " . mysqli_error($mysqli));
	mysqli_close($mysqli);
	echo "Слушатель зачислен";
?>