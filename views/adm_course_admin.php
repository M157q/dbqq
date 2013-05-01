<?php
    session_start();

    // check illegal users, and force to logout
    require_once("../controllers/Session.php");
    require_once("../models/User.php");
    if ($_SESSION['adm'] == false) RedirectByPerm($_SESSION['perm']);
        showWarning();
?>
<!DOCTYPE html>
<html>
<title>課程管理安安</title>
<head>
    <meta charset="utf-8">
    <link href="../include/bootstrap/css/bootstrap.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>課程管理</h1>
        <hr>
        <?php
            require_once("../models/Course.php");
            GetCourseInfoTable();
        ?>
        <hr>

        <div class="form-actions">
        <h2>刪除課程</h2>
        <p>
        <form id="delete_course" method="post" action="../controllers/AdmDeleteCourse.php">
            <label>課號: </label>
            <input type="text" id="course_id" name="course_id" placeholder="課號" required />
            <label>年度: </label>
            <input type="text" id="course_year" name="course_year" placeholder="年度" required />
            <br>
            <button class="btn btn-success" form="delete_course" type="submit">刪除該課程</button>
        </form>
        </p>
        </div>

        <hr>

        <div class="form-actions">
        <h2>新增/刪除課程內學生</h2>
        <p>
        <form id="edit_course_stu" method="post" action="../controllers/AdmEditCourseTaken.php">
            <p>
            <label class="radio">
                <input type="radio" name="action" value="add" required />新增</label>
            <label class="radio">
                <input type="radio" name="action" value="delete" required />刪除</label>
            </p>
            <label>課號: </label>
            <input type="text" name="course_id" placeholder="課號" required />
            <label>年度: </label>
            <input type="text" name="course_year" placeholder="年度" required />
            <label>學生帳號: </label>
            <input type="text" name="stu_id" placeholder="學生帳號" required />
            <button class="btn btn-success" form="edit_course_stu" type="submit">確定</button>
        </form>
        </p>
        </div>

        <hr>

        <a class="btn btn-info" href="../index.php">back</a><br/>
        <hr>
    </div>
</body>
</html>
