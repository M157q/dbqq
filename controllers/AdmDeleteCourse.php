<?php
    session_start();
    require_once('../controllers/Session.php');
    require_once('../models/Course.php');
    require_once('../components/Mysqli.php');

    // you're not a administrator, go away!
    if ($_SESSION['adm'] == false) RedirectByPerm($_SESSION['perm']);

    $course_id = $_POST['course_id'];
    $course_year = $_POST['course_year'];
    $errmsg = '';

    if (!CheckCourseIDExist($course_id, $course_year))
        $errmsg = 'Course ID: '.$course_id.' of year '.$course_year.' not found.';
    else
    {
        // update the data in the database
        $link = MysqliConnection('Write');
        $query = 'DELETE FROM Course WHERE ID=? AND Year=?';
        $stmt = mysqli_stmt_init($link);
        if (mysqli_stmt_prepare($stmt, $query)) {
            mysqli_stmt_bind_param($stmt, "ss", $course_id, $course_year);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        mysqli_close($link);
        $errmsg = '您已成功刪除該課程';
    }

    $_SESSION['errmsg'] = $errmsg;
    //RedirectByPerm($_SESSION['perm']);
    header('Location: http://dbqq.nctucs.net:5566/views/adm_course_admin.php')
?>
