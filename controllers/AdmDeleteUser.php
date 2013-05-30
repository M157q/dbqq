<?php
    session_start();
    require_once('../controllers/Session.php');
    require_once('../models/User.php');
    require_once('../components/Mysqli.php');

    // you're not a administrator, go away!
    if ($_SESSION['adm'] == false) RedirectByPerm($_SESSION['perm']);

    $id = $_POST['account'];
    $errmsg = '';

    if (CheckStudentIDExist($id))
        $perm = 'stu';
    elseif(CheckProfessorIDExist($id))
        $perm = 'pro';
    else 
        $errmsg = "此帳號 $id 並不存在";

    if( (isAdmin($id)) && (numberOfAdmin() == 1) )
        $errmsg = '將此帳號刪除將造成系統沒有系統管理員，故此動作無效。';
    else
    {
        if (isset($perm) and !empty($perm))
        {
            // update the data in the database
            $link = MysqliConnection('Write');

            if ($perm == 'stu')
                $query = 'DELETE FROM Student WHERE ID = ?';
            elseif ($perm == 'pro')
                $query = 'DELETE FROM Professor WHERE ID = ?';
            else {
                $errmsg = '權限有誤';
                $_SESSION['errmsg'] = $errmsg;
                CheckPermAndRedirect($_SESSION['perm'], "adm");
            }

            $stmt = mysqli_stmt_init($link);
            if (mysqli_stmt_prepare($stmt, $query)) {
                mysqli_stmt_bind_param($stmt, "s", $id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
            mysqli_close($link);
            $errmsg = '您已成功刪除該使用者';

            // delete records in Course_change
            if ($perm = 'stu') {
                $link = MysqliConnection('Write');
                $query = 'DELETE FROM Course_change WHERE stu_id = ?';
                $stmt = mysqli_stmt_init($link);
                if (mysqli_stmt_prepare($stmt, $query)) {
                    mysqli_stmt_bind_param($stmt, "s", $id);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                }
                mysqli_close($link);
            }
        }
    }

    $_SESSION['errmsg'] = $errmsg;
    //RedirectByPerm($_SESSION['perm']);
    header('Location: ../views/adm_user_admin.php');
?>
