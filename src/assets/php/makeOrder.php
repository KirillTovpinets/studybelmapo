<?php
    ini_set("display_errors", 1);
   
   require("config.php");
   
   $mysqli = mysqli_connect($host, $user, $passwd, $dbname) or die ("Ошибка подключения к базе данных: ". mysqli_connect_erro());
   $mysqli->query("SET NAMES utf8");
   $data = json_decode(file_get_contents("php://input"));
   $courses = $data->selectedCourses;
   $isEnter = $data->type;
    
    if($isEnter){
        $about = "О зачислении";
    }else{
        $about = "Об отчислении";
    }
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
                    <td width='40%'>$about слушателей на переподготовку</td>
                    <td></td>
                </tr>
            </table>
            <p></p>
            <p>В соответствии со сводным планом повышения 
            квалификации и переподготовки руководителей и 
            специалистов здравоохранения Республики Беларусь 
            на 2017 год, утвержденным Министром 
            здравоохранения Республики Беларусь,<br/>
            ПРИКАЗЫВАЮ:<br/>
                <ol>";
                
    $sendTo = array();
    for($i = 0; $i < count($courses); $i++){
        $number = $courses[$i]->Number;
        $CourseObj = $mysqli->query("SELECT name FROM cources WHERE Number = '$number'");
        $courseNameArr = $CourseObj->fetch_assoc();
        $courseName = $courseNameArr["name"];
        
        $CathedraObj = $mysqli->query("SELECT name FROM cathedras INNER JOIN arrivals ON cathedras.id = arrivals.CathedrId WHERE arrivals.CourseId = '$number'");
        $CathedraNameObj = $CathedraObj->fetch_assoc();
        $cathedraName = $CathedraNameObj["name"];
        array_push($sendTo, $cathedraName);
        $doc_body .= "<li>
                        Зачислить в число слушателей группы № $number переподготовки
                        по специальности \"$courseName\" 
                        (переподготовка в очной форме получения образования) на
                        кафедре $cathedraName согласно списку:
                        <ol class='StudList'>";
        $result = $mysqli->query("SELECT personal_card.surname, personal_card.name, personal_card.patername 
        FROM personal_card 
        INNER JOIN arrivals ON personal_card.unique_Id = arrivals.PersonLink 
        WHERE arrivals.CourseId = '$number' AND arrivals.Status = 0") or die ("Ошибка выполнения запроса: " . mysqli_error($mysqli));
        $countRows = 0;
        while($row = $result->fetch_assoc()){
            $name = $row["name"];
            $surname = $row["surname"];
            $patername = $row["patername"];
            $doc_body .= "<li>$surname $name $patername</li>";
            $countRows++;
        }
        $doc_body .= "</ol></li>";
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
        
        
    $file = 'HelloWorld.doc';
    header('Content-Disposition: attachment; filename="' . $file . '"');
    header('Content-Type: application/vnd.msword;format=attachment;');
    header('Content-Transfer-Encoding: binary');
    
    echo "<meta http-equiv=Content-Type content='text/html; charset=utf-8'>";
    echo $doc_body;
?>