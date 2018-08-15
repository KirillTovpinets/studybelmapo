<?php 
	ini_set("display_errors", 1);
	require_once("config.php");

	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	$data = (array)json_decode(file_get_contents("php://input"));
	
	$query = "SELECT COUNT(*) AS Total FROM arrivals_zip ";
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
		}else if($value == "cources_zip"){
			$query .= "INNER JOIN $value ON arrivals_zip.CourseId = $value.$connectField ";
		}else if ($value != "arrivals" && $value != "arrivals_zip") {
			$query .= "INNER JOIN $value ON arrivals_zip.PersonId = $value.$connectField ";
		}else if($value == 'arrivals_zip'){

		}
	}
	// if(in_array("arrivals_zip", $data["tableIds"])){
	// 	$query = str_replace("arrivals", "arrivals_zip", $query);
	// }

	$response = array();
	$addAnd = false;
	$values = $data;
	unset($values["tableIds"]);
	$query .= "WHERE";
	$ORquery = $query;
	$SeperateQuery = $query;
	$total = 0;
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
				if($key == "years"){
					$particularQuery = $SeperateQuery . " YEAR(Date) = $val";
				}else{
					$particularQuery = $SeperateQuery . " $key = $val";
				}
				$result = $mysqli->query($particularQuery) or die ("Error in '$particularQuery': " . mysqli_error($mysqli));
				$arr = $result->fetch_assoc();
				$obj["value"] = $arr["Total"];
				$total += $arr["Total"];
				$obj["label"] = "$key-$val";
				array_push($response, $obj);
			}
			if($key == "years"){
				$str = implode(" OR YEAR(Date) = ", $value);
				$query .= " (YEAR(Date) = $str)";
				$ORquery .= " (YEAR(Date) = $str)";	
			}else{
				$str = implode(" OR $key = ", $value);
				$query .= " ($key = $str)";
				$ORquery .= " ($key = $str)";
			}
			$addAnd = true;
			continue;
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
		$total += $arr["Total"];

		$obj["label"] = $key;
		array_push($response, $obj);

	}
	$result = $mysqli->query($query) or die ("Error in '$query': " . mysqli_error($mysqli));
	$array = $result->fetch_assoc();
	
	$Cross["value"] = $array["Total"];
	// $Cross["value"] = $query;
	$Cross["label"] = "Интегрированный";

	$Total["value"] = $total;
	$Total["label"] = "total";

	array_push($response, $Cross);
	array_push($response, $Total);
	echo json_encode($response);

?>