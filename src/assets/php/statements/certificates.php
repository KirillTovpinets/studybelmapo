<?php
    function makeCertificateList($data, $courses, $mysqli){
        $prorector = $data->prorector;
        $headmaster = $data->headmaster;
        $doc_body = "<html>
                        <style>
                            body, p, ol, ul{
                                font-size:19px;
                            }
                            p, ol{
                                text-indent: 1.25cm;
                                margin-top:0pt;
                            }
                            ol{
                                text-indent: 1.25cm;
                                padding:0px;
                            }
                            .StudList li{
                                margin-left:0pt;
                            }
                            table{
                                page-break-after: always;
                            }
                        </style>";
        for($i = 0; $i < count($courses); $i++){
            $number = $courses[$i]->Number;
            $id = $courses[$i]->id;
            $query = "SELECT cources.id, cources.Number, cources.name, cources.Start, cources.Finish, cources.Notes, cathedras.name AS cathedra FROM cources INNER JOIN cathedras ON cources.cathedraId = cathedras.id WHERE cources.id = '$id'";
            $CourseObj = $mysqli->query($query) or die ("Error in '$query':" . mysqli_error($mysqli));
            $courseNameArr = $CourseObj->fetch_assoc();
            $courseName = $courseNameArr["name"];
            $number = $courseNameArr["Number"];
            $notes = $courseNameArr["Notes"];
            $courseid = $courseNameArr["id"];
            $cathedraName = $courseNameArr["cathedra"];
            $query = "SELECT personal_card.name_in_to_form FROM personal_card INNER JOIN arrivals ON personal_card.id = arrivals.PersonId WHERE arrivals.CourseId = $courseid ORDER BY personal_card.name_in_to_form ASC";
            $studObj = $mysqli->query($query) or die("Error in '$query': ". mysqli_error($mysqli));
            $Start = date_create_from_format('Y-m-d', $courseNameArr["Start"]);
            $Start = $Start->format("d.m.y");
            $Finish = date_create_from_format('Y-m-d', $courseNameArr["Finish"]);
            $Finish = $Finish->format("d.m.y") ;
            $doc_body .= "<p style='text-align:right;'>Проректору по учебной работе<br> $prorector</p>
                    <p>
                        Просим подписать свидетельства слушателям курса № $number Повышение квалификации \"$courseName\" ($notes) $Start - $Finish
                    </p>
                    <ol>";
            while ($row = $studObj->fetch_assoc()) {
                   $person = $row["name_in_to_form"];
                   $doc_body .= "<li>$person</li>";
               }   

            $doc_body .= "</ol>";
            $doc_body .= "<p>Заведующий кафедрой $cathedraName $headmaster</p>";
            $doc_body .= '<span style="font-size:12.0pt;font-family:\"Times New Roman\","serif";mso-fareast-font-family:
                            \"Times New Roman\";mso-fareast-theme-font:minor-fareast;mso-ansi-language:RU;
                            mso-fareast-language:RU;mso-bidi-language:AR-SA"><br clear=all
                            style="mso-special-character:line-break;page-break-before:always">
                            </span>';
        }
        return $doc_body;
    }
?>