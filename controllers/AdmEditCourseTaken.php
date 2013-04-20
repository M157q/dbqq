<?php
    session_start();
    // you're not a administrator, go away!
    if ($_SESSION['adm'] == false) RedirectByPerm($_SESSION['perm']);

    require_once('../controllers/Session.php');
    require_once('../models/Course.php');
    require_once('../models/User.php');
    require_once('../components/Mysqli.php');

    $action = $_POST['action']; //add or delete
    $course_id = $_POST['course_id'];
    $course_year = $_POST['course_year'];
    $stu_id = $_POST['stu_id'];
    $errmsg = '';

    if (!CheckCourseIDExist($course_id, $course_year))
        $errmsg = '課號:'.$course_id.' 年度:'.$course_year.' 的課程並不存在';
    elseif(!CheckStudentIDExist($stu_id))
        $errmsg = '此學生帳號:'.$stu_id.' 並不存在';
    else
    {
        if ($action === 'add')
        {
            if(CheckStudentInCourse($stu_id, $course_id, $course_year))
                $errmsg = '此學生已在此課程的修課生名單中';
            else 
            {
                // update the data in the database
                $link = MysqliConnection('Write');
                $query = 'INSERT INTO Course_taken (StudentID, CourseID, CourseYear) VALUES (?, ?, ?)';
                $stmt = mysqli_stmt_init($link);
                if (mysqli_stmt_prepare($stmt, $query)) {
                    mysqli_stmt_bind_param($stmt, "sss", $stu_id, $course_id, $course_year);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                }
                mysqli_close($link);
                $errmsg = '您已成功將該學生加入此課程';
            }
        }

        if ($action === 'delete')
        {
            if(!CheckStudentInCourse($stu_id, $course_id, $course_year))
                $errmsg = '此學生並未修習此課程';
            else
            {
                // update the data in the database
                $link = MysqliConnection('Write');
                $query = 'DELETE FROM Course_taken WHERE StudentID=? AND CourseID=? AND CourseYear=?';
                $stmt = mysqli_stmt_init($link);
                if (mysqli_stmt_prepare($stmt, $query)) {
                    mysqli_stmt_bind_param($stmt, "sss", $stu_id, $course_id, $course_year);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                }
                mysqli_close($link);
                $errmsg = '您已成功將該學生從此課程中刪除';
            }
        }
    }

    $_SESSION['errmsg'] = $errmsg;
    //RedirectByPerm($_SESSION['perm']);
    header('Location: http://140.113.27.34:5566/views/adm_course_admin.php')
?>
