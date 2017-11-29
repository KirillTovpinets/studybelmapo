<?php 
    unset($_SESSION["loged_user"]);
    $_SESSION["loged_user"] = NULL;
	session_destroy();
	header("Location: /index.html");
 ?>