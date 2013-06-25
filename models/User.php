<?php
function CheckId($id)
{
    $result = false;
    if( isset($id) && !is_null($id) )
    {
        if(preg_match('/^[0-9]{1,10}$/', $id) === 1) $result = true;
    }
    return $result;
}

function CheckPasswd($passwd)
{
    $result = false;
    if( isset($passwd) && !is_null($passwd) )
    {
        $result = true;
    }
    return $result;
}

function numberOfAdmin()
{
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');
    $stu = 0;
    $pro = 0;

    // check the Student table
    $query = 'SELECT COUNT(*) FROM Student WHERE AdminFlag=1';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $stu);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

    // check the Professor table
    $query = 'SELECT COUNT(*) FROM Professor WHERE AdminFlag=1';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $pro);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);

    return ($stu+$pro);
}

function isAdmin($id)
{
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');
    $stu = 0;
    $pro = 0;

    // check the Student table
    $query = 'SELECT COUNT(ID) FROM Student WHERE ID=? AND AdminFlag=1';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $stu);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

    // check the Professor table
    $query = 'SELECT COUNT(ID) FROM Professor WHERE ID=? AND AdminFlag=1';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $pro);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);

    if ($stu or $pro) return true;
    else return false;

    //if ($stu or $pro) $_SESSION['adm'] = true;
    //else $_SESSION['adm'] = false;
}

function isBanned($id)
{
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');
    $stu = 0;
    $pro = 0;

    // check the Student table
    $query = 'SELECT COUNT(ID) FROM Student WHERE ID=? AND ban=1';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $stu);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

    // check the Professor table
    $query = 'SELECT COUNT(ID) FROM Professor WHERE ID=? AND ban=1';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $pro);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);

    if ($stu or $pro) return true;
    else return false;
}

function CheckUser_ID_and_Passwd($id, $passwd) {
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');

    require_once('../components/utility.php');
    $passwd = salted($passwd);

    $result = false;
    $pro_id = false;
    $stu_id = false;

    // check the Professor table
    $query = 'SELECT COUNT(ID) FROM Professor WHERE ID=? AND Password=SHA1(?)';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "ss", $id, $passwd);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $pro_id);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

    // check the Student table
    $query = 'SELECT COUNT(ID) FROM Student WHERE ID=? AND Password=SHA1(?)';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "ss", $id, $passwd);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $stu_id);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);

    // set user's permission in session
    if ($pro_id) $_SESSION['perm'] = 'pro';
    if ($stu_id) $_SESSION['perm'] = 'stu';

    $result = ($pro_id or $stu_id);
    return $result;
}

function Select_UserList($link){
    $stmt = mysqli_stmt_init($link);
    $result = false;
    if (mysqli_stmt_prepare($stmt, 'SELECT * FROM `UserList`'))
    {
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $UserList_ID, $UserList_Password, $UserList_Name);
        while(mysqli_stmt_fetch($stmt))
        {
            $result[] = array($UserList_ID, $UserList_Password, $UserList_Name);
        }
        mysqli_stmt_close($stmt);
    }
    return $result;
}

function CheckStudentIDExist($id) {
    require_once('../components/Mysqli.php');
    $stu_result = false;
    $link = MysqliConnection('Read');

    $query = 'SELECT COUNT(ID) From Student WHERE ID=?';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $stu_result);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

    mysqli_close($link);
    return $stu_result or false;
}

function CheckProfessorIDExist($id) {
    require_once('../components/Mysqli.php');
    $pro_result = false;
    $link = MysqliConnection('Read');

    $query = 'SELECT COUNT(ID) From Professor WHERE ID=?';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $pro_result);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

    mysqli_close($link);
    return $pro_result or false;
}

//  Administrator is now presented as a flag in the table Student and Professor.
//  Not a table anymore.
//
//function CheckAdminIDExist($id) {
//    require_once('../components/Mysqli.php');
//    $pro_result = false;
//    $link = MysqliConnection('Read');
//
//    $query = 'SELECT COUNT(ID) From Administrator WHERE ID=?';
//    $stmt = mysqli_stmt_init($link);
//    if (mysqli_stmt_prepare($stmt, $query))
//    {
//        mysqli_stmt_bind_param($stmt, "s", $id);
//        mysqli_stmt_execute($stmt);
//        mysqli_stmt_bind_result($stmt, $pro_result);
//        mysqli_stmt_fetch($stmt);
//        mysqli_stmt_close($stmt);
//    }
//
//    mysqli_close($link);
//    return $pro_result or false;
//}

function CheckIDExist($id) {
    return (CheckStudentIDExist($id) or CheckProfessorIDExist($id));
}

function ReturnUserPerm($id) {
    $perm = '';
    if (CheckStudentIDExist($id)) $perm = 'stu';
    if (CheckProfessorIDExist($id)) $perm = 'pro';
    return $perm;
}

function ReturnUserName($id) {
    $perm = ReturnUserPerm($id);
    $name = '';
    if ($perm != '')
    {
        $link = MysqliConnection('Read');

        if ($perm == 'stu')
            $query = 'SELECT Name From Student WHERE ID=?';
        if ($perm == 'pro')
            $query = 'SELECT Name From Professor WHERE ID=?';

        $stmt = mysqli_stmt_init($link);
        if (mysqli_stmt_prepare($stmt, $query))
        {
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $name);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
        }
        mysqli_close($link);
    }

    return $name;
}

function CheckNumberExist($number) {
    $stu_result = false;
    $pro_result = true;
    $link = MysqliConnection('Read');

    $query = 'SELECT StudentNumber From Student WHERE StudentNumber=?';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "s", $number);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $stu_result);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

    $query = 'SELECT ProfessorNumber From Professor WHERE ProfessorNumber=?';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "s", $number);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $pro_result);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
    return ($stu_result or $pro_result);
}

function ShowStudentInfo($id) {
    require_once('../models/Department.php');
    $depart_list = GetDepartmentList();

    // get student information
    $link = MysqliConnection('Read');
    $query = 'SELECT s.ID, s.Name, s.StudentNumber, s.department, g.Name From Student s LEFT JOIN Grade g ON s.grade = g.ID WHERE s.ID=?';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $stu_id, $stu_name, $stu_num, $stu_depart, $stu_grade);
        mysqli_stmt_fetch($stmt);
        echo "<h2>基本資料</h2>";
        echo "<ul>";
        echo "<li>ID:   $stu_id  </li>";
        echo "<li>姓名: $stu_name</li>";
        echo "<li>學號: $stu_num </li>";
        if (array_key_exists($stu_depart, $depart_list)) {
            echo "<li>系所: " . $depart_list[$stu_depart] . "</li>";
        }
        else {
            echo "<li>系所資料好像怪怪的 :~</li>";
        }
        echo "<li>年級: $stu_grade</li>";
        echo "<li>總修課學分: " . creditSum($stu_id) . "</li>";
        echo "<li>總修課時數: " . courseHourCount($stu_id) . "</li>";
        echo "</ul>";
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}

function ShowProfessorInfo($id) {
    require_once('../models/Department.php');
    $depart_list = GetDepartmentList();

    // get professor information
    $link = MysqliConnection('Read');
    $query = 'SELECT ID, Name, ProfessorNumber, department From Professor WHERE ID=?';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $pro_id, $pro_name, $pro_num, $pro_depart);
        mysqli_stmt_fetch($stmt);
        echo "<h2>基本資料</h2>";
        echo "<ul>";
        echo "<li>ID:   $pro_id  </li>";
        echo "<li>姓名: $pro_name</li>";
        echo "<li>教職員編號: $pro_num </li>";
        if (array_key_exists($pro_depart, $depart_list)) {
            echo "<li>系所: " . $depart_list[$pro_depart] . "</li>";
        }
        else {
            echo "<li>系所資料好像怪怪的 :~</li>";
        }
        echo "</ul>";
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}

function ShowAdminArea()
{
    echo '<div class="well">';
    echo "<h2>管理員專區</h2>";
    echo "<img src=\"http://emos.plurk.com/f02b24f881e56d1d67b9b0e1e9f188a4_w48_h48.gif\">";
    echo "<p><ul>";
    echo "<li> <a href=\"../views/adm_user_admin.php\">使用者管理</a> </li>";
    echo "<li> <a href=\"../views/adm_course_admin.php\">課程管理</a> </li>";
    echo "</ul></p>";
    echo '</div>';
}

function creditSum($id) {
    require_once('../components/Mysqli.php');

    $link = MysqliConnection('Read');
    $query = 'SELECT SUM( credit )
        FROM  `Course`
        WHERE ID
        IN (
            SELECT CourseID
            FROM  `Course_taken`
            WHERE StudentID =?
        )';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $sum);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
    if ($sum)
        return $sum;
    else
        return 0;
}

function courseHourCount ($id){
    require_once('../components/Mysqli.php');

    $link = MysqliConnection('Read');
    $query = ' SELECT class_hours
        FROM  `Course`
        WHERE ID
        IN (

            SELECT CourseID
            FROM  `Course_taken`
            WHERE StudentID =?
        )';

    $chr = "";

    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $hr);
        while (mysqli_stmt_fetch($stmt)) {
            $chr .= $hr;
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
    return (substr_count($chr, 'Y'));
}

function showWarning()
{
    if (isset($_SESSION['errmsg']) && $_SESSION['errmsg'] !== '')
    {
        echo '<div class="alert alert-error">提醒訊息：' . $_SESSION['errmsg'] . '</div>';
        $_SESSION['errmsg'] = '';
    }
    if (isset($_SESSION['id']) && isBanned($_SESSION['id'])) echo '<div class="alert alert-block">您正在被停權中</div>';
}

function showLoginMessage()
{
    echo '<h2>' . $_SESSION['id'] . ' 歡迎登入</h2>' ;
}

function proGetCourseInfo ($pro_id, $course_id, $course_year) {
    require_once('../components/Mysqli.php');
    require_once('../models/Department.php');

    $link = MysqliConnection('Read');

    $course_list = array();
    $depart_list = GetDepartmentList();

    // get course data
    //$query = 'SELECT c.Name, c.student_upper_bound, c.class_room, c.credit,
    //          c.department, g.Name, c.required, c.class_hours, c.Additional_Info
    //          FROM Course c LEFT JOIN Grade g ON c.grade = g.ID
    //          Where c.pro_id = ? AND c.ID = ? AND c.Year = ?';
    $query = 'SELECT Name, student_upper_bound, class_room, credit,
              department, grade, required, class_hours, Additional_Info
              FROM Course
              WHERE pro_id = ? AND ID = ? AND Year = ?';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "sss", $pro_id, $course_id, $course_year);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $name, $sub, $classroom, $credit, $dep, $grade, $req, $class_hours, $add_info);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
    return array($name, $sub, $classroom, $credit, $dep, $grade, $req, $class_hours, $add_info);
}

function GetDeleteWarning ($stu_id) {
    require_once('../components/Mysqli.php');


    // delete for different reasones
    $deleted1 = array();
    $deleted2 = array();
    $deleted3 = array();
    $deleted4 = array();

    $link = MysqliConnection('Read');
    // fetch the changed course

    $query = 'SELECT change_type, info FROM Course_change WHERE stu_id=?';

    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "s", $stu_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $type, $info);
        while ( mysqli_stmt_fetch($stmt) ) {
            if      ($type == "1") { array_push($deleted1, $info); }
            else if ($type == "2") { array_push($deleted2, $info); }
            else if ($type == "3") { array_push($deleted3, $info); }
            else if ($type == "4") { array_push($deleted4, $info); }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);


    // output
    if (count($deleted1) > 0 || count($deleted2) > 0 ||
        count($deleted3) > 0 || count($deleted4) > 0) {
        echo "<div class=\"alert alert-error\">";
        if (count($deleted1) > 0) {
            echo "<h4>您的以下課程因課程衝堂而刪除於修課名單:</h4><ul>";
            foreach ($deleted1 as $i) { echo "<li>$i</li>"; }
            echo "</ul>";
        }
        if (count($deleted2) > 0) {
            echo "<br>";
            echo "<h4>您的以下課程因修課身份資格不服而刪除於修課名單:</h4><ul>";
            foreach ($deleted2 as $i) { echo "<li>$i</li>"; }
            echo "</ul>";
        }
        if (count($deleted3) > 0) {
            echo "<br>";
            echo "<h4>您的以下課程已被踢除於修課名單內:</h4><ul>";
            foreach ($deleted3 as $i) { echo "<li>$i</li>"; }
            echo "</ul>";
        }
        if (count($deleted4) > 0) {
            echo "<br>";
            echo "<h4>您的以下課程已被刪除:</h4><ul>";
            foreach ($deleted4 as $i) { echo "<li>$i</li>"; }
            echo "</ul>";
        }
        echo "</div>";


        // delete the record in Course_change
        $link = MysqliConnection('Write');
        $query = 'DELETE FROM Course_change WHERE stu_id=?';
        $stmt = mysqli_stmt_init($link);
        if (mysqli_stmt_prepare($stmt, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $stu_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        mysqli_close($link);
    }
}

function GetGradeByStuID ($stu_id) {
    require_once('../components/Mysqli.php');

    $link = MysqliConnection('Read');

    // get student's grade
    $query = 'SELECT grade FROM Student WHERE ID=?';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "s", $stu_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $grade);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
    return $grade;
}

function GetDepartByStuID ($stu_id) {
    require_once('../components/Mysqli.php');

    $link = MysqliConnection('Read');

    // get student's department
    $query = 'SELECT department FROM Student WHERE ID=?';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "s", $stu_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $depart);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
    return $depart;
}

function NewProfessor($pro, $dep) {

    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');
    $exist = 0;
    $id = 0;

    $query = 'SELECT id FROM Professor WHERE name=?';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "s", $pro);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $result);
        if(mysqli_stmt_fetch($stmt)) {
            $exist = 1;
            $id = $result;
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);

    if($exist == 0)
    {
        $link = MysqliConnection('Write');
        $query = 'INSERT INTO Professor(id,name,department,AdminFlag,ban) VALUES (?,?,?,?,?)';
        $stmt = mysqli_stmt_init($link);
        if (mysqli_stmt_prepare($stmt, $query))
        {
            mysqli_stmt_bind_param($stmt, "sssss", $pro, $pro, $dep, $id, $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        mysqli_close($link);

        $link = MysqliConnection('Read');
        $query = 'SELECT id FROM Professor WHERE name=?';
        $stmt = mysqli_stmt_init($link);
        if (mysqli_stmt_prepare($stmt, $query))
        {
            mysqli_stmt_bind_param($stmt, "s", $pro);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $result);
            if(mysqli_stmt_fetch($stmt)) {
                $exist = 1;
                $id = $result;
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($link);
    }

    return $id;

}

?>
