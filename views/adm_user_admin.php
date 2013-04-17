<?php
    session_start();
    // check illegal users, and force to logout
    if ($_SESSION['perm'] != 'adm') {
        header('Location: '."../controllers/Logout.php");
    }
    require_once("../models/Adm.php");
?>
<html>
<body>
<h1>使用者管理</h1>
<h2>使用者清單</h2>
<hr>
<div>
    <?php GetStudentInfoTable() ?>
    <br />
    <?php GetProfessorInfoTable(); ?>
</div>

<hr>
<h2>刪除使用者</h2>
<p>
<form id="delete" method="post" action="../controllers/AdmDeleteUser.php">
    <label>帳號: </label>
    <input type="text" id="account" name="account" maxlength="10" placeholder="帳號" required />
    <button form="delete" type="submit">刪除使用者</button>
</form>
</p>
<hr>
<h2>更改使用者密碼</h2>
<p> 
<form id="passwd" method="post" action="../controllers/AdmEditPass.php">
    <pre><font color="red">密碼長度必須為10以內</font></pre>
    <label>帳號: </label>
    <input type="text" id="account" name="account" maxlength="10" placeholder="帳號" required />
    <label>新密碼: </label>
    <input type="password" id="passwd" name="new_passwd" maxlength="10" placeholder="新的密碼" required />
    <label>新密碼確認: </label>
    <input type="password" id="passwd" name="confirm_passwd" maxlength="10" placeholder="
密碼確認" required />
    <button form="passwd" type="submit">更改密碼</button>
 </form>
 </p>
<hr>
<a href="../views/adm.php">back</a>
</body>
</html>
