<?php
session_start();

require_once('../components/Mysqli.php');
require_once("../models/Course.php");
require_once('../controllers/Session.php');
CheckPermAndRedirect($_SESSION['perm'], 'stu');

$course_id_years = array();
$course_ids = array();
$selected_cid_year = array();

// get all course id which is been checked
foreach ($_POST as $id_year => $check) {
    if ($check == "on") {
        array_push($course_id_years, $id_year);
        list($id, $year) = explode('_', $id_year);
        array_push($course_ids, $id);
    }
}

//get selected course list of student
$link = MysqliConnection('Read');

$course_list = array();

$query = 'SELECT CourseID, CourseYear FROM Course_taken WHERE StudentID=?';
$stmt = mysqli_stmt_init($link);
if (mysqli_stmt_prepare($stmt, $query))
{
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['id']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $cid, $cyear);
    while(mysqli_stmt_fetch($stmt)) {
        array_push($selected_cid_year, $cid."_".$cyear);
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($link);

$link = MysqliConnection('Read');
//Check if any confliction in class_hours
$query = 'SELECT class_hours FROM Course WHERE id=? AND year=?';

// from courses which student choose via the views/stu.php
foreach($course_id_years as $i) {
    $conflict = false;
    //echo "\$i -> $i<br>";
    list($id, $year) = explode('_', $i);
    if (CheckIfChosen($_SESSION['id'], $id)) {
        $_SESSION['errmsg'] .= "course ID: $id 此課程已選擇  ";
        continue;
    }

    // check chosen courses
    foreach($selected_cid_year as $j) {
        //echo "checking -> $j <br>";
        list($id, $year) = explode('_', $i);
        $stmt = mysqli_stmt_init($link);
        if(mysqli_stmt_prepare($stmt, $query)) {
            mysqli_stmt_bind_param($stmt, "ss", $id, $year);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $c_chr);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
        }

        list($id, $year) = explode('_', $j);
        $stmt = mysqli_stmt_init($link);
        if(mysqli_stmt_prepare($stmt, $query)) {
            mysqli_stmt_bind_param($stmt, "ss", $id, $year);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $s_chr);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
        }
        // $c_chr -> course (select in the views/stud.php)'s coures hour
        // $s_chr -> chosen course's course hour
        if (CheckCourseConfliction($s_chr, $c_chr)) {
            $conflict = true;
            break;
        }
    }
    // if not conflict, then choose the course
    if (!$conflict) {
        ChooseCourse($_SESSION['id'], $i);
    }
    else {
        list($id, $year) = explode('_', $i);
        $_SESSION['errmsg'] .= "course ID: $id 課程衝堂 QQ ";
    }
}

mysqli_close($link);
RedirectByPerm('stu');
?>
