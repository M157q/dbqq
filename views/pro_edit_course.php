<?php
    session_start();
    require_once('../models/Grade.php');
    require_once('../models/Department.php');
    require_once('../models/User.php');
    require_once('../controllers/Session.php');
    if (isBanned($_SESSION['id'])) RedirectByPerm($_SESSION['perm']);
    if ($_SESSION['perm'] != 'pro') RedirectByPerm($_SESSION['perm']);

    if (isset($_POST['id']))   $_SESSION['course_id'] = $_POST['id'];
    if (isset($_POST['year'])) $_SESSION['course_year'] = $_POST['year'];

    list($name, $sub, $classroom, $credit, $dep, $grade, $req, $class_hours, $add_info) = proGetCourseInfo($_SESSION['id'], $_SESSION['course_id'], $_SESSION['course_year']);

    // if no such course, then go back
    if(!isset($name)) {
        $_SESSION['errmsg'] = '您沒有教授該課程';
        RedirectByPerm($_SESSION['perm']);
    }
    else {
        //recover the data pro input into form
        $req0 = $req=="0" ? "SELECTED" : "";
        $req1 = $req=="1" ? "SELECTED" : "";

        $dep1 = $dep=="1" ? "SELECTED" : "";
        $dep2 = $dep=="2" ? "SELECTED" : "";
        $dep3 = $dep=="3" ? "SELECTED" : "";
        $dep4 = $dep=="4" ? "SELECTED" : "";
        $dep5 = $dep=="5" ? "SELECTED" : "";
        $dep6 = $dep=="6" ? "SELECTED" : "";
        $dep7 = $dep=="7" ? "SELECTED" : "";
        $dep8 = $dep=="8" ? "SELECTED" : "";
        $dep9 = $dep=="9" ? "SELECTED" : "";
        $dep10 = $dep=="10" ? "SELECTED" : "";
        $dep11 = $dep=="11" ? "SELECTED" : "";
        $dep12 = $dep=="12" ? "SELECTED" : "";
        $dep13 = $dep=="13" ? "SELECTED" : "";
        $dep14 = $dep=="14" ? "SELECTED" : "";
        $dep15 = $dep=="15" ? "SELECTED" : "";
        $dep16 = $dep=="16" ? "SELECTED" : "";
        $dep17 = $dep=="17" ? "SELECTED" : "";

        $grade1 = CheckGradeIfExist($grade,"1") ? "CHECKED" : "";
        $grade2 = CheckGradeIfExist($grade,"2") ? "CHECKED" : "";
        $grade3 = CheckGradeIfExist($grade,"3") ? "CHECKED" : "";
        $grade4 = CheckGradeIfExist($grade,"4") ? "CHECKED" : "";
        $grade5 = CheckGradeIfExist($grade,"5") ? "CHECKED" : "";
        $grade6 = CheckGradeIfExist($grade,"6") ? "CHECKED" : "";

        $day1 = substr($class_hours, 0, 15);
        $day2 = substr($class_hours, 15, 15);

        $mon1 = substr($day1, 0, 1)=="1" ? "SELECTED" : "";
        $tue1 = substr($day1, 0, 1)=="2" ? "SELECTED" : "";
        $wed1 = substr($day1, 0, 1)=="3" ? "SELECTED" : "";
        $thu1 = substr($day1, 0, 1)=="4" ? "SELECTED" : "";
        $fri1 = substr($day1, 0, 1)=="5" ? "SELECTED" : "";
        $sat1 = substr($day1, 0, 1)=="6" ? "SELECTED" : "";
        $sun1 = substr($day1, 0, 1)=="7" ? "SELECTED" : "";

        $A1 = substr($day1, 1, 1)=="Y" ? "CHECKED" : "";
        $B1 = substr($day1, 2, 1)=="Y" ? "CHECKED" : "";
        $C1 = substr($day1, 3, 1)=="Y" ? "CHECKED" : "";
        $D1 = substr($day1, 4, 1)=="Y" ? "CHECKED" : "";
        $X1 = substr($day1, 5, 1)=="Y" ? "CHECKED" : "";
        $E1 = substr($day1, 6, 1)=="Y" ? "CHECKED" : "";
        $F1 = substr($day1, 7, 1)=="Y" ? "CHECKED" : "";
        $G1 = substr($day1, 8, 1)=="Y" ? "CHECKED" : "";
        $H1 = substr($day1, 9, 1)=="Y" ? "CHECKED" : "";
        $Y1 = substr($day1, 10, 1)=="Y" ? "CHECKED" : "";
        $I1 = substr($day1, 11, 1)=="Y" ? "CHECKED" : "";
        $J1 = substr($day1, 12, 1)=="Y" ? "CHECKED" : "";
        $K1 = substr($day1, 13, 1)=="Y" ? "CHECKED" : "";
        $L1 = substr($day1, 14, 1)=="Y" ? "CHECKED" : "";

        if(isset($day2)) {
            $mon2 = substr($day2, 0, 1)=="1" ? "SELECTED" : "";
            $tue2 = substr($day2, 0, 1)=="2" ? "SELECTED" : "";
            $wed2 = substr($day2, 0, 1)=="3" ? "SELECTED" : "";
            $thu2 = substr($day2, 0, 1)=="4" ? "SELECTED" : "";
            $fri2 = substr($day2, 0, 1)=="5" ? "SELECTED" : "";
            $sat2 = substr($day2, 0, 1)=="6" ? "SELECTED" : "";
            $sun2 = substr($day2, 0, 1)=="7" ? "SELECTED" : "";

            $A2 = substr($day2, 1, 1)=="Y" ? "CHECKED" : "";
            $B2 = substr($day2, 2, 1)=="Y" ? "CHECKED" : "";
            $C2 = substr($day2, 3, 1)=="Y" ? "CHECKED" : "";
            $D2 = substr($day2, 4, 1)=="Y" ? "CHECKED" : "";
            $X2 = substr($day2, 5, 1)=="Y" ? "CHECKED" : "";
            $E2 = substr($day2, 6, 1)=="Y" ? "CHECKED" : "";
            $F2 = substr($day2, 7, 1)=="Y" ? "CHECKED" : "";
            $G2 = substr($day2, 8, 1)=="Y" ? "CHECKED" : "";
            $H2 = substr($day2, 9, 1)=="Y" ? "CHECKED" : "";
            $Y2 = substr($day2, 10, 1)=="Y" ? "CHECKED" : "";
            $I2 = substr($day2, 11, 1)=="Y" ? "CHECKED" : "";
            $J2 = substr($day2, 12, 1)=="Y" ? "CHECKED" : "";
            $K2 = substr($day2, 13, 1)=="Y" ? "CHECKED" : "";
            $L2 = substr($day2, 14, 1)=="Y" ? "CHECKED" : "";
        }
?>

<!DOCTYPE html>
<html lang="zh">
<title>Professor Edit Course</title>
<head>
    <meta charset="utf-8">
    <link href="../include/bootstrap/css/bootstrap.css" rel="stylesheet">
</head>

<body>
    <div class="container">
    <h1>修改課程</h1>
    <div class="form-actions">
    <?php showWarning(); ?>
    <form method="POST" action="../controllers/ProEditCourse.php">
        <p>
        <label>課程名稱:</label>
        <input type="text" id="name" name="name" maxlength="30" value="<?php echo $name;?>"  placeholder="世界雷資料庫" required />
        </p>
        <p>
        <label>教室:</label>
        <input type="text" id="class_room" name="class_room" value="<?php echo $classroom;?>"  placeholder="EC 115" required />
        </p>
        <p>
        <label>人數上限:</label>
        <input type="number" id="student_upper_bound" name="student_upper_bound" value="<?php echo $sub;?>"  placeholder="56" required />
        </p>
        <p>
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
        <input type="checkbox" name="d1[]" value="4" <?php echo $X1;?>>X
        <input type="checkbox" name="d1[]" value="5" <?php echo $E1;?>>E
        <input type="checkbox" name="d1[]" value="6" <?php echo $F1;?>>F
        <input type="checkbox" name="d1[]" value="7" <?php echo $G1;?>>G
        <input type="checkbox" name="d1[]" value="8" <?php echo $H1;?>>H
        <input type="checkbox" name="d1[]" value="9" <?php echo $Y1;?>>Y
        <input type="checkbox" name="d1[]" value="10" <?php echo $I1;?>>I
        <input type="checkbox" name="d1[]" value="11" <?php echo $J1;?>>J
        <input type="checkbox" name="d1[]" value="12" <?php echo $K1;?>>K
        <input type="checkbox" name="d1[]" value="13" <?php echo $L1;?>>L
        </p>
        <p>
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
        <input type="checkbox" name="d2[]" value="4" <?php echo $X2;?>>X
        <input type="checkbox" name="d2[]" value="5" <?php echo $E2;?>>E
        <input type="checkbox" name="d2[]" value="6" <?php echo $F2;?>>F
        <input type="checkbox" name="d2[]" value="7" <?php echo $G2;?>>G
        <input type="checkbox" name="d2[]" value="8" <?php echo $H2;?>>H
        <input type="checkbox" name="d2[]" value="9" <?php echo $Y2;?>>Y
        <input type="checkbox" name="d2[]" value="10" <?php echo $I2;?>>I
        <input type="checkbox" name="d2[]" value="11" <?php echo $J2;?>>J
        <input type="checkbox" name="d2[]" value="12" <?php echo $K2;?>>K
        <input type="checkbox" name="d2[]" value="13" <?php echo $L2;?>>L
        </p>
        <p>
        <label>學分:</label>
        <input type="number" id="credit" name="credit" value="<?php echo $credit;?>"  placeholder="128" required />
        <br /><br />
        <label>必選修:</label>
        <select name="required">
            <option <?php echo $req0;?> value="0"> 必修 </option>
            <option <?php echo $req1;?> value="1"> 選修 </option>
        </select>
        </p>
        <p>
        <label>系所:</label>
        <select name="department" required />
            <option <?php echo $dep1;?> value="1"> 資訊工程學系 </option>
            <option <?php echo $dep2;?> value="2"> 電資學士班 </option>
            <option <?php echo $dep3;?> value="3"> 人文社會學系 </option>
            <option <?php echo $dep4;?> value="4"> 管理科學學系 </option>
            <option <?php echo $dep5;?> value="5"> 電子工程學系 </option>
            <option <?php echo $dep6;?> value="6"> 電機工程學系 </option>
            <option <?php echo $dep7;?> value="7"> 機械工程學系 </option>
            <option <?php echo $dep8;?> value="8"> 土木工程學系 </option>
            <option <?php echo $dep9;?> value="9"> 材料科學與工程學系 </option>
            <option <?php echo $dep10;?> value="10"> 奈米科學及工程學士學位學程 </option>
            <option <?php echo $dep11;?> value="11"> 電子物理學系 </option>
            <option <?php echo $dep12;?> value="12"> 財金管理學系 </option>
            <option <?php echo $dep13;?> value="13"> 應用數學系 </option>
            <option <?php echo $dep14;?> value="14"> 外國語文學系 </option>
            <option <?php echo $dep15;?> value="15"> 生物科技學系 </option>
            <option <?php echo $dep16;?> value="16"> 電信工程學系 </option>
            <option <?php echo $dep17;?> value="17"> 光電工程學系 </option>
        </select>
        </p>
        <p>
        <label>開課年級:</label>
        <input type="checkbox" name="grade[]" value="1" <?php echo $grade1;?>> 大一
        <input type="checkbox" name="grade[]" value="2" <?php echo $grade2;?>> 大二
        <input type="checkbox" name="grade[]" value="3" <?php echo $grade3;?>> 大三
        <input type="checkbox" name="grade[]" value="4" <?php echo $grade4;?>> 大四
        <input type="checkbox" name="grade[]" value="5" <?php echo $grade5;?>> 研一
        <input type="checkbox" name="grade[]" value="6" <?php echo $grade6;?>> 研二
        </p>
        <p>
        <label>備註:</label>
        <br>
        <textarea name="additional_info" cols=56 rows=4><?php echo $add_info;?></textarea>
        </p>
        <input type="hidden" name="id" value="<?php echo $_SESSION['course_id'];?>">
        <input type="hidden" name="year" value="<?php echo $_SESSION['course_year'];?>">
        <button class="btn btn-primary" type="submit">修改</button>
    </form>
    </div>

    <a class="btn btn-success" href="../views/pro.php">回上頁</a><br/>
    </div>
</body>
</html>
<?php } ?>
