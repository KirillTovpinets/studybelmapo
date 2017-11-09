<?php
	ini_set("display_errors", 1);
    require_once("rb.php");
    require_once("config.php");
    R::setup("mysql:host=$host;dbname=$dbname", $user, $passwd);
    $mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения: " . mysqli_connect_error());
    $request = json_decode(file_get_contents('php://input'));
	$login = $request->log;
	$pass =  $request->pass;
	$user = R::findOne("users", "login = ?", array($login));
	if($user){
	    if(password_verify($pass, $user->pass)){
	    	session_start();
	    	$_SESSION["loged_user"] = $user;
	    	$message = "success";
	    }else{
	        $message = "pass";
	    }
	}else{
	    $message = "login";
	}
	echo $message
?>