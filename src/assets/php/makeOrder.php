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

    if($isEnter){
        $about = "О зачислении слушателей на $type";
        $status = 2;
        $currentStatus = 1;
    }else{
        $about = "Об окончании слушателями $type";
        $status = 3;
        $currentStatus = 2;
    }
    if ($isEnter == 0 || $isEnter == 1) {
        $doc_body = "
            <html>
                <style>
                    body, p, ol, ul{
                        font-size:14pt;
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
            $notes = $courses[$i]->Notes;
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
                            Зачислить в число слушателей группы №$number $typeRelForm
                            по специальности \"$courseName\" 
                            ($notes) на
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
            WHERE arrivals.CourseId = '$id' AND arrivals.Status = $currentStatus ORDER BY personal_card.name_in_to_form") or die ("Ошибка выполнения запроса: " . mysqli_error($mysqli));
            $countRows = 0;
            while($row = $result->fetch_assoc()){
                $id = $row["id"];
                $updateData = "SELECT * FROM history_of_changes WHERE personId = $id ORDER BY id ASC";
                $updateObj = $mysqli->query($updateData) or die ("Error in '$updateData': " . mysqli_error($mysqli));
                while ($updateRow = $updateObj->fetch_assoc()) {
                    if($updateRow["field"] == "name_in_to_form"){
                        $updateRow["field"] = "nameInDativeForm";
                    }
                    foreach ($row as $key => $value) {
                        if ($key == $updateRow["field"]) {
                            $newValue = $updateRow["new_value"];
                            if (!is_numeric($newValue)) {
                                $row[$key] = $newValue;
                            }else{
                                foreach ($correspondings as $keyOut => $valueOut) {
                                    if ($keyOut == $key) {
                                        $table = $valueOut;
                                        $query = "SELECT name FROM $table WHERE id = $newValue";
                                        $result = $mysqli->query($query) or die ("Error in '$query': " . mysqli_error($mysqli));
                                        $newNameArr = $result->fetch_assoc();
                                        $newName = $newNameArr["name"];
                                        $row[$key] = $newName;
                                    }
                                    continue;
                                }
                            }
                        }
                    }
                }
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
            $doc_body .= '<span style="font-size:12.0pt;font-family:\"Times New Roman\","serif";mso-fareast-font-family:
                            \"Times New Roman\";mso-fareast-theme-font:minor-fareast;mso-ansi-language:RU;
                            mso-fareast-language:RU;mso-bidi-language:AR-SA"><br clear=all
                            style="mso-special-character:line-break;page-break-before:always">
                            </span>';
        }
    }else if($isEnter == 3){
        $prorector = $data->prorector;
        $headmaster = $data->headmaster;
        $exam_form = $data->exam_form;
        $exam_date = $data->exam_date;
        $doc_body = "";
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
            $query = "SELECT personal_card.name, personal_card.surname, personal_card.patername FROM personal_card INNER JOIN arrivals ON personal_card.id = arrivals.PersonId WHERE arrivals.CourseId = $courseid ORDER BY personal_card.name_in_to_form ASC";
            $studObj = $mysqli->query($query) or die("Error in '$query': ". mysqli_error($mysqli));
            $Start = date_create_from_format('Y-m-d', $courseNameArr["Start"]);
            $Start = $Start->format("d.m.y");
            $Finish = date_create_from_format('Y-m-d', $courseNameArr["Finish"]);
            $Finish = $Finish->format("dd.mm.y") ;
            $doc_body .= "<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
            text-align:center;line-height:normal'><span style='font-size:14.0pt;font-family:
            \"Times New Roman\",serif'>Государственное учреждение образования <o:p></o:p></span></p>
            
            <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
            text-align:center;line-height:normal'><span style='font-size:14.0pt;font-family:
            \"Times New Roman\",serif'>«Белорусская медицинская академия последипломного
            образования»<o:p></o:p></span></p>
            
            <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 align=left
             width=650 style='width:487.5pt;border-collapse:collapse;border:none;
             mso-yfti-tbllook:1184;mso-table-lspace:9.0pt;margin-left:6.75pt;mso-table-rspace:
             9.0pt;margin-right:6.75pt;mso-table-anchor-vertical:paragraph;mso-table-anchor-horizontal:
             margin;mso-table-left:left;mso-table-top:5.65pt;mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
             mso-border-insideh:none;mso-border-insidev:none'>
             <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>
              <td width=650 colspan=15 valign=top style='width:487.5pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
              text-align:center;line-height:normal;mso-element:frame;mso-element-frame-hspace:
              9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
              mso-element-anchor-horizontal:margin;mso-element-top:5.65pt;mso-height-rule:
              exactly'><span style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
              mso-fareast-font-family:\"Times New Roman\"'>ЗАЧЁТНО-ЭКЗАМЕНАЦИОННАЯ ВЕДОМОСТЬ<o:p></o:p></span></p>
              <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
              text-align:center;line-height:normal;mso-element:frame;mso-element-frame-hspace:
              9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
              mso-element-anchor-horizontal:margin;mso-element-top:5.65pt;mso-height-rule:
              exactly'><span style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
              mso-fareast-font-family:\"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
              </td>
             </tr>
             <tr style='mso-yfti-irow:1'>
              <td width=73 valign=top style='width:54.4pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
              justify;text-justify:inter-ideograph;line-height:normal;mso-element:frame;
              mso-element-frame-hspace:9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:
              paragraph;mso-element-anchor-horizontal:margin;mso-element-top:5.65pt;
              mso-height-rule:exactly'><span style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
              mso-fareast-font-family:\"Times New Roman\"'>Группа<o:p></o:p></span></p>
              </td>
              <td width=577 colspan=14 valign=top style='width:433.1pt;border:none;
              border-bottom:solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
              padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'></span><span
              lang=EN-US style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
              mso-fareast-font-family:\"Times New Roman\"'> </span><span style='font-size:
              14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:\"Times New Roman\"'><o:p></o:p></span></p>
              </td>
             </tr>
             <tr style='mso-yfti-irow:2'>
              <td width=73 valign=top style='width:54.4pt;padding:0cm 5.4pt 0cm 5.4pt'></td>
              <td width=577 colspan=14 valign=top style='width:433.1pt;border:none;
              border-bottom:solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
              padding:0cm 5.4pt 0cm 5.4pt'></td>
             </tr>
             <tr style='mso-yfti-irow:3'>
              <td width=243 colspan=6 valign=top style='width:182.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'>Форма итоговой аттестации<o:p></o:p></span></p>
              </td>
              <td width=407 colspan=9 valign=top style='width:305.25pt;border:none;
              border-bottom:solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
              padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'>$exam_form<o:p></o:p></span></p>
              </td>
             </tr>
             <tr style='mso-yfti-irow:4'>
              <td width=205 colspan=5 valign=top style='width:153.75pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'>Учебная дисциплина:<o:p></o:p></span></p>
              </td>
              <td width=445 colspan=10 valign=top style='width:333.75pt;border:none;
              border-bottom:solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
              padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span class=SpellE><span
              lang=EN-US style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
              mso-fareast-font-family:\"Times New Roman\";mso-ansi-language:EN-US'>$courseName</span></span><span
              lang=EN-US style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
              mso-fareast-font-family:\"Times New Roman\";mso-ansi-language:EN-US'><o:p></o:p></span></p>
              </td>
             </tr>
             <tr style='mso-yfti-irow:5'>
              <td width=650 colspan=15 valign=top style='width:487.5pt;border:none;
              border-bottom:solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
              padding:0cm 5.4pt 0cm 5.4pt'></td>
             </tr>
             <tr style='mso-yfti-irow:6'>
              <td width=650 colspan=15 valign=top style='width:487.5pt;border:none;
              border-bottom:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;
              mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
              padding:0cm 5.4pt 0cm 5.4pt'></td>
             </tr>
             <tr style='mso-yfti-irow:7'>
              <td width=168 colspan=3 valign=top style='width:125.85pt;border:none;
              mso-border-top-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'>Члены комиссии<o:p></o:p></span></p>
              </td>
              <td width=482 colspan=12 valign=top style='width:361.65pt;border:none;
              border-bottom:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;
              mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
              padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span class=SpellE><span
              lang=EN-US style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
              mso-fareast-font-family:\"Times New Roman\";mso-ansi-language:EN-US'></span></span><span
              lang=EN-US style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
              mso-fareast-font-family:\"Times New Roman\";background:yellow;mso-highlight:
              yellow;mso-ansi-language:EN-US'><o:p></o:p></span></p>
              </td>
             </tr>
             <tr style='mso-yfti-irow:8'>
              <td width=168 colspan=3 valign=top style='width:125.85pt;padding:0cm 5.4pt 0cm 5.4pt'></td>
              <td width=482 colspan=12 valign=top style='width:361.65pt;border:none;
              border-bottom:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;
              mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
              padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\";background:yellow;mso-highlight:yellow'></span><span
              style='font-size:10.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\";background:yellow;mso-highlight:yellow'><o:p></o:p></span></p>
              </td>
             </tr>
             <tr style='mso-yfti-irow:9'>
              <td width=168 colspan=3 valign=top style='width:125.85pt;padding:0cm 5.4pt 0cm 5.4pt'></td>
              <td width=482 colspan=12 valign=top style='width:361.65pt;border:none;
              border-bottom:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;
              mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
              padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\";background:yellow;mso-highlight:yellow'></span><span
              style='font-size:10.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\";background:yellow;mso-highlight:yellow'><o:p></o:p></span></p>
              </td>
             </tr>
             <tr style='mso-yfti-irow:10'>
              <td width=168 colspan=3 valign=top style='width:125.85pt;padding:0cm 5.4pt 0cm 5.4pt'></td>
              <td width=482 colspan=12 valign=top style='width:361.65pt;border:none;
              border-bottom:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;
              mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
              padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span class=SpellE><span
              lang=EN-US style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
              mso-fareast-font-family:\"Times New Roman\";background:yellow;mso-highlight:
              yellow;mso-ansi-language:EN-US'></span></span><span
              lang=EN-US style='font-size:10.0pt;font-family:\"Times New Roman\",serif;
              mso-fareast-font-family:\"Times New Roman\";background:yellow;mso-highlight:
              yellow;mso-ansi-language:EN-US'><o:p></o:p></span></p>
              </td>
             </tr>
             <tr style='mso-yfti-irow:11'>
              <td width=308 colspan=8 valign=top style='width:230.9pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
              text-align:center;line-height:normal;mso-element:frame;mso-element-frame-hspace:
              9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
              mso-element-anchor-horizontal:margin;mso-element-top:5.65pt;mso-height-rule:
              exactly'><span style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
              mso-fareast-font-family:\"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
              </td>
              <td width=342 colspan=7 valign=top style='width:256.6pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
              text-align:center;line-height:normal;mso-element:frame;mso-element-frame-hspace:
              9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
              mso-element-anchor-horizontal:margin;mso-element-top:5.65pt;mso-height-rule:
              exactly'><span style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
              mso-fareast-font-family:\"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
              </td>
             </tr>
             <tr style='mso-yfti-irow:12'>
              <td width=252 colspan=7 valign=top style='width:189.2pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span lang=EN-US
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\";mso-ansi-language:EN-US'>Дата проведения аттестации<o:p></o:p></span></p>
              </td>
              <td width=398 colspan=8 valign=top style='width:298.3pt;border:none;
              border-bottom:solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
              padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'>$exam_date<o:p></o:p></span></p>
              </td>
             </tr>
             <tr style='mso-yfti-irow:13'>
              <td width=308 colspan=8 valign=top style='width:230.9pt;border:none;
              border-bottom:solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
              padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
              text-align:center;line-height:normal;mso-element:frame;mso-element-frame-hspace:
              9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
              mso-element-anchor-horizontal:margin;mso-element-top:5.65pt;mso-height-rule:
              exactly'><span style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
              mso-fareast-font-family:\"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
              </td>
              <td width=342 colspan=7 valign=top style='width:256.6pt;border:none;
              border-bottom:solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
              padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
              text-align:center;line-height:normal;mso-element:frame;mso-element-frame-hspace:
              9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
              mso-element-anchor-horizontal:margin;mso-element-top:5.65pt;mso-height-rule:
              exactly'><span style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
              mso-fareast-font-family:\"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
              </td>
             </tr>
             <tr style='mso-yfti-irow:14'>
              <td width=422 colspan=10 valign=top style='width:316.35pt;border:solid windowtext 1.0pt;
              border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
              padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
              text-align:center;line-height:normal;mso-element:frame;mso-element-frame-hspace:
              9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
              mso-element-anchor-horizontal:margin;mso-element-top:5.65pt;mso-height-rule:
              exactly'><span style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
              mso-fareast-font-family:\"Times New Roman\"'>Фамилия, собственное имя, отчество
              (если таковое имеется) слушателя<o:p></o:p></span></p>
              </td>
              <td width=228 colspan=5 valign=top style='width:171.15pt;border-top:none;
              border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
              mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
              mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
              text-align:center;line-height:normal;mso-element:frame;mso-element-frame-hspace:
              9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
              mso-element-anchor-horizontal:margin;mso-element-top:5.65pt;mso-height-rule:
              exactly'><span style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
              mso-fareast-font-family:\"Times New Roman\"'>Отметка<o:p></o:p></span></p>
              </td>
             </tr>";

             $index = 1;
            while ($row = $studObj->fetch_assoc()) {
                $person = $row["surname"] . " " . $row["name"] . " " . $row["patername"];
                $doc_body .= "<tr style='mso-yfti-irow:18'>
                <td width=422 colspan=10 valign=top style='width:316.35pt;border:solid windowtext 1.0pt;
                border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                padding:0cm 5.4pt 0cm 5.4pt'>
                <p class=MsoListParagraph style='margin-top:0cm;margin-right:0cm;margin-bottom:
                0cm;margin-left:7.1pt;margin-bottom:.0001pt;mso-add-space:auto;text-indent:
                0cm;line-height:normal;mso-list:l5 level1 lfo4;tab-stops:21.75pt'><![if !supportLists]><span
                style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
                \"Times New Roman\"'><span style='mso-list:Ignore'>$index.<span
                style='font:7.0pt \"Times New Roman\"'>&nbsp;&nbsp; </span></span></span><![endif]><span
                lang=EN-US style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
                mso-fareast-font-family:\"Times New Roman\";mso-ansi-language:EN-US'>$person</span><span
                style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
                \"Times New Roman\"'><o:p></o:p></span></p>
                </td>
                <td width=228 colspan=5 valign=top style='width:171.15pt;border-top:none;
                border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
                mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                normal'><span style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
                mso-fareast-font-family:\"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
                </td>
                </tr>";
                    $index++;
            }
             $doc_body .= "<tr style='mso-yfti-irow:23'>
              <td width=489 colspan=12 valign=top style='width:366.5pt;border:none;
              mso-border-top-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'>Количество слушателей, присутствовавших на аттестации<o:p></o:p></span></p>
              </td>
              <td width=57 colspan=2 valign=top style='width:42.9pt;border:none;border-bottom:
              solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:
              solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;padding:
              0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
              text-align:center;line-height:normal;mso-element:frame;mso-element-frame-hspace:
              9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
              mso-element-anchor-horizontal:margin;mso-element-top:5.65pt;mso-height-rule:
              exactly'><span style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
              mso-fareast-font-family:\"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
              </td>
              <td width=104 valign=top style='width:78.1pt;border:none;mso-border-top-alt:
              solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'>чел.<o:p></o:p></span></p>
              </td>
             </tr>
             <tr style='mso-yfti-irow:24'>
              <td width=422 colspan=10 valign=top style='width:316.35pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'>Количество слушателей, получивших отметки:<o:p></o:p></span></p>
              </td>
              <td width=228 colspan=5 valign=top style='width:171.15pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
              text-align:center;line-height:normal;mso-element:frame;mso-element-frame-hspace:
              9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
              mso-element-anchor-horizontal:margin;mso-element-top:5.65pt;mso-height-rule:
              exactly'><span style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
              mso-fareast-font-family:\"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
              </td>
             </tr>
             <tr style='mso-yfti-irow:25'>
              <td width=120 colspan=2 valign=top style='width:90.2pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'>«зачтено»<o:p></o:p></span></p>
              </td>
              <td width=76 colspan=2 valign=top style='width:56.75pt;border:none;
              border-bottom:solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
              padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
              </td>
              <td width=454 colspan=11 valign=top style='width:340.55pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'>чел.<o:p></o:p></span></p>
              </td>
             </tr>
             <tr style='mso-yfti-irow:26'>
              <td width=120 colspan=2 valign=top style='width:90.2pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'>«<span class=SpellE>незачтено</span>»<o:p></o:p></span></p>
              </td>
              <td width=76 colspan=2 valign=top style='width:56.75pt;border:none;
              border-bottom:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;
              mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
              padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
              </td>
              <td width=454 colspan=11 valign=top style='width:340.55pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'>чел.<o:p></o:p></span></p>
              </td>
             </tr>
             <tr style='mso-yfti-irow:27'>
              <td width=461 colspan=11 valign=top style='width:345.45pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'>Количество слушателей, не явившихся на аттестацию<o:p></o:p></span></p>
              </td>
              <td width=66 colspan=2 valign=top style='width:49.75pt;border:none;
              border-bottom:solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
              padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
              text-align:center;line-height:normal;mso-element:frame;mso-element-frame-hspace:
              9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
              mso-element-anchor-horizontal:margin;mso-element-top:5.65pt;mso-height-rule:
              exactly'><span style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
              mso-fareast-font-family:\"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
              </td>
              <td width=123 colspan=2 valign=top style='width:92.3pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'>чел.<o:p></o:p></span></p>
              </td>
             </tr>
             <tr style='mso-yfti-irow:28'>
              <td width=461 colspan=11 valign=top style='width:345.45pt;padding:0cm 5.4pt 0cm 5.4pt'></td>
              <td width=66 colspan=2 valign=top style='width:49.75pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
              text-align:center;line-height:normal;mso-element:frame;mso-element-frame-hspace:
              9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
              mso-element-anchor-horizontal:margin;mso-element-top:5.65pt;mso-height-rule:
              exactly'><span style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
              mso-fareast-font-family:\"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
              </td>
              <td width=123 colspan=2 valign=top style='width:92.3pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
              </td>
             </tr>
             <tr style='mso-yfti-irow:29'>
              <td width=308 colspan=8 valign=top style='width:230.9pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'>Члены комиссии<o:p></o:p></span></p>
              </td>
              <td width=104 valign=top style='width:78.05pt;border:none;border-bottom:solid windowtext 1.0pt;
              mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
              </td>
              <td width=238 colspan=6 valign=top style='width:178.55pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\";background:yellow;mso-highlight:yellow'><o:p></o:p></span></p>
              </td>
             </tr>
             <tr style='mso-yfti-irow:30'>
              <td width=308 colspan=8 valign=top style='width:230.9pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
              </td>
              <td width=104 valign=top style='width:78.05pt;border:none;border-bottom:solid windowtext 1.0pt;
              mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
              </td>
              <td width=238 colspan=6 valign=top style='width:178.55pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\";background:yellow;mso-highlight:yellow'>(инициалы, фамилия)<o:p></o:p></span></p>
              </td>
             </tr>
             <tr style='mso-yfti-irow:31'>
              <td width=308 colspan=8 valign=top style='width:230.9pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
              </td>
              <td width=104 valign=top style='width:78.05pt;border:none;border-bottom:solid windowtext 1.0pt;
              mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
              </td>
              <td width=238 colspan=6 valign=top style='width:178.55pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\";background:yellow;mso-highlight:yellow'>(инициалы, фамилия)</span><span
              style='font-size:10.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\";background:yellow;mso-highlight:yellow'><o:p></o:p></span></p>
              </td>
             </tr>
             <tr style='mso-yfti-irow:32'>
              <td width=308 colspan=8 valign=top style='width:230.9pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
              </td>
              <td width=104 valign=top style='width:78.05pt;border:none;border-bottom:solid windowtext 1.0pt;
              mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
              </td>
              <td width=238 colspan=6 valign=top style='width:178.55pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\";background:yellow;mso-highlight:yellow'>(инициалы, фамилия)</span><span
              style='font-size:10.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\";background:yellow;mso-highlight:yellow'><o:p></o:p></span></p>
              </td>
             </tr>
             <tr style='mso-yfti-irow:33;mso-yfti-lastrow:yes'>
              <td width=308 colspan=8 valign=top style='width:230.9pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span lang=EN-US
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\";mso-ansi-language:EN-US'><o:p>&nbsp;</o:p></span></p>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span class=SpellE><span
              lang=EN-US style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
              mso-fareast-font-family:\"Times New Roman\";mso-ansi-language:EN-US'>Декан</span></span><span
              lang=EN-US style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
              mso-fareast-font-family:\"Times New Roman\";mso-ansi-language:EN-US'> </span><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'>терапевтического</span><span lang=EN-US style='font-size:
              14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:\"Times New Roman\";
              mso-ansi-language:EN-US'> <span class=SpellE>факультета</span></span><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'><o:p></o:p></span></p>
              </td>
              <td width=104 valign=top style='width:78.05pt;border:none;border-bottom:solid windowtext 1.0pt;
              mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal align=right style='margin-bottom:0cm;margin-bottom:.0001pt;
              text-align:right;line-height:normal;mso-element:frame;mso-element-frame-hspace:
              9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
              mso-element-anchor-horizontal:margin;mso-element-top:5.65pt;mso-height-rule:
              exactly'><span style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
              mso-fareast-font-family:\"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
              </td>
              <td width=238 colspan=6 valign=top style='width:178.55pt;padding:0cm 5.4pt 0cm 5.4pt'>
              <p class=MsoNormal align=right style='margin-bottom:0cm;margin-bottom:.0001pt;
              text-align:right;line-height:normal;mso-element:frame;mso-element-frame-hspace:
              9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
              mso-element-anchor-horizontal:margin;mso-element-top:5.65pt;mso-height-rule:
              exactly'><span style='font-size:14.0pt;font-family:\"Times New Roman\",serif;
              mso-fareast-font-family:\"Times New Roman\"'><o:p>&nbsp;</o:p></span></p>
              <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
              normal;mso-element:frame;mso-element-frame-hspace:9.0pt;mso-element-wrap:
              around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
              margin;mso-element-top:5.65pt;mso-height-rule:exactly'><span class=SpellE><span
              style='font-size:14.0pt;font-family:\"Times New Roman\",serif;mso-fareast-font-family:
              \"Times New Roman\"'>М.В.Штонда</span></span><span style='font-size:14.0pt;
              font-family:\"Times New Roman\",serif;mso-fareast-font-family:\"Times New Roman\"'><o:p></o:p></span></p>
              </td>
             </tr>
             <![if !supportMisalignedColumns]>
             <tr height=0>
              <td width=73 style='border:none'></td>
              <td width=48 style='border:none'></td>
              <td width=48 style='border:none'></td>
              <td width=28 style='border:none'></td>
              <td width=9 style='border:none'></td>
              <td width=38 style='border:none'></td>
              <td width=9 style='border:none'></td>
              <td width=56 style='border:none'></td>
              <td width=104 style='border:none'></td>
              <td width=10 style='border:none'></td>
              <td width=39 style='border:none'></td>
              <td width=28 style='border:none'></td>
              <td width=38 style='border:none'></td>
              <td width=19 style='border:none'></td>
              <td width=104 style='border:none'></td>
             </tr>
             <![endif]>
            </table>";
        }
    }else if($isEnter == 4){
        require_once("statements/gek.php");
        $doc_body = makeGEK($data, $courses, $mysqli);
    }else if($isEnter == 8){ 
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
            $query = "SELECT personal_card.id, personal_card.name, personal_card.surname, personal_card.patername $selectAddField FROM personal_card INNER JOIN arrivals ON personal_card.id = arrivals.PersonId $fromConnections WHERE arrivals.CourseId = $id ORDER BY personal_card.name_in_to_form ASC";

            $studObj = $mysqli->query($query) or die("Error in '$query': ". mysqli_error($mysqli));
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
            while ($student = $studObj->fetch_assoc()) {
                $id = $student["id"];
                $updateData = "SELECT * FROM history_of_changes WHERE personId = $id ORDER BY id ASC";
                $updateObj = $mysqli->query($updateData) or die ("Error in '$updateData': " . mysqli_error($mysqli));
                while ($updateRow = $updateObj->fetch_assoc()) {
                    if($updateRow["field"] == "name_in_to_form"){
                        $updateRow["field"] = "nameInDativeForm";
                    }
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
                $person = $student["surname"] . " " . $student["name"] . " " . $student["patername"];
                $doc_body .= "<tr style='border:1px solid black;'>
                                <td style='border:1px solid black;'>$index</td>
                                <td style='border:1px solid black;'>$person</td>";
                for($j = 0; $j < count($additionalField); $j++){
                    $doc_body .= "<td>" . $student[$additionalField[$j]] . "</td>";
                }
                        
                $doc_body .= "</tr>";
                $index++;
            }   

            $doc_body .= "</table>";
        }

    }
    $file = 'HelloWorld.doc';
    header('Content-Disposition: attachment; filename="' . $file . '"');
    header('Content-Type: application/vnd.msword;format=attachment;');
    header('Content-Transfer-Encoding: binary');
    
    echo "<meta http-equiv=Content-Type content='text/html; charset=utf-8'>";
    echo $doc_body;
?>