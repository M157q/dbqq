<?php
session_start();

require_once('../components/Mysqli.php');
require_once("../models/Course.php");
require_once('../controllers/Session.php');
CheckPermAndRedirect($_SESSION['perm'], 'stu');


$link = MysqliConnection('Read');

$query = 'DELETE FROM Course_taken WHERE StudentID=? AND CourseID=?';
$stmt = mysqli_stmt_init($link);
if (mysqli_stmt_prepare($stmt, $query))
{
    mysqli_stmt_bind_param($stmt, "ss", $_SESSION['id'], $_POST['id']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
mysqli_close($link);
RedirectByPerm('stu');
?>
