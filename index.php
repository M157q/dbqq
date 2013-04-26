<?php
    session_start();
#    var_dump($_SESSION);
    require_once('models/User.php');
    require_once('controllers/Session.php');
    if (isset($_SESSION['id']) && CheckId($_SESSION['id'])) RedirectByPerm($_SESSION['perm']);
?>
<!DOCTYPE html>
<html lang="zh">
<title>Welcome to dbqq!</title>
<head>
    <meta charset="utf-8">
    <title>Login</title>
<style>
    body {
        width: 35em;
        margin: 0 auto;
        font-family: Tahoma, Verdana, Arial, sans-serif;
    }
</style>
</head>
<body>
<h1 text="#">歡迎使用選課系統</h1>
<p>If you see this page, our server is successfully working. ^q^</p>

<p>Your IP is:<p>
<?php
    echo $_SERVER['REMOTE_ADDR'];
?>

<!-- login -->

<form method="post" action="controllers/Login.php">
    <p>
        <label>帳號:</label>
        <input type="text" id="account" name="account" required>
    </p>
    <p>
        <label>密碼:</label>
        <input type="password" id="passwd" name="passwd" required>
    </p>
    <p><button type="submit">登入</button></p>
</form>

<?php 
    if(isset($_SESSION['errmsg']) && !empty($_SESSION['errmsg'])){
            $errormsg = $_SESSION['errmsg'];
            unset($_SESSION['errmsg']);
            echo "$errormsg".'<br/>';
    }
?>
        <a href="/views/stu_regist.php">學生申請帳號</a><br/>
        <a href="/views/pro_regist.php">教授申請帳號</a><br/>
        <a href="/views/course_list.php">課程列表</a><br/>
    <h3>部份功能有用到 html5 故有些瀏覽器可能無法支援:-(</h3>
 <p class="codeblock">

      <!-- Oh noes, you found it! -->
      hey, <span style="position: absolute; left: -100px; top: -100px"> σ ﾟ∀ ﾟ) ﾟ∀ﾟ)σ  阿哈哈你看看你</span>
    try to copy this line XD
    </p>
    <p>
</body>
</html>
