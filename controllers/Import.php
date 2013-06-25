<?php

    $line = explode("\r\n", $_POST['text']);
    
    foreach($line as $i) {
        $item = explode(",", $i);
        //$j[0] = year
        //$j[1] = semester
        //$j[4] = name
        //$j[5] = student_upper_bound
        //$j[6] = class_hours
        //$j[7] = class_room
        //$j[8] = credit
        //$j[9] = hours
        //$j[10] = pro_name
        //$j[11] = pro_dep
        //$j[12] = required
        //$j[13] = class_dep
    }
        //header("Location: ../views/import.php");
?>
