<?php 
	ini_set("display_errors", 1);
	require_once("config.php");

	function getSqlObj($tableName, $mysqli){
		$result = $mysqli->query("SELECT *, name AS value FROM $tableName ORDER BY value ASC");
		return $result;
	}
	function getArray($SqlObj){
		$newArray = array();
		while ($row = $SqlObj->fetch_assoc()) {
			if (isset($row["Id"]) && $row["Id"] == 0) {
				continue;
			}
			if (isset($row["id"]) && $row["id"] == 0) {
				continue;
			}
			array_push($newArray, $row);
		}
		return $newArray;
	}

	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");

	if (isset($_GET["marks"])) {
		$marksObj = getSqlObj("marks", $mysqli);
		$marksArr = getArray($marksObj);
		
		echo json_encode($marksArr);
		return;
	}
	if (isset($_GET["type"])) {
		$obj = getSqlObj("educType", $mysqli);
		$arr = getArray($obj);
		
		echo json_encode($arr);
		return;
	}
	$estObj = getSqlObj("personal_establishment", $mysqli);
	$residObj = getSqlObj("countries", $mysqli);
	$appObj = getSqlObj("personal_appointment", $mysqli);
	$orgObj = getSqlObj("personal_organizations", $mysqli);
	$regObj = getSqlObj("regions", $mysqli);
	$belmapo_residenceObj = getSqlObj("Residence", $mysqli);
	$depObj = getSqlObj("personal_department", $mysqli);
	$facObj = getSqlObj("personal_faculty", $mysqli);

	$facBelMAPOObj = getSqlObj("faculties", $mysqli);
	$cathBelMAPOObj = getSqlObj("cathedras", $mysqli);
	$coursesBelMAPOObj = getSqlObj("cources", $mysqli);
	$formBelMAPOObj = getSqlObj("formofeducation", $mysqli);
	$educTypeBelMAPOObj = getSqlObj("educType", $mysqli);

	$specialityDocObj = getSqlObj("speciality_doct", $mysqli);
	$specialityRetrObj = getSqlObj("speciality_retraining", $mysqli);
	$specialityOtherObj = getSqlObj("speciality_other", $mysqli);

	$qualificationMainObj = getSqlObj("qualification_main", $mysqli);
	$qualificationAddObj = getSqlObj("qualification_add", $mysqli);
	$qualificationOtherObj = getSqlObj("qualification_other", $mysqli);
	$cities = getSqlObj("cities", $mysqli);

	$estArr = getArray($estObj);
	$residArr = getArray($residObj);
	$appArr = getArray($appObj);
	$orgArr = getArray($orgObj);
	foreach ($orgArr as $key => $value) {
		if (isset($value["location_cntr"]) && !empty($value["location_cntr"])) {
			$countrId = $value["location_cntr"];
			$result = $mysqli->query("SELECT name FROM countries WHERE id = $countrId") or die ("Error in 'SELECT name FROM countries WHERE id = $countrId': " . mysqli_error($mysqli));
			$arr = $result->fetch_assoc();
			$country = $arr["name"];

			if (isset($value["location_city"]) && !empty($value["location_city"])) {
				$cityId = $value["location_city"];
				$result = $mysqli->query("SELECT name FROM cities WHERE id = $cityId") or die ("Error in 'SELECT name FROM city WHERE id = $cityId': " . mysqli_error($mysqli));
				$arr = $result->fetch_assoc();
				$city = $arr["name"];
				$value["value"] = $value["value"] . ' (' . $country . ', ' . $city .')';
			}else{
				$value["value"] = $value["value"] . ' (' . $country . ')';
			}
		}
		$orgArr[$key] = $value;
	}
	$regArr = getArray($regObj);
	$belmapo_residenceArr = getArray($belmapo_residenceObj);
	$depArr = getArray($depObj);
	$facArr = getArray($facObj);

	$facBel = getArray($facBelMAPOObj);
	$cathBel = getArray($cathBelMAPOObj);
	$coursesBel = getArray($coursesBelMAPOObj);
	$formBel = getArray($formBelMAPOObj);
	$educTypeBel = getArray($educTypeBelMAPOObj);

	$specialityDocArr = getArray($specialityDocObj);
	$specialityRetrArr = getArray($specialityRetrObj);
	$specialityOtherArr = getArray($specialityOtherObj);

	$qualificationMainArr = getArray($qualificationMainObj);
	$qualificationAddArr = getArray($qualificationAddObj);
	$qualificationOtherArr = getArray($qualificationOtherObj);
	$citiesArr = getArray($cities);
	foreach ($citiesArr as $key => $value) {
		if (isset($value["district"])) {
			$disctrictId = $value["district"];
			$result = $mysqli->query("SELECT name FROM bel_districts WHERE id = $disctrictId") or die ("Error in 'SELECT name FROM bel_districts WHERE id = $disctrictId': " . mysqli_error($mysqli));
			$arr = $result->fetch_assoc();
			$district = $arr["name"];
			if(!empty($district)){
				$value["value"] = $value["value"] . ' (' . $district . ' район)';
			}
		}
		$citiesArr[$key] = $value;
	}

	$response['estArr'] = $estArr;
	$response['residArr'] = $residArr;
	$response['appArr'] = $appArr;
	$response['orgArr'] = $orgArr;
	$response['regArr'] = $regArr;
	$response['depArr'] = $depArr;
	$response['facArr'] = $facArr;
	$response['belmapo_residence'] = $belmapo_residenceArr;

	$response['facBel'] = $facBel;
	$response['cathBel'] = $cathBel;
	$response['coursesBel'] = $coursesBel;
	$response['formBel'] = $formBel;
	$response['educTypeBel'] = $educTypeBel;

	$response['specialityDocArr'] = $specialityDocArr;
	$response['specialityRetrArr'] = $specialityRetrArr;
	$response['specialityOtherArr'] = $specialityOtherArr;
	$response['qualificationMainArr'] = $qualificationMainArr;
	$response['qualificationAddArr'] = $qualificationAddArr;
	$response['qualificationOtherArr'] = $qualificationOtherArr;
	$response['citiesArr'] = $citiesArr;
	echo json_encode($response);
?>