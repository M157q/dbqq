<?php
   function DepartListGen () {
       require_once('../components/Mysqli.php');
       $link = MysqliConnection('Read');

       // check the Administrator table
       $query = 'SELECT ID, Name FROM Department';
       $stmt = mysqli_stmt_init($link);
       if (mysqli_stmt_prepare($stmt, $query))
       {
           mysqli_stmt_execute($stmt);
           mysqli_stmt_bind_result($stmt, $depart_id, $depart_name);
           while(mysqli_stmt_fetch($stmt)) {
               echo '<option value="'.$depart_id.'"> '.$depart_name.' </option>';
           }
           mysqli_stmt_close($stmt);
       } 
   }     
?>       
         
