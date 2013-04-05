<?php
    require_once('../models/User.php');
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read'); // ??
    mysqli_close($link);
    
    $illegal = 'http://140.113.27.34:5566/index.php';

    if(!CheckId($_SESSION['id'])) {
       header('Location: '."$illegal");
    }

    function CheckPermAndRedirect($perm, $need) {
        if ($perm != $need) {
            if ($_SESSION['perm'] == 'adm')
                header('Location: '."../views/adm.php");
            elseif ($_SESSION['perm'] == 'pro')
                header('Location: '."../views/pro.php");
            elseif ($_SESSION['perm'] == 'stu')
                header('Location: '."../views/stu.php");
            else {
                header('Location: '."../controllers/Logout.php");
            }
        }
    }
?>
