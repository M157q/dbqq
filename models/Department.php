<?php
function DepartListGen () {
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');

    // get IDs and names from department
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
    mysqli_close($link);
}

function GetDepartmentList() {
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');

    // get department list
    $query = 'SELECT Name FROM Department';
    $stmt = mysqli_stmt_init($link);
    $depart_list = array();
    $depart_list_index = 1;
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $depart);
        while (mysqli_stmt_fetch($stmt)) {
            $depart_list[$depart_list_index++] = $depart;
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
    return $depart_list;
}
?>

