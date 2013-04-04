<?php
   function DepartListGen () {
       require_once('../models/MysqliConnection.php');
       $link = MysqliConnection('Read');

       // check the Administrator table
       $query = 'SELECT Name FROM Department';
       $stmt = mysqli_stmt_init($link);
       if (mysqli_stmt_prepare($stmt, $query))
       {
           mysqli_stmt_execute($stmt);
           mysqli_stmt_bind_result($stmt, $depart_name);
           while(mysqli_stmt_fetch($stmt)) {
               echo "<option>$depart_name</option>";
           }
           mysqli_stmt_close($stmt);
       } 
   }     
?>       
         
         
         
         
         
         
         
         
         
         
