<!DOCTYPE HTML>
<html>
<title>Course Filter</title>
    <head>
        <meta charset="utf-8">
        <link href="../include/bootstrap/css/bootstrap.css" rel="stylesheet">
    </head>
    <body>

    <div class="container">
<h2>課程過濾器</h2>
    <?php
        session_start();
        require_once('../controllers/Session.php');
        require_once('../models/User.php');
        require_once('../models/Course.php');
        require_once('../models/Department.php');
        CheckPermAndRedirect($_SESSION['perm'], 'stu');

        showWarning();

    ?>

    <form method="post" action="../views/course_filter_result.php">
        <div class="alert alert-info">
        <h3>系所:</h3>
<?php
        $F = 0;
        $error = 0;
        $i = "1";
        while(!$error)
        {
            echo '<p>';
            $loop = 0;
            while($loop < 4)
            {
                $name = GetDepByID($i);
                while($name == false)
                {
                    $F++;
                    $i++;
                    if($F >= 3)
                    {
                        $error = 1;
                        break;
                    }
                    $name = GetDepByID($i);
                }

                if($error)
                    break;
                echo '<input type="checkbox" name="dep[]" value="'.$i.'">'.$name;
                $F = 0;
                $loop++;
                $i++;
            }
            echo '</p>';
        }
?>        
        <p><h3>年級:</h3></p>
        <p>
        <input type="checkbox" name="grade[]" value="1">大一
        <input type="checkbox" name="grade[]" value="2">大二
        <input type="checkbox" name="grade[]" value="3">大三
        <input type="checkbox" name="grade[]" value="4">大四
        <input type="checkbox" name="grade[]" value="5">研一
        <input type="checkbox" name="grade[]" value="6">研二
        </p>
        </div>

        <div class="alert alert-success">
        <p>時間過濾:
        <input type="radio" name="mode" value="1">模式一
        <input type="radio" name="mode" value="2">模式二
        </p>
        </div>

        <table border="2" class="table table-striped table-bordered">
        <tr>
            <th>時段\星期</th>
            <th>一</th>
            <th>二</th>
            <th>三</th>
            <th>四</th>
            <th>五</th>
            <th>六</th>
            <th>日</th>
        </tr>
        <?php
            $k = 1;
            $hours = array("A","B","C","D","X","E","F","G","H","Y","I","J","K","L");

            foreach($hours as $i)
            {
                echo "<tr>";
                echo "<td>$i</td>";
                echo "<td><input type=\"checkbox\" name=\"mon[]\" value=\"$k\"></td>";
                echo "<td><input type=\"checkbox\" name=\"tue[]\" value=\"$k\"></td>";
                echo "<td><input type=\"checkbox\" name=\"wed[]\" value=\"$k\"></td>";
                echo "<td><input type=\"checkbox\" name=\"thu[]\" value=\"$k\"></td>";
                echo "<td><input type=\"checkbox\" name=\"fri[]\" value=\"$k\"></td>";
                echo "<td><input type=\"checkbox\" name=\"sat[]\" value=\"$k\"></td>";
                echo "<td><input type=\"checkbox\" name=\"sun[]\" value=\"$k\"></td>";
                echo "</tr>";
                $k++;
            }
        ?>
        </table>
        <p class="lead">課程關鍵字:
            <input type="text" name="name" class="input-medium search-query">
        </p>

        <button type="submit" class="btn btn-primary">啟動過濾器</button>

    </form>
    <a class="btn btn-info" href="../views/stu.php">回上頁</a>
</div>
</body>
</html>
