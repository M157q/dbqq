<?php
    session_start();
    require_once('../models/Grade.php');
    require_once('../models/User.php');
    require_once('../models/Course.php');
    require_once('../components/Mysqli.php');
    require_once('../controllers/Session.php');

    if (isBanned($_SESSION['id'])) RedirectByPerm($_SESSION['perm']);
    CheckPermAndRedirect($_SESSION['perm'], 'pro');

    // redirect to the home page by default
    $redirect_url = '../views/pro_add_course.php';
   
    // user input error detection and error message return
    $errmsg = '';
    
    if($_POST['student_upper_bound'] < 1)
        $errmsg = '人數上限必須大於零';
    //elseif(!isset($_POST['grade']))
    //    $errmsg = '開課年級未填';
    elseif($_POST['credit'] < 0)
        $errmsg = '學分數不能為負值';
    elseif($_POST['day1'] == $_POST['day2'])
        $errmsg = '時段一與時段二不能在同一天';
    elseif(!isset($_POST['d1']))
        $errmsg = '時段一之時間未填';
    elseif($_POST['day2'] != "0" && !isset($_POST['d2']))
        $errmsg = '時段二之時間未填';
    else {
        // push class hour data into a string
        $class_hours = $_POST['day1'];
        $d1 = $_POST['d1'];
        $day1 = array("0"=>"N", "1"=>"N", "2"=>"N", "3"=>"N", "4"=>"N", "5"=>"N", "6"=>"N", "7"=>"N", "8"=>"N", "9"=>"N", "10"=>"N", "11"=>"N", "12"=>"N", "13"=>"N");
        foreach($d1 as $i => $x) $day1[$x] = "Y";
        $daystr = implode($day1);
        $class_hours .= $daystr;
        if($_POST['day2'] != "0") {
            $class_hours .= $_POST['day2'];
            $d2 = $_POST['d2'];
            $day2 = array("0"=>"N", "1"=>"N", "2"=>"N", "3"=>"N", "4"=>"N", "5"=>"N", "6"=>"N", "7"=>"N", "8"=>"N", "9"=>"N", "10"=>"N", "11"=>"N", "12"=>"N", "13"=>"N");
            foreach($d2 as $i => $x) $day2[$x] = "Y";
            $daystr = implode($day2);
            $class_hours .= $daystr;
        }

        if(CheckProIfCollision($_SESSION['id'], $class_hours))
            $errmsg = '此課程時段與其他課程衝堂';
        else {
            $name = $_POST['name'];
            $class_room = $_POST['class_room'];
            $student_upper_bound = $_POST['student_upper_bound'];
            $required = $_POST['required'];
            $credit = $_POST['credit'];
            $year = $_POST['year'];
            $department = $_POST['department'];
            if (isset($_POST['grade'])) $grade = GradeToBinary($_POST['grade']);
            else $grade = '111111';
            $additional_info = $_POST['additional_info'];

            // insert the data to the database
            $link = MysqliConnection('Write');
            $query = 'INSERT INTO Course (Year, Name, pro_id, student_upper_bound, class_room, credit, required, department, grade, class_hours, additional_info) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $stmt = mysqli_stmt_init($link);
            if (mysqli_stmt_prepare($stmt, $query))
            {
                mysqli_stmt_bind_param($stmt, "dssdsddssss", $year, $name, $_SESSION['id'], $student_upper_bound, $class_room, $credit, $required, $department, $grade, $class_hours, $additional_info);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
            mysqli_close($link);
            // if adding course is ok, then goto the professor page
            $redirect_url = '../views/pro.php';
            $errmsg = '您已成功新增課程!';
        }
    }

    $_SESSION['errmsg'] = $errmsg;
    header("Location: $redirect_url");
?>

