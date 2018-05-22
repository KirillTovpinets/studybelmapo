<?php

    function makeStudList($data, $courses, $mysqli){
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
        $additionalField = $data->statementInfo;
        $form = 0;
        if(isset($data->form) && $data->form != 0){
            $form = $data->form;
        }
        $doc_body = "<html>
                        <style>
                            body, p, ol, ul{
                                font-size:14pt;
                            }
                            p, ol{
                                text-align:left;
                                text-indent: 1.25cm;
                                margin-top:0pt;
                            }
                            table{
                                border-collapse: collapse;
                            }
                            table tr td, th{
                                border: 1px solid black;
                            }
                        </style>";
        for($i = 0; $i < count($courses); $i++){
            
            $number = $courses[$i]->Number;
            $id = $courses[$i]->id;
            $name = $courses[$i]->name;
            $start = explode("-", $courses[$i]->Start);
            $finish = explode("-", $courses[$i]->Finish);

            $courseStart = $start[2] . "." . $start[1] . "." . $start[0];
            $courseFinish = $finish[2] . "." . $finish[1] . "." . $finish[0];

            $selectAddField = "";
            $fromConnections = "";
            for($j = 0; $j < count($additionalField); $j++){
                switch($additionalField[$j]){
                    case 'appointment';
                    case 'department': {
                        $table = CONNECTIONS[$additionalField[$j]];
                        $selectAddField .= ", $table.name AS " . $additionalField[$j];
                        $fromConnections .= " LEFT JOIN $table ON personal_card." . $additionalField[$j] . " = $table.id" ;
                        break;
                    }
                    case 'organization': {
                        $table = CONNECTIONS[$additionalField[$j]];
                        $selectAddField .= ", concat(organization_forms.short_name, ' &laquo;', $table.name, '&raquo;')  AS " . $additionalField[$j];
                        $fromConnections .= " LEFT JOIN $table ON personal_card." . $additionalField[$j] . " = $table.id LEFT JOIN organization_forms ON organization_forms.id = $table.form";
                        break;
                    }
                    case 'establishmentId':{
                        $table = CONNECTIONS[$additionalField[$j]];
                        $selectAddField .= ", $table.name AS " . $additionalField[$j];
                        $fromConnections .= " INNER JOIN personal_prof_info ON personal_card.id = personal_prof_info.PersonId LEFT JOIN $table ON $table.id = personal_prof_info." . $additionalField[$j];
                        break;
                    }
                    case 'cityzenship';
                    case 'tel_number_mobile';
                    case 'tel_number_work': {
                        if(strpos($fromConnections, "INNER JOIN personal_private_info") === false ){
                            $fromConnections .= " INNER JOIN personal_private_info ON personal_card.id = personal_private_info.PersonId";
                        }
                        $table = CONNECTIONS[$additionalField[$j]];
                        if(!empty($table)){
                            $selectAddField .= ", $table.name AS " . $additionalField[$j];
                            $fromConnections .= " LEFT JOIN $table ON $table.id = personal_private_info." . $additionalField[$j];
                        }else{
                            $selectAddField .= ", personal_private_info.`" . $additionalField[$j] . "`";
                        }
                        break;
                    }
                    case 'Dic_count': {
                        $selectAddField .= ", arrivals." . $additionalField[$j];
                    }
                }
            }
            $addCondition = "";
            if($form != 0){
                if($form == 1){
                    $addCondition = " AND arrivals.FormEduc = 1";
                }else{
                    $addCondition = " AND arrivals.FormEduc = 2";
                }
            }
            $query = "SELECT personal_card.id, personal_card.name, personal_card.surname, personal_card.patername, personal_card.name_in_to_form $selectAddField FROM personal_card INNER JOIN arrivals ON personal_card.id = arrivals.PersonId $fromConnections WHERE arrivals.CourseId = $id $addCondition ORDER BY personal_card.name_in_to_form ASC";

            $studObj = $mysqli->query($query) or die("Error in '$query': ". mysqli_error($mysqli));
            $doc_body .= "<p style='text-align:center;'> Курс №$number &laquo;$name&raquo;</p>";
            $doc_body .= "<table><tr>";
            $doc_body .= "<th>№ п/п</th>";
            $doc_body .= "<th>Фамилия, имя, отчество</th>";

            for($j = 0; $j < count($additionalField); $j++){
                if($additionalField[$j] == "Start-Finish"){
                    $doc_body .= "<th>Дата проведения обучения</th>";    
                    continue;
                }
                $label = LABELS[$additionalField[$j]];
                $doc_body .= "<th>$label</th>";
            }
            
            $doc_body .= "</tr>";
            $index = 1;
            $studList = array();

            while($student = $studObj->fetch_assoc()){
                $id = $student["id"];
                $updateData = "SELECT * FROM history_of_changes WHERE personId = $id ORDER BY id ASC";
                $updateObj = $mysqli->query($updateData) or die ("Error in '$updateData': " . mysqli_error($mysqli));
                while ($updateRow = $updateObj->fetch_assoc()) {
                    foreach ($student as $key => $value) {
                        if ($key == $updateRow["field"]) {
                            $newValue = $updateRow["new_value"];
                            if (!is_numeric($newValue)) {
                                $student[$key] = $newValue;
                            }else{
                                foreach ($correspondings as $keyOut => $valueOut) {
                                    if ($keyOut == $key) {
                                        $table = $valueOut;
                                        $query = "SELECT name FROM $table WHERE id = $newValue";
                                        $result = $mysqli->query($query) or die ("Error in '$query': " . mysqli_error($mysqli));
                                        $newNameArr = $result->fetch_assoc();
                                        $newName = $newNameArr["name"];
                                        $student[$key] = $newName;
                                    }
                                    continue;
                                }
                            }
                        }
                    }
                }
                array_push($studList, $student);
            }

            for($k = 0; $k < count($studList) - 1; $k++){
                for($j = $k + 1; $j < count($studList); $j++){
                    if(strcmp($studList[$k]["name_in_to_form"], $studList[$j]["name_in_to_form"]) > 0){
                        $temp = $studList[$k];
                        $studList[$k] = $studList[$j];
                        $studList[$j] = $temp;
                    }
                }
            }
            for($k = 0; $k < count($studList); $k++){
                
                $person = $studList[$k]["surname"] . " " . $studList[$k]["name"] . " " . $studList[$k]["patername"];
                $doc_body .= "<tr style='border:1px solid black;'>
                                <td style='border:1px solid black;'>$index</td>
                                <td style='border:1px solid black;'>$person</td>";
                for($j = 0; $j < count($additionalField); $j++){
                    if($additionalField[$j] == "Start-Finish"){
                        $doc_body .= "<td>$courseStart - $courseFinish</td>";    
                        continue;
                    }
                    $doc_body .= "<td>" . $studList[$k][$additionalField[$j]] . "</td>";
                }
                        
                $doc_body .= "</tr>";
                $index++;
            }   

            $doc_body .= "</table>";
        }
        return $doc_body;
    }
?>