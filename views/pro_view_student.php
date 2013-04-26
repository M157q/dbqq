<html lang="zh">
<title>學生列表</title>
<head>
    <meta charset="utf-8">
    <title>student list</title>
</head>
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
<body>

<?php
    session_start();
    require_once("../models/Course.php");
    require_once("../models/Department.php");
    require_once("../models/User.php");
    require_once("../components/Mysqli.php");
    require_once("../controllers/Session.php");
    if ($_SESSION['ban']) RedirectByPerm($_SESSION['perm']);
    if ($_SESSION['perm'] != 'pro') RedirectByPerm($_SESSION['perm']);
    showWarning();

    list($CourseID, $CourseYear) = explode('_', $_POST['id_year']);
    $sid_list = array();
    $stu_list = array();
    $depart_list = GetDepartmentList();

    if(!isset($_POST['id_year'])) {
        $_SESSION['errmsg'] = '沒有選擇課程 無法顯示學生列表';
        header('Location: ../views/pro.php');
    }

    $link = MysqliConnection('Read');
    $query = 'SELECT StudentID FROM Course_taken WHERE CourseID=? AND CourseYear=?';
    $stmt = mysqli_stmt_init($link);
    if(mysqli_stmt_prepare($stmt, $query))
    {
        mysqli_stmt_bind_param($stmt, "ss", $CourseID, $CourseYear);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $result);
        while(mysqli_stmt_fetch($stmt)) {
            array_push($sid_list, $result);
        }
        mysqli_stmt_close($stmt);
    }

    mysqli_close($link);

    $link = MysqliConnection('Read');
    $query = 'SELECT StudentNumber, Name, department, grade FROM Student WHERE ID=?';
    foreach($sid_list as $i) {
        $stmt = mysqli_stmt_init($link);
        if(mysqli_stmt_prepare($stmt, $query))
        {
            mysqli_stmt_bind_param($stmt, "s", $i);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $SN, $name, $dep, $grade);
            if(mysqli_stmt_fetch($stmt)) {
                array_push($stu_list, array($SN, $name, $dep, $grade));
            }
            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($link);

    array_multisort($stu_list);
       echo "<table border=5><caption>學生列表</caption>";
       echo "<tr>";
       echo "<th>學號</th><th>姓名</th><th>系所</th><th>年級</th>";
       echo "</tr>";
       foreach($stu_list as $row) {
           echo "<tr>";
           echo "<td>$row[0]</td>";
           echo "<td>$row[1]</td>";
           echo "<td>" . $depart_list[$row[2]] . "</td>";
           echo "<td>$row[3]</td>";
           echo "</tr>";
       }
       echo "</table>";
?>
<a href="../views/pro.php">回上頁</a>
</body>
</html>

