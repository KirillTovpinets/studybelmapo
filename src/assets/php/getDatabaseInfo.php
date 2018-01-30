<?php 
	ini_set("display_errors", 1);
	require_once 'config.php';
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Error: " . mysqli_connect_error());

	$param = $_GET["param"];

	switch ($param) {
		case 'schema':
			$query = "SHOW TABLES";
			break;
		case 'tablecontent':
			$table = $_GET["table"];
			$query = "SELECT * FROM $table";
	}

	$result = $mysqli->query($query) or die ("Error in '$query': " . mysqli_error($mysqli));
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
	echo json_encode($response);
?>