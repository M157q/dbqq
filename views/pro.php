<?php
    session_start();
    require_once('../controllers/Session.php');
    require_once('../models/User.php');
    require_once('../models/Course.php');
    $_SESSION['adm'] = isAdmin($_SESSION['id']);
    $_SESSION['ban'] = isBanned($_SESSION['id']);
    
    CheckPermAndRedirect($_SESSION['perm'], 'pro');
    if(array_key_exists('id', $_SESSION))
    {
        echo '<h2>user: ' . $_SESSION['id'] . ' has logined!!! </h2><br />' ;
        if ($_SESSION['errmsg'] !== '') {
            echo "錯誤信息：" . $_SESSION['errmsg'];
            $_SESSION['errmsg'] = '';
        }
        if ($_SESSION['ban']) echo '您正在被停權中';
?>
<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta charset="utf-8">
        <title>Professor's Main</title>
    </head>
    <body>
    <h1>安安我是 教授ㄉㄉ</h1>

<?php if ($_SESSION['adm']) ShowAdminArea(); ?>
        <div>
            <?php ShowProfessorInfo($_SESSION['id'])?>
        </div>
        <hr>

<?php if (!$_SESSION['ban']): ?>
        <div>
        <h2>修改資料</h2>
        <p> <form method="post" action="../controllers/ProEditName.php">
            <label>姓名:</label>
            <input type="text" id="name" name="name" placeholder="芃蚊子" required />
            <button type="submit">更改姓名</button>
        </form> </p>

        <p> <form method="post" action="../controllers/ProEditPass.php">
            <label>密碼: (請輸入10個字以內的密碼)</label>
            <input type="password" id="passwd" name="old_passwd" maxlength="10" placeholder="原本密碼" required />
            <input type="password" id="passwd" name="new_passwd" maxlength="10" placeholder="新的密碼" required />
            <input type="password" id="passwd" name="confirm_passwd" maxlength="10" placeholder="密碼確認" required />
            <button type="submit">更改密碼</button>
        </form> </p>
        </div>

        <hr>
        <h2>教授專區</h2>
        <a href="../views/pro_add_course.php">新增課程</a><br/>
        <div>
	    <h3>教授課程</h3>
	    <form method="post" action="../views/pro_view_student.php">
	    <?php ListProfessorCourse($_SESSION['id'])?>
            <button type="submit">學生列表</button>
            </form>
	    <h3>編輯課程</h3>
        <p> <form method="post" action="../views/pro_edit_course.php">
	    <label>課號:</label>
	    <input type="text" id="id" name="id" placeholder="4699" required />
	    <label>年度:</label>
	    <input type="number" id="year" name="year" placeholder="21XX" required />
            <button type="submit">編輯此課程</button>
	    </form> </p>
        </div>
<?php endif ?>

        <div><form name="logout" method="post" action="../controllers/Logout.php" >
        <p> <input type="submit" value="登出" /><p>
        </form> </div>
    </body>
</html>
<?php
    }
?>
