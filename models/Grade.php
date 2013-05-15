<?php
function GradeListGen () {
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');

    // get IDs and names from department
    $query = 'SELECT ID, Name FROM Grade';
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
    mysqli_close($link);
}
?>
