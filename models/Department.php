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

function NewDepartment($dep) {
    require_once('../components/Mysqli.php');
    $link = MysqliConnection('Read');
    $exist = 0;
    $id = 0;

    $query = 'SELECT id FROM Department WHERE name = ?';
    $stmt = mysqli_stmt_init($link);
    if(mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "s", $dep);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $result);
        if (mysqli_stmt_fetch($stmt)) {
            $exist = 1;
            $id = $result;
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
    
    if($exist == 0)
    {
        $link = MysqliConnection('Write');
        
        $query = 'INSERT INTO Department(name) VALUES (?)';
        $stmt = mysqli_stmt_init($link);
        if(mysqli_stmt_prepare($stmt, $query))
        {
            mysqli_stmt_bind_param($stmt, "s", $dep);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        mysqli_close($link);

        $link = MysqliConnection('Read');

        $query = 'SELECT id FROM Department WHERE name = ?';
        $stmt = mysqli_stmt_init($link);
        if(mysqli_stmt_prepare($stmt, $query))
        {
            mysqli_stmt_bind_param($stmt, "s", $dep);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $result);
            if (mysqli_stmt_fetch($stmt)) {
                $exist = 1;
                $id = $result;
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($link);
    }
    
    return $id;
}

function GetDepById($id){
    $query = 'SELECT name FROM Department WHERE id = ?';
    $link = MysqliConnection('Read');
    $stmt = mysqli_stmt_init($link);
    $name = "";
    if(mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $result);
        if (!mysqli_stmt_fetch($stmt)) {
            $name = false;
        }
        else
            $name = $result;
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);

    return $name;
}

?>

