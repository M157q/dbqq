<!DOCTYPE html>
<html lang="zh">
<title>User Registration</title>
<head>
    <meta charset="utf-8">
    <link href="../include/bootstrap/css/bootstrap.css" rel="stylesheet">
</head>

<body>
    <div class="container">
    <h1>學生申請帳號</h1>
<?php
    session_start();
    require_once('../models/Department.php');
    require_once('../models/Grade.php');
    require_once('../models/User.php');
    require_once('../controllers/Session.php');
    if (isset($_SESSION['perm'])) RedirectByPerm($_SESSION['perm']);
    showWarning(); 
?>
    <div class="form-actions">
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
                <?php GradeListGen(); ?>
            </select>
            <br /><br />
            <button class="btn btn-success btn-large" type="submit">申請帳號</button>
        </form>
    </div>
    <a class="btn btn-primary" href="../index.php">回到首頁</a><br/>
    </div>
</body>
</html>
