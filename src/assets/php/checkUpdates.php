<?php 
    ini_set("display_errors", 1);
    require_once("rb.php");
    require_once("config.php");
    session_start();
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подклчюения: " . mysqli_connect_error());
    $mysqli->query("SET NAMES utf8");
    $logedUser = $_SESSION["loged_user"];
    $userId = $logedUser->id;

	$data = checkUpdate($userId, $mysqli);
	mysqli_close($mysqli);
    
    echo $data;
?>