<?php 
	ini_set("display_errors", 1);
	require_once("rb.php");
	require_once("config.php");
	R::setup("mysql:host=$host;dbname=$dbname", $user, $passwd);
	$admin = R::find("users", "login = ?", array('admin'));
	$adminpass = $_POST["adminpass"];
	if (password_verify($adminpass, $admin["1"]->pass)) {
		$alreadyExist = R::find("users", "login = ?", array($_POST["login"]));
		if($alreadyExist){
			$message = "Этот логин уже зарегистрирован";
			$status = "danger";
			$responce = array('message' => $message, 'stat' => $status );
			echo json_encode($responce);
			exit();
		}
		$user = R::dispense("users");
		$user->login = $_POST["login"];
		$user->pass = password_hash($_POST["password"], PASSWORD_DEFAULT);
		$department = $_POST["department"];
		if($department{0} == "1"){
		    $isCathedra = 1;
		}else{
		    $isCathedra = 0;
		}
        $depId = substr($department, 1);
        $user->isCathedra = $isCathedra;
        $user->depId = $depId;
		R::store($user);
		$message = "Пользователь успешно добавлен";
		$status = "info";
	}else{
		$message = "Неправильный пароль администратора";
		$status = "danger";
	}
	$responce = array('message' => $message, 'stat' => $status);
	echo json_encode($responce);
?>