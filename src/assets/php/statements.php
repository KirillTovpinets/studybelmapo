<?php
    function makeStudList($mysqli){
        $additionalField = $data->statementInfo;
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
            $selectAddField = "";
            $fromConnections = "";
            for($j = 0; $j < count($additionalField); $j++){
                switch($additionalField[$j]){
                    case 'appointment';
                    case 'organization';
                    case 'department': {
                        $table = CONNECTIONS[$additionalField[$j]];
                        $selectAddField .= ", $table.name AS " . $additionalField[$j];
                        $fromConnections .= " INNER JOIN $table ON personal_card." . $additionalField[$j] . " = $table.id" ;
                        break;
                    }
                    case 'establishmentId':{
                        $table = CONNECTIONS[$additionalField[$j]];
                        $selectAddField .= ", $table.name AS " . $additionalField[$j];
                        $fromConnections .= " INNER JOIN personal_prof_info ON personal_card.id = personal_prof_info.PersonId INNER JOIN $table ON $table.id = personal_prof_info." . $additionalField[$j];
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
                            $fromConnections .= " INNER JOIN $table ON $table.id = personal_private_info." . $additionalField[$j];
                        }else{
                            $selectAddField .= ", personal_private_info.`" . $additionalField[$j] . "`";
                        }
                        break;
                    }
                }
            }
            $query = "SELECT personal_card.name, personal_card.surname, personal_card.patername $selectAddField FROM personal_card INNER JOIN arrivals ON personal_card.id = arrivals.PersonId $fromConnections WHERE arrivals.CourseId = $id ORDER BY personal_card.name_in_to_form ASC";

            echo $query;
            $studObj = $mysqli->query($query) or die("Error: ". mysqli_error($mysqli));
            $doc_body .= "<p style='text-align:center;'> Курс №$number '$name'</p>";
            
            $doc_body .= "<table><tr>";
            $doc_body .= "<th>№ п/п</th>";
            $doc_body .= "<th>Фамилия, имя, отчество</th>";

            for($j = 0; $j < count($additionalField); $j++){
                $label = LABELS[$additionalField[$j]];
                $doc_body .= "<th>$label</th>";
            }
            
            $doc_body .= "</tr>";
            $index = 1;
            while ($row = $studObj->fetch_assoc()) {
                   $person = $row["surname"] . " " . $row["name"] . " " . $row["patername"];
                   $doc_body .= "<tr style='border:1px solid black;'>
                                    <td style='border:1px solid black;'>$index</td>
                                    <td style='border:1px solid black;'>$person</td>";
                    for($j = 0; $j < count($additionalField); $j++){
                        $doc_body .= "<td>" . $row[$additionalField[$j]] . "</td>";
                    }
                            
                    $doc_body .= "</tr>";
                    $index++;
               }   

            $doc_body .= "</table>";
        }
        return $doc_body;
    }
?>