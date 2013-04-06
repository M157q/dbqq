<?php
session_start();
    require_once('../controllers/Session.php');
    require_once('../models/User.php');

    $id = $_SESSION['id'];
    $old_passwd = $_POST['old_passwd'];
    $new_passwd = $_POST['new_passwd'];
    $confirm_passwd = $_POST['confirm_passwd'];

    // you're not a professor!!!
    if ($_SESSION['perm'] != 'pro') {
        CheckPermAndRedirect($id, 'pro');
    }
    
    require_once('../components/Mysqli.php');
    $errmsg = '';
    if (!CheckPasswd($old_passwd))
       $errmsg = 'You have to enter your old password.';
    elseif (!CheckPasswd($new_passwd))
       $errmsg = 'You have to enter your new password.';
    elseif (!CheckPasswd($confirm_passwd))
       $errmsg = 'You have to enter your password confirm.';
    elseif ($new_passwd !== $confirm_passwd)
        $errmsg = 'two password not match';
    elseif(strlen($new_passwd) > 10)
        $errmsg = '密碼最大長度為10碼';
    elseif (!CheckUser_ID_and_Passwd($id, $old_passwd)) {
        //$errmsg = CheckUserByType($id, $old_passwd, "stu");
        $errmsg = 'old password error.';
    }
    else {
        require_once('../components/utility.php');
        $new_passwd = salted($new_passwd);

        // update the data in the database
        $link = MysqliConnection('Write');
        $query = 'UPDATE Professor SET Password = SHA1(?) WHERE ID = ?';
        $stmt = mysqli_stmt_init($link);
        if (mysqli_stmt_prepare($stmt, $query)) {
            mysqli_stmt_bind_param($stmt, "ss", $new_passwd, $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        mysqli_close($link);
        $errmsg = '您已成功修改密碼';
    }

    $_SESSION['errmsg'] = $errmsg;
    CheckPermAndRedirect($_SESSION['id'], "pro");
?>
