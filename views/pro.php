<?php
    session_start();
    $path = '../controllers/Session.php';
    require_once("$path");
    require_once("../models/User.php");
    CheckPermAndRedirect($_SESSION['perm'], 'pro');
    if(array_key_exists('id', $_SESSION))
    {
        echo '<h2>user: ' . $_SESSION['id'] . ' has logined!!! </h2><br />' ;
        echo "Debug: ";
        var_dump($_SESSION);
        // check illegal users, and force to logout
?>
<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta charset="utf-8">
        <title>Professor;s Main</title>
    </head>
    <body>
    <h1>安安我是 教授ㄉㄉ</h1>
        <div>
            <?php ShowProfessorInfo($_SESSION['id'])?>
        </div>
        <hr>
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
            <input type="password" id="passwd" name="confirm_passwd" maxlength="10" placeholder="
密碼確認" required />
            <button type="submit">更改密碼</button>
        </form> </p>
        </div>
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
