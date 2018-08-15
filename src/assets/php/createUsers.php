<?php
    ini_set("display_errors", 1);
    require_once "assets/php/config.php";

    $mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Error connecting to db: " . mysqli_connect_errorr());
    $mysqli->query("SET NAMES utf8");
    
    $cathResult = $mysqli->query("SELECT id FROM cathedras");

    while($row = $cathResult->fetch_assoc()){
        $id = $row["id"];

        $login = "belmapo_$id";
        $pass = "cafedra_$id";

        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $isCathedra = 1;

        $mysqli->query("INSERT INTO `users`(`login`, `pass`, `is_cathedra`, `dep_id`) VALUES ('$login', '$hash', '$isCathedra', '$id')");
    }
    mysqli_close($mysqli);
    echo "DONE!!!!!!!!!!!!!!!";
?>