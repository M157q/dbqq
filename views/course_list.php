<html lang="zh">
<title>毫無反應只是一個課程列表</title>
<head>
    <meta charset="utf-8">
    <link href="../views/css/bootstrap.css" rel="stylesheet">
</head>
<body>

    <div class="container">
      <h1>課程列表</h1>
      <a class="btn btn-info" href="../index.php">回首頁</a><br/>
      <hr>
        <?php
            require_once("../models/Course.php");
            GetCourseInfoTable();
        ?>
    </div>
</body>
</html>
