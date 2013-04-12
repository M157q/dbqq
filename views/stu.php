<?php
    session_start();
    $path = '../controllers/Session.php';
    require_once("$path");
    require_once("../models/User.php");
    require_once("../models/Course.php");
    CheckPermAndRedirect($_SESSION['perm'], 'stu');
    if(array_key_exists('id', $_SESSION))
    {
        echo '<h2>user: ' . $_SESSION['id'] . ' has logined!!! </h2><br />' ;
        echo "Debug: ";
        var_dump($_SESSION);
?>
<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta charset="utf-8">
        <title>Student's Main page</title>
    </head>
    <body>
    <h1>安安我是 student</h1>
        <?php ShowStudentInfo($_SESSION['id'])?>
        <hr>

        <h2>修改資料</h2>
        <p> <form method="post" action="../controllers/StuEditName.php">
            <label>姓名:</label>
            <input type="text" id="name" name="name" placeholder="芃蚊子" required />
            <button type="submit">更改姓名</button>
        </form> </p> 

        <p> <form method="post" action="../controllers/StuEditPass.php">
            <label>密碼: (請輸入10個字以內的密碼)</label>
            <input type="password" id="old_passwd" name="old_passwd" maxlength="10" placeholder="原本密碼" required />
            <input type="password" id="new_passwd" name="new_passwd" maxlength="10" placeholder="新的密碼" required />
            <input type="password" id="confirm_passwd" name="confirm_passwd" maxlength="10" placeholder="
密碼確認" required />
            <button type="submit">更改密碼</button>
        </form> </p>

        <hr>
        <h2>已選課程</h2>
        <?php ListStudentCourse($_SESSION['id']); ?>
        <hr>

        <h2>開始課程</h2>
        <form method="post" action="../controllers/CourseSelect.php">
            <?php
                GetCourseInfoTableWithCheckBox();
            ?>
            <button type="submit">選課安安</button>
        </form>

        <hr>

        <a href="/views/course_list.php">所有課程列表</a><br/>
        <div>
            <form name="logout" method="post" action="../controllers/Logout.php" >
                <p>
                    <input type="submit" value="登出" /><p>
            </form>
        </div>
    </body>
</html>
<?php
    }
?>
