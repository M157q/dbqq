<?php
    session_start();
    require_once('../controllers/Session.php');
    if(array_key_exists('id', $_SESSION))
    {
        echo 'user: ' . $_SESSION['id'] . ' has logined!!! <br />' ;
        // redirect the page
        RedirectByPerm($_SESSION['perm']);
?>
<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta charset="utf-8">
        <title>Main</title>
    </head>
    <body>
        <h1>時空傳送門</h1>
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
