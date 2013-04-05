<?php
    require_once('../models/User.php');
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read'); // ??
    mysqli_close($link);
    
    $illegal = 'http://140.113.27.34:5566/index.php';

    if(!CheckId($_SESSION['id'])) {
       header('Location: '."$illegal");
    }
?>
