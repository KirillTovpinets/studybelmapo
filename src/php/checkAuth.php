<?php 
    session_start();
    print_r($_SESSION["loged_user"]);
    if(!isset($_SESSION["loged_user"])){
        echo "index.html";
    }else{
        echo $_SERVER['HTTP_REFERER'];
    }
?>