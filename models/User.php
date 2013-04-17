<?php
function CheckId($id)
{
    $result = false;
    if( isset($id) && !is_null($id) )
    {
        if(preg_match('/^[0-9]{1,10}$/', $id) === 1) $result = true;
        if($id == 'r00t') $result = true;
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

function CheckUser_ID_and_Passwd($id, $passwd) {
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');

    require_once('../components/utility.php');
    $passwd = salted($passwd);

    $result = false;
    $adm_id = false;
    $pro_id = false;
    $stu_id = false;

    // query three tables and get user's id

    // check the Administrator table
    $query = 'SELECT ID FROM Administrator WHERE ID=? AND Password=SHA1(?)';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "ss", $id, $passwd);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $adm_id);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

    // check the Professor table
    $query = 'SELECT ID FROM Professor WHERE ID=? AND Password=SHA1(?)';
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
    $query = 'SELECT ID FROM Student WHERE ID=? AND Password=SHA1(?)';
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
    if ($adm_id)   $_SESSION['perm'] = 'adm';
    if ($pro_id)   $_SESSION['perm'] = 'pro';
    if ($stu_id)   $_SESSION['perm'] = 'stu';

    $result = ($adm_id or $pro_id or $stu_id);
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

function CheckAdminIDExist($id) {
    require_once('../components/Mysqli.php');
    $pro_result = false;
    $link = MysqliConnection('Read');

    $query = 'SELECT COUNT(ID) From Administrator WHERE ID=?';
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

function CheckIDExist($id) {
    return (CheckStudentIDExist($id) or CheckProfessorIDExist($id));
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
    $query = 'SELECT ID, Name, StudentNumber, department, grade From Student WHERE ID=?';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $stu_id, $stu_name, $stu_num, $stu_depart, $stu_grade);
        mysqli_stmt_fetch($stmt);
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
        echo "</ul>";
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}

function ShowProfessorInfo($id) {
    require_once('../models/Department.php');
    $depart_list = GetDepartmentList();

    // get student information
    $link = MysqliConnection('Read');
    $query = 'SELECT ID, Name, ProfessorNumber, department From Professor WHERE ID=?';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $pro_id, $pro_name, $pro_num, $pro_depart);
        mysqli_stmt_fetch($stmt);
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
?>
