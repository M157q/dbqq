<?php
    session_start();
    require_once('../models/Course.php');
    require_once('../models/Department.php');

?>
<!DOCTYPE html>
<html lang="zh">
<title>Professor add course</title>
<head>
    <meta charset="utf-8">
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
    <label>教室</label>
    <input type="text" id="class_room" name="class_room" placeholder="EC 115" required />
    <br /><br />
    <label>年度:</label>
    <input type="text" id="year" name="year" maxlength="10" placeholder="年度" required />
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
    <button type="submit">開課</button>
</form>

    <a href="../views/pro.php">回上頁</a><br/>
</body>
</html>
