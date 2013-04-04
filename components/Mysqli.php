<?php
    function MysqliConnection($connection_type){
        $config_set = parse_ini_file("../include/config.ini", true);
        $config = $config_set[$connection_type];
        extract($config);        

        $link = mysqli_connect("$dbserver", "$username", "$password", "$database");
            /* check connection */
            if (mysqli_connect_errno()) {
                $link = false;
            }
        return $link;
    }

    function MysqliOpen($Section){
        require_once('MysqliConnection.php');
        $link = MysqliConnection("$Section");
        return $link;
    }
?>
