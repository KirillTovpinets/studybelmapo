<?php
	ini_set("display_errors", 1);
    require_once("rb.php");
    require_once("config.php");
    R::setup("mysql:host=$host;dbname=$dbname", $user, $passwd);
    $request = json_decode(file_get_contents('php://input'));
	$login = $request->log;
	$pass =  $request->pass;
	$user = R::findOne("users", "login = ?", array($login));
	if($user){
	    if(password_verify($pass, $user->pass)){
	    	session_start();
	    	$now = date("Y-m-d H:i:s");
	    	$loginInfo = R::dispense("loginusers");
	    	$loginInfo->user_id = $user->id;
	    	$loginInfo->user_ip = $_SERVER["REMOTE_ADDR"];
	    	$loginInfo->user_agent = $_SERVER["HTTP_USER_AGENT"];
	    	$loginInfo->time = $now;
	    	R::store($loginInfo);
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