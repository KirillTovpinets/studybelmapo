<?php 
	ini_set("display_errors", 1);
	require_once("config.php");
	require_once("rb.php");
	session_start();

	$logedUser = $_SESSION["loged_user"];
	$logedUserId = $logedUser["id"];
	$data = json_decode(file_get_contents("php://input"));
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	$personId = $data->new->general->id;
	$new = (array)$data->new;
	$old = (array)$data->old;
	$personal = array("appointment", "organization", "department");
	$private = array("birthday", "isMale", "cityzenship", "	pasport_seria", "pasport_number", "pasport_date", "pasport_organ", "insurance_number", "city_type", "city", "street", "region", "building", "flat", "country", "tel_number_home", "tel_number_work", "tel_number_mobile");
	$prof = array("establishmentId", "facultyId","diploma_number","speciality_doc","speciality_retraining","speciality_other","experiance_general","experiance_special","experiance_last","qualification_main","qualification_add","qualification_other","main_category","main_category_date","add_category","add_category_date","diploma_start");
	// print_r($data);
	foreach ($new as $key => $value) {
		$new[$key] = (array)$value;
		$old[$key] = (array)$old[$key];
		foreach ($new[$key] as $keyValue => $valueValue) {
			if(is_object($valueValue)){
				$new[$key][$keyValue] = (array)$valueValue;
			}
		}
		$diff = array();
		$diff = array_diff($new[$key], $old[$key]);
		print_r($diff);
		if (!empty($diff)) {
			foreach ($diff as $keyDiff => $valueDiff) {
				$oldKey = "$key";
				$oldKeyDiff = "$keyDiff";
				$fromArray = "";
				if(in_array($keyDiff, $personal)){
					$fromArray = "personal_card";
				}else if(in_array($keyDiff, $private)){
					$fromArray = "personal_private_info";
				}else if(in_array($keyDiff, $prof)){
					$fromArray = "personal_prof_info";
				}
				$oldValue = $old[$oldKey]["_".$oldKeyDiff];
				if (is_array($valueDiff)) {
					$newValue = $valueDiff["id"];
				}else{
					$newValue = $valueDiff;
				}
				if($newValue == ""){
					$newValue = 0;
				}
				$today = date("Y-m-d");
				$oldQuery = "SELECT $keyDiff AS oldId FROM $fromArray WHERE id = $personId";
				$oldValueIdObj = $mysqli->query($oldQuery) or die ("Ошибка в '$oldQuery': " . mysqli_error($mysqli));
				$oldValueIdArr = $oldValueIdObj->fetch_assoc();
				$oldId = $oldValueIdArr["oldId"];
				$query = "INSERT INTO `history_of_changes`(`userId`, `personId`, `field`, `old_value`, `new_value`, `date`) VALUES ('$logedUserId', '$personId', '$keyDiff', '$oldId', '$newValue', '$today')";
				$result = $mysqli->query($query) or die ("Ошибка в '$query': " . mysqli_error($mysqli));
			}
		}
	}
	mysqli_close($mysqli);
	echo "Изменения успешно внесены";
?>