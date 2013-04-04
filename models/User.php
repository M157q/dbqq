<?php

function CheckId($id)
{
    $result = false;
    if( !is_null($id) && !empty($id) )
    {
        if(preg_match("/^[0-9]{1,10}$/", $id) === 1) $result = true;
        if($id == "r00t") $result = true;
    }
    return $result;
}

function CheckPasswd($passwd)
{
    $result = false;
    if( !is_null($passwd) && !empty($passwd) )
    {
        $result = true;
    }
    return $result;
}

function CheckUser_ID_and_Passwd($link, $id, $passwd) {
    require_once("../include/salt.php");
    $passwd = $passwd . $salt;

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

    // set user's permission in session
    if ($adm_id)   $_SESSION['perm'] = 'adm';
    if ($pro_id)   $_SESSION['perm'] = 'pro';
    if ($stu_id)   $_SESSION['perm'] = 'stu';
    return $adm_id || $pro_id || $stu_id;
    
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

function CheckIDExist($id) {
    $stu_result = false;
    $pro_result = true;
    $link = MysqliConnection('Read');

    $query = 'SELECT ID From Student WHERE ID=?';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $stu_result);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

    $query = 'SELECT ID From Professor WHERE ID=?';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $pro_result);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
    return ($stu_result or $pro_result);
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
    return ($stu_result or $pro_result);
}
?>
