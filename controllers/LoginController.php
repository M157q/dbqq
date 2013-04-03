<?php
   session_start(); 
   

   $path1 = '../models/LoginCheck.php';
   $path2 = '../models/MysqliConnection.php';
   require_once("$path1"); 
   require_once("$path2"); 
   
   $redirect_url = 'index.php';
   $link = MysqliConnection('Read');

   //user input error detection and error message return
   $errmsg = '';
   if(!CheckId($_POST['account'])) 
       $errmsg = 'Your ID format is wrong.';
   elseif(!CheckPasswd($_POST['passwd'])) 
       $errmsg = 'You have to enter your password.';
   elseif(!CheckUserList_Id_and_Passwd($link, $_POST['account'], $_POST['passwd']))
       $errmsg = 'Login failed.';
   else
   {
       $redirect_url = 'views/main.php';
       $_SESSION['account'] = $_POST['account'];
   }

   $_SESSION['errmsg'] = $errmsg;
   header('Location: ../views/main.php');
?>
