<?php
    session_start();
    // check illegal users, and force to logout
    if ($_SESSION['perm'] != 'adm') {
        //header('Location: '."../controllers/Logout.php");
    }
?>
<html>
<body>
<?php echo "user admin"; ?>
        <h2>更改使用者密碼</h2>
        <hr>
        <p> <form method="post" action="../controllers/AdmEditPass.php">
            <label>密碼: (請輸入10個字以內的密碼)</label>
            <input type="text" id="account" name="account" maxlength="10" placeholder="帳號" required />
            <input type="password" id="passwd" name="new_passwd" maxlength="10" placeholder="新的密碼" required />
            <input type="password" id="passwd" name="confirm_passwd" maxlength="10" placeholder="
密碼確認" required />
            <select name="perm" required />
                <option value="stu"> 學生 </option>
                <option value="pro"> 教授 </option>
            </select>
            <button type="submit">更改密碼</button>
        </form> </p>
        <a href="../views/adm.php">back</a>
</body>
</html>
