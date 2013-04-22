<html lang="zh">
<title>毫無反應只是一個課程列表</title>
<head>
    <meta charset="utf-8">
    <title>Login</title>
<style>
    body {
        width: auto;
        font-family: Tahoma, Verdana, Arial, sans-serif;
    }
    th {
        width: auto;
    }
    table {
        width: 100%;
    } 
</style>
</head>
<body>
<h1>課程列表</h1>
        <a href="../index.php">回首頁</a><br/>
<hr>
<?php
    require_once("../models/Course.php");
    GetCourseInfoTable();
?>
</body>
</html>
