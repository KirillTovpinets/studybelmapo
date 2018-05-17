<?php
    ini_set("display_errors", 1);
   
   require("config.php");
   
   $mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения к базе данных: ". mysqli_connect_erro());
   $mysqli->query("SET NAMES utf8");
   $data = json_decode(file_get_contents("php://input"));
   $courses = $data->selectedCourses;
   $statementList = ["Enter", "Deduct", "SignCertificate", "ExamList", "GEK", "Abstract", "", "", "studList"];
   $docType = $statementList[$data->type];
   $status = 0;
   $currentStatus = 0;
   $currentYear = date("Y");
   $typeId = $courses[0]->Type;
   $query = "SELECT * FROM educType WHERE id = $typeId";
    $typeObj = $mysqli->query($query) or die ("Error in '$query': " . mysqli_error($mysqli));
    $typeArr = $typeObj->fetch_assoc();
    $type = mb_strtolower($typeArr["name"]);
    $typeRelForm = mb_strtolower($typeArr["Relative_form"]);
    $correspondings = array(
		"appointment" => "personal_appointment",
		"organization" => "personal_organizations",
		"department" => "personal_department",
		"establishmentId" => "personal_establishment",
		"facultyId" => "personal_faculty",
		"qualification_add" => "qualification_add",
		"qualification_main" => "qualification_main",
		"qualification_other" => "qualification_other",
		"speciality_doc" => "speciality_doct",
		"speciality_other" => "speciality_other",
		"speciality_retraining" => "speciality_retraining",
		"cityzenship" => "countries",
		"region" => "regions"
    );
    


    if($docType == "Enter"){
        require_once("statements/deduct.php");
        $doc_body = makeDeduct($data, $courses, $mysqli);
    }
    if ($docType == "Deduct") {
        require_once("statements/enter.php");
        $doc_body = makeEnter($data, $courses, $mysqli);
    }else if($docType == "SignCertificate"){
        require_once("statements/certificates.php");
        $doc_body = makeCertificateList($data, $courses, $mysqli);
    }else if($docType == "ExamList"){
        require_once("statements/examList.php");
        $doc_body = makeExamList($data, $courses, $mysqli);
    }else if($docType == "GEK"){
        require_once("statements/gek.php");
        $doc_body = makeGEK($data, $courses, $mysqli);
    }else if($docType == "studList"){ 
        require_once("statements/studList.php");
        $doc_body = makeStudList($data, $courses, $mysqli);
    }
    $file = 'HelloWorld.doc';
    header('Content-Disposition: attachment; filename="' . $file . '"');
    header('Content-Type: application/vnd.msword;format=attachment;');
    header('Content-Transfer-Encoding: binary');
    
    echo "<meta http-equiv=Content-Type content='text/html; charset=utf-8'>";
    echo $doc_body;
?>