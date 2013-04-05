<?php
function GetStudentInfoTable() {
    require_once('../models/Department.php');
    $depart_list = GetDepartmentList();

    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');

    $stu_list = array();

    // get student data
    $query = 'SELECT ID, Name, StudentNumber, department, grade FROM Student';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $name, $num, $depart, $grade);
        while(mysqli_stmt_fetch($stmt)) {
            array_push($stu_list, array($id, $name, $num, $depart, $grade));
        }
        array_multisort($stu_list);
        echo "<table border=5><caption>學生清單</caption>";
        echo "<tr>";
        echo "<th>ID</th>" . "<th>姓名</th>" . "<th>學號</th>" . "<th>系所</th>" .
             "<th>年級</th>";
        echo "</tr>";
        foreach($stu_list as $row) {
            echo "<tr>";
            echo "<td>$row[0]</td>";
            echo "<td>$row[1]</td>";
            echo "<td>$row[2]</td>";
            if (array_key_exists($row[3], $depart_list)) {
                echo "<td>" . $depart_list[$row[3]] . "</td>";
            }
            else {
                echo "<td>你什麼系的@@?</td>";
            }
            echo "<td>$row[4]</td>";
            echo "</tr>";
        }
        echo "</table>";
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}

function GetProfessorInfoTable() {
    require_once('../models/Department.php');
    $depart_list = GetDepartmentList();

    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');

    $pro_list = array();

    // get student data
    $query = 'SELECT ID, Name, ProfessorNumber, department FROM Professor';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $name, $num, $depart);
        echo "<table border=5><caption>教授清單</caption>";
        echo "<tr>";
        echo "<th>ID</th>" . "<th>姓名</th>" . "<th>教職員編號</th>" . "<th>系所</th>";
        echo "</tr>";
        while(mysqli_stmt_fetch($stmt)) {
            array_push($pro_list, array($id, $name, $num, $depart));
        }
        array_multisort($pro_list);
        foreach($pro_list as $row) {
            echo "<tr>";
            echo "<td>$row[0]</td>";
            echo "<td>$row[1]</td>";
            echo "<td>$row[2]</td>";
            if (array_key_exists($row[3], $depart_list)) {
                echo "<td>" . $depart_list[$row[3]] . "</td>";
            }
            else {
                echo "<td>你什麼系的@@?</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}
?>
