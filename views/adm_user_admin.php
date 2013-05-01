<?php
    session_start();
    // check illegal users, and force to logout

    require_once("../controllers/Session.php");
    require_once("../models/User.php");
    require_once("../models/Adm.php");

?>
<!DOCTYPE HTML>
<html>
<title>課程管理安安</title>
<head>
    <meta charset="utf-8">
    <link href="../include/bootstrap/css/bootstrap.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>使用者管理</h1>
        <hr>
        <h2>使用者清單</h2>
        <?php GetStudentInfoTable() ?>
        <br />
        <?php GetProfessorInfoTable(); ?>

        <hr>

        <div class="form-actions">
        <h2>刪除使用者</h2>
        <p><form id="delete" method="post" action="../controllers/AdmDeleteUser.php">
            <label>帳號: </label>
            <input type="text" id="account" name="account" maxlength="10" placeholder="帳號" required />
            <br>
            <button class="btn btn-danger" form="delete" type="submit">刪除使用者</button>
        </form></p>
        </div>

        <hr>

        <div class="form-actions">
        <h2>更改使用者密碼</h2>
        <p><form id="passwd" method="post" action="../controllers/AdmEditPass.php">
            <pre><font color="red">Note: 密碼長度必須為10以內</font></pre>
            <label>帳號: </label>
            <input type="text" id="account" name="account" maxlength="10" placeholder="帳號" required />
            <label>新密碼: </label>
            <input type="password" id="passwd" name="new_passwd" maxlength="10" placeholder="新的密碼" required />
            <label>新密碼確認: </label>
            <input type="password" id="passwd" name="confirm_passwd" maxlength="10" placeholder="密碼確認" required />
            <br>
            <button class="btn btn-danger" form="passwd" type="submit">更改密碼</button>
        </form></p>
        </div>

        <hr>

        <div class="form-actions">
        <h2>更改使用者身份</h2>
        <p><form id="identity" method="post" action="../controllers/AdmIdentityChange.php">
            <label>帳號: </label>
            <input type="text" id="account" name="account" maxlength="10" placeholder="帳號" required />
            <p>
            <input type="radio" name="action" value="admin" required />系統管理員
            <input type="radio" name="action" value="user" required />一般使用者<br />
            </p>
            <button class="btn btn-danger" form="identity" type="submit">更改身份</button>
        </form> </p>
        </div>

        <hr>

        <div class="form-actions">
        <h2>更改停權狀態</h2>
        <p><form id="ban" method="post" action="../controllers/AdmBanUser.php">
            <label>帳號: </label>
            <input type="text" id="account" name="account" maxlength="10" placeholder="帳號" required />
            <p>
            <input type="radio" name="action" value="ban" required />停權
            <input type="radio" name="action" value="unban" required />解除停權<br />
            </p>
            <button class="btn btn-danger" form="ban" type="submit">確定</button>
        </form></p>
        </div>

        <hr>

        <a class="btn btn-info" href="../index.php">back</a>
    </div>
</body>
</html>
