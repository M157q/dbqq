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
<?php echo "user admin"; ?>
<hr>
<div>
    <?php GetStudentInfoTable() ?>
    <hr>
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
    <label>密碼: (請輸入10個字以內的密碼)</label>
    <input type="text" id="account" name="account" maxlength="10" placeholder="帳號" required />
    <input type="password" id="passwd" name="new_passwd" maxlength="10" placeholder="新的密碼" required />
    <input type="password" id="passwd" name="confirm_passwd" maxlength="10" placeholder="
密碼確認" required />
    <button form="passwd" type="submit">更改密碼</button>
 </form>
 </p>
<hr>
<a href="../views/adm.php">back</a>
</body>
</html>
