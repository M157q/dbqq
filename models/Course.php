<?php
function RequireToStroing($req) {
    if ($req == 0)
        return "必修";
    else
        return "選修";
}

// convert classhours from strings to human readable format
//    3NNYYNNNN5NNNNNNYN -> 二FGH 三CD六G
//    2NNNNNYYY -> 二FGH
function ClassHoursToStroing($hours) {
    $ret = "";
    $weekday = array("一", "二", "三", "四", "五", "六", "日");
    $hour_name = array("A", "B", "C", "D", "E", "F", "G", "H");
    $ret .= $weekday[substr($hours, 0, 1)-1];

    foreach (range(1, 9) as $i) {
        if (substr($hours, $i, 1) == "Y")
            $ret .= $hour_name[$i-1];
    }

    if (strlen($hours) > 9) {
        $ret .= $weekday[substr($hours, 9, 1)-1];
        foreach (range(10, 17) as $i) {
            if (substr($hours, $i, 1) == "Y")
                $ret .= $hour_name[$i-10];
        }
    }
    return $ret;
}

function GetCourseInfoTable() {
    require_once('../models/Department.php');
    require_once('../models/User.php');
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');

    $course_list = array();
    $depart_list = GetDepartmentList();

    // get course data
    $query = 'SELECT ID, Year, Name, pro_id, student_upper_bound,
              class_room, credit, department, grade, required, class_hours,
              Additional_Info FROM Course';
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
            echo "<td>$row[8]</td>";
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
    require_once('../models/Department.php');
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');

    $course_list = array();
    $depart_list = GetDepartmentList();

    // get course data
    $query = 'SELECT ID, Year, Name, pro_id, student_upper_bound,
              class_room, credit, department, grade, required, class_hours,
              Additional_Info FROM Course';
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
        echo "<td>$row[8]</td>";
        echo "<td>" . RequireToStroing($row[9]) . "</td>";
        echo "<td>" . ClassHoursToStroing($row[10]) . "</td>";
        echo "<td>$row[11]</td>";
        echo "</tr>";
    }
    echo "</table>";
}



function GetCourseInfoTableByIDs($IDs) {
    require_once('../components/Mysqli.php');
    require_once('../models/User.php');
    require_once('../models/Department.php');
    $link = MysqliConnection('Read');

    $course_list = array();
    $depart_list = GetDepartmentList();

    foreach ($IDs as $cid) {
    // get course data
        $query = 'SELECT ID, Year, Name, pro_id, student_upper_bound,
                  class_room, credit, department, grade, required, class_hours,
                  Additional_Info FROM Course WHERE id=?';
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
        echo "<td>$row[8]</td>";
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
    require_once('../models/Department.php');
    require_once('../models/User.php');
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');

    $course_list = array();
    $depart_list = GetDepartmentList();

    // get course data
    $query = 'SELECT ID, Year, Name, student_upper_bound, class_room, credit, department, grade, required, class_hours, Additional_Info FROM Course Where pro_id=?';
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
            echo "<td>$row[7]</td>";
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

function CheckProIfCollision($pro_id, $class_hours) {
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
		mysqli_stmt_close($stmt);
		mysqli_close($link);
		return true;
	    }
	}
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
    return false;
}


// return ture if two course are conflict
function CheckCourseConfliction($c1, $c2) {
    $result = false;
    // force len($c1) >= len($c2)
    if (strlen($c1) < strlen($c2)) {
        $t = $c1; $c1 = $c2; $c2 = $t;
    }

    $cc1 = array(substr($c1, 0, 9), substr($c1, 9, 18));
    $cc2 = array(substr($c2, 0, 9), substr($c2, 9, 18));
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
        foreach (range(1, 9) as $i) {
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
    $link = MysqliConnection('Read');

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

?>
