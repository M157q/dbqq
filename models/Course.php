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

?>
