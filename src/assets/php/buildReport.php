<?php 
	ini_set("display_errors", 1);
	require_once("config.php");

	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	$data = (array)json_decode(file_get_contents("php://input"));
	
	$query = "SELECT COUNT(*) AS Total FROM arrivals ";
	foreach ($data["tableIds"] as $key => $value) {
		$connectField = "PersonId";
		switch ($value) {
			case 'personal_card' || 'cources' :{
				$connectField = "id";
				break;
			}
		}
		if($value == "cources"){
			$query .= "INNER JOIN $value ON arrivals.CourseId = $value.$connectField ";
		}else if ($value != "arrivals") {
			$query .= "INNER JOIN $value ON arrivals.PersonId = $value.$connectField ";
		}
	}

	$response = array();
	$addAnd = false;
	$values = $data;
	unset($values["tableIds"]);
	$query .= "WHERE";
	$ORquery = $query;
	$SeperateQuery = $query;
	foreach ($values as $key => $value) {
		if ($addAnd && ((is_object($value) && isset($value->id)) || (is_array($value) && count($value) > 0) || (!is_array($value) && !is_object($value) && $value != ""))) {
			$query .= " AND ";
			$ORquery .= " OR ";
		}
		if (is_object($value) && isset($value->id)) {
			$query .= " $key = $value->id ";
			$ORquery .= " $key = $value->id ";
			$varSeparateQuery = $SeperateQuery;
			$varSeparateQuery .= " $key = $value->id ";
			$addAnd = true;
		}
		else if(is_array($value) && count($value) > 0){
			for ($i=0; $i < count($value); $i++) { 
				$val = $value[$i];
				$particularQuery = $SeperateQuery . " $key = $val";
				$result = $mysqli->query($particularQuery) or die ("Error in '$particularQuery': " . mysqli_error($mysqli));
				$arr = $result->fetch_assoc();
				$obj["value"] = $arr["Total"];
				$obj["label"] = "$key-$val";
				array_push($response, $obj);
			}
			$str = implode(" OR $key = ", $value);
			$query .= " ($key = $str)";
			$ORquery .= " ($key = $str)";
			$varSeparateQuery = $SeperateQuery;
			$varSeparateQuery .= " ($key = $str)";
			$addAnd = true;
		}
		else if($value != "" && !is_object($value) && !is_array($value)){
			$query .= " $key = '$value'";
			$ORquery .= " $key = '$value'";
			$varSeparateQuery = $SeperateQuery;
			$varSeparateQuery .= " $key = '$value'";
			$addAnd;
		}else{
			continue;
		}
		$result = $mysqli->query($varSeparateQuery) or die ("Error in '$varSeparateQuery': " . mysqli_error($mysqli));
		$arr = $result->fetch_assoc();
		$obj["value"] = $arr["Total"];
		$obj["label"] = $key;
		array_push($response, $obj);

	}
	$result = $mysqli->query($query) or die ("Error in '$query': " . mysqli_error($mysqli));
	$ORresult = $mysqli->query($ORquery) or die ("Error in '$ORquery': " . mysqli_error($mysqli));
	$array = $result->fetch_assoc();
	// echo $query;
	
	$obj["value"] = $array["Total"];
	$obj["label"] = "total";

	$ORobj["value"] = $array["Total"];
	$ORobj["label"] = "total";

	array_push($response, $obj);
	array_push($response, $ORobj);
	echo json_encode($response);

?>