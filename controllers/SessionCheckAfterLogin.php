<?php
    $path1 = '../models/LoginCheck.php';
    $path2 = '../models/MysqliConnection.php';
    require_once("$path1");
    require_once("$path2");
    $link = MysqliConnection('Read');
    
    $illegal = 'http://140.113.27.34:5566/index.php';

    if(!CheckId($_SESSION['id'])) {
       header('Location: '."$illegal");
    }
?>
