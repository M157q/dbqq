<?php
/*
    require_once('../models/User.php');
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read'); // ??
    mysqli_close($link);
    
    $illegal = 'http://140.113.27.34:5566/index.php';

    if(!CheckId($_SESSION['id'])) {
       header('Location: '."$illegal");
    }
 */

    function CheckPermAndRedirect($perm, $need) {
        if ($perm !== $need) {
            RedirectByPerm($perm);
        }
    }

    function RedirectByPerm($perm) {
        //if ($perm == 'adm')
        //    header('Location: http://140.113.27.34:5566/views/adm.php');
        if ($perm == 'pro')
            header('Location: http://140.113.27.34:5566/views/pro.php');
        elseif ($perm == 'stu')
            header('Location: http://140.113.27.34:5566/views/stu.php');
        else
            header('Location: http://140.113.27.34:5566/controllers/Logout.php');
    }

?>
