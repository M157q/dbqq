<?php
    session_start();
    require_once('../controllers/Session.php');
    require_once('../models/User.php');
    require_once('../components/Mysqli.php');
    if ($_SESSION['ban']) RedirectByPerm($_SESSION['perm']);
    if ($_SESSION['perm'] != 'pro') RedirectByPerm($_SESSION['perm']);

    $id = $_SESSION['id'];
    $old_passwd = $_POST['old_passwd'];
    $new_passwd = $_POST['new_passwd'];
    $confirm_passwd = $_POST['confirm_passwd'];
    $errmsg = '';
    
    if (!CheckPasswd($old_passwd))
       $errmsg = '請輸入舊密碼';
    elseif (!CheckPasswd($new_passwd))
       $errmsg = '請輸入新密碼';
    elseif (!CheckPasswd($confirm_passwd))
       $errmsg = '請輸入確認密碼';
    elseif (!CheckUser_ID_and_Passwd($id, $old_passwd))
        $errmsg = '舊密碼輸入錯誤';
    elseif(strlen($new_passwd) > 10)
        $errmsg = '密碼最大長度為10碼';
    elseif ($new_passwd !== $confirm_passwd)
        $errmsg = '新密碼與確認密碼不符';
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
    RedirectByPerm($_SESSION['perm']);
?>
