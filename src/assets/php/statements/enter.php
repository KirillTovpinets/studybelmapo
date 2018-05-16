<?php 
  function makeEnter($data, $courses, $mysqli){
    // $prorector = $data->prorector;
    // $headmaster = $data->headmaster;
    // $exam_form = $data->exam_form;
    // $exam_date = $data->exam_date;
    $doc_body = "";
    $typeId = $courses[0]->Type;
    $query = "SELECT * FROM educType WHERE id = $typeId";
    $typeObj = $mysqli->query($query) or die ("Error in '$query': " . mysqli_error($mysqli));
    $typeArr = $typeObj->fetch_assoc();
    $type = mb_strtolower($typeArr["name"]);
    $typeRelForm = mb_strtolower($typeArr["Relative_form"]);
    $courseName = "";
    for($i = 0; $i < count($courses); $i++){
        $number = $courses[$i]->Number;
        $start = explode('-', $courses[$i]->Start);
        $finish = explode('-', $courses[$i]->Finish);
        $courseStart = $start[2] . "." . $start[1] . "." . $start[0];
        $courseFinish = $finish[2] . "." . $finish[1] . "." . $finish[0];
        $id = $courses[$i]->id;
        $query = "SELECT cources.id, cources.Number, cources.name, cources.Start, cources.Finish, cources.Notes, cathedras.name AS cathedra FROM cources INNER JOIN cathedras ON cources.cathedraId = cathedras.id WHERE cources.id = '$id'";
        $CourseObj = $mysqli->query($query) or die ("Error in '$query' " . mysqli_error($mysqli));
        $courseNameArr = $CourseObj->fetch_assoc();
        $courseName = $courseNameArr["name"];
        $number = $courseNameArr["Number"];
        $notes = $courseNameArr["Notes"];
        $courseid = $courseNameArr["id"];
        $cathedraName = mb_strtolower($courseNameArr["cathedra"]);
        $studObj = $mysqli->query("SELECT personal_card.id, personal_card.name, personal_card.surname, personal_card.patername, personal_card.name_in_to_form, arrivals.Dic_count FROM personal_card INNER JOIN arrivals ON personal_card.id = arrivals.PersonId WHERE arrivals.CourseId = $courseid ORDER BY personal_card.name_in_to_form ASC") or die("Error: ". mysqli_error($mysqli));

        $studList = array();

        $budgetList = array();
        $payfulList = array();
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
            if($student["Dic_count"] != ''){
                array_push($payfulList, $student);
            }else{
                array_push($budgetList, $student);
            }
        }

        for($k = 0; $k < count($budgetList) - 1; $k++){
            for($j = $k + 1; $j < count($budgetList); $j++){
                if(strcmp($budgetList[$k]["name_in_to_form"], $budgetList[$j]["name_in_to_form"]) > 0){
                    $temp = $budgetList[$k];
                    $budgetList[$k] = $budgetList[$j];
                    $budgetList[$j] = $temp;
                }
            }
        }
        for($k = 0; $k < count($payfulList) - 1; $k++){
            for($j = $k + 1; $j < count($payfulList); $j++){
                if(strcmp($payfulList[$k]["name_in_to_form"], $payfulList[$j]["name_in_to_form"]) > 0){
                    $temp = $payfulList[$k];
                    $payfulList[$k] = $payfulList[$j];
                    $payfulList[$j] = $temp;
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
        <link rel=File-List href='приказ%20о%20зачислении.files/filelist.xml'>
        <title>О зачислении слушателей на</title>
        <!--[if gte mso 9]><xml>
         <o:DocumentProperties>
          <o:Author>prokopenko</o:Author>
          <o:Template>Normal</o:Template>
          <o:LastAuthor>Товпинец Кирилл</o:LastAuthor>
          <o:Revision>2</o:Revision>
          <o:TotalTime>28</o:TotalTime>
          <o:LastPrinted>2018-04-25T07:16:00Z</o:LastPrinted>
          <o:Created>2018-05-14T12:38:00Z</o:Created>
          <o:LastSaved>2018-05-14T12:38:00Z</o:LastSaved>
          <o:Pages>4</o:Pages>
          <o:Words>597</o:Words>
          <o:Characters>4342</o:Characters>
          <o:Company>Home</o:Company>
          <o:Lines>36</o:Lines>
          <o:Paragraphs>9</o:Paragraphs>
          <o:CharactersWithSpaces>4930</o:CharactersWithSpaces>
          <o:Version>16.00</o:Version>
         </o:DocumentProperties>
         <o:OfficeDocumentSettings>
          <o:RelyOnVML/>
          <o:AllowPNG/>
         </o:OfficeDocumentSettings>
        </xml><![endif]-->
        <link rel=themeData href='приказ%20о%20зачислении.files/themedata.thmx'>
        <link rel=colorSchemeMapping
        href='приказ%20о%20зачислении.files/colorschememapping.xml'>
        <!--[if gte mso 9]><xml>
         <w:WordDocument>
          <w:TrackMoves>false</w:TrackMoves>
          <w:TrackFormatting/>
          <w:PunctuationKerning/>
          <w:DrawingGridHorizontalSpacing>6 пт</w:DrawingGridHorizontalSpacing>
          <w:DisplayHorizontalDrawingGridEvery>2</w:DisplayHorizontalDrawingGridEvery>
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
           Name='index 1'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='index 2'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='index 3'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='index 4'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='index 5'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='index 6'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='index 7'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='index 8'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='index 9'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='toc 1'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='toc 2'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='toc 3'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='toc 4'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='toc 5'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='toc 6'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='toc 7'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='toc 8'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='toc 9'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Normal Indent'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='footnote text'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='annotation text'/>
          <w:LsdException Locked='false' Priority='99' SemiHidden='true'
           UnhideWhenUsed='true' Name='header'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='footer'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='index heading'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           QFormat='true' Name='caption'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='table of figures'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='envelope address'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='envelope return'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='footnote reference'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='annotation reference'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='line number'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='page number'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='endnote reference'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='endnote text'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='table of authorities'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='macro'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='toa heading'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='List'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='List Bullet'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='List 2'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='List 3'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='List Bullet 2'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='List Bullet 3'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='List Bullet 4'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='List Bullet 5'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='List Number 2'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='List Number 3'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='List Number 4'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='List Number 5'/>
          <w:LsdException Locked='false' QFormat='true' Name='Title'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Closing'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Signature'/>
          <w:LsdException Locked='false' Priority='1' SemiHidden='true'
           UnhideWhenUsed='true' Name='Default Paragraph Font'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Body Text'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Body Text Indent'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='List Continue'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='List Continue 2'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='List Continue 3'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='List Continue 4'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='List Continue 5'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Message Header'/>
          <w:LsdException Locked='false' QFormat='true' Name='Subtitle'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Body Text First Indent 2'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Note Heading'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Body Text 2'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Body Text 3'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Body Text Indent 2'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Body Text Indent 3'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Block Text'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Hyperlink'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='FollowedHyperlink'/>
          <w:LsdException Locked='false' QFormat='true' Name='Strong'/>
          <w:LsdException Locked='false' QFormat='true' Name='Emphasis'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Document Map'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Plain Text'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='E-mail Signature'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='HTML Top of Form'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='HTML Bottom of Form'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Normal (Web)'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='HTML Acronym'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='HTML Address'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='HTML Cite'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='HTML Code'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='HTML Definition'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='HTML Keyboard'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='HTML Preformatted'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='HTML Sample'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='HTML Typewriter'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='HTML Variable'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Normal Table'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='annotation subject'/>
          <w:LsdException Locked='false' Priority='99' SemiHidden='true'
           UnhideWhenUsed='true' Name='No List'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Outline List 1'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Outline List 2'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Outline List 3'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Simple 1'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Simple 2'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Simple 3'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Classic 1'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Classic 2'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Classic 3'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Classic 4'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Colorful 1'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Colorful 2'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Colorful 3'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Columns 1'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Columns 2'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Columns 3'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Columns 4'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Columns 5'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Grid 1'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Grid 2'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Grid 3'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Grid 4'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Grid 5'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Grid 6'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Grid 7'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Grid 8'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table List 1'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table List 2'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table List 3'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table List 4'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table List 5'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table List 6'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table List 7'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table List 8'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table 3D effects 1'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table 3D effects 2'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table 3D effects 3'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Contemporary'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Elegant'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Professional'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Subtle 1'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Subtle 2'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Web 1'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Web 2'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Web 3'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Balloon Text'/>
          <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
           Name='Table Theme'/>
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
            mso-font-charset:1;
            mso-generic-font-family:roman;
            mso-font-pitch:variable;
            mso-font-signature:0 0 0 0 0 0;}
        @font-face
            {font-family:Tahoma;
            panose-1:2 11 6 4 3 5 4 4 2 4;
            mso-font-charset:204;
            mso-generic-font-family:swiss;
            mso-font-pitch:variable;
            mso-font-signature:1627400839 -2147483648 8 0 66047 0;}
         /* Style Definitions */
         p.MsoNormal, li.MsoNormal, div.MsoNormal
            {mso-style-unhide:no;
            mso-style-qformat:yes;
            mso-style-parent:';
            margin:0cm;
            margin-bottom:.0001pt;
            mso-pagination:widow-orphan;
            font-size:12.0pt;
            font-family:'Times New Roman',serif;
            mso-fareast-font-family:'Times New Roman';}
        p.MsoHeader, li.MsoHeader, div.MsoHeader
            {mso-style-priority:99;
            mso-style-unhide:no;
            mso-style-link:'Верхний колонтитул Знак';
            margin:0cm;
            margin-bottom:.0001pt;
            mso-pagination:widow-orphan;
            tab-stops:center 233.85pt right 467.75pt;
            font-size:12.0pt;
            font-family:'Times New Roman',serif;
            mso-fareast-font-family:'Times New Roman';}
        p.MsoFooter, li.MsoFooter, div.MsoFooter
            {mso-style-unhide:no;
            mso-style-link:'Нижний колонтитул Знак';
            margin:0cm;
            margin-bottom:.0001pt;
            mso-pagination:widow-orphan;
            tab-stops:center 233.85pt right 467.75pt;
            font-size:12.0pt;
            font-family:'Times New Roman',serif;
            mso-fareast-font-family:'Times New Roman';}
        p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
            {mso-style-unhide:no;
            mso-style-link:'Текст выноски Знак';
            margin:0cm;
            margin-bottom:.0001pt;
            mso-pagination:widow-orphan;
            font-size:8.0pt;
            font-family:'Tahoma',sans-serif;
            mso-fareast-font-family:'Times New Roman';}
        span.a
            {mso-style-name:'Текст выноски Знак';
            mso-style-unhide:no;
            mso-style-locked:yes;
            mso-style-link:'Текст выноски';
            mso-ansi-font-size:8.0pt;
            mso-bidi-font-size:8.0pt;
            font-family:'Tahoma',sans-serif;
            mso-ascii-font-family:Tahoma;
            mso-hansi-font-family:Tahoma;
            mso-bidi-font-family:Tahoma;}
        span.a0
            {mso-style-name:'Верхний колонтитул Знак';
            mso-style-priority:99;
            mso-style-unhide:no;
            mso-style-locked:yes;
            mso-style-link:'Верхний колонтитул';
            mso-ansi-font-size:12.0pt;
            mso-bidi-font-size:12.0pt;}
        span.a1
            {mso-style-name:'Нижний колонтитул Знак';
            mso-style-unhide:no;
            mso-style-locked:yes;
            mso-style-link:'Нижний колонтитул';
            mso-ansi-font-size:12.0pt;
            mso-bidi-font-size:12.0pt;}
        .MsoChpDefault
            {mso-style-type:export-only;
            mso-default-props:yes;}
         /* Page Definitions */
         @page
            {mso-footnote-separator:url('приказ%20о%20зачислении.files/header.htm') fs;
            mso-footnote-continuation-separator:url('приказ%20о%20зачислении.files/header.htm') fcs;
            mso-endnote-separator:url('приказ%20о%20зачислении.files/header.htm') es;
            mso-endnote-continuation-separator:url('приказ%20о%20зачислении.files/header.htm') ecs;}
        @page WordSection1
            {size:595.3pt 841.9pt;
            margin:2.0cm 42.55pt 2.0cm 70.9pt;
            mso-header-margin:35.45pt;
            mso-footer-margin:35.45pt;
            mso-title-page:yes;
            mso-header:url('приказ%20о%20зачислении.files/header.htm') h1;
            mso-paper-source:0;}
        div.WordSection1
            {page:WordSection1;}
         /* List Definitions */
         @list l0
            {mso-list-id:494762768;
            mso-list-type:hybrid;
            mso-list-template-ids:-1703239048 893649222 68747289 68747291 68747279 68747289 68747291 68747279 68747289 68747291;}
        @list l0:level1
            {mso-level-tab-stop:17.85pt;
            mso-level-number-position:left;
            margin-left:0cm;
            text-indent:0cm;}
        @list l0:level2
            {mso-level-number-format:alpha-lower;
            mso-level-tab-stop:72.0pt;
            mso-level-number-position:left;
            text-indent:-18.0pt;}
        @list l0:level3
            {mso-level-number-format:roman-lower;
            mso-level-tab-stop:108.0pt;
            mso-level-number-position:right;
            text-indent:-9.0pt;}
        @list l0:level5
            {mso-level-number-format:alpha-lower;
            mso-level-tab-stop:180.0pt;
            mso-level-number-position:left;
            text-indent:-18.0pt;}
        @list l0:level6
            {mso-level-number-format:roman-lower;
            mso-level-tab-stop:216.0pt;
            mso-level-number-position:right;
            text-indent:-9.0pt;}
        @list l0:level8
            {mso-level-number-format:alpha-lower;
            mso-level-tab-stop:288.0pt;
            mso-level-number-position:left;
            text-indent:-18.0pt;}
        @list l0:level9
            {mso-level-number-format:roman-lower;
            mso-level-tab-stop:324.0pt;
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
            mso-style-priority:99;
            mso-style-parent:';
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
        
        <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
        
        <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
        
        <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
        
        <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
        
        <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
        
        <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
        
        <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
        
        <p class=MsoNormal><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
        
        <p class=MsoNormal style='margin-top:0pt;line-height:14.0pt;mso-line-height-rule:exactly'><span
        style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
        
        <p class=MsoNormal style='margin-top:0pt;line-height:14.0pt;mso-line-height-rule:exactly'><span
        style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
        
        <p class=MsoNormal style='margin-top:0pt;line-height:14.0pt;mso-line-height-rule:exactly'><span
        style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
        
        <p class=MsoNormal style='margin-top:0pt;line-height:14.0pt;mso-line-height-rule:exactly'><span
        style='font-size:14.0pt'>О зачислении слушателей на<o:p></o:p></span></p>
        
        <p class=MsoNormal style='margin-top:0pt;line-height:14.0pt;mso-line-height-rule:exactly'><span
        style='font-size:14.0pt'>повышение квалификации<o:p></o:p></span></p>
        
        <p class=MsoNormal style='margin-top:0pt;line-height:14.0pt;mso-line-height-rule:exactly'><span
        style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
        
        <p class=MsoNormal style='margin-top:0pt;text-align:justify;text-indent:35.4pt'><span
        style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
        
        <p class=MsoNormal style='margin-top:0pt;text-align:justify;text-indent:35.4pt'><span
        style='font-size:14.0pt'>В соответствии со сводным планом повышения
        квалификации и переподготовки руководителей и специалистов здравоохранения
        Республики Беларусь на 2018 год, утвержденным Министром здравоохранения Республики
        Беларусь,<o:p></o:p></span></p>
        
        <p class=MsoNormal style='margin-top:0pt;text-align:justify'><span style='font-size:14.0pt'>ПРИКАЗЫВАЮ:<o:p></o:p></span></p>
        
        <p class=MsoNormal style='margin-top:0pt;text-align:justify'><a name=first></a><span
        style='font-size:14.0pt'><span style='mso-tab-count:1'>         </span>1.
        Зачислить в число слушателей группы № $number $typeRelForm « $courseName »
        ($notes) на кафедре $cathedraName согласно
        списку:<o:p></o:p></span></p>
        
        <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
         style='border-collapse:collapse;mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt'>";
        
         $index = 1;
         for($k = 0; $k < count($budgetList); $k++){
                
            $person = $budgetList[$k]["surname"] . " " . $budgetList[$k]["name"] . " " . $budgetList[$k]["patername"];
            $doc_body .= "<tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;page-break-inside:avoid'>
                        <td width=378 valign=top style='width:283.45pt;padding:0cm 5.4pt 0cm 5.4pt'>
                        <p class=MsoNormal style='margin-top:0pt;tab-stops:17.85pt'><span style='font-size:14.0pt'>$index.
                        $person<o:p></o:p></span></p>
                        </td>
                        <td width=189 valign=top style='width:141.7pt;padding:0cm 5.4pt 0cm 5.4pt'>
                        <p class=MsoNormal style='margin-top:0pt;text-align:justify'><span style='font-size:14.0pt'><o:p></o:p></span></p>
                        </td>
                    </tr>";
            $index++;
        }   
        for($k = 0; $k < count($payfulList); $k++){
            $contractNumber = $payfulList[$k]["Dic_count"];
            $person = $payfulList[$k]["surname"] . " " . $payfulList[$k]["name"] . " " . $payfulList[$k]["patername"];
            $doc_body .= "<tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;page-break-inside:avoid'>
                        <td width=378 valign=top style='width:283.45pt;padding:0cm 5.4pt 0cm 5.4pt'>
                        <p class=MsoNormal style='margin-top:0pt;tab-stops:17.85pt'><span style='font-size:14.0pt'>$index.
                        $person<o:p></o:p></span></p>
                        </td>
                        <td width=189 valign=top style='width:141.7pt;padding:0cm 5.4pt 0cm 5.4pt'>
                        <p class=MsoNormal style='margin-top:0pt;text-align:justify'><span style='font-size:14.0pt'><o:p>платное Д № $contractNumber</o:p></span></p>
                        </td>
                    </tr>";
            $index++;
        }   
         
        $doc_body .= "</table>
        <p class=MsoNormal style='margin-top:0pt;text-align:justify;text-indent:35.4pt'><span
        style='font-size:14.0pt'>2. Заведующим кафедрами обеспечить проведение учебных
        занятий с $courseStart по $courseFinish в соответствии с учебными планами повышения
        квалификации.<o:p></o:p></span></p>
        
        <p class=MsoNormal style='margin-top:0pt;text-align:justify'><span style='font-size:14.0pt'><span
        style='mso-tab-count:1'>         </span>3. Контроль за исполнением приказа
        возложить на проректора по учебной работе Калинину Т.В.<o:p></o:p></span></p>
        
        <p class=MsoNormal style='margin-top:0pt;text-align:justify'><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
        
        <p class=MsoNormal style='margin-top:0pt;text-align:justify'><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
        
        <table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0
         style='border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt;
         mso-yfti-tbllook:480;mso-padding-alt:0cm 5.4pt 0cm 5.4pt;mso-border-insideh:
         .5pt solid windowtext;mso-border-insidev:.5pt solid windowtext'>
         <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;mso-yfti-lastrow:yes'>
          <td width=319 valign=top style='width:239.25pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal style='margin-top:0pt;text-align:justify'><span style='font-size:14.0pt'>Ректор
          академии<o:p></o:p></span></p>
          </td>
          <td width=319 valign=top style='width:239.3pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
          <p class=MsoNormal align=right style='text-align:right'><span
          style='font-size:14.0pt'>М.А.Герасименко<o:p></o:p></span></p>
          </td>
         </tr>
        </table>
        
        <p class=MsoNormal style='margin-top:0pt;text-align:justify'><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>
        
        </div>
        
        </body>
        
        </html>";
    }
    return $doc_body;
  }