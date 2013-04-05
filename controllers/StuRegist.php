<?php
session_start();

    require_once('../models/User.php');
    require_once('../components/Mysqli.php');
    require_once('../include/salt.php');

    // redirect to the home page by default
    $redirect_url = '../views/stu_regist.php';

    // user input error detection and error message return
    $errmsg = '';
    if(!CheckId($_POST['account']))
        $errmsg = '您輸入的帳號格式有誤';
    elseif(!CheckId($_POST['stu_id']))
        $errmsg = '您輸入的學號格式有誤';
    elseif(!CheckPasswd($_POST['passwd']))
        $errmsg = '請輸入您的密碼';
    elseif(strlen($_POST['passwd']) > 10)
        $errmsg = 'Spec 規定: 密碼最大長度為 10 碼 ^.<';
    elseif(CheckIDExist($_POST['account'])) {
        $errmsg = '此帳號已被使用';
    elseif(CheckNumberExist($_POST['stu_id'])) {
        $errmsg = '此學號已被使用';
    }
    else {
        $id = $_POST['account'];
        $passwd = $_POST['passwd'] . $salt;
        $name = $_POST['name'];
        $stu_id = $_POST['stu_id'];
        $department = $_POST['department'];
        $grade = $_POST['grade'];

        // insert the data to the database
        $link = MysqliConnection('Write');
        $query = 'INSERT INTO Student (ID, Password, Name, StudentNumber, department, grade) VALUES ( ?, SHA1(?), ?, ?, ?, ?)';
        $stmt = mysqli_stmt_init($link);
        if (mysqli_stmt_prepare($stmt, $query))
        {
            mysqli_stmt_bind_param($stmt, "ssssss", $id, $passwd, $name, $stu_id, $department, $grade);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        mysqli_close($link);
        // if regitstration is ok, then goto the main page
        $redirect_url = '../views/main.php';
        $_SESSION['id'] = $_POST['account'];
        $_SESSION['perm'] = 'stu';
    }

    $_SESSION['errmsg'] = $errmsg;
    header("Location: $redirect_url");
?>
