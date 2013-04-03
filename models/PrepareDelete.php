<?php
function Delete_UserList($link, $id)
{
    $stmt = mysqli_stmt_init($link);
    $result = false;
    $query = "DELETE FROM `UserList` WHERE `UserList_Id` = ?"; 
    if (mysqli_stmt_prepare($stmt, $query)) 
    {
        mysqli_stmt_bind_param($stmt, "s", $id);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    return $result;
}
?>
