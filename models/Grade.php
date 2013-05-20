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
//for example, 000011 = 大一大二
function GradeToString ($grade) {
    $result = "";
    $one = substr($grade,0,1);
    $two = substr($grade,1,1);
    $three = substr($grade,2,1);
    $four = substr($grade,3,1);
    $five = substr($grade,4,1);
    $six = substr($grade,5,1);
    
    if($one == "1")
        $result .= "大一";
    if($two == "1")
        $result .= "大二";
    if($three == "1")
        $result .= "大三";
    if($four == "1")
        $result .= "大四";
    if($five == "1")
        $result .= "研一";
    if($six == "1")
        $result .= "研二";

    return $result;

}

//convert POST data user input to DB data
//for example, array:{1,2,4} = 001011
function GradeToBinary ($grade) {
    $result = "";
    $reverse = "";
    $index = 1;

    foreach($grade as $i) {
        while($index != $i) {
            $reverse .= "0";
            $index++;
        }
        $reverse .= "1";
    }

    $index = 5;
    while($index >= 0) {
        $temp = substr($reverse,$index,1);
        $result .= $temp;
        $index--;
    }
      
    return $result;
}

?>

