<?php
    function CheckPermAndRedirect($perm, $need) {
        if ($perm !== $need) {
            RedirectByPerm($perm);
        }
    }

    function RedirectByPerm($perm) {
        if ($perm == 'pro')
            header('Location: http://dbqq.nctucs.net:5566/views/pro.php');
        elseif ($perm == 'stu')
            header('Location: http://dbqq.nctucs.net:5566/views/stu.php');
        elseif ($perm == 'illegal')
            header('Location: http://ddqq.nctucs.net:5566/controllers/Logout.php');
        else
            header('Location: http://dbqq.nctucs.net:5566/index.php');
    }

?>
