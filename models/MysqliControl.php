<?php
    function Insert_UserList($link, $id, $passwd){
        /* Select queries return a resultset */
        $query="INSERT INTO `UserList`(`UserList_Id`,`UserList_Passwd`,`UserType_Id`) VALUES ('".$id."',SHA1('".$passwd."'),1)";
        if(mysqli_query($link, $query)){
            echo 'insert succeeded. <br />';
        } else echo'insert failed. <br />';
    }

    #function Select_UserList($link){
    #    /* Select queries return a resultset */
    #    $query='SELECT * FROM `UserList`';
    #    $data = array();
    #    if ($result = mysqli_query($link, $query)) {
    #        while($row = mysqli_fetch_assoc($result)){
    #            $data[] = $row;
    #        }
    #        mysqli_free_result($result);
    #    }
    #    return $data;
    #}

    function Update_UserList($link, $oldid, $newid, $newrawpasswd){
        $newpasswd = SHA1($newrawpasswd);
        $query = "UPDATE `UserList` SET `UserList_Id` = '".$newid."', `UserList_Passwd` = '".$newpasswd."' WHERE `UserList    _Id` = '".$oldid."'"; 
        if (mysqli_query($link, $query)){
            echo 'update succeed. <br />';
        } else echo 'update failed. <br />';
    }

    function Delete_UserList($link, $id) {
        $query = "DELETE FROM `UserList` WHERE `UserList_Id` = '".$id."'"; 
        if (mysqli_query($link, $query)){
            echo 'delete succeed.<br />';
        } else echo 'delete failed.<br />';
    }
?>
