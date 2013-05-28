<?php
    session_start();
    require_once('../controllers/Session.php');
    require_once('../models/Course.php');
    require_once('../components/Mysqli.php');

    CheckPermAndRedirect($_SESSION['perm'], 'pro');

    $course_id = $_POST['course_id'];
    $course_year = $_POST['course_year'];
    $pro_id = $_SESSION['id'];
    $errmsg = '';

    if (!CheckCourseIDExist($course_id, $course_year))
        $errmsg = "課號: $course_id  年度: $course_year 的課程並不存在";
    else
    {
        // pre delete processing
        $stu_list = ListCourseStudents($course_id, $course_year);
        foreach ($stu_list as $stu_id) {
            StudentDeleteCourse($stu_id, $course_id, $course_year);
            UpdateCourseChange($course_id, $course_year, $stu_id, "3");
        }

        // update the data in the database
        $link = MysqliConnection('Write');
        $query = 'DELETE FROM Course WHERE ID=? AND Year=? AND pro_id=?';
        $stmt = mysqli_stmt_init($link);
        if (mysqli_stmt_prepare($stmt, $query)) {
            mysqli_stmt_bind_param($stmt, "sss", $course_id, $course_year, $pro_id);
            mysqli_stmt_execute($stmt);
            if (mysqli_stmt_affected_rows($stmt)) $errmsg = '您已成功刪除該課程';
            else $errmsg = '這不是您所建立的課程，故無法刪除。';
            mysqli_stmt_close($stmt);
        }
        mysqli_close($link);
    }

    $_SESSION['errmsg'] = $errmsg;
    RedirectByPerm($_SESSION['perm']);
?>
