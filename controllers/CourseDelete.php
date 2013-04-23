<?php
session_start();

require_once('../components/Mysqli.php');
require_once("../models/Course.php");
require_once('../controllers/Session.php');
CheckPermAndRedirect($_SESSION['perm'], 'stu');


$link = MysqliConnection('Read');

$query = 'DELETE FROM Course_taken WHERE StudentID=? AND CourseID=? AND 
         CourseYear=?';
$stmt = mysqli_stmt_init($link);
if (mysqli_stmt_prepare($stmt, $query))
{
    mysqli_stmt_bind_param($stmt, "sss", $_SESSION['id'], $_POST['id'],
                                         $_POST['year']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
mysqli_close($link);
RedirectByPerm('stu');
?>
