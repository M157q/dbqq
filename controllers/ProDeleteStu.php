<?php session_start();
    require_once('../controllers/Session.php');
    require_once('../models/User.php');
    require_once('../models/Course.php');
    require_once('../components/Mysqli.php');

    CheckPermAndRedirect($_SESSION['perm'], 'pro');

    $id = $_POST['account'];
    $errmsg = '';
    list($course_id, $course_year) = explode('_', $_SESSION['id_year']);
    $del_ok = 0;

    if (!CheckStudentIDExist($id)) {
        $errmsg = "此學生帳號 $id 並不存在";
    }
    else {
        // update the data in the database
        $link = MysqliConnection('Write');
        $query = 'DELETE FROM Course_taken WHERE StudentID=? AND CourseID=? AND CourseYear=?';
        $stmt = mysqli_stmt_init($link);
        if (mysqli_stmt_prepare($stmt, $query)) {
            mysqli_stmt_bind_param($stmt, "sss", $id, $course_id, $course_year);
            if (mysqli_stmt_execute($stmt)) {
                $errmsg = '您已成功刪除該使用者';
                $del_ok = 1;
            }
            else $errmsg = "$id 不在本課程的修課學生名單內";
            mysqli_stmt_close($stmt);
        }
        mysqli_close($link);
    }

    // there's a deletion
    if ($del_ok == 1) {
        UpdateCourseChange($course_id, $course_year, $id, "3");
    }


    $_SESSION['errmsg'] = $errmsg;
    //RedirectByPerm($_SESSION['perm']);
    header('Location: ../views/pro_view_student.php');
?>
