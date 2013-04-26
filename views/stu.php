<!DOCTYPE html>
<html lang="zh">
<?php
    session_start();
    require_once('../controllers/Session.php');
    require_once('../models/User.php');
    require_once('../models/Course.php');
    if (isset($_SESSION['id'])) {
        $_SESSION['adm'] = isAdmin($_SESSION['id']);
        $_SESSION['ban'] = isBanned($_SESSION['id']);
    }
    else {
        header('Location: http://dbqq.nctucs.net:5566/index.php');
    }
    
    CheckPermAndRedirect($_SESSION['perm'], 'stu');
    if(array_key_exists('id', $_SESSION))
    {
        showLoginMessage();
        showWarning();
?>
    <head>
        <meta charset="utf-8">
        <title>Student's Main page</title>
    </head>
    <body>
    <h1>安安我是 student</h1>

<?php if ($_SESSION['adm']) ShowAdminArea(); ?>

    <?php ShowStudentInfo($_SESSION['id'])?>
    <hr>

<?php if (!$_SESSION['ban']): ?>
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

    <h2>開始選課</h2>
    <form method="post" action="../controllers/CourseSelect.php">
        <?php
            GetCourseInfoTableWithCheckBox();
        ?>
        <button type="submit">選課安安</button>
        <pre><img src="http://statics.plurk.com/1bd653e166492e40e214ef6ce4dd716f.png"></pre>
    </form>

    <hr>
    <h2>取消選課</h2>
    <form method="post" action="../controllers/CourseDelete.php">
	    <label>課程 ID :</label>
	    <input type="text" id="id" name="id" placeholder="5566" required />
	    <label>年度 :</label>
	    <input type="text" id="year" name="year" placeholder="21XX" required />
        <button type="submit">教授ㄅㄅ~ </button>
        <img src="http://statics.plurk.com/a55bdb344892676b0fea545354654a49.gif">
    </form>
    <hr>

    <a href="/views/course_list.php">所有課程列表</a><br/>
<?php endif ?>

    <div><form name="logout" method="post" action="../controllers/Logout.php" >
        <p><input type="submit" value="登出" /><p>
    </form> </div>

    </body>
</html>
<?php
    }
?>
