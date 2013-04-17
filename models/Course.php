<?php
function GetCourseInfoTable() {
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');

    $course_list = array();

    // get course data
    $query = 'SELECT ID, Year, Name, Additional_Info FROM Course';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $year, $name, $add_info);
        while(mysqli_stmt_fetch($stmt)) {
            array_push($course_list, array($id, $year, $name, $add_info));
        }
        array_multisort($course_list);
        echo "<table border=5><caption>課程清單</caption>";
        echo "<tr>";
        echo "<th>ID</th>" . "<th>年度</th>" . "<th>課名</th>" .
             "<th>備註</th>";
        echo "</tr>";
        foreach($course_list as $row) {
            echo "<tr>";
            echo "<td>$row[0]</td>";
            echo "<td>$row[1]</td>";
            echo "<td>$row[2]</td>";
            echo "<td>$row[3]</td>";
            echo "</tr>";
        }
        echo "</table>";
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}


function GetCourseInfoTableWithCheckBox() {
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');

    $course_list = array();

    $query = 'SELECT ID, Year, Name, Additional_Info FROM Course';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $year, $name, $add_info);
        while(mysqli_stmt_fetch($stmt)) {
            array_push($course_list, array($id, $year, $name, $add_info));
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);

    array_multisort($course_list);
    echo "<table border=5><caption>課程清單</caption>";
    echo "<tr>";
    echo "<th>選擇</th><th>ID</th>" . "<th>年度</th>" . "<th>課名</th>" .
         "<th>備註</th>";
    echo "</tr>";
    foreach($course_list as $row) {
        echo "<tr>";
        echo "<td><input type=\"checkbox\" name=\"$row[0]\" style=\"text-align:center; vertical-align: middle;\"> </td>";
        echo "<td>$row[0]</td>";
        echo "<td>$row[1]</td>";
        echo "<td>$row[2]</td>";
        echo "<td>$row[3]</td>";
        echo "</tr>";
    }
    echo "</table>";
}



function GetCourseInfoTableByIDs($IDs) {
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');

    $course_list = array();

    foreach ($IDs as $cid) {
        $query = 'SELECT ID, Year, Name, Additional_Info FROM Course WHERE id=?';
        $stmt = mysqli_stmt_init($link);
        if (mysqli_stmt_prepare($stmt, $query))
        {
            mysqli_stmt_bind_param($stmt, "s", $cid);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $id, $year, $name, $add_info);
            mysqli_stmt_fetch($stmt);
            array_push($course_list, array($id, $year, $name, $add_info));
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);

    array_multisort($course_list);
    echo "<table border=5><caption>課程清單</caption>";
    echo "<tr>";
    echo "<th>ID</th>" . "<th>年度</th>" . "<th>課名</th>" .
         "<th>備註</th>";
    echo "</tr>";
    foreach($course_list as $row) {
        echo "<tr>";
        echo "<td>$row[0]</td>";
        echo "<td>$row[1]</td>";
        echo "<td>$row[2]</td>";
        echo "<td>$row[3]</td>";
        echo "</tr>";
    }
    echo "</table>";
}


function ChooseCourse($studentID, $IDs) {
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Write');

    $course_list = array();

    foreach ($IDs as $cid) {
        if (CheckIfChosen($studentID, $cid)) {
            continue;
        }
        $query = 'INSERT INTO Course_taken (StudentID, CourseID) VALUES (?, ?)';
        $stmt = mysqli_stmt_init($link);
        if (mysqli_stmt_prepare($stmt, $query))
        {
            mysqli_stmt_bind_param($stmt, "ss", $studentID, $cid);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        echo "$studentID, $cid<br>";
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
    echo "<h1>begin test</h1>";
    var_dump($cc1);
    echo "<br>";
    var_dump($cc2);
    echo "<hr>";
    foreach ($cc1 as $i) {
        foreach ($cc2 as $j) {
            echo "comparing ";
            var_dump($i);
            var_dump($j);
            if (CompareCourse($i, $j)) {
                echo "confliction ^_^";
                $result = true;
            }
            else {
                echo "no confliction";
            }
            echo "<br>";
        }
    }
    echo "<hr>";
    return $result;
}

function CompareCourse($c1, $c2) {
    if (substr($c1, 0, 1) == substr($c2, 0, 1)) {
        foreach (range(1, 9) as $i) {
            echo substr($c1, $i, 1);
            echo "/";
            echo substr($c2, $i, 1);
            echo "<br>";
            if (substr($c1, $i, 1) == "Y" and substr($c2, $i, 1) == "Y")
                return true;
        }
        return false;
    }
    return false;
}
?>
