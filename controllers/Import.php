<?php
    require_once('../models/Department.php');    
    require_once('../models/User.php');
    require_once('../models/Course.php');
    require_once('../components/Mysqli.php');

    if ($_FILES["file"]["error"] > 0)
    {
        echo "Error: " . $_FILES["file"]["error"] . "<br>";
    }
    else
    {
        echo "Upload: " . $_FILES["file"]["name"] . "<br>";
        echo "Type: " . $_FILES["file"]["type"] . "<br>";
        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
        echo "Stored in: " . $_FILES["file"]["tmp_name"];
    }
    ///*
    $file = fopen('../../'.$_FILES["file"]["tmp_name"], "r");
    
    while(!feof($file)) {
        $i = fgets($file);
        $item = explode(",", $i);
        foreach($item as $j)
        {
            echo $j;
            echo ",";
        }
        echo "<br>";
        //$item[0] = year
        $year = $item[1];//$item[1] = semester
        if($year == "X")
            $year = 3;
        $course_name = $item[4];//$item[4] = name
        $sub = $item[5];//$item[5] = student_upper_bound
        $class_hours = $item[6] != "" ? HoursStrToNormal($item[6]) : "1NNNNNNNNNNNNNN";//$item[6] = class_hours
        $classroom = isset($item[7]) ? $item[7] : "";//$item[7] = class_room
        $credit = $item[8];//$item[8] = credit
        //$item[9] = hours
        $pro_dep = NewDepartment($item[11]);//$item[11] = pro_dep
        $pro = NewProfessor($item[10], $pro_dep);//$item[10] = pro_name
        $require = RequireStrToNum($item[12]);//$item[12] = required
        $dep = NewDepartment($item[13]);//$item[13] = class_dep
        $grade = "111111";
        $Additional_Info = "";
        ///*
        $link = MysqliConnection('Write');
        $query = 'INSERT INTO Course (Year, Name, pro_id, student_upper_bound, class_room, credit, required, department, grade, class_hours, additional_info) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = mysqli_stmt_init($link);
        if (mysqli_stmt_prepare($stmt, $query))
        {
            mysqli_stmt_bind_param($stmt, "dssdsddssss", $year, $course_name, $pro, $sub, $classroom, $credit, $require, $dep, $grade, $class_hours, $Additional_Info);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        mysqli_close($link);
        //*/
        unset($i);
        unset($item);
    }
    //*/
        //header("Location: ../views/import.php");
?>
