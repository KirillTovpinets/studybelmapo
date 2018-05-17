<?php
    function makeExamList($data, $courses, $mysqli){
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
        return $doc_body;
    }
?>