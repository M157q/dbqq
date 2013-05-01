<?php
    session_start();
    require_once('../models/Course.php');
    require_once('../models/Department.php');
    require_once('../models/User.php');
    require_once('../controllers/Session.php');
    if ($_SESSION['ban']) RedirectByPerm($_SESSION['perm']);
    if ($_SESSION['perm'] != 'pro') RedirectByPerm($_SESSION['perm']);
    showWarning();
?>
<!DOCTYPE html>
<html lang="zh">
<title>Professor add course</title>
<head>
    <meta charset="utf-8">
    <link href="../include/bootstrap/css/bootstrap.css" rel="stylesheet">
<style>
    body {
        width: 35em;
        margin: 0 auto;
        font-family: Tahoma, Verdana, Arial, sans-serif;
    }
</style>
</head>
<body>
<h1>教授新增課程</h1>

<!-- login -->

<form method="post" action="../controllers/ProAddCourse.php">
    <label>課程名稱:</label>
    <input type="text" id="name" name="name" maxlength="30" placeholder="世界雷資料庫" required />
    <br /><br />
    <label>教室:</label>
    <input type="text" id="class_room" name="class_room" placeholder="EC 115" required />
    <br /><br />
    <label>人數上限:</label>
    <input type="number" id="student_upper_bound" name="student_upper_bound" placeholder="56" required />
    <br /><br />
    <label>時段一:</label>
    <select name="day1">
	<option value="1"> 星期一 </option>
	<option value="2"> 星期二 </option>
	<option value="3"> 星期三 </option>
	<option value="4"> 星期四 </option>
	<option value="5"> 星期五 </option>
	<option value="6"> 星期六 </option>
	<option value="7"> 星期日 </option>
    </select>
    <input type="checkbox" name="d1[]" value="0">A
    <input type="checkbox" name="d1[]" value="1">B
    <input type="checkbox" name="d1[]" value="2">C
    <input type="checkbox" name="d1[]" value="3">D
    <input type="checkbox" name="d1[]" value="4">E
    <input type="checkbox" name="d1[]" value="5">F
    <input type="checkbox" name="d1[]" value="6">G
    <input type="checkbox" name="d1[]" value="7">H
    <br /><br />
    <label>時段二:</label>
    <select name="day2">
        <option value="0"> 無 </option>
        <option value="1"> 星期一 </option>
        <option value="2"> 星期二 </option>
        <option value="3"> 星期三 </option>
        <option value="4"> 星期四 </option>
        <option value="5"> 星期五 </option>
        <option value="6"> 星期六 </option>
        <option value="7"> 星期日 </option>
    </select>
    <input type="checkbox" name="d2[]" value="0">A
    <input type="checkbox" name="d2[]" value="1">B
    <input type="checkbox" name="d2[]" value="2">C
    <input type="checkbox" name="d2[]" value="3">D
    <input type="checkbox" name="d2[]" value="4">E
    <input type="checkbox" name="d2[]" value="5">F
    <input type="checkbox" name="d2[]" value="6">G
    <input type="checkbox" name="d2[]" value="7">H
    <br /><br />
    <label>學分:</label>
    <input type="number" id="credit" name="credit" placeholder="128" required />
    <br /><br />
    <label>必選修:</label>
    <select name="required">
	<option value="0"> 必修 </option>
	<option value="1"> 選修 </option>
    </select>
    <br /><br />
    <label>年度:</label>
    <input type="number" id="year" name="year" placeholder="21XX" required />
    <br /><br />
    <label>系所:</label>
    <select name="department" required />
        <?php DepartListGen(); ?>
    </select>
    <br /><br />
    <label>開課年級:</label>
    <select name="grade" required />
        <option value="大一"> 大一 </option>
        <option value="大二"> 大二 </option>
        <option value="大三"> 大三 </option>
        <option value="大四"> 大四 </option>
        <option value="碩一"> 碩一 </option>
        <option value="碩二"> 碩二 </option>
    </select>
    <br /><br />
    <label>備註:</label>
    <br />
    <textarea name="additional_info" cols=56 rows=4></textarea>
    <br /><br />
    <button type="submit">開課</button>
</form>

    <a href="../views/pro.php">回上頁</a><br/>
</body>
</html>
