<?php
   session_start();

   require_once('../models/User.php');
   require_once('../controllers/Session.php');

   // user input error detection and error message return
   $errmsg = '';
   if(!CheckId($_POST['account']))
       $errmsg = '您的帳號格式有錯誤';
   elseif(!CheckPasswd($_POST['passwd']))
       $errmsg = '請輸入您的密碼';
   elseif(!CheckUser_ID_and_Passwd($_POST['account'], $_POST['passwd']))
       $errmsg = '登入失敗 帳號或密碼錯誤';
   else {
       $_SESSION['id'] = $_POST['account'];
   }
   
   $_SESSION['errmsg'] = $errmsg;
   RedirectByPerm($_SESSION['perm']);
?>
