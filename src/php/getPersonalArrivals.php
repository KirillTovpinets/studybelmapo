<?php 
	ini_set("display_errors", 1);
	require_once("config.php");
	require_once("rb.php");
	R::setup("mysql:host=$host;dbname=$dbname", $user, $passwd);

	$personId = $_GET["id"];

	$person = R::findOne("personal_card", "id = ?", array($personId));

	if($person){
		$arrivals = R::find("arrivals_zip", "PersonLink = ? ", array($person->unique_Id));
		echo json_encode($arrivals);
	}
 ?>