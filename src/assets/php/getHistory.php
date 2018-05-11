<?php 
	ini_set("display_errors", 1);
	require_once("config.php");
	
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения к базе " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
    $personId = $_GET["id"];
    
	$query = "SELECT history_of_changes.field, history_of_changes.old_value, history_of_changes.new_value, history_of_changes.date, cathedras.name FROM history_of_changes INNER JOIN users ON history_of_changes.userId = users.id INNER JOIN cathedras ON users.dep_id = cathedras.id WHERE personId = $personId";
	$result = $mysqli->query($query) or die ("Ошибка в запросе '$query': " . mysqli_error($mysqli));

	$response = array();
	while ($row = $result->fetch_assoc()) {
        $field = $row["field"];
        $oldVal = $row["old_value"];
        $newVal = $row["new_value"];
        if(array_key_exists($field, CONNECTIONS)){
            $table = CONNECTIONS[$field];
            $newQuery = "SELECT name FROM $table WHERE id = $newVal";
            $oldQuery = "SELECT name FROM $table WHERE id = $oldVal";
            $newObj = $mysqli->query($newQuery) or die ("Error in '$newQuery': " . mysqli_error($mysqli));
            $newArr = $newObj->fetch_assoc();
            $row["new_value"] = $newArr["name"];
            $oldObj = $mysqli->query($oldQuery) or die ("Error in '$oldQuery': " . mysqli_error($mysqli));
            $oldArr = $oldObj->fetch_assoc();
            $row["old_value"] = $oldArr["name"];
        }
        
		array_push($response, $row);
	}
	mysqli_close($mysqli);
	echo json_encode($response);
 ?>