<?php
session_start();
    require_once('../controllers/Session.php');
    require_once('../models/User.php');

    $id = $_POST['account'];

    // you're not a administrator, go away!
    if ($_SESSION['adm'] == false) RedirectByPerm($_SESSION['perm']);

    //if ($_SESSION['perm'] !== 'adm') {
    //    CheckPermAndRedirect($_SESSION['perm'], 'adm');
    //}

    require_once('../components/Mysqli.php');
    $errmsg = '';

    if (CheckStudentIDExist($id))
        $perm = 'stu';
    elseif(CheckProfessorIDExist($id))
        $perm = 'pro';
    else 
        $errmsg = "$id not found.";

    if (isset($perm) and !empty($perm))
    {
        require_once('../components/utility.php');
        $new_passwd = salted($new_passwd);

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
    }

    $_SESSION['errmsg'] = $errmsg;
    //RedirectByPerm($_SESSION['perm']);
    header('Location: ../views/adm_user_admin.php');
?>
