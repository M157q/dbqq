<?php
   session_start();

   require_once('../models/User.php');
   require_once('../components/Mysqli.php');

   $redirect_url = 'http://140.113.27.34:5566/index.php';
   $link = MysqliConnection('Read');

   // user input error detection and error message return
   $errmsg = '';
   if(!CheckId($_POST['account']))
       $errmsg = 'Your ID format is wrong.';
   elseif(!CheckPasswd($_POST['passwd']))
       $errmsg = 'You have to enter your password.';
   elseif(!CheckUser_ID_and_Passwd($link, $_POST['account'], $_POST['passwd'])) {
       $errmsg = 'Login failed.';
   }
   else {
       $redirect_url = 'http://140.113.27.34:5566/views/main.php';
       $_SESSION['id'] = $_POST['account'];
   }

   mysqli_close($link);

   $_SESSION['errmsg'] = $errmsg;
   header("Location: $redirect_url");
?>
