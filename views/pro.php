<?php
    session_start();
    $path = '../controllers/Session.php';
    require_once("$path");
    require_once("../models/User.php");
    if(array_key_exists('id', $_SESSION))
    {
        echo '<h2>user: ' . $_SESSION['id'] . ' has logined!!! </h2><br />' ;
        echo "Debug: ";
        var_dump($_SESSION);
        // check illegal users, and force to logout
        if ($_SESSION['perm'] != 'pro') {
            header('Location: '."../controllers/Logout.php");
        }
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
