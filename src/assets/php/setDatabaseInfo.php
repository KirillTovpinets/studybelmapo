<?php 
	ini_set("display_errors", 1);
	require_once 'config.php';
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Error: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	
	$data = json_decode(file_get_contents("php://input"));
	$query = "";
	switch ($data->action) {
		case 'edit':
			$query = "update $data->table set $data->field = '$data->name' where id = $data->id";
			break;
		case 'delete':
			$query = "delete from $data->table where id = $data->id";
			break;
		
		default:
			# code...
			break;
	}
	$mysqli->query($query) or die ("Error in '$query': " . mysqli_error($mysqli));
	echo $query;
?>