<?php 
	ini_set("display_errors", 1);
	require_once("config.php");
	require_once("rb.php");
	
	$mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения к базе данных: " . mysqli_connect_error());
	$mysqli->query("SET NAMES utf8");
	$user_ip = $_SERVER["REMOTE_ADDR"];
	$user_agent = $_SERVER["HTTP_USER_AGENT"];
	$logedUser = $mysqli->query("SELECT * FROM login_users WHERE user_ip = '$user_ip' AND user_agent = '$user_agent'") or die ("Ошибка запроса: " . mysqli_error($mysqli));
	if ($logedUser->{"num_rows"} > 0) {
		session_start();
		$user = $_SESSION["loged_user"];
		$is_cathedra = $user->is_cathedra;
		$depId = $user->dep_id;
		if ($is_cathedra === "1") {
			$cathedraObj = $mysqli->query("SELECT * from cathedras where id=$depId");
			$arr = $cathedraObj->fetch_assoc();
			echo json_encode($arr);
		}else{
			$depObj = $mysqli->query("SELECT * from belmapo_departments where id=$depId");
			$arr = $depObj->fetch_assoc();
			echo json_encode($arr);
		}
	}
	mysqli_close($mysqli);
 ?>