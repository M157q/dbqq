<?php
    session_start();
    require_once('../models/Grade.php');
    require_once('../models/User.php');
    require_once('../models/Course.php');
    require_once('../components/Mysqli.php');
    require_once('../controllers/Session.php');

    if (isBanned($_SESSION['id']))
        RedirectByPerm($_SESSION['perm']);

    CheckPermAndRedirect($_SESSION['perm'], 'pro');

    $redirct_url = '../views/pro_edit_course.php';

    if ($_POST['student_upper_bound'] < 1)
        $_SESSION['errmsg'] = '人數上限必須大於零';
    elseif (!isset($_POST['grade']))
        $_SESSION['errmsg'] = '開課年級未填';
    elseif ($_POST['credit'] < 0)
        $_SESSION['errmsg'] = '學分數不能為負值';
    elseif ($_POST['day1'] == $_POST['day2'])
        $_SESSION['errmsg'] = '時段一與時段二不能在同一天';
    elseif (!isset($_POST['d1']))
        $_SESSION['errmsg'] = '時段一之時間未填';
    elseif ($_POST['day2'] != "0" && !isset($_POST['d2']))
        $_SESSION['errmsg'] = '時段二之時間未填';
    else {
        // push class hour data into a string
        $id = $_POST['id'];
        $class_hours = $_POST['day1'];
        $d1 = $_POST['d1'];
        $day1 = array("0"=>"N", "1"=>"N", "2"=>"N", "3"=>"N", "4"=>"N",
                      "5"=>"N", "6"=>"N", "7"=>"N", "8"=>"N", "9"=>"N",
                      "10"=>"N", "11"=>"N", "12"=>"N", "13"=>"N");

        foreach ($d1 as $i => $x) {
            $day1[$x] = "Y";
        }

        $daystr = implode($day1);
        $class_hours .= $daystr;

        if ($_POST['day2'] != "0") {
            $class_hours .= $_POST['day2'];
            $d2 = $_POST['d2'];
            $day2 = array("0"=>"N", "1"=>"N", "2"=>"N", "3"=>"N", "4"=>"N",
                          "5"=>"N", "6"=>"N", "7"=>"N", "8"=>"N", "9"=>"N",
                          "10"=>"N", "11"=>"N", "12"=>"N", "13"=>"N");

            foreach ($d2 as $i => $x) {
                $day2[$x] = "Y";
            }

            $daystr = implode($day2);
            $class_hours .= $daystr;
        }

        if (CheckProEditIfCollision($_SESSION['id'], $class_hours, $id))
            $_SESSION['errmsg'] = '此課程時段與其他課程衝堂';
        else {
            $name = $_POST['name'];
            $student_upper_bound = $_POST['student_upper_bound'];
            $class_room = $_POST['class_room'];
            $required = $_POST['required'];
            $credit = $_POST['credit'];
            $year = $_POST['year'];
            $department = $_POST['department'];

            // set all grades on
            if(!isset($_POST['grade']))
                $grade = "111111";
            else
                $grade = GradeToBinary($_POST['grade']);

            $additional_info = $_POST['additional_info'];

            // update the data to the database
            $link = MysqliConnection('Write');
            $query = 'UPDATE Course SET Name=?, student_upper_bound=?, ' .
                     'class_room=?, credit=?, required=?, department=?, ' .
                     'grade=?, class_hours=?, additional_info=? ' .
                     'WHERE ID=? AND pro_id=? AND Year=?';

            $stmt = mysqli_stmt_init($link);
            if (mysqli_stmt_prepare($stmt, $query))
            {
                #mysqli_stmt_bind_param($stmt, "sdsddssssssd", $name, $student_upper_bound, $class_room, $credit, $required, $department, $grade, $class_hours, $additional_info, $id, $_SESSION['id'], $year);
                mysqli_stmt_bind_param($stmt, "ssssssssssss", 
                                    $name, $student_upper_bound, $class_room,
                                    $credit, $required, $department, $grade,
                                    $class_hours, $additional_info, $id,
                                    $_SESSION['id'], $year);

                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }

            mysqli_close($link);

            $_SESSION['errmsg'] = '您已成功修改課程資訊';
            $redirct_url = '../views/pro.php';
        }
    }

    // post edit check
    $stu_list = ListCourseStudents($id, $year);
    foreach ($stu_list as $stu_id) {
        $stu_grade = GetGradeByStuID($stu_id);
        $stu_depart = GetDepartByStuID($stu_id);
        // you are not in the correct grade or not in the correct department
        if (($grade[strlen($grade) - $stu_grade] != 1) ||
            ($stu_depart != $department)) {
            StudentDeleteCourse($stu_id, $id, $year);
            UpdateCourseChange($id, $year, $stu_id, "2");
        }


        $stu_course_list = ListTakenCoursesByStuID($stu_id);
        foreach ($stu_course_list as $row) {
            // except this course
            if ($id != $row[0] || $year != $row[1]) {
                if ( CheckCourseConfliction($class_hours,
                    GetCourseClassHours($row[0], $row[1]))) {
                    StudentDeleteCourse($stu_id, $id, $year);
                    UpdateCourseChange($id, $year, $stu_id, "1");
                }
            }
        }
    }

    header("Location: $redirct_url");
?>

