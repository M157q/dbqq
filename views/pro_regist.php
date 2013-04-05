<?php
    session_start();
    var_dump($_SESSION);
    require_once('../models/Department.php');
?>
<!DOCTYPE html>
<html lang="zh">
<title>User Registration</title>
<head>
    <meta charset="utf-8">
<style>
    body {
        width: 35em;
        margin: 0 auto;
        font-family: Tahoma, Verdana, Arial, sans-serif;
    }
</style>
</head>
<body>
<h1>教授申請帳號</h1>

<!-- login -->

<form method="post" action="../controllers/ProRegist.php">
    <label>帳號:</label>
    <input type="text" id="account" name="account" maxlength="10" placeholder="請輸入10個字以內的數字" required />
    <br /><br />
    <label>密碼:</label>
    <input type="password" id="passwd" name="passwd" maxlength="10" placeholder="請輸入10個字以內的密碼" required />
    <br /><br />
    <label>姓名:</label>
    <input type="text" id="name" name="name" placeholder="芃蚊子" required />
    <br /><br />
    <label>教職員編號:</label>
    <input type="text" id="pro_id" name="pro_id" maxlength="10" placeholder="請輸入教職員編號" required />
    <br /><br />
    <label>系所:</label>
    <select name="department" required />
        <?php DepartListGen(); ?>
    </select>
    <br /><br />

    <button type="submit">申請帳號</button>
</form>

    <a href="../index.php">回到首頁</a><br/>
</body>
</html>
