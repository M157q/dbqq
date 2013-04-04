<?php
// XXX: currently only support student regitration. (and just fill id/name/pass)
session_start();
    // this may be move to models XD
    function CheckIDExist($id) {
        $result = false;
        $link = MysqliConnection('Read');
        $query = 'SELECT ID From Student WHERE ID=?';
        $stmt = mysqli_stmt_init($link);
        if (mysqli_stmt_prepare($stmt, $query))
        {
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $result);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
        }
        return $result;
    }

    require_once('../models/LoginCheck.php'); 
    require_once('../models/MysqliConnection.php'); 
    require_once('../include/salt.php');

    // redirect to the home page by default
    $redirect_url = 'http://140.113.27.34:5566/index.php';

    //user input error detection and error message return
    $errmsg = '';
    if(!CheckId($_POST['account'])) 
        $errmsg = 'Your ID format is wrong.';
    elseif(!CheckPasswd($_POST['passwd'])) 
        $errmsg = 'You have to enter your password.';
    elseif(CheckIDExist($_POST['account'])) {
        $errmsg = 'this account has been used';
        $redirect_url = '../views/regist.php';
    }
    else {
        $id = $_POST['account'];
        $passwd = $_POST['passwd'] . $salt;
        $name = $_POST['name'];

        // insert the data to the database
        $link = MysqliConnection('Write');
        $query = 'INSERT INTO Student (ID, Password, Name) VALUES ( ?, SHA1(?), ?)';
        $stmt = mysqli_stmt_init($link);
        if (mysqli_stmt_prepare($stmt, $query))
        {
            mysqli_stmt_bind_param($stmt, "sss", $id, $passwd, $name);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        // if regitstration is ok, then goto the main page
        $redirect_url = 'http://140.113.27.34:5566/views/main.php';
        $_SESSION['id'] = $_POST['account'];
        // XXX: completion the Professor login support QQ
        $_SESSION['perm'] = 'stu'; 
    }

    $_SESSION['errmsg'] = $errmsg;
    header("Location: $redirect_url");
?>
