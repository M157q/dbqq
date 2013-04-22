<?php
session_start();
var_dump($_POST);

require_once("../models/Course.php");
require_once('../controllers/Session.php');
CheckPermAndRedirect($_SESSION['perm'], 'stu');

// get all course id which is been checked
$course_id_years = array();
$course_ids = array();
foreach ($_POST as $id_year => $check) {
    if ($check == "on") {
        array_push($course_id_years, $id_year);
        list($id, $year) = explode('_', $id_year);
        array_push($course_ids, $id);
    }
}

ChooseCourse($_SESSION['id'], $course_id_years);
#echo "選擇課程";
#GetCourseInfoTableByIDs($course_ids);
RedirectByPerm('stu');
?>
