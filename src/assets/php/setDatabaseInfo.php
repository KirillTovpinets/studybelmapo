<?php 
	ini_set("display_errors", 1);
	require_once 'config.php';
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Error: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	
	$data = (array)json_decode(file_get_contents("php://input"));
	$query = "";
	switch ($data["action"]) {
		case 'edit':
			$table = $data["table"];
			$fields = $data["field"];
			for ($i=0; $i < count($fields); $i++) { 
				$field = $fields[$i];
				$value = $data[$fields[$i]];
				if (is_object($value)) {
					$value = $value->id;
				}
				$id = $data["id"];
				$query .= "update $table set $field = '$value' where id = $id;";
			}
			break;
		case 'delete':
			print_r($data);
			$table = $data["table"];
			$id = $data["id"];
			$query = "delete from $table where id = $id";
			break;
		case 'add':
			$table = $data["table"];
			$fields = $data["fields"];
			$query = "INSERT INTO $table(";
			for ($i=0; $i < count($fields); $i++) { 
				$field = $fields[$i]->name;
				if ($field == "id") {
					continue;
				}
				$query .= "$field";
				if ($i != count($fields) - 1 ) {
					$query .= ", ";
				}
			}
			$query .= ") VALUES (";
			print_r($data);
			for ($i=0; $i < count($fields); $i++) { 
				if ($fields[$i]->name != 'id') {
					$value = $data[$fields[$i]->name];
					$query .= "'$value'";
				}
				if (($i != count($fields) - 1) && $i != 0){
					$query .= ", ";
				}
			}
			$query .= ")";
			echo $query;
			break;
		default:
			# code...
			break;
	}
	$mysqli->query($query) or die ("Error in '$query': " . mysqli_error($mysqli));
	echo $query;
?>