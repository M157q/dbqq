<?php
    session_start();
    require_once('models/User.php');
    require_once('controllers/Session.php');
    if (isset($_SESSION['id']) && CheckId($_SESSION['id']))
        RedirectByPerm($_SESSION['perm']);
?>

<!DOCTYPE html>
<html lang="zh">
<title>Welcome to dbqq!</title>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <style type="text/css">
          body {
            padding-top: 20px;
            padding-bottom: 60px;
          }

          /* Custom container */
          .container {
            margin: 0 auto;
            max-width: 1000px;
          }
          .container > hr {
            margin: 60px 0;
          }

          /* 嘎蹦脆 */
          .jumbotron {
            margin: 40px 0;
            text-align: center;
          }
          .jumbotron h1 {
            font-size: 100px;
            line-height: 1;
          }
          .jumbotron .lead {
            font-size: 24px;
            line-height: 1.25;
          }
          .jumbotron .btn {
            font-size: 21px;
            padding: 14px 24px;
          }

        </style>
<link href="include/bootstrap/css/bootstrap.css" rel="stylesheet">
</head>
<body>

    <div class="container">
      <div class="masthead">
        <h1  class="page-header" align="center">歡迎使用選課系統</h1>
      </div>
      <!-- Jumbotron -->
      <div class="jumbotron">
        <p class="codeblock">
          <?php showWarning(); ?>
          <h3>部份功能有用到 html5 故有些瀏覽器可能無法支援:-(</h3>
              <!-- Oh noes, you found it! -->
              hey, <span style="position: absolute; left: -100px; top: -100px"> σ ﾟ∀ ﾟ) ﾟ∀ﾟ)σ  阿哈哈你看看你</span> try to copy this line XD
        </p>
        <div class="alert alert-success">
            <p class="lead">If you see this page, our server is successfully working. ^q^</p>
            <p class="lead">Your IP is: <?php echo $_SERVER['REMOTE_ADDR']; ?> </p>
        </div>
        <div class="alert alert-info">
         <!-- 進擊の威儀 -->
        <h2>進擊の威儀</h2>
        <p><iframe width="853" height="480" src="https://www.youtube-nocookie.com/embed/YUMIoF8XGC4?rel=0&autoplay=1" frameborder="0" allowfullscreen style="margin: 0, auto"></iframe> </p>
      </div>
      </div>
      <script>//alert("助教安安，您累惹嗎？聽首歌吧")</script>

<!-- login -->

<div class="hero-unit">
<form method="post" action="controllers/Login.php">
    <p>
        <label>帳號:</label>
        <input type="text" id="account" name="account" required>
    </p>
    <p>
        <label>密碼:</label>
        <input type="password" id="passwd" name="passwd" required>
    </p>
    <p><button type="submit" class="btn btn-large btn-danger">異次元蟲洞入口</button></p>
</form>

    <hr>
    <div class="row-fluid">
        <a class="btn btn-success" href="/views/stu_regist.php">學生申請帳號</a>
        <a class="btn btn-success" href="/views/pro_regist.php">教授申請帳號</a>
        <a class="btn btn-success" href="/views/course_list.php">課程列表</a>
    </div>

    </div>
</div>
</body>
</html>
