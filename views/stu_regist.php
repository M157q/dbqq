<?php
    session_start();
    require_once('../models/Department.php');
    require_once('../models/User.php');
    require_once('../controllers/Session.php');
    if (isset($_SESSION['perm'])) RedirectByPerm($_SESSION['perm']);
    showWarning();
?>
<!DOCTYPE html>
<html lang="zh">
<title>User Registration</title>
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
        <h1>學生申請帳號</h1>

        <!-- login -->
        <form method="post" action="../controllers/StuRegist.php">
            <label>帳號:</label>
            <input type="text" id="account" name="account" maxlength="10" placeholder="請輸入10個字以內的數字" required />
            <br /><br />
            <label>密碼:</label>
            <input type="password" id="passwd" name="passwd" maxlength="10" placeholder="請輸入10個字以內的密碼" required />
            <br /><br />
            <label>姓名:</label>
            <input type="text" id="name" name="name" placeholder="芃蚊子" required />
            <br /><br />
            <label>學號:</label>
            <input type="text" id="stu_id" name="stu_id" maxlength="10" placeholder="請輸入學號" required />
            <br /><br />
            <label>系所:</label>
            <select name="department" required />
                <?php DepartListGen(); ?>
            </select>
            <br /><br />
            <label>年級:</label>
            <select name="grade" required />
                <option value="大一"> 大一 </option>
                <option value="大二"> 大二 </option>
                <option value="大三"> 大三 </option>
                <option value="大四"> 大四 </option>
            </select>
            <br /><br />
            <button class="btn btn-success btn-large" type="submit">申請帳號</button>
        </form>
        <a href="../index.php">回到首頁</a><br/>
        </div>
    </div>
</body>
</html>
