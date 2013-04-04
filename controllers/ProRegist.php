<?php
session_start();

    require_once('../models/User.php'); 
    require_once('../components/Mysqli.php'); 
    require_once('../include/salt.php');

    // redirect to the home page by default
    $redirect_url = '../views/pro_regist.php';

    //user input error detection and error message return
    $errmsg = '';
    if(!CheckId($_POST['account'])) 
        $errmsg = '您輸入的帳號格式有誤';
    elseif(!CheckId($_POST['pro_id'])) 
        $errmsg = '您輸入的教職員編號號格式有誤';
    elseif(!CheckPasswd($_POST['passwd'])) 
        $errmsg = '請輸入您的密碼';
    elseif(CheckIDExist($_POST['account'])) 
        $errmsg = '此帳號已被使用';
    elseif(CheckNumberExist($_POST['pro_id'])) 
        $errmsg = '此教職員編號已被使用';
    else {
        $id = $_POST['account'];
        $passwd = $_POST['passwd'] . $salt;
        $name = $_POST['name'];
        $pro_id = $_POST['pro_id'];
        $department = $_POST['department'];

        // insert the data to the database
        $link = MysqliConnection('Write');
        $query = 'INSERT INTO Professor (ID, Password, Name, ProfessorNumber, department) VALUES ( ?, SHA1(?), ?, ?, ?)';
        $stmt = mysqli_stmt_init($link);
        if (mysqli_stmt_prepare($stmt, $query))
        {
            mysqli_stmt_bind_param($stmt, "sssss", $id, $passwd, $name, $pro_id, $department);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        // if regitstration is ok, then goto the main page
        $redirect_url = '../views/main.php';
        $_SESSION['id'] = $_POST['account'];
        $_SESSION['perm'] = 'pro'; 
    }

    $_SESSION['errmsg'] = $errmsg;
    header("Location: $redirect_url");
?>
