<!DOCTYPE HTML>
<html lang="zh">
<title>學生列表</title>
<head>
    <meta charset="utf-8">
    <link href="../include/bootstrap/css/bootstrap.css" rel="stylesheet">
    <style>
          .jumbotron {
            margin: 60px 0;
            text-align: left;
          }
    </style>
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <h1>檢視修課學生列表</h1>
            <hr>
<?php
    session_start();
    require_once("../models/Course.php");
    require_once("../models/Department.php");
    require_once("../models/User.php");
    require_once("../components/Mysqli.php");
    require_once("../controllers/Session.php");
    if (isBanned($_SESSION['id'])) RedirectByPerm($_SESSION['perm']);
    if ($_SESSION['perm'] != 'pro') RedirectByPerm($_SESSION['perm']);
    showWarning();
    if(!isset($_POST['id_year'])) {
        $_SESSION['errmsg'] = '沒有選擇課程 無法顯示學生列表';
        RedirectByPerm($_SESSION['perm']);
    }
    
    ProViewCourseStudent($_POST['id_year']);
?>
        <a class="btn btn-info" href="./pro.php">回上頁</a>
    </div>
</div>
</body>
</html>

