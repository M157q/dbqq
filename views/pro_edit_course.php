<?php

    require_once('../models/Department.php');
    require_once('../models/User.php');
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');

    $course_list = array();
    $depart_list = GetDepartmentList();

    // get course data
    $query = 'SELECT Name, student_upper_bound, class_room, credit, department, grade, required, class_hours, Additional_Info FROM Course Where pro_id=? AND id=? AND year=?';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "ssd", $_SESSION['id'], $_POST['id'], $_POST['year']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $name, $sub, $classroom, $credit, $dep, $grade, $req, $class_hours, $add_info);
        while(mysqli_stmt_fetch($stmt)) {
            array_push($course_list, array($id, $year, $name, $sub, $classroom, $credit, $dep, $grade, $req, $class_hours, $add_info));
        }
    }
?>
