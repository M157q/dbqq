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
    
    function Update_UserList($link, $oldid, $newid, $newpasswd)
    {
        $stmt = mysqli_stmt_init($link);
        $result = false;
        $query = 'UPDATE `UserList` SET `UserList_Id` = ?, `UserList_Passwd` = SHA1(?) WHERE `UserList_Id` = ? LIMIT 1'; 
        if (mysqli_stmt_prepare($stmt, $query)) 
        {
            mysqli_stmt_bind_param($stmt, "sss", $newid, $newpasswd, $oldid);
            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        return $result;
    }
?>
