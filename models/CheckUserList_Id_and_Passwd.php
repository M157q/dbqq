<?php
function CheckUser_ID_and_Passwd($link, $id, $passwd){
    $stmt = mysqli_stmt_init($link);
    $adm_id = false;
    $pro_id = false;
    $stu_id = false;

    // query three tables and get user's id

    // check the Administrator table
    $query = 'SELECT ID FROM Administrator WHERE ID=? AND Password=SHA1(?)';
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "ss", $id, $passwd);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $adm_id);
        mysqli_stmt_fetch($stmt)
    }

    // check the Professor table
    $query = 'SELECT ID FROM Professor WHERE ID=? AND Password=SHA1(?)';
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "ss", $id, $passwd);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $pro_id);
        mysqli_stmt_fetch($stmt)
    }

    // check the Student table
    $query = 'SELECT ID FROM Student WHERE ID=? AND Password=SHA1(?)';
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "ss", $id, $passwd);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $stu_id);
        mysqli_stmt_fetch($stmt)
    }

    mysqli_stmt_close($stmt);

    return $adm_id ? $adm_id : 
           $pro_id ? $pro_id :
           $stu_id ? $stu_id : false;
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

?>
