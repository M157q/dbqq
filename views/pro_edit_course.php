<?php
    session_start();    
    require_once('../models/Department.php');
    require_once('../models/User.php');
    require_once('../components/Mysqli.php');
    require_once('../controllers/Session.php');
    if ($_SESSION['ban']) RedirectByPerm($_SESSION['perm']);
    if ($_SESSION['perm'] != 'pro') RedirectByPerm($_SESSION['perm']);

    $link = MysqliConnection('Read');

    $course_list = array();
    $depart_list = GetDepartmentList();
    
    // get course data
    $query = 'SELECT Name, student_upper_bound, class_room, credit, department, grade, required, class_hours, Additional_Info FROM Course Where pro_id=? AND id=? AND year=?';
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "ssd", $_SESSION['id'], $_POST['id'], $_POST['year']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $name, $sub, $classroom, $credit, $dep, $grade, $req, $class_hours, $add_info);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($link);

    //recover the data pro input into form  
    $req0 = $req=="0" ? "SELECTED" : "";
    $req1 = $req=="1" ? "SELECTED" : "";
    
    $grade1 = $grade=="大一" ? "SELECTED" : "";
    $grade2 = $grade=="大二" ? "SELECTED" : "";
    $grade3 = $grade=="大三" ? "SELECTED" : "";
    $grade4 = $grade=="大四" ? "SELECTED" : "";
    $grade5 = $grade=="碩一" ? "SELECTED" : "";
    $grade6 = $grade=="碩二" ? "SELECTED" : "";
  
    $day1 = substr($class_hours, 0, 9);
    $day2 = substr($class_hours, 9, 9);
    
    $mon1 = substr($day1, 0, 1)=="1" ? "SELECTED" : "";
    $tue1 = substr($day1, 0, 1)=="2" ? "SELECTED" : "";
    $wed1 = substr($day1, 0, 1)=="3" ? "SELECTED" : "";
    $thu1 = substr($day1, 0, 1)=="4" ? "SELECTED" : "";
    $fri1 = substr($day1, 0, 1)=="5" ? "SELECTED" : "";
    $sat1 = substr($day1, 0, 1)=="6" ? "SELECTED" : "";
    $sun1 = substr($day1, 0, 1)=="7" ? "SELECTED" : "";

    if(isset($day2)) {
    	$mon2 = substr($day2, 0, 1)=="1" ? "SELECTED" : "";
    	$tue2 = substr($day2, 0, 1)=="2" ? "SELECTED" : "";
    	$wed2 = substr($day2, 0, 1)=="3" ? "SELECTED" : "";
    	$thu2 = substr($day2, 0, 1)=="4" ? "SELECTED" : "";
    	$fri2 = substr($day2, 0, 1)=="5" ? "SELECTED" : "";
    	$sat2 = substr($day2, 0, 1)=="6" ? "SELECTED" : "";
    	$sun2 = substr($day2, 0, 1)=="7" ? "SELECTED" : "";
	}

    $A1 = substr($day1, 1, 1)=="Y" ? "CHECKED" : "";
    $B1 = substr($day1, 2, 1)=="Y" ? "CHECKED" : "";
    $C1 = substr($day1, 3, 1)=="Y" ? "CHECKED" : "";
    $D1 = substr($day1, 4, 1)=="Y" ? "CHECKED" : "";
    $E1 = substr($day1, 5, 1)=="Y" ? "CHECKED" : "";
    $F1 = substr($day1, 6, 1)=="Y" ? "CHECKED" : "";
    $G1 = substr($day1, 7, 1)=="Y" ? "CHECKED" : "";
    $H1 = substr($day1, 8, 1)=="Y" ? "CHECKED" : "";

    if(isset($day2)) {
	$A2 = substr($day2, 1, 1)=="Y" ? "CHECKED" : "";
    	$B2 = substr($day2, 2, 1)=="Y" ? "CHECKED" : "";
    	$C2 = substr($day2, 3, 1)=="Y" ? "CHECKED" : "";
    	$D2 = substr($day2, 4, 1)=="Y" ? "CHECKED" : "";
    	$E2 = substr($day2, 5, 1)=="Y" ? "CHECKED" : "";
    	$F2 = substr($day2, 6, 1)=="Y" ? "CHECKED" : "";
    	$G2 = substr($day2, 7, 1)=="Y" ? "CHECKED" : "";
    	$H2 = substr($day2, 8, 1)=="Y" ? "CHECKED" : "";
    	}
?>

<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta charset="utf-8">
        <title>Professor's Main</title>
    </head>
    <style>
        body {
            width: 35em;
            margin: 0 auto;
            font-family: Tahoma, Verdana, Arial, sans-serif;
        }
    </style>
    <body>
    <h1>修改課程</h1>
    <br />
    <form method="POST" action="../controllers/ProEditCourse.php">
	<label>課程名稱:</label>
    	<input type="text" id="name" name="name" maxlength="30" value="<?php echo $name;?>"  placeholder="世界雷資料庫" required />
   	<br /><br />
	<label>教室:</label>
   	<input type="text" id="class_room" name="class_room" value="<?php echo $classroom;?>"  placeholder="EC 115" required />
    	<br /><br />
    	<label>人數上限:</label>
    	<input type="number" id="student_upper_bound" name="student_upper_bound" value="<?php echo $sub;?>"  placeholder="56" required />
    	<br /><br />
    	<label>時段一:</label>
    	<select name="day1">
            <option <?php echo $mon1;?> value="1"> 星期一 </option>
            <option <?php echo $tue1;?> value="2"> 星期二 </option>
            <option <?php echo $wed1;?> value="3"> 星期三 </option>
            <option <?php echo $thu1;?> value="4"> 星期四 </option>
            <option <?php echo $fri1;?> value="5"> 星期五 </option>
            <option <?php echo $sat1;?> value="6"> 星期六 </option>
            <option <?php echo $sun1;?> value="7"> 星期日 </option>
    	</select>
    	<input type="checkbox" name="d1[]" value="0" <?php echo $A1;?>>A
    	<input type="checkbox" name="d1[]" value="1" <?php echo $B1;?>>B
    	<input type="checkbox" name="d1[]" value="2" <?php echo $C1;?>>C
    	<input type="checkbox" name="d1[]" value="3" <?php echo $D1;?>>D
    	<input type="checkbox" name="d1[]" value="4" <?php echo $E1;?>>E
    	<input type="checkbox" name="d1[]" value="5" <?php echo $F1;?>>F
    	<input type="checkbox" name="d1[]" value="6" <?php echo $G1;?>>G
    	<input type="checkbox" name="d1[]" value="7" <?php echo $H1;?>>H
    	<br /><br />
    	<label>時段二:</label>
    	<select name="day2">
            <option value="0"> 無 </option>
            <option <?php echo $mon2;?> value="1"> 星期一 </option>
            <option <?php echo $tue2;?> value="2"> 星期二 </option>
            <option <?php echo $wed2;?> value="3"> 星期三 </option>
            <option <?php echo $thu2;?> value="4"> 星期四 </option>
            <option <?php echo $fri2;?> value="5"> 星期五 </option>
            <option <?php echo $sat2;?> value="6"> 星期六 </option>
            <option <?php echo $sun2;?> value="7"> 星期日 </option>
    	</select>
    	<input type="checkbox" name="d2[]" value="0" <?php echo $A2;?>>A
    	<input type="checkbox" name="d2[]" value="1" <?php echo $B2;?>>B
    	<input type="checkbox" name="d2[]" value="2" <?php echo $C2;?>>C
    	<input type="checkbox" name="d2[]" value="3" <?php echo $D2;?>>D
    	<input type="checkbox" name="d2[]" value="4" <?php echo $E2;?>>E
    	<input type="checkbox" name="d2[]" value="5" <?php echo $F2;?>>F
    	<input type="checkbox" name="d2[]" value="6" <?php echo $G2;?>>G
    	<input type="checkbox" name="d2[]" value="7" <?php echo $H2;?>>H
    	<br /><br />
    	<label>學分:</label>
    	<input type="number" id="credit" name="credit" value="<?php echo $credit;?>"  placeholder="128" required />
    	<br /><br />
    	<label>必選修:</label>
    	<select name="required">
            <option <?php echo $req0;?> value="0"> 必修 </option>
            <option <?php echo $req1;?> value="1"> 選修 </option>
    	</select>
    	<br /><br />
    	<label>系所:</label>
    	<select name="department" required />
            <?php DepartListGen(); ?>
    	</select>
    	<br /><br />
    	<label>開課年級:</label>
    	<select name="grade" required />
            <option <?php echo $grade1;?> value="大一"> 大一 </option>
            <option <?php echo $grade2;?> value="大二"> 大二 </option>
            <option <?php echo $grade3;?> value="大三"> 大三 </option>
            <option <?php echo $grade4;?> value="大四"> 大四 </option>
            <option <?php echo $grade5;?> value="碩一"> 碩一 </option>
            <option <?php echo $grade6;?> value="碩二"> 碩二 </option>
    	</select>
    	<br /><br />
    	<label>備註:</label>
    	<br />
    	<textarea name="additional_info" cols=56 rows=4><?php echo $add_info;?></textarea>
    	<br /><br />
        <input type="hidden" id="id" name="id" value="<?php echo $_POST['id'];?>">
        <input type="hidden" id="year" name="year" value="<?php echo $_POST['year'];?>">
    	<button type="submit">修改</button>
    </form>

    <a href="../views/pro.php">回上頁</a><br/>
    </body>
</html>
