<?php 
	ini_set("display_errors", 1);
	require_once 'config.php';
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Error: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	$param = $_GET["param"];
	$query = "";
	$limit = "";
	if (isset($_GET["limit"])) {
		$limitatioin = $_GET["limit"];
		$offset = $_GET["offset"];
		$limit = " LIMIT $limitatioin OFFSET $offset";
	}
	switch ($param) {
		case 'schema':
			$query = "SHOW TABLES";
			$limit = "";
			break;
		case 'tablecontent':
			$table = $_GET["table"];
			$query = "SELECT * FROM $table";
			break;
		case 'fieldcontent':
			$keys = array(
				"CourseId" => "cources",
				"ResidPlace" => "residence",
				"FormEduc" => "formofeducation",
				"Status" => "status",
				"PersonId" => "personal_card",
				"facultId" => "faculties"
			);
			$table = $_GET["table"];
			$field = $_GET["field"];
			$value = $_GET["row"];
			$anotherTable = $keys[$field];
			$query = "SELECT DISTINCT * FROM (SELECT $anotherTable.name FROM $table INNER JOIN $anotherTable ON $table.$field = $anotherTable.id WHERE $anotherTable.id = $value) AS total";
			break;
	}

	$result = $mysqli->query($query . $limit) or die ("Error in '$query $limit': " . mysqli_error($mysqli));
	$respond = array();

	while ($row = $result->fetch_assoc()) {
		if (isset($row["Tables_in_$dbname"])) {
			$value = $row["Tables_in_$dbname"];
		}else{
			$value = $row;
		}
		array_push($respond, $value);
	}
	
	$response = array();
	$response[$param] = $respond;

	if ($limit != "") {
		$resultTotal = $mysqli->query("SELECT COUNT(*) AS Total FROM ($query) AS total") or die ("Error in 'SELECT COUNT(*) AS Total FROM ($query) AS total': " . mysqli_error($mysqli));
		$total = $resultTotal->fetch_assoc();
		$response["Total"] = $total["Total"];
	}
	echo json_encode($response);
?>