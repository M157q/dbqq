<?php
function RequireToStroing($req) {
    if ($req == 0)
        return "必修";
    else
        return "選修";
}

// convert classhours from strings to human readable format
//    3NNYYNNNNNNNNNN5NNNNNNNYNNNNNN -> 二FGH 三CD六G
//    2NNNNNNYYY -> 二FGH
function ClassHoursToStroing($hours) {
    $ret = "";
    $weekday = array("一", "二", "三", "四", "五", "六", "日");
    $hour_name = array("A", "B", "C", "D", "X", "E", "F", "G", "H", "Y", "I", "J", "K", "L");
    $ret .= $weekday[substr($hours, 0, 1)-1];

    foreach (range(1, 14) as $i) {
        if (substr($hours, $i, 1) == "Y")
            $ret .= $hour_name[$i-1];
    }

    if (strlen($hours) > 15) {
        $ret .= $weekday[substr($hours, 15, 1)-1];
        foreach (range(16, 29) as $i) {
            if (substr($hours, $i, 1) == "Y")
                $ret .= $hour_name[$i-16];
        }
    }
    return $ret;
}

function GetCourseInfoTable() {
    require_once('../models/Department.php');
    require_once('../models/User.php');
    require_once('../models/Grade.php');
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');

    $course_list = array();
    $depart_list = GetDepartmentList();

    // get course data
    $query = 'SELECT c.ID, c.Year, c.Name, c.pro_id, c.student_upper_bound,
              c.class_room, c.credit, c.department, c.grade, c.required, c.class_hours,
              c.Additional_Info FROM Course c';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $year, $name, $pro_id, $sub,
                                $classroom, $credit, $dep, $grade, $req,
                                $class_hours, $add_info);
        while(mysqli_stmt_fetch($stmt)) {
            array_push($course_list, array($id, $year, $name, $pro_id, $sub,
                                           $classroom, $credit, $dep, $grade,
                                            $req, $class_hours, $add_info));
        }
        array_multisort($course_list);
        echo "<table border=5 class=\"table table-striped table-bordered\">";
        echo "<caption>課程清單</caption>";
        echo "<tr>";
        echo "<th>ID</th><th>年度</th><th>課名</th><th>開課教授</th>" .
             "<th>修課人數上限</th><th>教室</th><th>學分</th>" .
             "<th>開課系所</th><th>年級</th><th>必選修</th><th>時間</th>" .
             "<th>備註</th>";
        echo "</tr>";
        foreach($course_list as $row) {
            echo "<tr>";
            echo "<td>$row[0]</td>";
            echo "<td>$row[1]</td>";
            echo "<td>$row[2]</td>";
            echo "<td>" . ReturnUserName($row[3]) . "</td>";
            echo "<td>$row[4]</td>";
            echo "<td>$row[5]</td>";
            echo "<td>$row[6]</td>";
            echo "<td>" . $depart_list[$row[7]] . "</td>";
            echo "<td>" . GradeToString($row[8]) . "</td>";
            echo "<td>" . RequireToStroing($row[9]) . "</td>";
            echo "<td>" . ClassHoursToStroing($row[10]) . "</td>";
            echo "<td>$row[11]</td>";
            echo "</tr>";
        }
        echo "</table>";
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}

function GetCourseInfoTableWithCheckBox() {
    require_once('../models/User.php');
    require_once('../models/Grade.php');
    require_once('../models/Department.php');
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');

    $course_list = array();
    $depart_list = GetDepartmentList();

    // get course data
    $query = 'SELECT c.ID, c.Year, c.Name, c.pro_id, c.student_upper_bound,
              c.class_room, c.credit, c.department, c.grade, c.required, c.class_hours,
              c.Additional_Info FROM Course c';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $year, $name, $pro_id, $sub,
                                $classroom, $credit, $dep, $grade, $req,
                                $class_hours, $add_info);
        while(mysqli_stmt_fetch($stmt)) {
            array_push($course_list, array($id, $year, $name, $pro_id, $sub,
                                           $classroom, $credit, $dep, $grade,
                                            $req, $class_hours, $add_info));
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);

    array_multisort($course_list);
    echo "<table border=5 class=\"table table-striped table-bordered\">";
    echo "<caption>課程清單</caption>";
    echo "<tr>";
    echo "<th>選擇</th><th>ID</th><th>年度</th><th>課名</th><th>開課教授</th>" .
         "<th>修課人數上限</th><th>教室</th><th>學分</th>" .
         "<th>開課系所</th><th>年級</th><th>必選修</th><th>時間</th>" .
         "<th>備註</th>";
    echo "</tr>";
    foreach($course_list as $row) {
        echo "<tr>";
        echo "<td><input type=\"checkbox\" name=\"$row[0]_$row[1]\" style=\"text-align:center; vertical-align: middle;\"> </td>";
        echo "<td>$row[0]</td>";
        echo "<td>$row[1]</td>";
        echo "<td>$row[2]</td>";
        echo "<td>" . ReturnUserName($row[3]) . "</td>";
        echo "<td>$row[4]</td>";
        echo "<td>$row[5]</td>";
        echo "<td>$row[6]</td>";
        echo "<td>" . $depart_list[$row[7]] . "</td>";
        echo "<td>" . GradeToString($row[8]) . "</td>";
        echo "<td>" . RequireToStroing($row[9]) . "</td>";
        echo "<td>" . ClassHoursToStroing($row[10]) . "</td>";
        echo "<td>$row[11]</td>";
        echo "</tr>";
    }
    echo "</table>";
}



function GetCourseInfoTableByIDs($IDs) {
    require_once('../models/Grade.php');
    require_once('../components/Mysqli.php');
    require_once('../models/User.php');
    require_once('../models/Department.php');
    $link = MysqliConnection('Read');

    $course_list = array();
    $depart_list = GetDepartmentList();

    foreach ($IDs as $cid) {
    // get course data
        $query = 'SELECT c.ID, c.Year, c.Name, c.pro_id, c.student_upper_bound,
              c.class_room, c.credit, c.department, c.grade, c.required, c.class_hours,
              c.Additional_Info FROM Course c WHERE c.ID = ?';
        $stmt = mysqli_stmt_init($link);
        if (mysqli_stmt_prepare($stmt, $query))
        {
            mysqli_stmt_bind_param($stmt, "s", $cid);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $id, $year, $name, $pro_id, $sub,
                                    $classroom, $credit, $dep, $grade, $req,
                                    $class_hours, $add_info);
            mysqli_stmt_fetch($stmt);
            array_push($course_list, array($id, $year, $name, $pro_id, $sub,
                                           $classroom, $credit, $dep, $grade,
                                            $req, $class_hours, $add_info));
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);

    array_multisort($course_list);
    echo "<table border=5 class=\"table table-striped table-bordered\">";
    echo "<caption>課程清單</caption>";
    echo "<tr>";
    echo "<th>ID</th><th>年度</th><th>課名</th><th>開課教授</th>" .
         "<th>修課人數上限</th><th>教室</th><th>學分</th>" .
         "<th>開課系所</th><th>年級</th><th>必選修</th><th>時間</th>" .
         "<th>備註</th>";
    echo "</tr>";
    foreach($course_list as $row) {
        echo "<tr>";
        echo "<td>$row[0]</td>";
        echo "<td>$row[1]</td>";
        echo "<td>$row[2]</td>";
        echo "<td>" . ReturnUserName($row[3]) . "</td>";
        echo "<td>$row[4]</td>";
        echo "<td>$row[5]</td>";
        echo "<td>$row[6]</td>";
        echo "<td>" . $depart_list[$row[7]] . "</td>";
        echo "<td>" . GradeToString($row[8]) . "</td>";
        echo "<td>" . RequireToStroing($row[9]) . "</td>";
        echo "<td>" . ClassHoursToStroing($row[10]) . "</td>";
        echo "<td>$row[11]</td>";
        echo "</tr>";
    }
    echo "</table>";
}


function ChooseCourse($studentID, $ID_years) {
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Write');

    $course_list = array();

    list ($cid, $year) = explode('_', $ID_years);
    // if the course is chosen, then close mysqli link and return
    if (CheckIfChosen($studentID, $cid)) {
        mysqli_close($link);
        return;
    }
    $query = 'INSERT INTO Course_taken (StudentID, CourseID, CourseYear) VALUES (?, ?, ?)';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "ssd", $studentID, $cid, $year);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}

// check if this student has chosen the course
function CheckIfChosen($stu_id, $cid) {
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');

    $result = false;

    $query = 'SELECT CourseID FROM Course_taken WHERE StudentID=? and CourseID=?';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, "ss", $stu_id, $cid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $result);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
    return $result or false;
}

function ListStudentCourse($id) {
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');

    $course_list = array();

    $query = 'SELECT CourseID FROM Course_taken WHERE StudentID=?';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $cid);
        while (mysqli_stmt_fetch($stmt)) {
            array_push($course_list, $cid);
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);

    GetCourseInfoTableByIDs($course_list);
}

function ListProfessorCourse($pro_id) {
    require_once('../models/Grade.php');
    require_once('../models/Department.php');
    require_once('../models/User.php');
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');

    $course_list = array();
    $depart_list = GetDepartmentList();

    // get course data
    $query = 'SELECT c.ID, c.Year, c.Name, c.student_upper_bound,
              c.class_room, c.credit, c.department, c.grade, c.required, c.class_hours,
              c.Additional_Info FROM Course c WHERE c.pro_id = ?';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
	mysqli_stmt_bind_param($stmt, "s", $pro_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $year, $name, $sub, $classroom, $credit, $dep, $grade, $req, $class_hours, $add_info);
        while(mysqli_stmt_fetch($stmt)) {
            array_push($course_list, array($id, $year, $name, $sub, $classroom, $credit, $dep, $grade, $req, $class_hours, $add_info));
        }
        array_multisort($course_list);
	echo "<table class=\"table table-striped table-bordered\"><caption></caption>";
        echo "<tr>";
        echo "<th>選擇</th><th>ID</th><th>年度</th><th>課名</th>" .
             "<th>修課人數上限</th><th>教室</th><th>學分</th>" .
             "<th>開課系所</th><th>年級</th><th>必選修</th><th>時間</th>" .
             "<th>備註</th>";
        echo "</tr>";
        foreach($course_list as $row) {
            echo "<tr>";
            echo "<td><input type=\"radio\" name=\"id_year\" value=\"$row[0]_$row[1]\" style=\"text-align:center; vertical-align: middle;\"></option> </td>";
            echo "<td>$row[0]</td>";
            echo "<td>$row[1]</td>";
            echo "<td>$row[2]</td>";
            echo "<td>$row[3]</td>";
            echo "<td>$row[4]</td>";
            echo "<td>$row[5]</td>";
            echo "<td>" . $depart_list[$row[6]] . "</td>";
            echo "<td>" . GradeToString($row[7]) . "</td>";
            echo "<td>" . RequireToStroing($row[8]) . "</td>";
            echo "<td>" . ClassHoursToStroing($row[9]) . "</td>";
            echo "<td>$row[10]</td>";
            echo "</tr>";
        }
        echo "</table>";
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}

function ProViewCourseStudent($id_year)
{
    list($CourseID, $CourseYear) = explode('_', $id_year);
    $sid_list = array();
    $stu_list = array();
    $depart_list = GetDepartmentList();


    $link = MysqliConnection('Read');
    $query = 'SELECT StudentID FROM Course_taken WHERE CourseID=? AND CourseYear=?';
    $stmt = mysqli_stmt_init($link);
    if(mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "ss", $CourseID, $CourseYear);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $result);
        while(mysqli_stmt_fetch($stmt)) {
            array_push($sid_list, $result);
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);

    $link = MysqliConnection('Read');
    $query = 'SELECT StudentNumber, Name, department, grade FROM Student WHERE ID=?';
    foreach($sid_list as $i) {
        $stmt = mysqli_stmt_init($link);
        if(mysqli_stmt_prepare($stmt, $query))
        {
            mysqli_stmt_bind_param($stmt, "s", $i);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $SN, $name, $dep, $grade);
            if(mysqli_stmt_fetch($stmt)) {
                array_push($stu_list, array($SN, $name, $dep, $grade));
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);

    require_once('../models/Grade.php');
    array_multisort($stu_list);
    echo "<table border=5 class=\"table table-striped table-bordered\">";
    echo "<caption>學生列表</caption>";
    echo "<tr>";
    echo "<th>學號</th><th>姓名</th><th>系所</th><th>年級</th>";
    echo "</tr>";
    foreach($stu_list as $row) {
        echo "<tr>";
        echo "<td>$row[0]</td>";
        echo "<td>$row[1]</td>";
        echo "<td>" . $depart_list[$row[2]] . "</td>";
        echo "<td>" . showGrade($row[3]) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

function CheckProIfCollision($pro_id, $class_hours) {
    $result = false;

    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');
    $query = 'SELECT class_hours FROM Course WHERE pro_id=?';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query)) {
    	mysqli_stmt_bind_param($stmt, "s", $pro_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $chrs);
        while(mysqli_stmt_fetch($stmt)) {
            if(CheckCourseConfliction($class_hours, $chrs)) {
                $result = true;
                break;
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
    return $result;
}

function CheckProEditIfCollision($pro_id, $class_hours, $cid) {
    $result = false;

    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');
    $query = 'SELECT id, class_hours FROM Course WHERE pro_id=?';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $pro_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $chrs);
        while(mysqli_stmt_fetch($stmt)) {
            if($id != $cid && CheckCourseConfliction($class_hours, $chrs)) {
                $result = true;
                break;
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
    return $result;
}

// return ture if two course are conflict
function CheckCourseConfliction($c1, $c2) {
    $result = false;
    // force len($c1) >= len($c2)
    if (strlen($c1) < strlen($c2)) {
        $t = $c1; $c1 = $c2; $c2 = $t;
    }

    $cc1 = array(substr($c1, 0, 15), substr($c1, 15, 15));
    $cc2 = array(substr($c2, 0, 15), substr($c2, 15, 15));
    foreach ($cc1 as $i) {
        foreach ($cc2 as $j) {
            if (CompareCourse($i, $j)) {
                $result = true;
            }
        }
    }
    return $result;
}

function CompareCourse($c1, $c2) {
    if (substr($c1, 0, 1) == substr($c2, 0, 1)) {
        foreach (range(1, 14) as $i) {
            if (substr($c1, $i, 1) == "Y" and substr($c2, $i, 1) == "Y")
                return true;
        }
        return false;
    }
    return false;
}

function CheckCourseIDExist($course_id, $course_year)
{
    require_once('../components/Mysqli.php');
    $result = false;
    $link = MysqliConnection('Read');

    $query = 'SELECT COUNT(ID) From Course WHERE ID=? AND Year=?';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "ss", $course_id, $course_year);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $result);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

    mysqli_close($link);
    return $result or false;
}

function StudentDeleteCourse($stu_id, $course_id, $course_year)
{ 
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Write');

    $query = 'DELETE FROM Course_taken WHERE StudentID=? AND CourseID=? AND 
        CourseYear=?';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "sss", $stu_id, $course_id, $course_year);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}

function CheckStudentInCourse($stu_id, $course_id, $course_year)
{
    require_once('../components/Mysqli.php');
    $result = false;
    $link = MysqliConnection('Read');

    $query = 'SELECT COUNT(pkid) FROM Course_taken WHERE StudentID=? AND CourseID=? AND CourseYear=?';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "sss", $stu_id, $course_id, $course_year);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $result);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

    mysqli_close($link);
    return $result or false;
}

//convert class hours to formatted string in mode 1
//for example, 1C=%1__Y%
function Mode1FormattedString($day, $hours)
{
    $result = "%".$day;

    $i = 1;
    while($i < $hours)
    {
        $result .= "_";
        $i++;
    }

    $result .= ("Y"."%");

    return $result;
}

//convert class hours to formatted string in mode 2
//for example, 1AB2C=1YYNNNNNNNNNNNN2NNYNNNNNNNNNNN
function Mode2FormattedString($class_hours)
{
    $day = "1";
    $hours = "1";
    $result = "";
    foreach($class_hours as $i)
    {
        if(!empty($i))
        {
            if(empty($result))
                $result = $day;
            else
                $result .= $day;

            foreach($i as $j)
            {
                while($hours != $j)
                {
                    $result .= "N";
                    $hours++;
                }
                $result .= "Y";
                $hours++;
            }
            
            while($hours != "15")
            {
                $result .= "N";
                $hours++;
            }
        }
        $hours = "1";
        $day++;
    }

    return $result;
}

function CourseFilter($dep, $grade, $mode, $class_hours, $name)
{
    require_once('../components/Mysqli.php');
    require_once('../models/Department.php');
    require_once('../models/User.php');
    require_once('../models/Grade.php');

    $gradestring = "";
    $dup_list = array();
    $course_list = array();
    $depart_list = GetDepartmentList();

    if($mode == 1)
    {
        $day = "1";

        $link = MysqliConnection('Read');
        $query = 'SELECT ID, Year, Name, pro_id, student_upper_bound, class_room, credit, department, grade, required, class_hours, Additional_Info FROM Course WHERE Name LIKE ? AND department=? AND grade LIKE ? AND class_hours LIKE ?';
        foreach($class_hours as $i)
        {
            if(!empty($i))
            {
                foreach($i as $j)
                {
                    $hourstring = Mode1FormattedString($day,$j);
                    foreach($dep as $k)
                    {
                        foreach($grade as $l)
                        {
                            $gradestring = GradeToFormattedString($l);

                            $stmt = mysqli_stmt_init($link);
                            if(mysqli_stmt_prepare($stmt, $query))
                            {
                                mysqli_stmt_bind_param($stmt, "ssss", $name, $k, $gradestring, $hourstring);
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_bind_result($stmt, $id, $year, $cname, $pro_id, $student_upper_bound, $class_room, $credit, $department, $cgrade, $required, $class_hour, $Additional_Info);
                                while(mysqli_stmt_fetch($stmt)) {
                                    array_push($dup_list, array($id, $year, $cname, $pro_id, $student_upper_bound, $class_room, $credit, $department, $cgrade, $required, $class_hour, $Additional_Info));
                                }
                                mysqli_stmt_close($stmt);
                            }
                        }
                    }
                }
            }
            $day++;
        }
        mysqli_close($link);
    }
    else if($mode == 2)
    {
        $hourstring = Mode2FormattedString($class_hours);

        $link = MysqliConnection('Read');
        $query = 'SELECT ID, Year, Name, pro_id, student_upper_bound, class_room, credit, department, grade, required, class_hours, Additional_Info FROM Course WHERE Name LIKE ? AND department=? AND grade LIKE ? AND class_hours=?';
        foreach($dep as $k)
        {
            foreach($grade as $l)
            {
                $gradestring = GradeToFormattedString($l);
                
                $stmt = mysqli_stmt_init($link);
                if(mysqli_stmt_prepare($stmt, $query))
                {
                    mysqli_stmt_bind_param($stmt, "ssss", $name, $k, $gradestring, $hourstring);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $id, $year, $cname, $pro_id, $student_upper_bound, $class_room, $credit, $department, $cgrade, $required, $class_hour, $Additional_Info);
                    while(mysqli_stmt_fetch($stmt)) {
                        array_push($dup_list, array($id, $year, $cname, $pro_id, $student_upper_bound, $class_room, $credit, $department, $cgrade, $required, $class_hour, $Additional_Info));
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        }
        mysqli_close($link);
    }

    foreach($dup_list as $i)
    {   
        $dup = "0";
        foreach($course_list as $j)
            if($i[0] == $j[0])
                $dup = "1";

        if($dup == "0")
            array_push($course_list, $i);
    }

    array_multisort($course_list);
        echo "<table border=5 class=\"table table-striped table-bordered\">";
        echo "<tr>";
        echo "<th>ID</th><th>年度</th><th>課名</th><th>開課教授</th>" .
             "<th>修課人數上限</th><th>教室</th><th>學分</th>" .
             "<th>開課系所</th><th>年級</th><th>必選修</th><th>時間</th>" .
             "<th>備註</th>";
        echo "</tr>";
        foreach($course_list as $row) {
            echo "<tr>";
            echo "<td>$row[0]</td>";
            echo "<td>$row[1]</td>";
            echo "<td>$row[2]</td>";
            echo "<td>" . ReturnUserName($row[3]) . "</td>";
            echo "<td>$row[4]</td>";
            echo "<td>$row[5]</td>";
            echo "<td>$row[6]</td>";
            echo "<td>" . $depart_list[$row[7]] . "</td>";
            echo "<td>" . GradeToString($row[8])  . "</td>";
            echo "<td>" . RequireToStroing($row[9]) . "</td>";
            echo "<td>" . ClassHoursToStroing($row[10]) . "</td>";
            echo "<td>$row[11]</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</table>";
}

function ListCourseStudents ($cid, $cyr){
    require_once('../components/Mysqli.php');

    $stu_list = array();

    $link = MysqliConnection('Read');
    $query = 'SELECT StudentID FROM Course_taken WHERE CourseID=? AND CourseYear=?';
    $stmt = mysqli_stmt_init($link);
    if(mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "ss", $cid, $cyr);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $std_id);
        while(mysqli_stmt_fetch($stmt)) {
            array_push($stu_list, $std_id);
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);

    return $stu_list;
}


// type:
// 2: Professor edit his course, but student is not in the correct grade
// 3: Professor delete student from his course
function UpdateCourseChange ($course_id, $course_year, $stu_id, $type) {
    require_once('../components/Mysqli.php');

    $link = MysqliConnection('Write');
    $query = 'INSERT INTO Course_change ' .
             '(course_id, course_year, stu_id, change_type) ' .
             'VALUES (?, ?, ?, ?)';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, "ssss",
                               $course_id, $course_year, $stu_id, $type);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}

?>
