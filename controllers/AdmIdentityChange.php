<?php
    session_start();
    // you're not a administrator, go away!
    if ($_SESSION['adm'] == false) RedirectByPerm($_SESSION['perm']);

    require_once('../controllers/Session.php');
    require_once('../models/User.php');
    require_once('../components/Mysqli.php');

    $action = $_POST['action'];     //admin or user
    $account = $_POST['account'];
    $errmsg = '';

    $perm = ReturnUserPerm($account);

    if (!CheckIDExist($account))
        $errmsg = '此帳號:'.$account.' 並不存在';
    else
    {
        if ($action === 'admin')
        {
            if(isAdmin($account))
                $errmsg = '此帳號已是系統管理員';
            else 
            {
                // let the account become admin
                $link = MysqliConnection('Write');

                if ($perm == 'stu')
                    $query = 'UPDATE `Student` SET AdminFlag = TRUE WHERE ID = ?';
                if ($perm == 'pro')
                    $query = 'UPDATE `Professor` SET AdminFlag = TRUE WHERE ID = ?';

                $stmt = mysqli_stmt_init($link);
                if (mysqli_stmt_prepare($stmt, $query)) {
                    mysqli_stmt_bind_param($stmt, "s", $account);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                }
                mysqli_close($link);
                $errmsg = '您已成功將該帳號變更為系統管理者';
            }
        }

        if ($action === 'user')
        {
            if(!isAdmin($account))
                $errmsg = '此帳號已是一般使用者';
            elseif(numberOfAdmin() == 1)
                $errmsg = '將此帳號變更為一般使用者將造成系統沒有系統管理員，故此動作無效。';
            else
            {
                // let the account become admin
                $link = MysqliConnection('Write');

                if ($perm == 'stu')
                    $query = 'UPDATE `Student` SET AdminFlag = FALSE WHERE ID = ?';
                if ($perm == 'pro')
                    $query = 'UPDATE `Professor` SET AdminFlag = FALSE WHERE ID = ?';

                $stmt = mysqli_stmt_init($link);
                if (mysqli_stmt_prepare($stmt, $query)) {
                    mysqli_stmt_bind_param($stmt, "s", $account);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                }
                mysqli_close($link);
                $errmsg = '您已成功將該帳號變更為一般使用者';
            }
        }
    }

    $_SESSION['errmsg'] = $errmsg;
    //RedirectByPerm($_SESSION['perm']);
    header('Location: http://140.113.27.34:5566/views/adm_user_admin.php')
?>
