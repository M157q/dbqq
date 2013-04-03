<?php
   session_start();
   session_unset();
   session_destroy(); 
   $redirect_url='../index.php';
   header('Location:'."$redirect_url"); 
?>
