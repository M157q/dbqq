<?php
    session_start();
    require_once("../controllers/Session.php");
    //require_once("../models/User.php");
    //require_once("../models/Adm.php");
    if(!$SESSION['adm'])
        RedirectByPerm($_SESSION['perm']);
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
        <title>超級使用者 Main</title>
    </head>
    <body>
    <h1>安安我是 adm</h1>
    <p>
<ul>
<li> <a href="../views/adm_user_admin.php">使用者管理</a> </li>
<li> <a href="../views/adm_course_admin.php">課程管理</a> </li>
</ul>
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
