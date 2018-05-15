<?php 
  function makeGEK($data, $courses, $mysqli){
    $prorector = $data->prorector;
    $headmaster = $data->headmaster;
    $exam_form = $data->exam_form;
    $exam_date = $data->exam_date;
    $doc_body = "";
    for($i = 0; $i < count($courses); $i++){
        $number = $courses[$i]->Number;
        $id = $courses[$i]->id;
        $query = "SELECT cources.id, cources.Number, cources.name, cources.Start, cources.Finish, cources.Notes, cathedras.name AS cathedra FROM cources INNER JOIN cathedras ON cources.cathedraId = cathedras.id WHERE cources.id = '$id'";
        $CourseObj = $mysqli->query($query) or die ("Error in '$query' " . mysqli_error($mysqli));
        $courseNameArr = $CourseObj->fetch_assoc();
        $courseName = $courseNameArr["name"];
        $number = $courseNameArr["Number"];
        $notes = $courseNameArr["Notes"];
        $courseid = $courseNameArr["id"];
        $cathedraName = $courseNameArr["cathedra"];
        $studObj = $mysqli->query("SELECT personal_card.name, personal_card.surname, personal_card.patername FROM personal_card INNER JOIN arrivals ON personal_card.id = arrivals.PersonId WHERE arrivals.CourseId = $courseid ORDER BY personal_card.name_in_to_form ASC") or die("Error: ". mysqli_error($mysqli));

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
        $doc_body = "<html xmlns:v='urn:schemas-microsoft-com:vml'
        xmlns:o='urn:schemas-microsoft-com:office:office'
        xmlns:w='urn:schemas-microsoft-com:office:word'
        xmlns:m='http://schemas.microsoft.com/office/2004/12/omml'
        xmlns='http://www.w3.org/TR/REC-html40'>
        
        <head>
        <meta http-equiv=Content-Type content='text/html; charset=windows-1251'>
        <meta name=ProgId content=Word.Document>
        <meta name=Generator content='Microsoft Word 15'>
        <meta name=Originator content='Microsoft Word 15'>
        <link rel=File-List href='Ведомость%20ГЭК.files/filelist.xml'>
        <!--[if gte mso 9]><xml>
         <o:DocumentProperties>
          <o:Author>pisaryk</o:Author>
          <o:Template>Normal</o:Template>
          <o:LastAuthor>Товпинец Кирилл</o:LastAuthor>
          <o:Revision>2</o:Revision>
          <o:TotalTime>537</o:TotalTime>
          <o:LastPrinted>2014-11-13T09:36:00Z</o:LastPrinted>
          <o:Created>2018-05-03T13:26:00Z</o:Created>
          <o:LastSaved>2018-05-03T13:26:00Z</o:LastSaved>
          <o:Pages>2</o:Pages>
          <o:Words>147</o:Words>
          <o:Characters>840</o:Characters>
          <o:Company>Home</o:Company>
          <o:Lines>7</o:Lines>
          <o:Paragraphs>1</o:Paragraphs>
          <o:CharactersWithSpaces>986</o:CharactersWithSpaces>
          <o:Version>16.00</o:Version>
         </o:DocumentProperties>
         <o:OfficeDocumentSettings>
          <o:TargetScreenSize>800x600</o:TargetScreenSize>
         </o:OfficeDocumentSettings>
        </xml><![endif]-->
        <link rel=themeData href='Ведомость%20ГЭК.files/themedata.thmx'>
        <link rel=colorSchemeMapping href='Ведомость%20ГЭК.files/colorschememapping.xml'>
        <!--[if gte mso 9]><xml>
         <w:WordDocument>
          <w:GrammarState>Clean</w:GrammarState>
          <w:TrackMoves>false</w:TrackMoves>
          <w:TrackFormatting/>
          <w:PunctuationKerning/>
          <w:ValidateAgainstSchemas/>
          <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>
          <w:IgnoreMixedContent>false</w:IgnoreMixedContent>
          <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>
          <w:DoNotPromoteQF/>
          <w:LidThemeOther>RU</w:LidThemeOther>
          <w:LidThemeAsian>X-NONE</w:LidThemeAsian>
          <w:LidThemeComplexScript>X-NONE</w:LidThemeComplexScript>
          <w:Compatibility>
           <w:BreakWrappedTables/>
           <w:SnapToGridInCell/>
           <w:WrapTextWithPunct/>
           <w:UseAsianBreakRules/>
           <w:UseWord2010TableStyleRules/>
           <w:DontGrowAutofit/>
           <w:DontUseIndentAsNumberingTabStop/>
           <w:FELineBreak11/>
           <w:WW11IndentRules/>
           <w:DontAutofitConstrainedTables/>
           <w:AutofitLikeWW11/>
           <w:HangulWidthLikeWW11/>
           <w:UseNormalStyleForList/>
           <w:DontVertAlignCellWithSp/>
           <w:DontBreakConstrainedForcedTables/>
           <w:DontVertAlignInTxbx/>
           <w:Word11KerningPairs/>
           <w:CachedColBalance/>
          </w:Compatibility>
          <w:BrowserLevel>MicrosoftInternetExplorer4</w:BrowserLevel>
          <m:mathPr>
           <m:mathFont m:val='Cambria Math'/>
           <m:brkBin m:val='before'/>
           <m:brkBinSub m:val='&#45;-'/>
           <m:smallFrac m:val='off'/>
           <m:dispDef/>
           <m:lMargin m:val='0'/>
           <m:rMargin m:val='0'/>
           <m:defJc m:val='centerGroup'/>
           <m:wrapIndent m:val='1440'/>
           <m:intLim m:val='subSup'/>
           <m:naryLim m:val='undOvr'/>
          </m:mathPr></w:WordDocument>
        </xml><![endif]--><!--[if gte mso 9]><xml>
         <w:LatentStyles DefLockedState='false' DefUnhideWhenUsed='false'
          DefSemiHidden='false' DefQFormat='false' LatentStyleCount='371'>
          <w:LsdException Locked='false' QFormat='true' Name='Normal'/>
          <w:LsdException Locked='false' QFormat='true' Name='heading 1'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           QFormat='true' Name='heading 2'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           QFormat='true' Name='heading 3'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           QFormat='true' Name='heading 4'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           QFormat='true' Name='heading 5'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           QFormat='true' Name='heading 6'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           QFormat='true' Name='heading 7'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           QFormat='true' Name='heading 8'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           QFormat='true' Name='heading 9'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           QFormat='true' Name='caption'/>
          <w:LsdException Locked='false' QFormat='true' Name='Title'/>
          <w:LsdException Locked='false' QFormat='true' Name='Subtitle'/>
          <w:LsdException Locked='false' QFormat='true' Name='Strong'/>
          <w:LsdException Locked='false' QFormat='true' Name='Emphasis'/>
          <w:LsdException Locked='false' Priority='99' SemiHidden='true'
           Name='Placeholder Text'/>
          <w:LsdException Locked='false' Priority='1' QFormat='true' Name='No Spacing'/>
          <w:LsdException Locked='false' Priority='60' Name='Light Shading'/>
          <w:LsdException Locked='false' Priority='61' Name='Light List'/>
          <w:LsdException Locked='false' Priority='62' Name='Light Grid'/>
          <w:LsdException Locked='false' Priority='63' Name='Medium Shading 1'/>
          <w:LsdException Locked='false' Priority='64' Name='Medium Shading 2'/>
          <w:LsdException Locked='false' Priority='65' Name='Medium List 1'/>
          <w:LsdException Locked='false' Priority='66' Name='Medium List 2'/>
          <w:LsdException Locked='false' Priority='67' Name='Medium Grid 1'/>
          <w:LsdException Locked='false' Priority='68' Name='Medium Grid 2'/>
          <w:LsdException Locked='false' Priority='69' Name='Medium Grid 3'/>
          <w:LsdException Locked='false' Priority='70' Name='Dark List'/>
          <w:LsdException Locked='false' Priority='71' Name='Colorful Shading'/>
          <w:LsdException Locked='false' Priority='72' Name='Colorful List'/>
          <w:LsdException Locked='false' Priority='73' Name='Colorful Grid'/>
          <w:LsdException Locked='false' Priority='60' Name='Light Shading Accent 1'/>
          <w:LsdException Locked='false' Priority='61' Name='Light List Accent 1'/>
          <w:LsdException Locked='false' Priority='62' Name='Light Grid Accent 1'/>
          <w:LsdException Locked='false' Priority='63' Name='Medium Shading 1 Accent 1'/>
          <w:LsdException Locked='false' Priority='64' Name='Medium Shading 2 Accent 1'/>
          <w:LsdException Locked='false' Priority='65' Name='Medium List 1 Accent 1'/>
          <w:LsdException Locked='false' Priority='99' SemiHidden='true' Name='Revision'/>
          <w:LsdException Locked='false' Priority='34' QFormat='true'
           Name='List Paragraph'/>
          <w:LsdException Locked='false' Priority='29' QFormat='true' Name='Quote'/>
          <w:LsdException Locked='false' Priority='30' QFormat='true'
           Name='Intense Quote'/>
          <w:LsdException Locked='false' Priority='66' Name='Medium List 2 Accent 1'/>
          <w:LsdException Locked='false' Priority='67' Name='Medium Grid 1 Accent 1'/>
          <w:LsdException Locked='false' Priority='68' Name='Medium Grid 2 Accent 1'/>
          <w:LsdException Locked='false' Priority='69' Name='Medium Grid 3 Accent 1'/>
          <w:LsdException Locked='false' Priority='70' Name='Dark List Accent 1'/>
          <w:LsdException Locked='false' Priority='71' Name='Colorful Shading Accent 1'/>
          <w:LsdException Locked='false' Priority='72' Name='Colorful List Accent 1'/>
          <w:LsdException Locked='false' Priority='73' Name='Colorful Grid Accent 1'/>
          <w:LsdException Locked='false' Priority='60' Name='Light Shading Accent 2'/>
          <w:LsdException Locked='false' Priority='61' Name='Light List Accent 2'/>
          <w:LsdException Locked='false' Priority='62' Name='Light Grid Accent 2'/>
          <w:LsdException Locked='false' Priority='63' Name='Medium Shading 1 Accent 2'/>
          <w:LsdException Locked='false' Priority='64' Name='Medium Shading 2 Accent 2'/>
          <w:LsdException Locked='false' Priority='65' Name='Medium List 1 Accent 2'/>
          <w:LsdException Locked='false' Priority='66' Name='Medium List 2 Accent 2'/>
          <w:LsdException Locked='false' Priority='67' Name='Medium Grid 1 Accent 2'/>
          <w:LsdException Locked='false' Priority='68' Name='Medium Grid 2 Accent 2'/>
          <w:LsdException Locked='false' Priority='69' Name='Medium Grid 3 Accent 2'/>
          <w:LsdException Locked='false' Priority='70' Name='Dark List Accent 2'/>
          <w:LsdException Locked='false' Priority='71' Name='Colorful Shading Accent 2'/>
          <w:LsdException Locked='false' Priority='72' Name='Colorful List Accent 2'/>
          <w:LsdException Locked='false' Priority='73' Name='Colorful Grid Accent 2'/>
          <w:LsdException Locked='false' Priority='60' Name='Light Shading Accent 3'/>
          <w:LsdException Locked='false' Priority='61' Name='Light List Accent 3'/>
          <w:LsdException Locked='false' Priority='62' Name='Light Grid Accent 3'/>
          <w:LsdException Locked='false' Priority='63' Name='Medium Shading 1 Accent 3'/>
          <w:LsdException Locked='false' Priority='64' Name='Medium Shading 2 Accent 3'/>
          <w:LsdException Locked='false' Priority='65' Name='Medium List 1 Accent 3'/>
          <w:LsdException Locked='false' Priority='66' Name='Medium List 2 Accent 3'/>
          <w:LsdException Locked='false' Priority='67' Name='Medium Grid 1 Accent 3'/>
          <w:LsdException Locked='false' Priority='68' Name='Medium Grid 2 Accent 3'/>
          <w:LsdException Locked='false' Priority='69' Name='Medium Grid 3 Accent 3'/>
          <w:LsdException Locked='false' Priority='70' Name='Dark List Accent 3'/>
          <w:LsdException Locked='false' Priority='71' Name='Colorful Shading Accent 3'/>
          <w:LsdException Locked='false' Priority='72' Name='Colorful List Accent 3'/>
          <w:LsdException Locked='false' Priority='73' Name='Colorful Grid Accent 3'/>
          <w:LsdException Locked='false' Priority='60' Name='Light Shading Accent 4'/>
          <w:LsdException Locked='false' Priority='61' Name='Light List Accent 4'/>
          <w:LsdException Locked='false' Priority='62' Name='Light Grid Accent 4'/>
          <w:LsdException Locked='false' Priority='63' Name='Medium Shading 1 Accent 4'/>
          <w:LsdException Locked='false' Priority='64' Name='Medium Shading 2 Accent 4'/>
          <w:LsdException Locked='false' Priority='65' Name='Medium List 1 Accent 4'/>
          <w:LsdException Locked='false' Priority='66' Name='Medium List 2 Accent 4'/>
          <w:LsdException Locked='false' Priority='67' Name='Medium Grid 1 Accent 4'/>
          <w:LsdException Locked='false' Priority='68' Name='Medium Grid 2 Accent 4'/>
          <w:LsdException Locked='false' Priority='69' Name='Medium Grid 3 Accent 4'/>
          <w:LsdException Locked='false' Priority='70' Name='Dark List Accent 4'/>
          <w:LsdException Locked='false' Priority='71' Name='Colorful Shading Accent 4'/>
          <w:LsdException Locked='false' Priority='72' Name='Colorful List Accent 4'/>
          <w:LsdException Locked='false' Priority='73' Name='Colorful Grid Accent 4'/>
          <w:LsdException Locked='false' Priority='60' Name='Light Shading Accent 5'/>
          <w:LsdException Locked='false' Priority='61' Name='Light List Accent 5'/>
          <w:LsdException Locked='false' Priority='62' Name='Light Grid Accent 5'/>
          <w:LsdException Locked='false' Priority='63' Name='Medium Shading 1 Accent 5'/>
          <w:LsdException Locked='false' Priority='64' Name='Medium Shading 2 Accent 5'/>
          <w:LsdException Locked='false' Priority='65' Name='Medium List 1 Accent 5'/>
          <w:LsdException Locked='false' Priority='66' Name='Medium List 2 Accent 5'/>
          <w:LsdException Locked='false' Priority='67' Name='Medium Grid 1 Accent 5'/>
          <w:LsdException Locked='false' Priority='68' Name='Medium Grid 2 Accent 5'/>
          <w:LsdException Locked='false' Priority='69' Name='Medium Grid 3 Accent 5'/>
          <w:LsdException Locked='false' Priority='70' Name='Dark List Accent 5'/>
          <w:LsdException Locked='false' Priority='71' Name='Colorful Shading Accent 5'/>
          <w:LsdException Locked='false' Priority='72' Name='Colorful List Accent 5'/>
          <w:LsdException Locked='false' Priority='73' Name='Colorful Grid Accent 5'/>
          <w:LsdException Locked='false' Priority='60' Name='Light Shading Accent 6'/>
          <w:LsdException Locked='false' Priority='61' Name='Light List Accent 6'/>
          <w:LsdException Locked='false' Priority='62' Name='Light Grid Accent 6'/>
          <w:LsdException Locked='false' Priority='63' Name='Medium Shading 1 Accent 6'/>
          <w:LsdException Locked='false' Priority='64' Name='Medium Shading 2 Accent 6'/>
          <w:LsdException Locked='false' Priority='65' Name='Medium List 1 Accent 6'/>
          <w:LsdException Locked='false' Priority='66' Name='Medium List 2 Accent 6'/>
          <w:LsdException Locked='false' Priority='67' Name='Medium Grid 1 Accent 6'/>
          <w:LsdException Locked='false' Priority='68' Name='Medium Grid 2 Accent 6'/>
          <w:LsdException Locked='false' Priority='69' Name='Medium Grid 3 Accent 6'/>
          <w:LsdException Locked='false' Priority='70' Name='Dark List Accent 6'/>
          <w:LsdException Locked='false' Priority='71' Name='Colorful Shading Accent 6'/>
          <w:LsdException Locked='false' Priority='72' Name='Colorful List Accent 6'/>
          <w:LsdException Locked='false' Priority='73' Name='Colorful Grid Accent 6'/>
          <w:LsdException Locked='false' Priority='19' QFormat='true'
           Name='Subtle Emphasis'/>
          <w:LsdException Locked='false' Priority='21' QFormat='true'
           Name='Intense Emphasis'/>
          <w:LsdException Locked='false' Priority='31' QFormat='true'
           Name='Subtle Reference'/>
          <w:LsdException Locked='false' Priority='32' QFormat='true'
           Name='Intense Reference'/>
          <w:LsdException Locked='false' Priority='33' QFormat='true' Name='Book Title'/>
          <w:LsdException Locked='false' Priority='37' SemiHidden='true'
           UnhideWhenUsed='true' Name='Bibliography'/>
          <w:LsdException Locked='false' Priority='39' SemiHidden='true'
           UnhideWhenUsed='true' QFormat='true' Name='TOC Heading'/>
          <w:LsdException Locked='false' Priority='41' Name='Plain Table 1'/>
          <w:LsdException Locked='false' Priority='42' Name='Plain Table 2'/>
          <w:LsdException Locked='false' Priority='43' Name='Plain Table 3'/>
          <w:LsdException Locked='false' Priority='44' Name='Plain Table 4'/>
          <w:LsdException Locked='false' Priority='45' Name='Plain Table 5'/>
          <w:LsdException Locked='false' Priority='40' Name='Grid Table Light'/>
          <w:LsdException Locked='false' Priority='46' Name='Grid Table 1 Light'/>
          <w:LsdException Locked='false' Priority='47' Name='Grid Table 2'/>
          <w:LsdException Locked='false' Priority='48' Name='Grid Table 3'/>
          <w:LsdException Locked='false' Priority='49' Name='Grid Table 4'/>
          <w:LsdException Locked='false' Priority='50' Name='Grid Table 5 Dark'/>
          <w:LsdException Locked='false' Priority='51' Name='Grid Table 6 Colorful'/>
          <w:LsdException Locked='false' Priority='52' Name='Grid Table 7 Colorful'/>
          <w:LsdException Locked='false' Priority='46'
           Name='Grid Table 1 Light Accent 1'/>
          <w:LsdException Locked='false' Priority='47' Name='Grid Table 2 Accent 1'/>
          <w:LsdException Locked='false' Priority='48' Name='Grid Table 3 Accent 1'/>
          <w:LsdException Locked='false' Priority='49' Name='Grid Table 4 Accent 1'/>
          <w:LsdException Locked='false' Priority='50' Name='Grid Table 5 Dark Accent 1'/>
          <w:LsdException Locked='false' Priority='51'
           Name='Grid Table 6 Colorful Accent 1'/>
          <w:LsdException Locked='false' Priority='52'
           Name='Grid Table 7 Colorful Accent 1'/>
          <w:LsdException Locked='false' Priority='46'
           Name='Grid Table 1 Light Accent 2'/>
          <w:LsdException Locked='false' Priority='47' Name='Grid Table 2 Accent 2'/>
          <w:LsdException Locked='false' Priority='48' Name='Grid Table 3 Accent 2'/>
          <w:LsdException Locked='false' Priority='49' Name='Grid Table 4 Accent 2'/>
          <w:LsdException Locked='false' Priority='50' Name='Grid Table 5 Dark Accent 2'/>
          <w:LsdException Locked='false' Priority='51'
           Name='Grid Table 6 Colorful Accent 2'/>
          <w:LsdException Locked='false' Priority='52'
           Name='Grid Table 7 Colorful Accent 2'/>
          <w:LsdException Locked='false' Priority='46'
           Name='Grid Table 1 Light Accent 3'/>
          <w:LsdException Locked='false' Priority='47' Name='Grid Table 2 Accent 3'/>
          <w:LsdException Locked='false' Priority='48' Name='Grid Table 3 Accent 3'/>
          <w:LsdException Locked='false' Priority='49' Name='Grid Table 4 Accent 3'/>
          <w:LsdException Locked='false' Priority='50' Name='Grid Table 5 Dark Accent 3'/>
          <w:LsdException Locked='false' Priority='51'
           Name='Grid Table 6 Colorful Accent 3'/>
          <w:LsdException Locked='false' Priority='52'
           Name='Grid Table 7 Colorful Accent 3'/>
          <w:LsdException Locked='false' Priority='46'
           Name='Grid Table 1 Light Accent 4'/>
          <w:LsdException Locked='false' Priority='47' Name='Grid Table 2 Accent 4'/>
          <w:LsdException Locked='false' Priority='48' Name='Grid Table 3 Accent 4'/>
          <w:LsdException Locked='false' Priority='49' Name='Grid Table 4 Accent 4'/>
          <w:LsdException Locked='false' Priority='50' Name='Grid Table 5 Dark Accent 4'/>
          <w:LsdException Locked='false' Priority='51'
           Name='Grid Table 6 Colorful Accent 4'/>
          <w:LsdException Locked='false' Priority='52'
           Name='Grid Table 7 Colorful Accent 4'/>
          <w:LsdException Locked='false' Priority='46'
           Name='Grid Table 1 Light Accent 5'/>
          <w:LsdException Locked='false' Priority='47' Name='Grid Table 2 Accent 5'/>
          <w:LsdException Locked='false' Priority='48' Name='Grid Table 3 Accent 5'/>
          <w:LsdException Locked='false' Priority='49' Name='Grid Table 4 Accent 5'/>
          <w:LsdException Locked='false' Priority='50' Name='Grid Table 5 Dark Accent 5'/>
          <w:LsdException Locked='false' Priority='51'
           Name='Grid Table 6 Colorful Accent 5'/>
          <w:LsdException Locked='false' Priority='52'
           Name='Grid Table 7 Colorful Accent 5'/>
          <w:LsdException Locked='false' Priority='46'
           Name='Grid Table 1 Light Accent 6'/>
          <w:LsdException Locked='false' Priority='47' Name='Grid Table 2 Accent 6'/>
          <w:LsdException Locked='false' Priority='48' Name='Grid Table 3 Accent 6'/>
          <w:LsdException Locked='false' Priority='49' Name='Grid Table 4 Accent 6'/>
          <w:LsdException Locked='false' Priority='50' Name='Grid Table 5 Dark Accent 6'/>
          <w:LsdException Locked='false' Priority='51'
           Name='Grid Table 6 Colorful Accent 6'/>
          <w:LsdException Locked='false' Priority='52'
           Name='Grid Table 7 Colorful Accent 6'/>
          <w:LsdException Locked='false' Priority='46' Name='List Table 1 Light'/>
          <w:LsdException Locked='false' Priority='47' Name='List Table 2'/>
          <w:LsdException Locked='false' Priority='48' Name='List Table 3'/>
          <w:LsdException Locked='false' Priority='49' Name='List Table 4'/>
          <w:LsdException Locked='false' Priority='50' Name='List Table 5 Dark'/>
          <w:LsdException Locked='false' Priority='51' Name='List Table 6 Colorful'/>
          <w:LsdException Locked='false' Priority='52' Name='List Table 7 Colorful'/>
          <w:LsdException Locked='false' Priority='46'
           Name='List Table 1 Light Accent 1'/>
          <w:LsdException Locked='false' Priority='47' Name='List Table 2 Accent 1'/>
          <w:LsdException Locked='false' Priority='48' Name='List Table 3 Accent 1'/>
          <w:LsdException Locked='false' Priority='49' Name='List Table 4 Accent 1'/>
          <w:LsdException Locked='false' Priority='50' Name='List Table 5 Dark Accent 1'/>
          <w:LsdException Locked='false' Priority='51'
           Name='List Table 6 Colorful Accent 1'/>
          <w:LsdException Locked='false' Priority='52'
           Name='List Table 7 Colorful Accent 1'/>
          <w:LsdException Locked='false' Priority='46'
           Name='List Table 1 Light Accent 2'/>
          <w:LsdException Locked='false' Priority='47' Name='List Table 2 Accent 2'/>
          <w:LsdException Locked='false' Priority='48' Name='List Table 3 Accent 2'/>
          <w:LsdException Locked='false' Priority='49' Name='List Table 4 Accent 2'/>
          <w:LsdException Locked='false' Priority='50' Name='List Table 5 Dark Accent 2'/>
          <w:LsdException Locked='false' Priority='51'
           Name='List Table 6 Colorful Accent 2'/>
          <w:LsdException Locked='false' Priority='52'
           Name='List Table 7 Colorful Accent 2'/>
          <w:LsdException Locked='false' Priority='46'
           Name='List Table 1 Light Accent 3'/>
          <w:LsdException Locked='false' Priority='47' Name='List Table 2 Accent 3'/>
          <w:LsdException Locked='false' Priority='48' Name='List Table 3 Accent 3'/>
          <w:LsdException Locked='false' Priority='49' Name='List Table 4 Accent 3'/>
          <w:LsdException Locked='false' Priority='50' Name='List Table 5 Dark Accent 3'/>
          <w:LsdException Locked='false' Priority='51'
           Name='List Table 6 Colorful Accent 3'/>
          <w:LsdException Locked='false' Priority='52'
           Name='List Table 7 Colorful Accent 3'/>
          <w:LsdException Locked='false' Priority='46'
           Name='List Table 1 Light Accent 4'/>
          <w:LsdException Locked='false' Priority='47' Name='List Table 2 Accent 4'/>
          <w:LsdException Locked='false' Priority='48' Name='List Table 3 Accent 4'/>
          <w:LsdException Locked='false' Priority='49' Name='List Table 4 Accent 4'/>
          <w:LsdException Locked='false' Priority='50' Name='List Table 5 Dark Accent 4'/>
          <w:LsdException Locked='false' Priority='51'
           Name='List Table 6 Colorful Accent 4'/>
          <w:LsdException Locked='false' Priority='52'
           Name='List Table 7 Colorful Accent 4'/>
          <w:LsdException Locked='false' Priority='46'
           Name='List Table 1 Light Accent 5'/>
          <w:LsdException Locked='false' Priority='47' Name='List Table 2 Accent 5'/>
          <w:LsdException Locked='false' Priority='48' Name='List Table 3 Accent 5'/>
          <w:LsdException Locked='false' Priority='49' Name='List Table 4 Accent 5'/>
          <w:LsdException Locked='false' Priority='50' Name='List Table 5 Dark Accent 5'/>
          <w:LsdException Locked='false' Priority='51'
           Name='List Table 6 Colorful Accent 5'/>
          <w:LsdException Locked='false' Priority='52'
           Name='List Table 7 Colorful Accent 5'/>
          <w:LsdException Locked='false' Priority='46'
           Name='List Table 1 Light Accent 6'/>
          <w:LsdException Locked='false' Priority='47' Name='List Table 2 Accent 6'/>
          <w:LsdException Locked='false' Priority='48' Name='List Table 3 Accent 6'/>
          <w:LsdException Locked='false' Priority='49' Name='List Table 4 Accent 6'/>
          <w:LsdException Locked='false' Priority='50' Name='List Table 5 Dark Accent 6'/>
          <w:LsdException Locked='false' Priority='51'
           Name='List Table 6 Colorful Accent 6'/>
          <w:LsdException Locked='false' Priority='52'
           Name='List Table 7 Colorful Accent 6'/>
         </w:LatentStyles>
        </xml><![endif]-->
        <style>
        <!--
         /* Font Definitions */
         @font-face
          {font-family:'Cambria Math';
          panose-1:2 4 5 3 5 4 6 3 2 4;
          mso-font-charset:204;
          mso-generic-font-family:roman;
          mso-font-pitch:variable;
          mso-font-signature:-536870145 1107305727 0 0 415 0;}
        @font-face
          {font-family:Calibri;
          panose-1:2 15 5 2 2 2 4 3 2 4;
          mso-font-charset:204;
          mso-generic-font-family:swiss;
          mso-font-pitch:variable;
          mso-font-signature:-536870145 1073786111 1 0 415 0;}
         /* Style Definitions */
         p.MsoNormal, li.MsoNormal, div.MsoNormal
          {mso-style-unhide:no;
          mso-style-qformat:yes;
          mso-style-parent:'';
          margin:0cm;
          margin-bottom:.0001pt;
          mso-pagination:widow-orphan;
          font-size:12.0pt;
          font-family:'Times New Roman',serif;
          mso-fareast-font-family:'Times New Roman';}
        p.MsoNoSpacing, li.MsoNoSpacing, div.MsoNoSpacing
          {mso-style-priority:1;
          mso-style-unhide:no;
          mso-style-qformat:yes;
          mso-style-parent:'';
          margin-top:0cm;
          margin-right:0cm;
          margin-bottom:0cm;
          margin-left:269.35pt;
          margin-bottom:.0001pt;
          mso-pagination:widow-orphan;
          font-size:11.0pt;
          font-family:'Calibri',sans-serif;
          mso-fareast-font-family:Calibri;
          mso-bidi-font-family:'Times New Roman';
          mso-fareast-language:EN-US;}
        @page WordSection1
          {size:595.3pt 841.9pt;
          margin:2.0cm 42.5pt 2.0cm 3.0cm;
          mso-header-margin:35.4pt;
          mso-footer-margin:35.4pt;
          mso-paper-source:0;}
        div.WordSection1
          {page:WordSection1;}
         /* List Definitions */
         @list l0
          {mso-list-id:118961194;
          mso-list-type:hybrid;
          mso-list-template-ids:-1053284950 68747279 68747289 68747291 68747279 68747289 68747291 68747279 68747289 68747291;}
        @list l0:level1
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:39.3pt;
          text-indent:-18.0pt;}
        @list l0:level2
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l0:level3
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          text-indent:-9.0pt;}
        @list l0:level4
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l0:level5
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l0:level6
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          text-indent:-9.0pt;}
        @list l0:level7
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l0:level8
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l0:level9
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          text-indent:-9.0pt;}
        @list l1
          {mso-list-id:220750933;
          mso-list-type:hybrid;
          mso-list-template-ids:-1838760368 -2129610734 201217632 445129374 -1987139932 1909498996 1668690852 -1421845494 -2105237472 1874363752;}
        @list l1:level1
          {mso-level-tab-stop:36.0pt;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l1:level2
          {mso-level-start-at:0;
          mso-level-number-format:none;
          mso-level-text:'';
          mso-level-tab-stop:18.0pt;
          mso-level-number-position:left;
          margin-left:0cm;
          text-indent:0cm;}
        @list l1:level3
          {mso-level-start-at:0;
          mso-level-number-format:none;
          mso-level-text:'';
          mso-level-tab-stop:18.0pt;
          mso-level-number-position:left;
          margin-left:0cm;
          text-indent:0cm;}
        @list l1:level4
          {mso-level-start-at:0;
          mso-level-number-format:none;
          mso-level-text:'';
          mso-level-tab-stop:18.0pt;
          mso-level-number-position:left;
          margin-left:0cm;
          text-indent:0cm;}
        @list l1:level5
          {mso-level-start-at:0;
          mso-level-number-format:none;
          mso-level-text:'';
          mso-level-tab-stop:18.0pt;
          mso-level-number-position:left;
          margin-left:0cm;
          text-indent:0cm;}
        @list l1:level6
          {mso-level-start-at:0;
          mso-level-number-format:none;
          mso-level-text:'';
          mso-level-tab-stop:18.0pt;
          mso-level-number-position:left;
          margin-left:0cm;
          text-indent:0cm;}
        @list l1:level7
          {mso-level-start-at:0;
          mso-level-number-format:none;
          mso-level-text:'';
          mso-level-tab-stop:18.0pt;
          mso-level-number-position:left;
          margin-left:0cm;
          text-indent:0cm;}
        @list l1:level8
          {mso-level-start-at:0;
          mso-level-number-format:none;
          mso-level-text:'';
          mso-level-tab-stop:18.0pt;
          mso-level-number-position:left;
          margin-left:0cm;
          text-indent:0cm;}
        @list l1:level9
          {mso-level-start-at:0;
          mso-level-number-format:none;
          mso-level-text:'';
          mso-level-tab-stop:18.0pt;
          mso-level-number-position:left;
          margin-left:0cm;
          text-indent:0cm;}
        @list l2
          {mso-list-id:259872205;
          mso-list-type:hybrid;
          mso-list-template-ids:-1047500286 702450778 68747289 68747291 68747279 68747289 68747291 68747279 68747289 68747291;}
        @list l2:level1
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:54.0pt;
          text-indent:-18.0pt;}
        @list l2:level2
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l2:level3
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          text-indent:-9.0pt;}
        @list l2:level4
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l2:level5
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l2:level6
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          text-indent:-9.0pt;}
        @list l2:level7
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l2:level8
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l2:level9
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          text-indent:-9.0pt;}
        @list l3
          {mso-list-id:602031281;
          mso-list-type:hybrid;
          mso-list-template-ids:1685725558 68747279 68747289 68747291 68747279 68747289 68747291 68747279 68747289 68747291;}
        @list l3:level1
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l3:level2
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l3:level3
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          text-indent:-9.0pt;}
        @list l3:level4
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l3:level5
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l3:level6
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          text-indent:-9.0pt;}
        @list l3:level7
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l3:level8
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l3:level9
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          text-indent:-9.0pt;}
        @list l4
          {mso-list-id:769206139;
          mso-list-template-ids:-1517362986;}
        @list l4:level1
          {mso-level-text:%1;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:18.0pt;
          text-indent:-18.0pt;}
        @list l4:level2
          {mso-level-text:'%1\.%2';
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:54.0pt;
          text-indent:-18.0pt;}
        @list l4:level3
          {mso-level-text:'%1\.%2\.%3';
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-36.0pt;}
        @list l4:level4
          {mso-level-text:'%1\.%2\.%3\.%4';
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-36.0pt;}
        @list l4:level5
          {mso-level-text:'%1\.%2\.%3\.%4\.%5';
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:198.0pt;
          text-indent:-54.0pt;}
        @list l4:level6
          {mso-level-text:'%1\.%2\.%3\.%4\.%5\.%6';
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:234.0pt;
          text-indent:-54.0pt;}
        @list l4:level7
          {mso-level-text:'%1\.%2\.%3\.%4\.%5\.%6\.%7';
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:288.0pt;
          text-indent:-72.0pt;}
        @list l4:level8
          {mso-level-text:'%1\.%2\.%3\.%4\.%5\.%6\.%7\.%8';
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:324.0pt;
          text-indent:-72.0pt;}
        @list l4:level9
          {mso-level-text:'%1\.%2\.%3\.%4\.%5\.%6\.%7\.%8\.%9';
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:378.0pt;
          text-indent:-90.0pt;}
        @list l5
          {mso-list-id:859780745;
          mso-list-type:hybrid;
          mso-list-template-ids:-551369314 702450778 68747289 68747291 68747279 68747289 68747291 68747279 68747289 68747291;}
        @list l5:level1
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:54.0pt;
          text-indent:-18.0pt;}
        @list l5:level2
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l5:level3
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          text-indent:-9.0pt;}
        @list l5:level4
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l5:level5
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l5:level6
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          text-indent:-9.0pt;}
        @list l5:level7
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l5:level8
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l5:level9
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          text-indent:-9.0pt;}
        @list l6
          {mso-list-id:990137007;
          mso-list-template-ids:-426240426;}
        @list l6:level1
          {mso-level-start-at:2;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:54.0pt;
          text-indent:-18.0pt;}
        @list l6:level2
          {mso-level-legal-format:yes;
          mso-level-text:'%1\.%2';
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l6:level3
          {mso-level-legal-format:yes;
          mso-level-text:'%1\.%2\.%3';
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-36.0pt;}
        @list l6:level4
          {mso-level-legal-format:yes;
          mso-level-text:'%1\.%2\.%3\.%4';
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:126.0pt;
          text-indent:-36.0pt;}
        @list l6:level5
          {mso-level-legal-format:yes;
          mso-level-text:'%1\.%2\.%3\.%4\.%5';
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:162.0pt;
          text-indent:-54.0pt;}
        @list l6:level6
          {mso-level-legal-format:yes;
          mso-level-text:'%1\.%2\.%3\.%4\.%5\.%6';
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:180.0pt;
          text-indent:-54.0pt;}
        @list l6:level7
          {mso-level-legal-format:yes;
          mso-level-text:'%1\.%2\.%3\.%4\.%5\.%6\.%7';
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:216.0pt;
          text-indent:-72.0pt;}
        @list l6:level8
          {mso-level-legal-format:yes;
          mso-level-text:'%1\.%2\.%3\.%4\.%5\.%6\.%7\.%8';
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:234.0pt;
          text-indent:-72.0pt;}
        @list l6:level9
          {mso-level-legal-format:yes;
          mso-level-text:'%1\.%2\.%3\.%4\.%5\.%6\.%7\.%8\.%9';
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:270.0pt;
          text-indent:-90.0pt;}
        @list l7
          {mso-list-id:1541361025;
          mso-list-type:hybrid;
          mso-list-template-ids:1656648946 -643415386 68747289 68747291 68747279 68747289 68747291 68747279 68747289 68747291;}
        @list l7:level1
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:54.0pt;
          text-indent:-18.0pt;}
        @list l7:level2
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:90.0pt;
          text-indent:-18.0pt;}
        @list l7:level3
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          margin-left:126.0pt;
          text-indent:-9.0pt;}
        @list l7:level4
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:162.0pt;
          text-indent:-18.0pt;}
        @list l7:level5
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:198.0pt;
          text-indent:-18.0pt;}
        @list l7:level6
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          margin-left:234.0pt;
          text-indent:-9.0pt;}
        @list l7:level7
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:270.0pt;
          text-indent:-18.0pt;}
        @list l7:level8
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:306.0pt;
          text-indent:-18.0pt;}
        @list l7:level9
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          margin-left:342.0pt;
          text-indent:-9.0pt;}
        @list l8
          {mso-list-id:1634603386;
          mso-list-type:hybrid;
          mso-list-template-ids:553918508 68747279 68747289 68747291 68747279 68747289 68747291 68747279 68747289 68747291;}
        @list l8:level1
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l8:level2
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l8:level3
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          text-indent:-9.0pt;}
        @list l8:level4
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l8:level5
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l8:level6
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          text-indent:-9.0pt;}
        @list l8:level7
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l8:level8
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l8:level9
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          text-indent:-9.0pt;}
        @list l9
          {mso-list-id:1880507095;
          mso-list-type:hybrid;
          mso-list-template-ids:-113106560 -1083273990 68747289 68747291 68747279 68747289 68747291 68747279 68747289 68747291;}
        @list l9:level1
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:72.0pt;
          text-indent:-18.0pt;}
        @list l9:level2
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:108.0pt;
          text-indent:-18.0pt;}
        @list l9:level3
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          margin-left:144.0pt;
          text-indent:-9.0pt;}
        @list l9:level4
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:180.0pt;
          text-indent:-18.0pt;}
        @list l9:level5
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:216.0pt;
          text-indent:-18.0pt;}
        @list l9:level6
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          margin-left:252.0pt;
          text-indent:-9.0pt;}
        @list l9:level7
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:288.0pt;
          text-indent:-18.0pt;}
        @list l9:level8
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:324.0pt;
          text-indent:-18.0pt;}
        @list l9:level9
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          margin-left:360.0pt;
          text-indent:-9.0pt;}
        @list l10
          {mso-list-id:2026442606;
          mso-list-type:hybrid;
          mso-list-template-ids:723564004 702450778 68747289 68747291 68747279 68747289 68747291 68747279 68747289 68747291;}
        @list l10:level1
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:54.0pt;
          text-indent:-18.0pt;}
        @list l10:level2
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:90.0pt;
          text-indent:-18.0pt;}
        @list l10:level3
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          margin-left:126.0pt;
          text-indent:-9.0pt;}
        @list l10:level4
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:162.0pt;
          text-indent:-18.0pt;}
        @list l10:level5
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:198.0pt;
          text-indent:-18.0pt;}
        @list l10:level6
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          margin-left:234.0pt;
          text-indent:-9.0pt;}
        @list l10:level7
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:270.0pt;
          text-indent:-18.0pt;}
        @list l10:level8
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:306.0pt;
          text-indent:-18.0pt;}
        @list l10:level9
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          margin-left:342.0pt;
          text-indent:-9.0pt;}
        @list l11
          {mso-list-id:2031761184;
          mso-list-type:hybrid;
          mso-list-template-ids:-186882602 702450778 68747289 68747291 68747279 68747289 68747291 68747279 68747289 68747291;}
        @list l11:level1
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          margin-left:54.0pt;
          text-indent:-18.0pt;}
        @list l11:level2
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l11:level3
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          text-indent:-9.0pt;}
        @list l11:level4
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l11:level5
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l11:level6
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          text-indent:-9.0pt;}
        @list l11:level7
          {mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l11:level8
          {mso-level-number-format:alpha-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:left;
          text-indent:-18.0pt;}
        @list l11:level9
          {mso-level-number-format:roman-lower;
          mso-level-tab-stop:none;
          mso-level-number-position:right;
          text-indent:-9.0pt;}
        ol
          {margin-bottom:0cm;}
        ul
          {margin-bottom:0cm;}
        -->
        </style>
        <!--[if gte mso 10]>
        <style>
         /* Style Definitions */
         table.MsoNormalTable
          {mso-style-name:'Обычная таблица';
          mso-tstyle-rowband-size:0;
          mso-tstyle-colband-size:0;
          mso-style-noshow:yes;
          mso-style-unhide:no;
          mso-style-parent:'';
          mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
          mso-para-margin:0cm;
          mso-para-margin-bottom:.0001pt;
          mso-pagination:widow-orphan;
          font-size:10.0pt;
          font-family:'Times New Roman',serif;}
        table.MsoTableGrid
          {mso-style-name:'Сетка таблицы';
          mso-tstyle-rowband-size:0;
          mso-tstyle-colband-size:0;
          mso-style-unhide:no;
          border:solid windowtext 1.0pt;
          mso-border-alt:solid windowtext .5pt;
          mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
          mso-border-insideh:.5pt solid windowtext;
          mso-border-insidev:.5pt solid windowtext;
          mso-para-margin:0cm;
          mso-para-margin-bottom:.0001pt;
          mso-pagination:widow-orphan;
          font-size:10.0pt;
          font-family:'Times New Roman',serif;}
        </style>
        <![endif]--><!--[if gte mso 9]><xml>
         <o:shapedefaults v:ext='edit' spidmax='1026'/>
        </xml><![endif]--><!--[if gte mso 9]><xml>
         <o:shapelayout v:ext='edit'>
          <o:idmap v:ext='edit' data='1'/>
         </o:shapelayout></xml><![endif]-->
        </head>
        
        <body lang=RU style='tab-interval:35.4pt'>
        
        <div class=WordSection1>
        
        <p class=MsoNormal align=center style='text-align:center'><span
        style='font-size:14.0pt'>Государственное учреждение образования <o:p></o:p></span></p>
        
        <p class=MsoNormal align=center style='text-align:center'><span
        style='font-size:14.0pt'>«Белорусская медицинская академия последипломного
        образования»<o:p></o:p></span></p>
        
        <p class=MsoNormal align=center style='text-align:center'><span
        style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
        
        <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width=650
         style='width:487.35pt;border-collapse:collapse;mso-yfti-tbllook:1184;
         mso-padding-alt:0cm 5.4pt 0cm 5.4pt'>
         <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>
          <td width=650 colspan=19 valign=top style='width:487.35pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'>ЗАЧЁТНО-ЭКЗАМЕНАЦИОННАЯ ВЕДОМОСТЬ<o:p></o:p></span></p>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:1'>
          <td width=73 colspan=2 valign=top style='width:54.6pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal style='text-align:justify'><span style='font-size:14.0pt'>Группа<o:p></o:p></span></p>
          </td>
          <td width=577 colspan=17 valign=top style='width:432.75pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><i style='mso-bidi-font-style:normal'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></i></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:2'>
          <td width=167 colspan=4 valign=top style='width:125.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'>Форма аттестации:<o:p></o:p></span></p>
          </td>
          <td width=483 colspan=15 valign=top style='width:362.35pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'>комплексный государственный
          экзамен<o:p></o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:3'>
          <td width=308 colspan=7 valign=top style='width:231.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'>Учебные(ая) дисциплины(а):<o:p></o:p></span></p>
          </td>
          <td width=341 colspan=12 valign=top style='width:256.1pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:4'>
          <td width=650 colspan=19 valign=top style='width:487.35pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><i style='mso-bidi-font-style:normal'><span
          style='font-size:14.0pt'>1.<o:p></o:p></span></i></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:5'>
          <td width=650 colspan=19 valign=top style='width:487.35pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><i style='mso-bidi-font-style:normal'><span
          style='font-size:14.0pt'>2.<o:p></o:p></span></i></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:6'>
          <td width=650 colspan=19 valign=top style='width:487.35pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><i style='mso-bidi-font-style:normal'><span
          style='font-size:14.0pt'>3.<o:p></o:p></span></i></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:7'>
          <td width=308 colspan=7 valign=top style='width:231.25pt;border:none;
          mso-border-top-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'>Председатель
          государственной экзаменационной комиссии<o:p></o:p></span></p>
          </td>
          <td width=341 colspan=12 valign=top style='width:256.1pt;border:none;
          mso-border-top-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:8'>
          <td width=308 colspan=7 rowspan=2 valign=top style='width:231.25pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'>Члены государственной
          экзаменационной комиссии<o:p></o:p></span></p>
          </td>
          <td width=341 colspan=12 valign=top style='width:256.1pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:9'>
          <td width=341 colspan=12 valign=top style='width:256.1pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:10'>
          <td width=308 colspan=7 valign=top style='width:231.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=341 colspan=12 valign=top style='width:256.1pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:11'>
          <td width=308 colspan=7 valign=top style='width:231.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=341 colspan=12 valign=top style='width:256.1pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:12'>
          <td width=308 colspan=7 valign=top style='width:231.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=341 colspan=12 valign=top style='width:256.1pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:13'>
          <td width=308 colspan=7 valign=top style='width:231.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=341 colspan=12 valign=top style='width:256.1pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:14'>
          <td width=489 colspan=16 valign=top style='width:366.9pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'>Дата проведения комплексного
          государственного экзамена<o:p></o:p></span></p>
          </td>
          <td width=161 colspan=3 valign=top style='width:120.45pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:15'>
          <td width=308 colspan=7 valign=top style='width:231.25pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=341 colspan=12 valign=top style='width:256.1pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:16'>
          <td width=422 colspan=12 valign=top style='width:316.75pt;border:solid windowtext 1.0pt;
          border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'>Фамилия, собственное имя, отчество (если таковое
          имеется) слушателя<o:p></o:p></span></p>
          </td>
          <td width=227 colspan=7 valign=top style='width:170.6pt;border-top:none;
          border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'>Отметка<o:p></o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:17'>
          <td width=422 colspan=12 valign=top style='width:316.75pt;border:solid windowtext 1.0pt;
          border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal style='margin-left:0cm;text-indent:0cm;mso-list:l0 level1 lfo12;
          tab-stops:14.2pt'><![if !supportLists]><span style='font-size:14.0pt'><span
          style='mso-list:Ignore'>1.<span style='font:7.0pt 'Times New Roman''>&nbsp;&nbsp;
          </span></span></span><![endif]><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=227 colspan=7 valign=top style='width:170.6pt;border-top:none;
          border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:18'>
          <td width=422 colspan=12 valign=top style='width:316.75pt;border:solid windowtext 1.0pt;
          border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal style='margin-left:0cm;text-indent:0cm;mso-list:l0 level1 lfo12;
          tab-stops:14.2pt'><![if !supportLists]><span style='font-size:14.0pt'><span
          style='mso-list:Ignore'>2.<span style='font:7.0pt 'Times New Roman''>&nbsp;&nbsp;
          </span></span></span><![endif]><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=227 colspan=7 valign=top style='width:170.6pt;border-top:none;
          border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:19'>
          <td width=422 colspan=12 valign=top style='width:316.75pt;border:solid windowtext 1.0pt;
          border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal style='margin-left:0cm;text-indent:0cm;mso-list:l0 level1 lfo12;
          tab-stops:14.2pt'><![if !supportLists]><span style='font-size:14.0pt'><span
          style='mso-list:Ignore'>3.<span style='font:7.0pt 'Times New Roman''>&nbsp;&nbsp;
          </span></span></span><![endif]><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=227 colspan=7 valign=top style='width:170.6pt;border-top:none;
          border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:20'>
          <td width=422 colspan=12 valign=top style='width:316.75pt;border:solid windowtext 1.0pt;
          border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal style='margin-left:0cm;text-indent:0cm;mso-list:l0 level1 lfo12;
          tab-stops:14.2pt'><![if !supportLists]><span style='font-size:14.0pt'><span
          style='mso-list:Ignore'>4.<span style='font:7.0pt 'Times New Roman''>&nbsp;&nbsp;
          </span></span></span><![endif]><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=227 colspan=7 valign=top style='width:170.6pt;border-top:none;
          border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:21'>
          <td width=422 colspan=12 valign=top style='width:316.75pt;border:solid windowtext 1.0pt;
          border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal style='margin-left:0cm;text-indent:0cm;mso-list:l0 level1 lfo12;
          tab-stops:14.2pt'><![if !supportLists]><span style='font-size:14.0pt'><span
          style='mso-list:Ignore'>5.<span style='font:7.0pt 'Times New Roman''>&nbsp;&nbsp;
          </span></span></span><![endif]><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=227 colspan=7 valign=top style='width:170.6pt;border-top:none;
          border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:22'>
          <td width=422 colspan=12 valign=top style='width:316.75pt;border:solid windowtext 1.0pt;
          border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal style='margin-left:0cm;text-indent:0cm;mso-list:l0 level1 lfo12;
          tab-stops:14.2pt'><![if !supportLists]><span style='font-size:14.0pt'><span
          style='mso-list:Ignore'>6.<span style='font:7.0pt 'Times New Roman''>&nbsp;&nbsp;
          </span></span></span><![endif]><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=227 colspan=7 valign=top style='width:170.6pt;border-top:none;
          border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:23'>
          <td width=422 colspan=12 valign=top style='width:316.75pt;border:solid windowtext 1.0pt;
          border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal style='margin-left:0cm;text-indent:0cm;mso-list:l0 level1 lfo12;
          tab-stops:14.2pt'><![if !supportLists]><span style='font-size:14.0pt'><span
          style='mso-list:Ignore'>7.<span style='font:7.0pt 'Times New Roman''>&nbsp;&nbsp;
          </span></span></span><![endif]><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=227 colspan=7 valign=top style='width:170.6pt;border-top:none;
          border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:24'>
          <td width=422 colspan=12 valign=top style='width:316.75pt;border:solid windowtext 1.0pt;
          border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal style='margin-left:0cm;text-indent:0cm;mso-list:l0 level1 lfo12;
          tab-stops:14.2pt'><![if !supportLists]><span style='font-size:14.0pt'><span
          style='mso-list:Ignore'>8.<span style='font:7.0pt 'Times New Roman''>&nbsp;&nbsp;
          </span></span></span><![endif]><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=227 colspan=7 valign=top style='width:170.6pt;border-top:none;
          border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:25'>
          <td width=422 colspan=12 valign=top style='width:316.75pt;border:none;
          mso-border-top-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'>Количество слушателей, <o:p></o:p></span></p>
          <p class=MsoNormal><span style='font-size:14.0pt'>присутствовавших на
          государственном экзамене<o:p></o:p></span></p>
          </td>
          <td width=57 colspan=3 valign=top style='width:42.9pt;border:none;border-bottom:
          solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:
          solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;padding:
          0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=170 colspan=4 valign=top style='width:127.7pt;border:none;
          mso-border-top-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          <p class=MsoNormal><span style='font-size:14.0pt'>чел.<o:p></o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:26'>
          <td width=422 colspan=12 valign=top style='width:316.75pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'>Количество слушателей,
          получивших отметки:<o:p></o:p></span></p>
          </td>
          <td width=227 colspan=7 valign=top style='width:170.6pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:27'>
          <td width=63 valign=top style='width:47.55pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'>«10» -<o:p></o:p></span></p>
          </td>
          <td width=62 colspan=2 valign=top style='width:46.85pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=63 colspan=2 valign=top style='width:47.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'>«8» - <o:p></o:p></span></p>
          </td>
          <td width=63 valign=top style='width:47.3pt;border:none;border-bottom:solid windowtext 1.0pt;
          mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=63 colspan=2 valign=top style='width:47.35pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'>«6» - <o:p></o:p></span></p>
          </td>
          <td width=63 colspan=2 valign=top style='width:47.3pt;border:none;border-bottom:
          solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=63 colspan=4 valign=top style='width:47.5pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'>«4» - <o:p></o:p></span></p>
          </td>
          <td width=63 colspan=3 valign=top style='width:47.35pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=63 valign=top style='width:47.3pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'>«2»- <o:p></o:p></span></p>
          </td>
          <td width=82 valign=top style='width:61.6pt;border:none;border-bottom:solid windowtext 1.0pt;
          mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:28'>
          <td width=63 valign=top style='width:47.55pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'>«9» - <o:p></o:p></span></p>
          </td>
          <td width=62 colspan=2 valign=top style='width:46.85pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=63 colspan=2 valign=top style='width:47.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'>«7» - <o:p></o:p></span></p>
          </td>
          <td width=63 valign=top style='width:47.3pt;border:none;border-bottom:solid windowtext 1.0pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:solid windowtext .5pt;
          mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=63 colspan=2 valign=top style='width:47.35pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'>«5» - <o:p></o:p></span></p>
          </td>
          <td width=63 colspan=2 valign=top style='width:47.3pt;border:none;border-bottom:
          solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:
          solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;padding:
          0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=63 colspan=4 valign=top style='width:47.5pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'>«3» - <o:p></o:p></span></p>
          </td>
          <td width=63 colspan=3 valign=top style='width:47.35pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=63 valign=top style='width:47.3pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'>«1» - <o:p></o:p></span></p>
          </td>
          <td width=82 valign=top style='width:61.6pt;border:none;border-bottom:solid windowtext 1.0pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:solid windowtext .5pt;
          mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:29'>
          <td width=366 colspan=9 valign=top style='width:274.4pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'>Количество слушателей, <o:p></o:p></span></p>
          <p class=MsoNormal><span style='font-size:14.0pt'>не явившихся на
          государственный экзамен<o:p></o:p></span></p>
          </td>
          <td width=66 colspan=4 valign=top style='width:49.75pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=center style='text-align:center'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=218 colspan=6 valign=top style='width:163.2pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          <p class=MsoNormal><span style='font-size:14.0pt'>чел.<o:p></o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:30'>
          <td width=308 colspan=7 valign=top style='width:231.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'>Председатель
          государственной экзаменационной комиссии<o:p></o:p></span></p>
          </td>
          <td width=104 colspan=4 valign=top style='width:78.1pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=right style='text-align:right'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=237 colspan=8 valign=bottom style='width:178.0pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'>/<o:p></o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:31'>
          <td width=308 colspan=7 valign=top style='width:231.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'>Члены государственной
          экзаменационной комиссии<o:p></o:p></span></p>
          </td>
          <td width=104 colspan=4 valign=top style='width:78.1pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=right style='text-align:right'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=237 colspan=8 valign=bottom style='width:178.0pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'>/<o:p></o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:32'>
          <td width=308 colspan=7 valign=top style='width:231.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=104 colspan=4 valign=top style='width:78.1pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=right style='text-align:right'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=237 colspan=8 valign=bottom style='width:178.0pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'>/<o:p></o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:33'>
          <td width=308 colspan=7 valign=top style='width:231.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=104 colspan=4 valign=top style='width:78.1pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=right style='text-align:right'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=237 colspan=8 valign=bottom style='width:178.0pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'>/<o:p></o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:34'>
          <td width=308 colspan=7 valign=top style='width:231.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=104 colspan=4 valign=top style='width:78.1pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=right style='text-align:right'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=237 colspan=8 valign=bottom style='width:178.0pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'>/<o:p></o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:35'>
          <td width=308 colspan=7 valign=top style='width:231.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=104 colspan=4 valign=top style='width:78.1pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=right style='text-align:right'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=237 colspan=8 valign=bottom style='width:178.0pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'>/<o:p></o:p></span></p>
          </td>
         </tr>
         <tr style='mso-yfti-irow:36;mso-yfti-lastrow:yes'>
          <td width=308 colspan=7 valign=top style='width:231.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'>Секретарь государственной
          экзаменационной комиссии<o:p></o:p></span></p>
          </td>
          <td width=104 colspan=4 valign=top style='width:78.1pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=right style='text-align:right'><span
          style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
          </td>
          <td width=237 colspan=8 valign=bottom style='width:178.0pt;border:none;
          border-bottom:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;
          mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
          padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal><span style='font-size:14.0pt'>/<o:p></o:p></span></p>
          </td>
         </tr>
         <![if !supportMisalignedColumns]>
         <tr height=0>
          <td width=83 style='border:none'></td>
          <td width=12 style='border:none'></td>
          <td width=69 style='border:none'></td>
          <td width=53 style='border:none'></td>
          <td width=29 style='border:none'></td>
          <td width=82 style='border:none'></td>
          <td width=73 style='border:none'></td>
          <td width=9 style='border:none'></td>
          <td width=66 style='border:none'></td>
          <td width=16 style='border:none'></td>
          <td width=45 style='border:none'></td>
          <td width=13 style='border:none'></td>
          <td width=13 style='border:none'></td>
          <td width=12 style='border:none'></td>
          <td width=50 style='border:none'></td>
          <td width=13 style='border:none'></td>
          <td width=20 style='border:none'></td>
          <td width=82 style='border:none'></td>
          <td width=107 style='border:none'></td>
         </tr>
         <![endif]>
        </table>
        
        <p class=MsoNormal><o:p>&nbsp;</o:p></p>
        
        </div>
        
        </body>
        
        </html>";
    
        // $Start = date_create_from_format('Y-m-d', $courseNameArr["Start"]);
        // $Start = $Start->format("d.m.y");
        // $Finish = date_create_from_format('Y-m-d', $courseNameArr["Finish"]);
        // $Finish = $Finish->format("d.m.y") ;
        // $doc_body .= "<p style='text-align:center;'>Государственное учреждение образования <br />
        //                 «Белорусская медицинская академия последипломного образования»
        //                 </p>
        //         <p style='text-align:center'>ЗАЧЁТНО-ЭКЗАМЕНАЦИОННАЯ ВЕДОМОСТЬ</p>";
        
        // $doc_body .= "<table><tr>";
        // $doc_body .= "<td style='width:10px;'>Группа</td>";
        // $doc_body .= "<td style='border-bottom:1px solid black'></td></tr>";
        // $doc_body .= "<tr><td>Форма аттестации:</td><td>комплексный государственный экзамен</td></tr>";
        // $doc_body .= "<tr><td>Учебные(ая) дисциплины(а):</td><td> \"$courseName\" ($notes)</td></tr>";
        // $doc_body .= "<tr><td>Председатель государственной комиссии:</td><td></td></tr>";
        // $doc_body .= "<tr><td>Члены государственной экзаменационной комиссии:</td><td></td></tr></table>";
        
        // $doc_body .= "<p>Дата проведения аттестации: $exam_date</p>";
        // $doc_body .= "<table style='border: 1px solid black; border-collapse: collapse;'>
        //                 <tr>
        //                     <th style='border:1px solid black;'>№</th>
        //                     <th style='border:1px solid black;'>Фамилия, собственное имя, отчество (если таковое имеется) слушателя</th>
        //                     <th style='border:1px solid black;'>Отметка</th>
        //                 </tr>";
        // $index = 1;
        // while ($row = $studObj->fetch_assoc()) {
        //        $person = $row["surname"] . " " . $row["name"] . " " . $row["patername"];
        //        $doc_body .= "<tr style='border:1px solid black;'>
        //                         <td style='border:1px solid black;'>$index</td>
        //                         <td style='border:1px solid black;'>$person</td>
        //                         <td style='border:1px solid black;'></td>
        //                     </tr>";
        //         $index++;
        //    }   

        // $doc_body .= "</table>";
        // $doc_body .= "<p>Количество слушателей, присутствовавших на аттестации _____чел.</p>";
        // $doc_body .= "<p>Количество слушателей, получивших отметки:</p>";
        // $doc_body .= "<table><tr><td>«зачтено»</td><td>_____ чел.</td></tr>";
        // $doc_body .= "<tr><td>«не зачтено»</td><td>_____ чел.</td></tr></table>";

        // $doc_body .= "<p>Количество слушателей, не явившихся на аттестацию _____ чел.</p>";
        // $doc_body .= "<table><tr><td>Члены комиссии</td><td>__________________________<br/>__________________________<br/>__________________________<br/>__________________________<br/></td></tr></table>";
        // $doc_body .= "<table><tr><td>Декан факультета</td><td>___________________</td></tr></table>";
        // $doc_body .= '<span style="font-size:12.0pt;font-family:\"Times New Roman\","serif";mso-fareast-font-family:
        //                 \"Times New Roman\";mso-fareast-theme-font:minor-fareast;mso-ansi-language:RU;
        //                 mso-fareast-language:RU;mso-bidi-language:AR-SA"><br clear=all
        //                 style="mso-special-character:line-break;page-break-before:always">
        //                 </span>';
    }
    return $doc_body;
  }