<?php
function Insert_UserList($link, $id, $passwd)
{
    $stmt = mysqli_stmt_init($link);
    $result = false;
    $query = 'INSERT INTO `UserList`(`UserList_Id`,`UserList_Passwd`,`UserType_Id`) VALUES (?,SHA1(?),1)';
    if (mysqli_stmt_prepare($stmt, $query)) 
    {
        mysqli_stmt_bind_param($stmt, "ss", $id, $passwd);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    return $result;
}
?>
