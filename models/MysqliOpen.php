<?php
    function MysqliOpen($Section){
        require_once('MysqliConnection.php');
        $link = MysqliConnection("$Section");
        return $link;
    }
?>
