<?php
    ini_set("display_errors", 1);
   
   require("config.php");
   
   $mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения к базе данных: ". mysqli_connect_erro());
   $mysqli->query("SET NAMES utf8");
   $data = json_decode(file_get_contents("php://input"));
   $courses = $data->selectedCourses;
   $isEnter = $data->type;
   $status = 0;
   $currentStatus = 0;
   $currentYear = date("Y");
    if($isEnter){
        $about = "О зачислении слушателей на переподготовку";
        $status = 2;
        $currentStatus = 1;
    }else{
        $about = "Об окончании слушателями курсов повышения квалификации";
        $status = 3;
        $currentStatus = 2;
    }
    if ($isEnter == 0 || $isEnter == 1) {
        $doc_body = "
            <html>
                <style>
                    body, p, ol, ul{
                        font-size:19px;
                    }
                    p, ol{
                        text-align:justify;
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
                </style>
                <table style='width:100%;margin-top:200px;'>
                    <tr style='vertical-align:bottom;'>
                        <td align='center'>ЗАГАД</td>
                        <td align='right'>ПРИКАЗ</td>
                    </tr>
                </table>
                <table style='margin-top:70px;'>
                    <tr>
                        <td width='40%'>$about</td>
                        <td></td>
                    </tr>
                </table>
                <p></p>";
        if ($isEnter) {
            $doc_body .= "<p>В соответствии со сводным планом повышения 
                квалификации и переподготовки руководителей и 
                специалистов здравоохранения Республики Беларусь 
                на $currentYear год, утвержденным Министром 
                здравоохранения Республики Беларусь,<br/>";
        }else{
            $doc_body .= "<p>В связи с выполнением учебных планов и программ курсов повышения квалификации <br/>";
        }

        $doc_body .= "ПРИКАЗЫВАЮ:<br/><ol>";
        $sendTo = array();
        for($i = 0; $i < count($courses); $i++){
            $number = $courses[$i]->Number;
            $id = $courses[$i]->id;
            $CourseObj = $mysqli->query("SELECT name, Start, Finish FROM cources WHERE id = '$id'");
            $courseNameArr = $CourseObj->fetch_assoc();
            $courseName = $courseNameArr["name"];
            $Start = date_create_from_format('Y-m-d', $courseNameArr["Start"]);
            $Start = $Start->format("d.m.y");
            $Finish = date_create_from_format('Y-m-d', $courseNameArr["Finish"]);
            $Finish = $Finish->format("d.m.y") ;
            // print_r($data);
            $CathedraObj = $mysqli->query("SELECT cathedras.name FROM cathedras INNER JOIN cources ON cathedras.id = cources.cathedraId WHERE cources.id = '$id'") or die ("Ошибка выполнения запроса: " . mysqli_error($mysqli));
            $CathedraNameObj = $CathedraObj->fetch_assoc();
            $cathedraName = $CathedraNameObj["name"];
            array_push($sendTo, $cathedraName);
            if ($isEnter) {
                $doc_body .= "<li>
                            Зачислить в число слушателей группы №$number переподготовки
                            по специальности \"$courseName\" 
                            (переподготовка в очной форме получения образования) на
                            кафедре $cathedraName согласно списку:
                            <ol class='StudList'>";
            }else{
                $doc_body .= "<li>
                            Провести выпуск группы №$number \"$courseName\" по кафедре $cathedraName согласно списку:
                            <ol class='StudList'>";
            }
            $result = $mysqli->query("SELECT personal_card.id, personal_card.surname, personal_card.name, personal_card.patername 
            FROM personal_card 
            INNER JOIN arrivals ON personal_card.id = arrivals.PersonId 
            WHERE arrivals.CourseId = '$id' AND arrivals.Status = $currentStatus") or die ("Ошибка выполнения запроса: " . mysqli_error($mysqli));
            $countRows = 0;
            while($row = $result->fetch_assoc()){
                $name = $row["name"];
                $surname = $row["surname"];
                $patername = $row["patername"];
                $id = $row["id"];
                $doc_body .= "<li>$surname $name $patername</li>";
                $query = "UPDATE arrivals SET Status = $status WHERE PersonId = $id";
                $mysqli->query($query) or die ("Error in '$query': " . mysqli_error($mysqli));
                $countRows++;
            }
            $doc_body .= "</ol></li>";
            if ($isEnter) {
                $doc_body .="<li>Провести учебные занятия с $Start  по $Finish в соответствии с учебным планом с отрывом от работы.</li>";
            }else{
                $doc_body .="<li>Выпуск слушателей провести $Finish</li>";
            }
            $doc_body .="<li>Контроль за исполнением данного приказа возложить на проректора по учебной работе Калинину Т.В.</li>";
        }
        mysqli_close($mysqli);                
        $doc_body .= "</ol>
                    
                    <table style='width:100%;font-size:19px;'>
                        <tr>
                            <td align='left'>Ректор академии</td>
                            <td align='right'>М.А.Герасименко</td>
                        </tr>
                    </table>
                    <br clear=all style='mso-special-character:line-break;page-break-before:always'>
                    <table width='100%'>
                        <tr>
                            <td width='40%'>Проректор по учебной работе<br/>Т.В.Калинина<br> __.01.2017</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td width='40%'>Начальник учебно-организационного отдела<br/>О.Н. Морозова<br> __.01.2017</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td width='40%'>Юристконсульт сектора правовой работы<br/>Н.Е. Павлюкевич<br> __.01.2017</td>
                            <td></td>
                        </tr>
                    </table>
                    <p>
                        Реестр рассылки:
                        <ul>
                            <li>Канцелярия - оригинал</li>";
        for($i = 0; $i < count($sendTo); $i++){
            $cathedra = $sendTo[$i];
            $doc_body .= "<li>Кафедра $cathedra</li>";
        }
        $doc_body .= "</ul>
                    </p>
                </p>
            </html>";
    }else if($isEnter == 2){
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
            $doc_body .= '<span style="font-size:12.0pt;font-family:"Times New Roman","serif";mso-fareast-font-family:
                            "Times New Roman";mso-fareast-theme-font:minor-fareast;mso-ansi-language:RU;
                            mso-fareast-language:RU;mso-bidi-language:AR-SA"><br clear=all
                            style="mso-special-character:line-break;page-break-before:always">
                            </span>';
        }
    }else if($isEnter == 3){
        $prorector = $data->prorector;
        $headmaster = $data->headmaster;
        $exam_form = $data->exam_form;
        $exam_date = $data->exam_date;
        $doc_body = "<html>
                        <style>
                            body, p, ol, ul{
                                font-size:19px;
                            }
                            p, ol{
                                text-align:left;
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
                        </style>";
        for($i = 0; $i < count($courses); $i++){
            $number = $courses[$i]->Number;
            $id = $courses[$i]->id;
            $CourseObj = $mysqli->query("SELECT cources.id, cources.Number, cources.name, cources.Start, cources.Finish, cources.Notes, cathedras.name AS cathedra FROM cources INNER JOIN cathedras ON cources.cathedraId = cathedras.id WHERE cources.id = '$id'");
            $courseNameArr = $CourseObj->fetch_assoc();
            $courseName = $courseNameArr["name"];
            $number = $courseNameArr["Number"];
            $notes = $courseNameArr["Notes"];
            $courseid = $courseNameArr["id"];
            $cathedraName = $courseNameArr["cathedra"];
            $studObj = $mysqli->query("SELECT personal_card.name, personal_card.surname, personal_card.patername FROM personal_card INNER JOIN arrivals ON personal_card.id = arrivals.PersonId WHERE arrivals.CourseId = $courseid ORDER BY personal_card.name_in_to_form ASC") or die("Error: ". mysqli_error($mysqli));
            $Start = date_create_from_format('Y-m-d', $courseNameArr["Start"]);
            $Start = $Start->format("d.m.y");
            $Finish = date_create_from_format('Y-m-d', $courseNameArr["Finish"]);
            $Finish = $Finish->format("d.m.y") ;
            $doc_body .= "<p style='text-align:center;'>Государственное учреждение образования 
                            «Белорусская медицинская академия последипломного образования»
                            </p>
                    <p style='text-align:center'>ЗАЧЁТНО-ЭКЗАМЕНАЦИОННАЯ ВЕДОМОСТЬ</p>";
            
            $doc_body .= "<p>Группа № $number \"$courseName\" ($notes)</p>";
            $doc_body .= "<p>Форма итоговой аттестации: $exam_form</p>";
            $doc_body .= "<p>Учебная дисциплина: \"$courseName\" ($notes)</p>";
            $doc_body .= "<p>Дата проведения аттестации: $exam_date</p>";
            $doc_body .= "<table style='border: 1px solid black; border-collapse: collapse;'>
                            <tr>
                                <th style='border:1px solid black;'>№</th>
                                <th style='border:1px solid black;'>Фамилия, собственное имя, отчество (если таковое имеется) слушателя</th>
                                <th style='border:1px solid black;'>Отметка</th>
                            </tr>";
            $index = 1;
            while ($row = $studObj->fetch_assoc()) {
                   $person = $row["surname"] . " " . $row["name"] . " " . $row["patername"];
                   $doc_body .= "<tr style='border:1px solid black;'>
                                    <td style='border:1px solid black;'>$index</td>
                                    <td style='border:1px solid black;'>$person</td>
                                    <td style='border:1px solid black;'></td>
                                </tr>";
                    $index++;
               }   

            $doc_body .= "</table>";
            $doc_body .= "<p>Количество слушателей, присутствовавших на аттестации _____чел.</p>";
            $doc_body .= "<p>Количество слушателей, получивших отметки:</p>";
            $doc_body .= "<table><tr><td>«зачтено»</td><td>_____ чел.</td></tr>";
            $doc_body .= "<tr><td>«не зачтено»</td><td>_____ чел.</td></tr></table>";

            $doc_body .= "<p>Количество слушателей, не явившихся на аттестацию _____ чел.</p>";
            $doc_body .= "<table><tr><td>Члены комиссии</td><td>__________________________<br/>__________________________<br/>__________________________<br/>__________________________<br/></td></tr></table>";
            $doc_body .= "<table><tr><td>Декан факультета</td><td>___________________</td></tr></table>";
            $doc_body .= '<span style="font-size:12.0pt;font-family:"Times New Roman","serif";mso-fareast-font-family:
                            "Times New Roman";mso-fareast-theme-font:minor-fareast;mso-ansi-language:RU;
                            mso-fareast-language:RU;mso-bidi-language:AR-SA"><br clear=all
                            style="mso-special-character:line-break;page-break-before:always">
                            </span>';
        }
    }
    $file = 'HelloWorld.doc';
    header('Content-Disposition: attachment; filename="' . $file . '"');
    header('Content-Type: application/vnd.msword;format=attachment;');
    header('Content-Transfer-Encoding: binary');
    
    echo "<meta http-equiv=Content-Type content='text/html; charset=utf-8'>";
    echo $doc_body;
?>