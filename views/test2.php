<?php
    require_once("../models/Adm.php");
    require_once("../models/Course.php");
            GetStudentInfoTable();
            GetProfessorInfoTable();
            GetCourseInfoTable();
  /*require_once('models/MysqliOpen.php');
  $Section = 'Read';
  $link = MysqliOpen($Section);
  $data = Update_UserList($link, '0016044', '0016200', 'qwer');

  function Update_UserList($link, $oldid, $newid, $newrawpasswd)
  {
    $newpasswd = SHA1($newrawpasswd);
    $query = "UPDATE `UserList` SET `UserList_Id` = '".$newid."', `UserList_Passwd` = '".$newpasswd."' WHERE `UserList_Id` = '".$oldid."'";
    /*$query = "UPDATE `UserList` SET `UserList_Id` = "
           ."'$newid'"
           .", `UserList_Passwd` = "
           ."'$newpasswd'"
           ." WHERE `UserList_Id` = "
           ."'$oldid'"
           ;
    mysqli_query($link, $query);
    echo $query;
    mysqli_close($link);
  }*/
  echo $_SERVER['REQUEST_URI'];
?>
