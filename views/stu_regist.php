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
<h1>學生申請帳號</h1>

<!-- login -->

<form method="post" action="../controllers/StuRegist.php">
    <label>帳號:</label>
    <input type="text" id="account" name="account" placeholder="請輸入10個字以內的數字" required />
    <br /><br />
    <label>密碼:</label>
    <input type="password" id="passwd" name="passwd" required />
    <br /><br />
    <label>姓名:</label>
    <input type="text" id="name" name="name" placeholder="芃蚊子" required />
    <br /><br />
    <label>學號:</label>
    <input type="text" id="stu_id" name="stu_id" placeholder="請輸入學號" required />
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
        <option value="碩一"> 碩一 </option>
        <option value="碩二"> 碩二 </option>
    </select>
    <br /><br />
    <button type="submit">申請帳號</button>
</form>

    <a href="../index.php">回到首頁</a><br/>
</body>
</html>
