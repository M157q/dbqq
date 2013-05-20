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
        mysqli_stmt_bind_result($stmt, $grade_id, $grade_name);
        while(mysqli_stmt_fetch($stmt)) {
            echo '<option value="'.$grade_id.'"> '.$grade_name.' </option>';
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}

//convert the result from DB to readable string
//for example, 6 = 大一大二
function GradeToString ($grade) {
    $result = "";
    
    if($grade % 2 == 0)
        $result .= "大一";
    if($grade % 3 == 0)
        $result .= "大二";
    if($grade % 5 == 0)
        $result .= "大三";
    if($grade % 7 == 0)
        $result .= "大四";
    if($grade % 11 == 0)
        $result .= "研一";
    if($grade % 13 == 0)
        $result .= "研二";

    return $result;

}

//convert POST data user input to DB data
//for example, array:{1,2,4} = 2*3*7 = 42
function GradeToPrimeProduct ($grade) {
    $result = 1;

    foreach($grade as $i)
    {
        if($i == "1")
            $result *= 2;
        else if($i == "2")
            $result *= 3;
        else if($i == "3")
            $result *= 5;
        else if($i == "4")
            $result *= 7;
        else if($i == "5")
            $result *= 11;
        else if($i == "6")
            $result *= 13;
    }
      
    return $result;
}

?>

