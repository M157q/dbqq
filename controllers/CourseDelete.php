<?php
session_start();

require_once("../models/Course.php");
require_once('../controllers/Session.php');
CheckPermAndRedirect($_SESSION['perm'], 'stu');

$stu_id = $_SESSION['id'];
$course_id = $_POST['id'];
$course_year = $_POST['year'];
$errmsg = '';
if (CheckCourseIDExist($course_id, $course_year))
{
    if (CheckStudentInCourse($stu_id, $course_id, $course_year))
    {
        StudentDeleteCourse($stu_id, $course_id, $course_year);
        $errmsg = '您已成功取消選擇此課程';
    }
    else $errmsg = '你並沒有選這門課';
}
else $errmsg = '課號' . $course_id . ' 年度'. $course_year . ' 的課程並不存在';

$_SESSION['errmsg'] = $errmsg;
RedirectByPerm('stu');
?>
