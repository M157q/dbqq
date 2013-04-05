<?php
function GetCourseInfoTable() {
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');

    $course_list = array();

    // get student data
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
?>
