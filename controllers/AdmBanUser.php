<?php
session_start();
    require_once('../controllers/Session.php');
    require_once('../models/User.php');
    require_once('../components/Mysqli.php');

    // you're not a administrator, go away!
    if ($_SESSION['adm'] == false) RedirectByPerm($_SESSION['perm']);

    $action = $_POST['action'];     //admin or user
    $account = $_POST['account'];
    $errmsg = '';
    $perm = ReturnUserPerm($account);

    if (!CheckIDExist($account))
        $errmsg = '此帳號:'.$account.' 並不存在';
    else
    {
        if ($action === 'ban')
        {
            if (isBanned($account))
                $errmsg = '此帳號已被停權';
            else if (isAdmin($account))
                $errmsg = '此帳號是系統管理員，無法被停權。';
            else 
            {
                // let the account be banned
                $link = MysqliConnection('Write');

                if ($perm == 'stu')
                    $query = 'UPDATE `Student` SET ban = TRUE WHERE ID = ?';
                if ($perm == 'pro')
                    $query = 'UPDATE `Professor` SET ban = TRUE WHERE ID = ?';

                $stmt = mysqli_stmt_init($link);
                if (mysqli_stmt_prepare($stmt, $query)) {
                    mysqli_stmt_bind_param($stmt, "s", $account);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                }
                mysqli_close($link);
                $errmsg = '您已成功將該帳號停權';
            }
        }

        if ($action === 'unban')
        {
            if(!isBanned($account))
                $errmsg = '此帳號並未被停權';
            else
            {
                // let the account become unbanned
                $link = MysqliConnection('Write');

                if ($perm == 'stu')
                    $query = 'UPDATE `Student` SET ban = FALSE WHERE ID = ?';
                if ($perm == 'pro')
                    $query = 'UPDATE `Professor` SET ban = FALSE WHERE ID = ?';

                $stmt = mysqli_stmt_init($link);
                if (mysqli_stmt_prepare($stmt, $query)) {
                    mysqli_stmt_bind_param($stmt, "s", $account);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                }
                mysqli_close($link);
                $errmsg = '您已成功將該帳號解除停權';
            }
        }
    }

    $_SESSION['errmsg'] = $errmsg;
    header('Location: ../views/adm_user_admin.php');
?>
