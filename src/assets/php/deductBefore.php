<?php 
	ini_set("display_errors", 1);
	require_once 'config.php';

	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Error connecting to db: " . mysqli_connect_errorr());
	$mysqli->query("SET NAMES utf8");

	$data = json_decode(file_get_contents("php://input"));

	print_r($data);
	$arrivalId = $data->arrivalId;
	$date = $data->DateGet;
	$orderNum = $data->orderNumber;
	$reason = $data->reason;
	$query = "INSERT INTO `deducts`(`date`, `order_number`, `reason`, `arrival_id`) VALUES ('$date', '$orderNum', '$reason', '$arrivalId')";
	$mysqli->query($query) or die ("Error in query '$query': " . mysqli_error($mysqli));

	$query = "UPDATE `arrivals` SET Status = 4 WHERE id = $arrivalId";
	$mysqli->query($query) or die ("Error in query '$query': " . mysqli_error($mysqli));
	echo "Success";
	mysqli_close($mysqli);
?>